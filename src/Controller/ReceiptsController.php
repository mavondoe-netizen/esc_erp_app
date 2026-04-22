<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Utility\Text;

/**
 * Receipts Controller
 *
 * Customer payment receipts — records cash collected against an invoice
 * and posts the corresponding ledger entries (Debit Bank, Credit AR).
 */
class ReceiptsController extends AppController
{
    public function index()
    {
        $companyId = $this->request->getAttribute('company_id');

        $Receipts = $this->fetchTable('Receipts');
        $query    = $Receipts->find()
            ->where(['Receipts.company_id' => $companyId])
            ->contain(['Customers', 'Accounts'])
            ->order(['Receipts.date' => 'DESC']);

        $receipts = $this->paginate($query, ['limit' => 50]);
        $this->set(compact('receipts'));
    }

    public function view(int $id)
    {
        $receipt = $this->fetchTable('Receipts')
            ->get($id, contain: ['Customers', 'Accounts', 'Transactions']);
        $this->set(compact('receipt'));
    }

    public function add()
    {
        $companyId = $this->request->getAttribute('company_id');

        $Receipts = $this->fetchTable('Receipts');
        $receipt  = $Receipts->newEmptyEntity();

        if ($this->request->is('post')) {
            $data               = $this->request->getData();
            $data['company_id'] = $companyId;
            $receipt = $Receipts->patchEntity($receipt, $data);

            if ($this->request->getQuery('popup')) {
                if ($Receipts->save($receipt)) {
                    $this->set('popupResult', ['id' => $receipt->id, 'name' => "RCT-{$receipt->id}"]);
                    $this->viewBuilder()->disableAutoLayout();
                    return $this->render('/Element/popup_success');
                }
            }

            if ($Receipts->save($receipt)) {
                $this->_postReceiptToLedger($receipt, $companyId);
                $this->Flash->success(__('Receipt saved.'));
                return $this->redirect(['action' => 'view', $receipt->id]);
            }
            $this->Flash->error(__('Could not save receipt.'));
        }

        [$customers, $accounts] = $this->_dropdowns($companyId);
        $this->set(compact('receipt', 'customers', 'accounts'));
    }

    public function edit(int $id)
    {
        $companyId = $this->request->getAttribute('company_id');

        $Receipts = $this->fetchTable('Receipts');
        $receipt  = $Receipts->get($id);

        if ($this->request->is(['post', 'put'])) {
            $receipt = $Receipts->patchEntity($receipt, $this->request->getData());
            if ($Receipts->save($receipt)) {
                $this->Flash->success(__('Receipt updated.'));
                return $this->redirect(['action' => 'view', $receipt->id]);
            }
            $this->Flash->error(__('Could not update receipt.'));
        }

        [$customers, $accounts] = $this->_dropdowns($companyId);
        $this->set(compact('receipt', 'customers', 'accounts'));
    }

    public function delete(int $id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $companyId = $this->request->getAttribute('company_id');

        $Receipts = $this->fetchTable('Receipts');
        $receipt  = $Receipts->find()->where(['Receipts.id' => $id, 'Receipts.company_id' => $companyId])->first();

        if (!$receipt) {
            $this->Flash->error('Receipt not found.');
            return $this->redirect(['action' => 'index']);
        }

        // Reverse ledger entries
        $this->_reverseReceiptLedger($id, $companyId);

        if ($Receipts->delete($receipt)) {
            $this->Flash->success(__('Receipt deleted.'));
        } else {
            $this->Flash->error(__('Could not delete receipt.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    private function _postReceiptToLedger($receipt, int $companyId): void
    {
        $Transactions = $this->fetchTable('Transactions');
        $Accounts     = $this->fetchTable('Accounts');

        $arAccount = $Accounts->find()
            ->where(['Accounts.company_id' => $companyId, 'Accounts.category LIKE' => '%Receivable%'])
            ->first();

        if (!$arAccount) return;

        $bankAccountId = $receipt->account_id ?? null;
        if (!$bankAccountId) return;

        $date     = $receipt->date ? $receipt->date->format('Y-m-d') : date('Y-m-d');
        $amount   = (float)($receipt->amount ?? 0);
        $currency = $receipt->currency ?? 'USD';
        $groupId  = Text::uuid();
        $ref      = "RCT-{$receipt->id}";

        $Transactions->getConnection()->transactional(function () use (
            $Transactions, $receipt, $arAccount, $bankAccountId,
            $date, $amount, $currency, $groupId, $ref, $companyId
        ) {
            // Debit: Bank/cash account
            $dr = $Transactions->newEntity([
                'company_id'        => $companyId,
                'date'              => $date,
                'description'       => "Receipt $ref",
                'currency'          => $currency,
                'amount'            => $amount,
                'zwg'               => $amount,
                'type'              => 'Debit',
                'account_id'        => $bankAccountId,
                'customer_id'       => $receipt->customer_id ?? null,
                'transaction_group' => $groupId,
            ], ['validate' => false]);
            $Transactions->save($dr, ['check_balance' => false]);

            // Credit: AR
            $cr = $Transactions->newEntity([
                'company_id'        => $companyId,
                'date'              => $date,
                'description'       => "Receipt $ref",
                'currency'          => $currency,
                'amount'            => $amount,
                'zwg'               => $amount,
                'type'              => 'Credit',
                'account_id'        => $arAccount->id,
                'customer_id'       => $receipt->customer_id ?? null,
                'transaction_group' => $groupId,
            ], ['validate' => false]);
            $Transactions->save($cr, ['check_balance' => false]);
        });
    }

    private function _reverseReceiptLedger(int $receiptId, int $companyId): void
    {
        // Receipts link to transactions via receipts_transactions join table
        $Transactions = $this->fetchTable('Transactions');
        $conn = $Transactions->getConnection();
        $stmt = $conn->execute(
            "SELECT t.transaction_group FROM transactions t
             JOIN receipts_transactions rt ON rt.transaction_id = t.id
             WHERE rt.receipt_id = :rid AND t.company_id = :cid",
            [':rid' => $receiptId, ':cid' => $companyId]
        );
        $groups = array_column($stmt->fetchAll('assoc'), 'transaction_group');
        $groups = array_filter(array_unique($groups));

        if (!empty($groups)) {
            $Transactions->deleteAll(['transaction_group IN' => $groups, 'company_id' => $companyId]);
        }
    }

    private function _dropdowns(int $companyId): array
    {
        $customers = $this->fetchTable('Customers')
            ->find('list', keyField: 'id', valueField: 'name')
            ->where(['Customers.company_id' => $companyId])->all();

        $accounts = $this->fetchTable('Accounts')
            ->find('list', keyField: 'id', valueField: 'name')
            ->where(['Accounts.company_id' => $companyId])
            ->order(['Accounts.type', 'Accounts.name'])->all();

        return [$customers, $accounts];
    }
}
