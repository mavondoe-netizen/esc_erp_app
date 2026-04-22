<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PayslipItems Model
 *
 * @property \App\Model\Table\PayslipsTable&\Cake\ORM\Association\BelongsTo $Payslips
 *
 * @method \App\Model\Entity\PayslipItem newEmptyEntity()
 * @method \App\Model\Entity\PayslipItem newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\PayslipItem> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PayslipItem get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\PayslipItem findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\PayslipItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\PayslipItem> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PayslipItem|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\PayslipItem saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\PayslipItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PayslipItem>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PayslipItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PayslipItem> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PayslipItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PayslipItem>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PayslipItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PayslipItem> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \App\Model\Behavior\TenantAwareBehavior
 */
class PayslipItemsTable extends Table
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

        $this->setTable('payslip_items');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Payslips', [
            'foreignKey' => 'payslip_id',
            'joinType' => 'INNER',
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
            ->integer('payslip_id')
            ->notEmptyString('payslip_id');

        $validator
            ->scalar('item_type')
            ->maxLength('item_type', 255)
            ->requirePresence('item_type', 'create')
            ->notEmptyString('item_type');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->decimal('amount')
            ->requirePresence('amount', 'create')
            ->notEmptyString('amount');

        $validator
            ->boolean('is_permanent')
            ->allowEmptyString('is_permanent');

        $validator
            ->scalar('currency')
            ->allowEmptyString('currency');

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
        $rules->add($rules->existsIn(['payslip_id'], 'Payslips'), ['errorField' => 'payslip_id']);
        $rules->add($rules->existsIn(['company_id'], 'Companies'), ['errorField' => 'company_id']);

        return $rules;
    }
}
