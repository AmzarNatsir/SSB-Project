<?php

namespace Tests\Unit;

use App\Enums\NegotiationStatus;
use App\Enums\UnitRequestStatus;
use App\Events\UnitRequestSubmitted;
use App\Models\ApprovalFlow;
use App\Models\ApprovalFlowLevel;
use App\Models\Negotiation;
use App\Models\Project;
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\UnitRequest;
use App\Models\User;
use App\Services\AuditService;
use App\Services\UnitRequestService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class UnitRequestServiceSubmitTest extends TestCase
{
    use RefreshDatabase;

    protected UnitRequestService $service;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock AuditService to avoid audit_logs table issues
        $this->mock(AuditService::class, function ($mock) {
            $mock->shouldReceive('log')->andReturn(true);
        });

        $this->service = app(UnitRequestService::class);
        $this->user = User::factory()->create();

        Event::fake();
    }

    /** @test */
    public function it_submits_draft_unit_request_with_approval_flow()
    {
        // Arrange: Create approval flow and draft unit request
        $this->createApprovalFlow();
        $unitRequest = $this->createDraftUnitRequest();

        // Act: Submit the unit request
        $submitted = $this->service->submit($unitRequest->uid, $this->user->id);

        // Assert: Verify status changed to SUBMITTED
        $this->assertEquals(UnitRequestStatus::SUBMITTED, $submitted->status);

        // Assert: Verify first level approval record was created
        $this->assertCount(1, $submitted->approvals);
        $approval = $submitted->approvals->first();
        $this->assertEquals(1, $approval->level);
        $this->assertEquals('pending', $approval->status);

        // Assert: Verify event was fired
        Event::assertDispatched(UnitRequestSubmitted::class, function ($event) use ($unitRequest) {
            return $event->unitRequest->id === $unitRequest->id;
        });
    }

    /** @test */
    public function it_auto_approves_when_no_approval_flow_exists()
    {
        // Arrange: Create draft unit request without approval flow
        $unitRequest = $this->createDraftUnitRequest();

        // Act: Submit the unit request
        $submitted = $this->service->submit($unitRequest->uid, $this->user->id);

        // Assert: Verify status changed to APPROVED
        $this->assertEquals(UnitRequestStatus::APPROVED, $submitted->status);

        // Assert: Verify approved_by and approved_at are set
        $this->assertEquals($this->user->id, $submitted->approved_by);
        $this->assertNotNull($submitted->approved_at);

        // Assert: Verify no approval records were created
        $this->assertCount(0, $submitted->approvals);

        // Assert: Verify event was fired
        Event::assertDispatched(UnitRequestSubmitted::class);
    }

    /** @test */
    public function it_submits_rejected_unit_request()
    {
        // Arrange: Create approval flow and rejected unit request
        $this->createApprovalFlow();
        $unitRequest = $this->createDraftUnitRequest();
        $unitRequest->update(['status' => UnitRequestStatus::REJECTED]);

        // Act: Submit the rejected request
        $submitted = $this->service->submit($unitRequest->uid, $this->user->id);

        // Assert: Verify status changed to SUBMITTED
        $this->assertEquals(UnitRequestStatus::SUBMITTED, $submitted->status);

        // Assert: Verify approval record was created
        $this->assertCount(1, $submitted->approvals);
    }

    /** @test */
    public function it_throws_exception_when_submitting_non_draft_or_rejected_status()
    {
        // Arrange: Create a submitted unit request
        $this->createApprovalFlow();
        $unitRequest = $this->createDraftUnitRequest();
        $unitRequest->update(['status' => UnitRequestStatus::SUBMITTED]);

        // Act & Assert: Expect validation exception
        $this->expectException(ValidationException::class);

        $this->service->submit($unitRequest->uid, $this->user->id);
    }

    /** @test */
    public function it_throws_exception_when_request_date_is_missing()
    {
        // Arrange: Create unit request without request_date
        $unitRequest = $this->createDraftUnitRequest();
        $unitRequest->update(['request_date' => null]);

        // Act & Assert: Expect validation exception
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Request date is required');

        $this->service->submit($unitRequest->uid, $this->user->id);
    }

    /** @test */
    public function it_throws_exception_when_mobilization_date_is_missing()
    {
        // Arrange: Create unit request without mobilization_date
        $unitRequest = $this->createDraftUnitRequest();
        $unitRequest->update(['mobilization_date' => null]);

        // Act & Assert: Expect validation exception
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Mobilization date is required');

        $this->service->submit($unitRequest->uid, $this->user->id);
    }

    /** @test */
    public function it_throws_exception_when_no_items_exist()
    {
        // Arrange: Create unit request and delete all items
        $unitRequest = $this->createDraftUnitRequest();
        $unitRequest->items()->delete();

        // Act & Assert: Expect validation exception
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('At least one unit request item is required');

        $this->service->submit($unitRequest->uid, $this->user->id);
    }

    /** @test */
    public function it_throws_exception_when_unit_request_not_found()
    {
        // Act & Assert: Expect exception
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('not found');

        $this->service->submit('non-existent-uid', $this->user->id);
    }

    /**
     * Helper method to create a draft unit request for testing
     */
    protected function createDraftUnitRequest(): UnitRequest
    {
        // Create project with approved negotiation and quotation
        $project = Project::factory()->create();

        $quotation = Quotation::factory()->create([
            'project_id' => $project->id,
        ]);

        QuotationItem::factory()->create([
            'quotation_id' => $quotation->id,
            'unit_name' => 'Test Unit',
            'quantity' => 2,
            'duration' => 15,
        ]);

        $negotiation = Negotiation::factory()->create([
            'project_id' => $project->id,
            'quotation_id' => $quotation->id,
            'status' => NegotiationStatus::APPROVED,
        ]);

        // Create unit request using the service
        $data = [
            'project_id' => $project->id,
            'request_date' => '2024-01-15',
            'mobilization_date' => '2024-02-15',
            'notes' => 'Initial notes',
        ];

        return $this->service->create($data, $this->user->id);
    }

    /**
     * Helper method to create approval flow for UnitRequest
     */
    protected function createApprovalFlow(): void
    {
        $flow = ApprovalFlow::create([
            'code' => 'UnitRequest',
            'name' => 'Unit Request Approval',
            'description' => 'Approval flow for unit requests',
        ]);

        ApprovalFlowLevel::create([
            'approval_flow_id' => $flow->id,
            'level_number' => 1,
            'approver_type' => 'role',
            'approver_role_id' => 1, // Assuming role ID 1 exists
        ]);
    }
}
