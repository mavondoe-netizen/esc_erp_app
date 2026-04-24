<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LevyItems Model
 *
 * @mixin \App\Model\Behavior\TenantAwareBehavior
 * @property \App\Model\Table\LeviesTable&\Cake\ORM\Association\BelongsTo $Levies
 * @property \App\Model\Table\AccountsTable&\Cake\ORM\Association\BelongsTo $Accounts
 * @property \App\Model\Table\ProductsTable&\Cake\ORM\Association\BelongsTo $Products
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 *
 * @method \App\Model\Entity\LevyItem newEmptyEntity()
 * @method \App\Model\Entity\LevyItem newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\LevyItem> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LevyItem get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\LevyItem findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\LevyItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\LevyItem> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\LevyItem|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\LevyItem saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\LevyItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LevyItem>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LevyItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LevyItem> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LevyItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LevyItem>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LevyItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LevyItem> deleteManyOrFail(iterable $entities, array $options = [])
 */
class LevyItemsTable extends Table
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

        $this->setTable('levy_items');
        $this->setDisplayField('description');
        $this->setPrimaryKey('id');

        $this->belongsTo('Levies', [
            'foreignKey' => 'levy_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Accounts', [
            'foreignKey' => 'account_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
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
            ->integer('levy_id')
            ->notEmptyString('levy_id');

        $validator
            ->integer('account_id')
            ->notEmptyString('account_id');

        $validator
            ->integer('product_id')
            ->allowEmptyString('product_id');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

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
            ->decimal('vat_rate')
            ->allowEmptyString('vat_rate');

        $validator
            ->decimal('vat_amount')
            ->allowEmptyString('vat_amount');

        $validator
            ->scalar('vat_type')
            ->maxLength('vat_type', 50)
            ->allowEmptyString('vat_type');

        $validator
            ->scalar('hs_code')
            ->maxLength('hs_code', 100)
            ->allowEmptyString('hs_code');

        $validator
            ->integer('company_id')
            ->allowEmptyString('company_id');

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
        $rules->add($rules->existsIn(['levy_id'], 'Levies'), ['errorField' => 'levy_id']);
        $rules->add($rules->existsIn(['account_id'], 'Accounts'), ['errorField' => 'account_id']);
        $rules->add($rules->existsIn(['company_id'], 'Companies'), ['errorField' => 'company_id']);

        return $rules;
    }
}
