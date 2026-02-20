<?php

namespace Tests\Unit;

use App\Enums\NegotiationStatus;
use App\Enums\UnitRequestStatus;
use App\Models\Negotiation;
use App\Models\Project;
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\UnitRequest;
use App\Models\User;
use App\Services\AuditService;
use App\Services\UnitRequestService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UnitRequestServiceUpdateTest extends TestCase
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

        Storage::fake('private');
    }

    /** @test */
    public function it_updates_request_dates_and_notes()
    {
        // Arrange: Create a draft unit request
        $unitRequest = $this->createDraftUnitRequest();

        $updateData = [
            'request_date' => '2024-02-01',
            'mobilization_date' => '2024-03-01',
            'notes' => 'Updated notes for the request',
        ];

        // Act: Update the unit request
        $updated = $this->service->update($unitRequest->uid, $updateData, $this->user->id);

        // Assert: Verify the updates
        $this->assertEquals('2024-02-01', $updated->request_date->format('Y-m-d'));
        $this->assertEquals('2024-03-01', $updated->mobilization_date->format('Y-m-d'));
        $this->assertEquals('Updated notes for the request', $updated->notes);
    }

    /** @test */
    public function it_handles_attachment_upload()
    {
        // Arrange: Create a draft unit request
        $unitRequest = $this->createDraftUnitRequest();

        $file = UploadedFile::fake()->create('document.pdf', 100);

        $updateData = [
            'attachment' => $file,
        ];

        // Act: Update with attachment
        $updated = $this->service->update($unitRequest->uid, $updateData, $this->user->id);

        // Assert: Verify attachment was stored
        $this->assertNotNull($updated->attachment_path);
        Storage::disk('private')->assertExists($updated->attachment_path);
    }

    /** @test */
    public function it_updates_unit_request_items()
    {
        // Arrange: Create a draft unit request with items
        $unitRequest = $this->createDraftUnitRequest();

        $quotationItem = $unitRequest->quotation->items->first();

        $updateData = [
            'items' => [
                [
                    'quotation_item_id' => $quotationItem->id,
                    'unit_name' => 'Updated Unit Name',
                    'qty' => 5,
                    'duration_days' => 30,
                    'remarks' => 'Updated remarks',
                ],
            ],
        ];

        // Act: Update items
        $updated = $this->service->update($unitRequest->uid, $updateData, $this->user->id);

        // Assert: Verify items were updated
        $this->assertCount(1, $updated->items);
        $this->assertEquals('Updated Unit Name', $updated->items->first()->unit_name);
        $this->assertEquals(5, $updated->items->first()->qty);
        $this->assertEquals('Updated remarks', $updated->items->first()->remarks);
    }

    /** @test */
    public function it_allows_updating_rejected_unit_request()
    {
        // Arrange: Create a rejected unit request
        $unitRequest = $this->createDraftUnitRequest();
        $unitRequest->update(['status' => UnitRequestStatus::REJECTED]);

        $updateData = [
            'notes' => 'Revised after rejection',
        ];

        // Act: Update the rejected request
        $updated = $this->service->update($unitRequest->uid, $updateData, $this->user->id);

        // Assert: Verify update was successful
        $this->assertEquals('Revised after rejection', $updated->notes);
    }

    /** @test */
    public function it_throws_exception_when_updating_non_editable_status()
    {
        // Arrange: Create a submitted unit request (not editable)
        $unitRequest = $this->createDraftUnitRequest();
        $unitRequest->update(['status' => UnitRequestStatus::SUBMITTED]);

        $updateData = [
            'notes' => 'Trying to update submitted request',
        ];

        // Act & Assert: Expect exception
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('cannot be edited');

        $this->service->update($unitRequest->uid, $updateData, $this->user->id);
    }

    /** @test */
    public function it_throws_exception_when_unit_request_not_found()
    {
        // Act & Assert: Expect exception
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('not found');

        $this->service->update('non-existent-uid', ['notes' => 'test'], $this->user->id);
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
}
