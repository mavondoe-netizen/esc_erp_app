<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tenders Model
 *
 * @property \App\Model\Table\ProcurementsTable&\Cake\ORM\Association\BelongsTo $Procurements
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\AwardsTable&\Cake\ORM\Association\HasMany $Awards
 * @property \App\Model\Table\EvaluationsTable&\Cake\ORM\Association\HasMany $Evaluations
 * @property \App\Model\Table\TenderBidsTable&\Cake\ORM\Association\HasMany $TenderBids
 *
 * @method \App\Model\Entity\Tender newEmptyEntity()
 * @method \App\Model\Entity\Tender newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Tender> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Tender get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Tender findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Tender patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Tender> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Tender|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Tender saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Tender>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Tender>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Tender>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Tender> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Tender>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Tender>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Tender>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Tender> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TendersTable extends Table
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

        $this->setTable('tenders');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('TenantAware');

        $this->belongsTo('Procurements', [
            'foreignKey' => 'procurement_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
        ]);
        $this->hasMany('Awards', [
            'foreignKey' => 'tender_id',
        ]);
        $this->hasMany('Evaluations', [
            'foreignKey' => 'tender_id',
        ]);
        $this->hasMany('TenderBids', [
            'foreignKey' => 'tender_id',
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
            ->integer('procurement_id')
            ->notEmptyString('procurement_id');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->dateTime('closing_date')
            ->allowEmptyDateTime('closing_date');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->allowEmptyString('status');

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
        $rules->add($rules->existsIn(['procurement_id'], 'Procurements'), ['errorField' => 'procurement_id']);
        $rules->add($rules->existsIn(['company_id'], 'Companies'), ['errorField' => 'company_id']);

        return $rules;
    }
}
