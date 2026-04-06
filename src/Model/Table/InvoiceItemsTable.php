<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * InvoiceItems Model
 *
 * @property \App\Model\Table\InvoicesTable&\Cake\ORM\Association\BelongsTo $Invoices
 * @property \App\Model\Table\AccountsTable&\Cake\ORM\Association\BelongsTo $Accounts
 *
 * @method \App\Model\Entity\InvoiceItem newEmptyEntity()
 * @method \App\Model\Entity\InvoiceItem newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\InvoiceItem> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\InvoiceItem get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\InvoiceItem findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\InvoiceItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\InvoiceItem> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\InvoiceItem|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\InvoiceItem saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\InvoiceItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\InvoiceItem>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\InvoiceItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\InvoiceItem> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\InvoiceItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\InvoiceItem>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\InvoiceItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\InvoiceItem> deleteManyOrFail(iterable $entities, array $options = [])
 */
class InvoiceItemsTable extends Table
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

        $this->setTable('invoice_items');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Invoices', [
            'foreignKey' => 'invoice_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Accounts', [
            'foreignKey' => 'account_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
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
            ->integer('invoice_id')
            ->notEmptyString('invoice_id');

        $validator
            ->integer('account_id')
            ->notEmptyString('account_id');

        $validator
            ->integer('quantity')
            ->requirePresence('quantity', 'create')
            ->notEmptyString('quantity');

        $validator
            ->numeric('unit_price')
            ->requirePresence('unit_price', 'create')
            ->notEmptyString('unit_price');

        $validator
            ->numeric('line_total')
            ->requirePresence('line_total', 'create')
            ->notEmptyString('line_total');

        $validator
            ->integer('product_id')
            ->allowEmptyString('product_id');

        $validator
            ->decimal('vat_rate')
            ->allowEmptyString('vat_rate');

        $validator
            ->decimal('vat_amount')
            ->allowEmptyString('vat_amount');

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
        $rules->add($rules->existsIn(['invoice_id'], 'Invoices'), ['errorField' => 'invoice_id']);
        $rules->add($rules->existsIn(['account_id'], 'Accounts'), ['errorField' => 'account_id']);
        $rules->add($rules->existsIn(['product_id'], 'Products'), ['errorField' => 'product_id']);

        return $rules;
    }
}
