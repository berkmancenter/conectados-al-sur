<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ProjectsTable extends Table
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

        $this->table('projects');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Instances', [
            'foreignKey' => 'instance_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('OrganizationTypes', [
            'foreignKey' => 'organization_type_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ProjectStages', [
            'foreignKey' => 'project_stage_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Countries', [
            'foreignKey' => 'country_id',
            'joinType' => 'INNER'
        ]);
        // $this->belongsTo('Countries', [
        //     'foreignKey' => 'country2_id',
        //     'joinType' => 'INNER'
        // ]);
        // $this->belongsTo('Countries', [
        //     'foreignKey' => 'country3_id',
        //     'joinType' => 'INNER'
        // ]);
        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id'
        ]);
        $this->belongsToMany('Categories', [
            'foreignKey' => 'project_id',
            'targetForeignKey' => 'category_id',
            'joinTable' => 'categories_projects'
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
            ->allowEmpty('id', 'create')
            ->add('id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->requirePresence('description', 'create')
            ->notEmpty('description');

        $validator
            ->requirePresence('url', 'create')
            ->notEmpty('url');

        $validator
            ->requirePresence('contribution', 'create')
            ->notEmpty('contribution');

        $validator
            ->requirePresence('contributing', 'create')
            ->notEmpty('contributing');

        $validator
            ->allowEmpty('organization');

        $validator
            ->numeric('latitude')
            ->allowEmpty('latitude');

        $validator
            ->numeric('longitude')
            ->allowEmpty('longitude');

        $validator
            ->date('start_date')
            ->allowEmpty('start_date');

        $validator
            ->date('finish_date')
            ->allowEmpty('finish_date');

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
        $rules->add($rules->isUnique(['id']));
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['instance_id'], 'Instances'));
        $rules->add($rules->existsIn(['organization_type_id'], 'OrganizationTypes'));
        $rules->add($rules->existsIn(['project_stage_id'], 'ProjectStages'));
        $rules->add($rules->existsIn(['country_id'], 'Countries'));
        // $rules->add($rules->existsIn(['country2_id'], 'Countries'));
        // $rules->add($rules->existsIn(['country3_id'], 'Countries'));
        $rules->add($rules->existsIn(['city_id'], 'Cities'));

        return $rules;
    }

    public function isOwnedBy($project_id, $user_id)
    {
        return $this->exists(['id' => $project_id, 'user_id' => $user_id]);
    }    
}
