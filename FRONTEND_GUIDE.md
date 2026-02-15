# Frontend Implementation Guide - Budget Module

## Component Structure (Suggested)

### 1. Budget Dashboard (`BudgetList.jsx` / `index.blade.php`)
- **API**: `GET /api/v1/budgets?project_id=X`
- **Columns**: Version, Status (Badge), Total HPP, Selling Price, Created At, Actions.
- **Features**: Filter by Status, "New Budget" button (if none active).

### 2. Budget Wizard (`CreateBudget.jsx`)
- **API**: `POST /api/v1/budgets`
- **Steps**:
  1. Project Selection (filter by `PROJECT_FEASIBLE`).
  2. Profit Margin Input.
  3. Cost Items Grid.
  4. Summary & Review.

### 3. Cost Input Grid (`CostItemsGrid.jsx`)
- **Props**: `items` (array), `onChange` (function).
- **Layout**: Table with editable cells.
- **Columns**: Category (Dropdown), Item Name, Qty, Unit, Unit Cost, Total (Calculated), Description.
- **Logic**: Auto-calculate `Total = Qty * Unit Cost`. Group totals by Category for display.

### 4. Approval View (`ApprovalAction.jsx`)
- **API**: `POST /api/v1/budgets/{id}/approve`
- **Props**: `budget`, `userRole`.
- **UI**:
  - Display "Approve", "Reject", "Request Revision" buttons based on user role and current budget status.
  - Textarea for `notes` (required for Rejection).

### 5. Revision Request (`RevisionModal.jsx`)
- **API**: `POST /api/v1/budgets/{id}/revise`
- **UI**: Modal prompting for "Reason for Revision".

## Status Badge Colors

| Status | Color | Label |
|--------|-------|-------|
| DRAFT | Gray | Draft |
| SUBMITTED | Blue | Submitted |
| APPROVED_L1 | Indigo | Approved by PM |
| APPROVED_L2 | Purple | Approved by Ops |
| BASELINE_APPROVED | Green | Baseline Approved (Locked) |
| REVISION_REQUIRED | Orange | Revision Required |
| REJECTED | Red | Rejected |

## Error Handling

- **422 Validation Error**: Display field-specific errors.
- **422 Version Mismatch**: "The budget has been modified by someone else. Please refresh the page."
- **403 Forbidden**: "You are not authorized to perform this action."
