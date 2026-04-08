<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Documents Model
 *
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 *
 * @method \App\Model\Entity\Document newEmptyEntity()
 * @method \App\Model\Entity\Document newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Document> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Document get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Document findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Document patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Document> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Document|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Document saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Document>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Document>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Document>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Document> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Document>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Document>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Document>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Document> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DocumentsTable extends Table
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

        $this->setTable('documents');
        $this->setDisplayField('entity_type');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

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
            ->integer('company_id')
            ->allowEmptyString('company_id');

        $validator
            ->scalar('entity_type')
            ->maxLength('entity_type', 100)
            ->requirePresence('entity_type', 'create')
            ->notEmptyString('entity_type');

        $validator
            ->integer('entity_id')
            ->requirePresence('entity_id', 'create')
            ->notEmptyString('entity_id');

        $validator
            ->scalar('file_path')
            ->maxLength('file_path', 255)
            ->requirePresence('file_path', 'create')
            ->notEmptyString('file_path');

        $validator
            ->scalar('file_name')
            ->maxLength('file_name', 255)
            ->allowEmptyString('file_name');

        $validator
            ->integer('uploaded_by')
            ->allowEmptyString('uploaded_by');

        $validator
            ->dateTime('uploaded_at')
            ->allowEmptyDateTime('uploaded_at');

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
        $rules->add($rules->existsIn(['company_id'], 'Companies'), ['errorField' => 'company_id']);

        return $rules;
    }
}
