<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Utility\Text;

/**
 * Estimates Controller
 *
 * Sales estimates/quotes — CRUD and "Convert to Invoice" action.
 */
class EstimatesController extends AppController
{
    public function index()
    {
        $companyId = $this->request->getAttribute('company_id');

        $Estimates = $this->fetchTable('Estimates');
        $conditions = ['Estimates.company_id' => $companyId];

        $status   = $this->request->getQuery('status');
        $customer = $this->request->getQuery('customer_id');
        if ($status)   $conditions['Estimates.status']      = $status;
        if ($customer) $conditions['Estimates.customer_id'] = (int)$customer;

        $query = $Estimates->find()
            ->where($conditions)
            ->contain(['Customers'])
            ->order(['Estimates.date' => 'DESC']);

        $estimates = $this->paginate($query, ['limit' => 50]);

        $customers = $this->fetchTable('Customers')
            ->find('list', keyField: 'id', valueField: 'name')
            ->where(['Customers.company_id' => $companyId])
            ->all();

        $this->set(compact('estimates', 'customers'));
    }

    public function view(int $id)
    {
        $estimate = $this->fetchTable('Estimates')
            ->get($id, contain: ['Customers', 'EstimateItems' => ['Accounts']]);
        $this->set(compact('estimate'));
    }

    public function add()
    {
        $companyId = $this->request->getAttribute('company_id');

        $Estimates = $this->fetchTable('Estimates');
        $estimate  = $Estimates->newEmptyEntity();

        if ($this->request->is('post')) {
            $data               = $this->request->getData();
            $data['company_id'] = $companyId;
            $data['status']     = $data['status'] ?? 'Draft';

            $estimate = $Estimates->patchEntity($estimate, $data, ['associated' => ['EstimateItems']]);

            if ($this->request->getQuery('popup')) {
                if ($Estimates->save($estimate)) {
                    $this->set('popupResult', ['id' => $estimate->id, 'name' => "EST-{$estimate->id}"]);
                    $this->viewBuilder()->disableAutoLayout();
                    return $this->render('/Element/popup_success');
                }
            }

            if ($Estimates->save($estimate)) {
                $this->Flash->success(__('Estimate saved.'));
                return $this->redirect(['action' => 'view', $estimate->id]);
            }
            $this->Flash->error(__('Could not save estimate.'));
        }

        [$customers, $accounts] = $this->_dropdowns($companyId);
        
        $products = $this->fetchTable('Products')->find()
            ->where(['Products.company_id' => $companyId])
            ->all();

        $productsOptions = [];
        $productsJson = [];
        foreach ($products as $p) {
            $productsOptions[$p->id] = $p->name;
            $productsJson[$p->id] = [
                'unit_price' => (float)$p->unit_price,
                'account_id' => $p->account_id,
                'vat_rate'   => (float)$p->vat_rate,
                'hs_code'    => $p->hs_code,
                'vat_type'   => $p->vat_type ?: 'Standard'
            ];
        }

        $this->set(compact('estimate', 'customers', 'accounts', 'productsOptions', 'productsJson'));
    }

    public function edit(int $id)
    {
        $companyId = $this->request->getAttribute('company_id');

        $Estimates = $this->fetchTable('Estimates');
        $estimate  = $Estimates->get($id, contain: ['EstimateItems']);

        if ($this->request->is(['post', 'put'])) {
            $estimate = $Estimates->patchEntity($estimate, $this->request->getData(), ['associated' => ['EstimateItems']]);
            if ($Estimates->save($estimate)) {
                $this->Flash->success(__('Estimate updated.'));
                return $this->redirect(['action' => 'view', $estimate->id]);
            }
            $this->Flash->error(__('Could not update estimate.'));
        }

        [$customers, $accounts] = $this->_dropdowns($companyId);

        $products = $this->fetchTable('Products')->find()
            ->where(['Products.company_id' => $companyId])
            ->all();

        $productsOptions = [];
        $productsJson = [];
        foreach ($products as $p) {
            $productsOptions[$p->id] = $p->name;
            $productsJson[$p->id] = [
                'unit_price' => (float)$p->unit_price,
                'account_id' => $p->account_id,
                'vat_rate'   => (float)$p->vat_rate,
                'hs_code'    => $p->hs_code,
                'vat_type'   => $p->vat_type ?: 'Standard'
            ];
        }

        $this->set(compact('estimate', 'customers', 'accounts', 'productsOptions', 'productsJson'));
    }

    public function delete(int $id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $companyId = $this->request->getAttribute('company_id');

        $Estimates = $this->fetchTable('Estimates');
        $estimate  = $Estimates->find()->where(['Estimates.id' => $id, 'Estimates.company_id' => $companyId])->first();

        if ($estimate && $Estimates->delete($estimate)) {
            $this->Flash->success(__('Estimate deleted.'));
        } else {
            $this->Flash->error(__('Could not delete estimate.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    // -----------------------------------------------------------------------
    // CONVERT TO INVOICE
    // -----------------------------------------------------------------------

    /**
     * POST /estimates/convert-to-invoice/{id}
     * Copies the estimate and its line items into a new Invoice (status Draft).
     *
     * @param int $id Estimate ID
     * @return \Cake\Http\Response|null
     */
    public function convertToInvoice(int $id)
    {
        $this->request->allowMethod(['post']);

        $companyId = $this->request->getAttribute('company_id');

        $Estimates = $this->fetchTable('Estimates');
        $estimate  = $Estimates->find()
            ->where(['Estimates.id' => $id, 'Estimates.company_id' => $companyId])
            ->contain(['EstimateItems'])
            ->first();

        if (!$estimate) {
            $this->Flash->error('Estimate not found.');
            return $this->redirect(['action' => 'index']);
        }

        $Invoices   = $this->fetchTable('Invoices');
        $InvoiceItems = $this->fetchTable('InvoiceItems');

        // Build invoice data from estimate
        $invoiceData = [
            'company_id'  => $companyId,
            'customer_id' => $estimate->customer_id,
            'date'        => date('Y-m-d'),
            'currency'    => $estimate->currency ?? 'USD',
            'description' => $estimate->description ?? "Converted from Estimate #{$estimate->id}",
            'status'      => 'Draft',
            'total'       => $estimate->total ?? 0,
            'reference'   => 'INV-' . strtoupper(substr(Text::uuid(), 0, 8)),
        ];

        $invoice = $Invoices->newEntity($invoiceData, ['validate' => false]);

        if (!$Invoices->save($invoice)) {
            $this->Flash->error('Could not create invoice from estimate.');
            return $this->redirect(['action' => 'view', $id]);
        }

        // Copy line items
        foreach ($estimate->estimate_items ?? [] as $item) {
            $invItem = $InvoiceItems->newEntity([
                'invoice_id'  => $invoice->id,
                'account_id'  => $item->account_id ?? null,
                'description' => $item->description ?? '',
                'quantity'    => $item->quantity ?? 1,
                'unit_price'  => $item->unit_price ?? 0,
                'total'       => $item->total ?? ($item->quantity * $item->unit_price),
            ], ['validate' => false]);
            $InvoiceItems->save($invItem);
        }

        // Mark estimate as Accepted
        $estimate->status = 'Accepted';
        $Estimates->save($estimate, ['validate' => false]);

        $this->Flash->success("Invoice #{$invoice->id} created from Estimate #{$estimate->id}.");
        return $this->redirect(['controller' => 'Invoices', 'action' => 'view', $invoice->id]);
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
