# Fix Transaction Deletion and Add Unreconciliation

The user cannot delete transactions linked to bank uploads because of a "zero-sum" validation rule that blocks partial deletions of balanced journal groups. Additionally, once a bank transaction is reconciled, it is "locked" in the dashboard with no way to undo the action or delete it locally.

## User Review Required

> [!IMPORTANT]
> **Automatic Cascading Deletes:** Deleting one leg of a reconciled transaction from the main ledger will now automatically delete the other leg and reset the bank transaction to an "unreconciled" state. This ensures financial integrity but might be unexpected for users who only intended to delete one side of a transfer.

> [!NOTE]
> We will add an "Undo Reconciliation" feature to the Bank Reconciliation dashboard to help users fix mistakes without having to hunt for the individual ledger entries.

## Proposed Changes

### Core Ledger Integrity

#### [MODIFY] [TransactionsTable](file:///c:/xampp/htdocs/esc_erp_app3/src/Model/Table/TransactionsTable.php)
- Restrict the `checkZeroSum` application rule to `on => save`. This prevents the rule from firing during `delete`, allowing the `afterDelete` cleanup to proceed.
- Enhance `afterDelete` hook:
    - If the deleted transaction has a `bank_transaction_id`, find the corresponding record in `bank_transactions` and set `reconciled = 0` and `transaction_id = NULL`.

---

### Bank Reconciliation Dashboard

#### [MODIFY] [BankTransactionsController](file:///c:/xampp/htdocs/esc_erp_app3/src/Controller/BankTransactionsController.php)
- [NEW ACTION] `apiUnreconcile()`:
    - Finds the bank transaction by ID (from POST).
    - Locates the associated system ledger transaction (if any).
    - Deletes all transactions sharing that `transaction_group` (clearing both legs).
    - Sets `reconciled = 0` on the bank row.
- [MODIFY] `index()`:
    - Update query to also fetch the last 15 "Recently Reconciled" items to show in the UI for quick undoing.

#### [MODIFY] [BankTransactions index.php](file:///c:/xampp/htdocs/esc_erp_app3/templates/BankTransactions/index.php)
- Add a "Recently Reconciled" tab or section below the main table.
- Add an `Unreconcile` button (undo icon) to the items in this list.
- Connect the button to the new AJAX endpoint.

## Verification Plan

### Automated Tests
- I will attempt to delete a reconciled transaction from the `Transactions/index` page and verify it successfully unreconciles the bank line.
- I will attempt to use the new "Unreconcile" button from the dashboard and verify the ledger entries are removed and the row returns to the dashboard list.

### Manual Verification
1. Import a bank CSV.
2. Categorize a transaction.
3. Attempt to delete it from the dashboard (should fail with instructions or succeed if unreconciled first).
4. Unreconcile it and verify it becomes editable/deletable again.
5. Go to Ledger, delete one side, and check if the bank dashboard shows the transaction as unreconciled.
