<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Subcontinents Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Continents
 * @property \Cake\ORM\Association\HasMany $Countries
 *
 * @method \App\Model\Entity\Subcontinent get($primaryKey, $options = [])
 * @method \App\Model\Entity\Subcontinent newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Subcontinent[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Subcontinent|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Subcontinent patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Subcontinent[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Subcontinent findOrCreate($search, callable $callback = null)
 */
class SubcontinentsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('subcontinents');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('Continents', [
            'foreignKey' => 'continent_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Countries', [
            'foreignKey' => 'subcontinent_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->requirePresence('name_es', 'create')
            ->notEmpty('name_es');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['continent_id'], 'Continents'));
        return $rules;
    }
}
