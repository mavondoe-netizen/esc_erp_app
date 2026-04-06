<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Buildings Model
 *
 * @property \App\Model\Table\InvestorsTable&\Cake\ORM\Association\BelongsTo $Investors
 * @property \App\Model\Table\BillsTable&\Cake\ORM\Association\HasMany $Bills
 * @property \App\Model\Table\TransactionsTable&\Cake\ORM\Association\HasMany $Transactions
 * @property \App\Model\Table\UnitsTable&\Cake\ORM\Association\HasMany $Units
 *
 * @method \App\Model\Entity\Building newEmptyEntity()
 * @method \App\Model\Entity\Building newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Building> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Building get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Building findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Building patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Building> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Building|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Building saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Building>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Building>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Building>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Building> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Building>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Building>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Building>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Building> deleteManyOrFail(iterable $entities, array $options = [])
 */
class BuildingsTable extends Table
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

        $this->setTable('buildings');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Investors', [
            'foreignKey' => 'investor_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Bills', [
            'foreignKey' => 'building_id',
        ]);
        $this->hasMany('Transactions', [
            'foreignKey' => 'building_id',
        ]);
        $this->hasMany('Units', [
            'foreignKey' => 'building_id',
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
            ->scalar('address')
            ->maxLength('address', 151)
            ->requirePresence('address', 'create')
            ->notEmptyString('address');

        $validator
            ->integer('investor_id')
            ->notEmptyString('investor_id');

        $validator
            ->dateTime('start_date')
            ->requirePresence('start_date', 'create')
            ->notEmptyDateTime('start_date');

        $validator
            ->boolean('isvacant')
            ->requirePresence('isvacant', 'create')
            ->notEmptyString('isvacant');

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
        $rules->add($rules->existsIn(['investor_id'], 'Investors'), ['errorField' => 'investor_id']);

        return $rules;
    }
}
