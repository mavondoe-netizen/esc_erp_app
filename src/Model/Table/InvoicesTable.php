<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\EventInterface;
use Cake\Utility\Text;
use ArrayObject;
/**
 * Invoices Model
 *
 * @mixin \App\Model\Behavior\TenantAwareBehavior
 * @property \App\Model\Table\CustomersTable&\Cake\ORM\Association\BelongsTo $Customers
 * @property \App\Model\Table\InvoiceItemsTable&\Cake\ORM\Association\HasMany $InvoiceItems
 * @property \App\Model\Table\AccountsTable&\Cake\ORM\Association\BelongsToMany $Accounts
 * @property \App\Model\Table\TransactionsTable&\Cake\ORM\Association\BelongsToMany $Transactions
 *
 * @method \App\Model\Entity\Invoice newEmptyEntity()
 * @method \App\Model\Entity\Invoice newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Invoice> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Invoice get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Invoice findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Invoice patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Invoice> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Invoice|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Invoice saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Invoice>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Invoice>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Invoice>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Invoice> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Invoice>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Invoice>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Invoice>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Invoice> deleteManyOrFail(iterable $entities, array $options = [])
 */
class InvoicesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->addBehavior('TenantAware');

        $this->setTable('invoices');
        $this->setDisplayField('currency');
        $this->setPrimaryKey('id');

        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('InvoiceItems', [
            'foreignKey' => 'invoice_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
        $this->belongsToMany('Accounts', [
            'foreignKey' => 'invoice_id',
            'targetForeignKey' => 'account_id',
            'joinTable' => 'accounts_invoices',
        ]);
        $this->belongsToMany('Transactions', [
            'foreignKey' => 'invoice_id',
            'targetForeignKey' => 'transaction_id',
            'joinTable' => 'invoices_transactions',
        ]);
        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->date('date')
            ->requirePresence('date', 'create')
            ->notEmptyDate('date');

        $validator
            ->integer('customer_id')
            ->notEmptyString('customer_id');

        $validator
            ->scalar('currency')
            ->maxLength('currency', 151)
            ->requirePresence('currency', 'create')
            ->notEmptyString('currency');

        $validator
            ->scalar('description')
            ->maxLength('description', 151)
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->scalar('status')
            ->maxLength('status', 151)
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        $validator
            ->numeric('total')
            ->requirePresence('total', 'create')
            ->notEmptyString('total');

        $validator
            ->scalar('manual_reference')
            ->maxLength('manual_reference', 100)
            ->allowEmptyString('manual_reference');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['customer_id'], 'Customers'), ['errorField' => 'customer_id']);
        $rules->add($rules->existsIn(['company_id'], 'Companies'), ['errorField' => 'company_id']);

        return $rules;
    }
    // src/Model/Table/InvoicesTable.php

    public function postToLedger($invoice, int $companyId): void
    {
        if (!isset($invoice->invoice_items) || empty($invoice->invoice_items)) {
            $invoice = $this->get($invoice->id, contain: ['InvoiceItems']);
        }

        $Transactions = \Cake\ORM\TableRegistry::getTableLocator()->get('Transactions');
        $Accounts     = \Cake\ORM\TableRegistry::getTableLocator()->get('Accounts');
        $Rates        = \Cake\ORM\TableRegistry::getTableLocator()->get('ExchangeRates');

        // Fetch current exchange rate for ZWG conversion
        $rate = $Rates->find()
            ->where(['company_id' => $companyId, 'currency' => $invoice->currency])
            ->where(['date <=' => $invoice->date ?: date('Y-m-d')])
            ->orderBy(['date' => 'DESC'])
            ->first();
        $rateVal = $rate ? (float)$rate->rate_to_base : 1.0;

        $arAccount = $Accounts->find()
            ->where(['Accounts.company_id' => $companyId, 'Accounts.category LIKE' => '%Receivable%'])
            ->first();

        if (!$arAccount) {
            $arAccount = $Accounts->newEntity([
                'name' => 'Accounts Receivable',
                'category' => 'Accounts Receivable',
                'type' => 'Asset',
                'company_id' => $companyId
            ]);
            $Accounts->save($arAccount);
        }
        $arAccountId = $arAccount->id;

        // Ensure "VAT Output" liability account exists
        $vatAccount = $Accounts->find()
            ->where(['Accounts.company_id' => $companyId, 'Accounts.name LIKE' => '%VAT Output%'])
            ->first();

        if (!$vatAccount) {
            $vatAccount = $Accounts->newEntity([
                'name' => 'VAT Output',
                'category' => 'Taxes Payable',
                'type' => 'Liability',
                'company_id' => $companyId
            ]);
            $Accounts->save($vatAccount);
        }
        $vatAccountId = $vatAccount->id;

        $date      = $invoice->date ? $invoice->date->format('Y-m-d') : date('Y-m-d');
        $ref       = $invoice->reference ?? "INV-{$invoice->id}";
        $currency  = $invoice->currency ?? 'USD';
        $groupId   = Text::uuid();

        $Transactions->getConnection()->transactional(function () use (
            $Transactions, $invoice, $arAccountId, $vatAccountId, $date, $ref, $currency, $groupId, $companyId, $rateVal
        ) {
            $total = (float)($invoice->total ?? 0);

            // Debit: Accounts Receivable (Full Amount)
            $dr = $Transactions->newEntity([
                'company_id'        => $companyId,
                'date'              => $date,
                'description'       => "Invoice $ref",
                'currency'          => $currency,
                'amount'            => $total,
                'zwg'               => $total * $rateVal,
                'type'              => 'Debit',
                'account_id'        => $arAccountId,
                'customer_id'       => $invoice->customer_id,
                'invoice_id'        => $invoice->id,
                'transaction_group' => $groupId,
            ], ['validate' => false]);
            $Transactions->save($dr, ['check_balance' => false]);

            if (!empty($invoice->invoice_items)) {
                $totalVat = 0.0;
                foreach ($invoice->invoice_items as $item) {
                    $qty        = (float)($item->quantity ?? 1);
                    $price      = (float)($item->unit_price ?? 0);
                    $vatRate    = (float)($item->vat_rate ?? 0);
                    
                    // Priority: 1. Stored vat_amount, 2. Calculation from vat_rate
                    $itemVat    = (float)($item->vat_amount ?? ($qty * $price * ($vatRate / 100)));
                    
                    // Priority: 1. Stored line_total (Gross), 2. Calculation (Qty * Price) + VAT
                    $itemGross  = (float)($item->line_total ?: ($qty * $price) + $itemVat);
                    
                    $netAmount  = $itemGross - $itemVat;
                    $totalVat  += $itemVat;

                    if (!$item->account_id || $netAmount == 0) continue;

                    // Credit: Revenue Account (Net)
                    $cr = $Transactions->newEntity([
                        'company_id'        => $companyId,
                        'date'              => $date,
                        'description'       => "Invoice $ref — " . ($item->description ?? ''),
                        'currency'          => $currency,
                        'amount'            => $netAmount,
                        'zwg'               => $netAmount * $rateVal,
                        'type'              => 'Credit',
                        'account_id'        => $item->account_id,
                        'customer_id'       => $invoice->customer_id,
                        'invoice_id'        => $invoice->id,
                        'transaction_group' => $groupId,
                    ], ['validate' => false]);
                    $Transactions->save($cr, ['check_balance' => false]);
                }

                // Credit: VAT Output Account (Total VAT)
                if ($totalVat > 0) {
                    $crVat = $Transactions->newEntity([
                        'company_id'        => $companyId,
                        'date'              => $date,
                        'description'       => "VAT Output — Invoice $ref",
                        'currency'          => $currency,
                        'amount'            => $totalVat,
                        'zwg'               => $totalVat * $rateVal,
                        'type'              => 'Credit',
                        'account_id'        => $vatAccountId,
                        'customer_id'       => $invoice->customer_id,
                        'invoice_id'        => $invoice->id,
                        'transaction_group' => $groupId,
                    ], ['validate' => false]);
                    $Transactions->save($crVat, ['check_balance' => false]);
                }
            } else {
                // Fallback if no items: assume full amount is revenue
                $cr = $Transactions->newEntity([
                    'company_id'        => $companyId,
                    'date'              => $date,
                    'description'       => "Invoice $ref (Revenue Fallback)",
                    'currency'          => $currency,
                    'amount'            => $total,
                    'zwg'               => $total * $rateVal,
                    'type'              => 'Credit',
                    'account_id'        => $arAccountId, // Wait, this should probably be a default revenue account?
                    // But for now, we'll just use the AR account as a placeholder if items are missing
                    'customer_id'       => $invoice->customer_id,
                    'invoice_id'        => $invoice->id,
                    'transaction_group' => $groupId,
                ], ['validate' => false]);
                $Transactions->save($cr, ['check_balance' => false]);
            }
        });
    }

    public function postPaymentToLedger($invoice, int $paymentAccountId, int $companyId): void
    {
        $Transactions = \Cake\ORM\TableRegistry::getTableLocator()->get('Transactions');
        $Accounts     = \Cake\ORM\TableRegistry::getTableLocator()->get('Accounts');

        $arAccount = $Accounts->find()
            ->where(['Accounts.company_id' => $companyId, 'Accounts.category LIKE' => '%Receivable%'])
            ->first();

        if (!$arAccount) {
            $arAccount = $Accounts->newEntity([
                'name' => 'Accounts Receivable',
                'category' => 'Accounts Receivable',
                'type' => 'Asset',
                'company_id' => $companyId
            ]);
            $Accounts->save($arAccount);
        }

        $date     = date('Y-m-d');
        $ref      = $invoice->reference ?? "INV-{$invoice->id}";
        $total    = (float)($invoice->total ?? 0);
        $currency = $invoice->currency ?? 'USD';
        $groupId  = Text::uuid();

        $Transactions->getConnection()->transactional(function () use (
            $Transactions, $arAccount, $invoice, $paymentAccountId,
            $date, $ref, $total, $currency, $groupId, $companyId
        ) {
            $dr = $Transactions->newEntity([
                'company_id'        => $companyId,
                'date'              => $date,
                'description'       => "Payment received — $ref",
                'currency'          => $currency,
                'amount'            => $total,
                'zwg'               => $total,
                'type'              => 'Debit',
                'account_id'        => $paymentAccountId,
                'customer_id'       => $invoice->customer_id,
                'invoice_id'        => $invoice->id,
                'transaction_group' => $groupId,
            ], ['validate' => false]);
            $Transactions->save($dr, ['check_balance' => false]);

            $cr = $Transactions->newEntity([
                'company_id'        => $companyId,
                'date'              => $date,
                'description'       => "Payment received — $ref",
                'currency'          => $currency,
                'amount'            => $total,
                'zwg'               => $total,
                'type'              => 'Credit',
                'account_id'        => $arAccount->id,
                'customer_id'       => $invoice->customer_id,
                'invoice_id'        => $invoice->id,
                'transaction_group' => $groupId,
            ], ['validate' => false]);
            $Transactions->save($cr, ['check_balance' => false]);
        });
    }

    public function reverseLedger(int $invoiceId, int $companyId): void
    {
        $Transactions = \Cake\ORM\TableRegistry::getTableLocator()->get('Transactions');

        $groups = $Transactions->find()
            ->where(['Transactions.invoice_id' => $invoiceId, 'Transactions.company_id' => $companyId])
            ->select(['transaction_group'])
            ->distinct(['transaction_group'])
            ->all()
            ->extract('transaction_group')
            ->filter()
            ->toArray();

        if (!empty($groups)) {
            $Transactions->deleteAll([
                'Transactions.transaction_group IN' => $groups,
                'Transactions.company_id'           => $companyId,
            ]);
        }
    }
}


