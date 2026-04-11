<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Accounts Model
 *
 * @property \App\Model\Table\BenefitsTable&\Cake\ORM\Association\HasMany $Benefits
 * @property \App\Model\Table\BillItemsTable&\Cake\ORM\Association\HasMany $BillItems
 * @property \App\Model\Table\InvoiceItemsTable&\Cake\ORM\Association\HasMany $InvoiceItems
 * @property \App\Model\Table\ReceiptsTable&\Cake\ORM\Association\HasMany $Receipts
 * @property \App\Model\Table\TransactionsTable&\Cake\ORM\Association\HasMany $Transactions
 * @property \App\Model\Table\InvoicesTable&\Cake\ORM\Association\BelongsToMany $Invoices
 *
 * @method \App\Model\Entity\Account newEmptyEntity()
 * @method \App\Model\Entity\Account newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Account> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Account get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Account findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Account patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Account> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Account|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Account saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Account>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Account>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Account>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Account> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Account>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Account>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Account>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Account> deleteManyOrFail(iterable $entities, array $options = [])
 */
class AccountsTable extends Table
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

        $this->setTable('accounts');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

       
        $this->hasMany('BillItems', [
            'foreignKey' => 'account_id',
        ]);
        $this->hasMany('InvoiceItems', [
            'foreignKey' => 'account_id',
        ]);
        $this->hasMany('Receipts', [
            'foreignKey' => 'account_id',
        ]);
        $this->hasMany('Transactions', [
            'foreignKey' => 'account_id',
        ]);
        $this->hasMany('Budgets', [
            'foreignKey' => 'account_id',
        ]);
        $this->belongsToMany('Invoices', [
            'foreignKey' => 'account_id',
            'targetForeignKey' => 'invoice_id',
            'joinTable' => 'accounts_invoices',
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
            ->scalar('name')
            ->maxLength('name', 151)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('category')
            ->maxLength('category', 151)
            ->requirePresence('category', 'create')
            ->notEmptyString('category');

        $validator
            ->scalar('type')
            ->maxLength('type', 151)
            ->requirePresence('type', 'create')
            ->notEmptyString('type');

        $validator
            ->scalar('subcategory')
            ->maxLength('subcategory', 255)
            ->allowEmptyString('subcategory');

        $validator
            ->numeric('opening_balance')
            ->allowEmptyString('opening_balance');

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
        $rules->add(function ($entity, $options) {
            // We only check if opening_balance is actually being set or changed
            if (!$entity->isDirty('opening_balance')) {
                return true;
            }

            $total = $this->find()
                ->where(['company_id' => $entity->company_id])
                ->sumOf('opening_balance');

            // Find current value in DB to subtract it (since sumOf includes it if it's already saved)
            // Or if it's a new entity, it's not in the sum yet.
            $currentInDb = 0;
            if (!$entity->isNew()) {
                $original = $this->get($entity->id);
                $currentInDb = (float)$original->opening_balance;
            }

            $newTotal = ($total - $currentInDb) + (float)$entity->opening_balance;

            if (abs($newTotal) > 0.001) {
                return false;
            }

            return true;
        }, 'checkOpeningBalancesBalance', [
            'errorField' => 'opening_balance',
            'message' => 'The sum of all opening balances must be zero.'
        ]);

        return $rules;
    }
}
