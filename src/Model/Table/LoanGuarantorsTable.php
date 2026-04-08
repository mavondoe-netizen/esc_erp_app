<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LoanGuarantors Model
 *
 * @property \App\Model\Table\LoanApplicationsTable&\Cake\ORM\Association\BelongsTo $LoanApplications
 *
 * @method \App\Model\Entity\LoanGuarantor newEmptyEntity()
 * @method \App\Model\Entity\LoanGuarantor newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\LoanGuarantor> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LoanGuarantor get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\LoanGuarantor findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\LoanGuarantor patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\LoanGuarantor> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\LoanGuarantor|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\LoanGuarantor saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\LoanGuarantor>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanGuarantor>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LoanGuarantor>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanGuarantor> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LoanGuarantor>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanGuarantor>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LoanGuarantor>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LoanGuarantor> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LoanGuarantorsTable extends Table
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

        $this->setTable('loan_guarantors');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('LoanApplications', [
            'foreignKey' => 'loan_application_id',
            'joinType' => 'INNER',
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
            ->integer('loan_application_id')
            ->notEmptyString('loan_application_id');

        $validator
            ->scalar('name')
            ->maxLength('name', 200)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('national_id')
            ->maxLength('national_id', 100)
            ->allowEmptyString('national_id');

        $validator
            ->scalar('relationship')
            ->maxLength('relationship', 100)
            ->allowEmptyString('relationship');

        $validator
            ->scalar('phone')
            ->maxLength('phone', 50)
            ->allowEmptyString('phone');

        $validator
            ->scalar('employer')
            ->maxLength('employer', 200)
            ->allowEmptyString('employer');

        $validator
            ->decimal('monthly_income')
            ->allowEmptyString('monthly_income');

        $validator
            ->scalar('currency')
            ->maxLength('currency', 10)
            ->notEmptyString('currency');

        $validator
            ->scalar('status')
            ->maxLength('status', 30)
            ->notEmptyString('status');

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
        $rules->add($rules->existsIn(['loan_application_id'], 'LoanApplications'), ['errorField' => 'loan_application_id']);

        return $rules;
    }
}
