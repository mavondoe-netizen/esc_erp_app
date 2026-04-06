<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CreditNoteItems Model
 *
 * @property \App\Model\Table\CreditNotesTable&\Cake\ORM\Association\BelongsTo $CreditNotes
 * @property \App\Model\Table\ProductsTable&\Cake\ORM\Association\BelongsTo $Products
 * @property \App\Model\Table\AccountsTable&\Cake\ORM\Association\BelongsTo $Accounts
 *
 * @method \App\Model\Entity\CreditNoteItem newEmptyEntity()
 * @method \App\Model\Entity\CreditNoteItem newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\CreditNoteItem> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CreditNoteItem get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\CreditNoteItem findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\CreditNoteItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\CreditNoteItem> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CreditNoteItem|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\CreditNoteItem saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\CreditNoteItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CreditNoteItem>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CreditNoteItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CreditNoteItem> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CreditNoteItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CreditNoteItem>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CreditNoteItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CreditNoteItem> deleteManyOrFail(iterable $entities, array $options = [])
 */
class CreditNoteItemsTable extends Table
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

        $this->setTable('credit_note_items');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('CreditNotes', [
            'foreignKey' => 'credit_note_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
        ]);
        $this->belongsTo('Accounts', [
            'foreignKey' => 'account_id',
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
            ->integer('credit_note_id')
            ->notEmptyString('credit_note_id');

        $validator
            ->integer('product_id')
            ->allowEmptyString('product_id');

        $validator
            ->integer('account_id')
            ->notEmptyString('account_id');

        $validator
            ->decimal('quantity')
            ->allowEmptyString('quantity');

        $validator
            ->decimal('unit_price')
            ->allowEmptyString('unit_price');

        $validator
            ->decimal('line_total')
            ->allowEmptyString('line_total');

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
        $rules->add($rules->existsIn(['credit_note_id'], 'CreditNotes'), ['errorField' => 'credit_note_id']);
        $rules->add($rules->existsIn(['product_id'], 'Products'), ['errorField' => 'product_id']);
        $rules->add($rules->existsIn(['account_id'], 'Accounts'), ['errorField' => 'account_id']);

        return $rules;
    }
}
