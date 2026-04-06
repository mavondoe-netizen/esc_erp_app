<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TaxTables Model
 *
 * @method \App\Model\Entity\TaxTable newEmptyEntity()
 * @method \App\Model\Entity\TaxTable newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\TaxTable> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TaxTable get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\TaxTable findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\TaxTable patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\TaxTable> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\TaxTable|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\TaxTable saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\TaxTable>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TaxTable>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\TaxTable>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TaxTable> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\TaxTable>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TaxTable>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\TaxTable>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TaxTable> deleteManyOrFail(iterable $entities, array $options = [])
 */
class TaxTablesTable extends Table
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

        $this->setTable('tax_tables');
        $this->setDisplayField('currency');
        $this->setPrimaryKey('id');
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
            ->scalar('currency')
            ->maxLength('currency', 151)
            ->requirePresence('currency', 'create')
            ->notEmptyString('currency');

        $validator
            ->integer('lower_limit')
            ->requirePresence('lower_limit', 'create')
            ->notEmptyString('lower_limit');

        $validator
            ->integer('upper_limit')
            ->requirePresence('upper_limit', 'create')
            ->notEmptyString('upper_limit');

        $validator
            ->numeric('rate')
            ->requirePresence('rate', 'create')
            ->notEmptyString('rate');

        $validator
            ->numeric('deduction')
            ->requirePresence('deduction', 'create')
            ->notEmptyString('deduction');

        $validator
            ->date('tax_year')
            ->requirePresence('tax_year', 'create')
            ->notEmptyDate('tax_year');

        return $validator;
    }
}
