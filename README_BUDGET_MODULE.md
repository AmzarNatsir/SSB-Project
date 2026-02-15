# Project Budgeting & Cost Baseline Module

This module manages project budgets, approval workflows, baseline locking, and revisions.

## Installation

1. Run migrations:
```bash
php artisan migrate
```

2. Seed approval tiers:
```bash
php artisan db:seed --class=ProjectBudgetApprovalTierSeeder
```

## Features

- **Dynamic Approval Workflow**: Configurable tiers via `project_budget_approval_tiers` table.
- **Baseline Locking**: Approved budgets become immutable.
- **Versioning**: Revisions create a new version of the budget.
- **Audit Trail**: Every action is logged in `audit_logs` table.
- **Optimistic Locking**: Prevents concurrent edits using `version` field.

## API Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/v1/projects/{projectId}/budget-history` | Get budget history (versions) |
| GET | `/api/v1/budgets` | List budgets (filter by `status`, `project_id`) |
| POST | `/api/v1/budgets` | Create new budget |
| GET | `/api/v1/budgets/{id}` | Get budget details |
| PUT | `/api/v1/budgets/{id}` | Update budget (if not locked) |
| DELETE | `/api/v1/budgets/{id}` | Delete budget (soft delete) |
| POST | `/api/v1/budgets/{id}/submit` | Submit budget for approval |
| POST | `/api/v1/budgets/{id}/approve` | Approve/Reject dependent on user tier |
| POST | `/api/v1/budgets/{id}/revise` | Create revision of locked budget |

## Usage Guide

1. **Creation**: Analyst creates a budget for a feasible project. Status: `DRAFT`.
2. **Submission**: Analyst submits budget. Status: `SUBMITTED`. First approver is notified.
3. **Approval**:
   - Level 1 Approver (e.g., PM) approves. Status: `APPROVED_L1`.
   - Level 2 Approver (e.g., Ops) approves. Status: `APPROVED_L2`.
   - Final Approver (e.g., Director) approves. Status: `BASELINE_APPROVED`.
4. **Revision**: If changes are needed after baseline approval, use the `/revise` endpoint to clone the budget into a new Draft version.

## Scaling & Best Practices

- **Performance**: Use eager loading (`with('items')`) which is implemented in the Repository. For large budgets (1000+ items), consider paginating items or using a dedicated Items endpoint.
- **Concurrency**: The system uses optimistic locking (`version` check). Frontend should handle the version mismatch error gracefully (prompt user to refresh).
- **Audit**: The `audit_logs` table can grow large. Consider archiving old logs or moving to a dedicated logging service (ELK stack) for specific "View" events if traffic is high.
