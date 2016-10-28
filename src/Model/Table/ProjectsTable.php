<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\View\Helper\LocHelper;

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
        $locHelper = new LocHelper(new \Cake\View\View());
        $str_name  = __d('projects','Name');
        $str_description   = __d('projects','Description');
        $str_contribution  = __d('projects','Project Contribution');
        $str_contributing  = __d('projects','Contributing to this project');
        $str_organization  = __d('projects','Organization');
        $str_country       = __d('projects','Country');
        $str_organization_type  = __d('projects','Organization Type');
        $str_project_stage      = __d('projects','Project Stage');

        $validator
            ->integer('id')
            ->allowEmpty('id', 'create')
            ->add('id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name', __d('projects', 'Please, fill the project name.'))
            ->add('name', [
                'minLength' => $locHelper->validationMinLength($str_name , 5),
                'maxLength' => $locHelper->validationMaxLength($str_name , 80)
            ]);

        $validator
            ->allowEmpty('url');

        $validator
            ->requirePresence('organization', 'create')
            ->notEmpty('organization', __d('projects', 'Please, write the related Organization name.'))
            ->add('organization', [
                'minLength' => $locHelper->validationMinLength($str_organization , 3),
                'maxLength' => $locHelper->validationMaxLength($str_organization , 80)
            ]);

        $validator
            ->requirePresence('description', 'create')
            ->notEmpty('description', $locHelper->validationNotEmpty($str_description))
            ->add('description', [
                'minLength' => $locHelper->validationMinLength($str_description , 40),
                'maxLength' => $locHelper->validationMaxLength($str_description , 1000)
            ]);

        $validator
            ->requirePresence('contribution', 'create')
            ->notEmpty('contribution', $locHelper->validationNotEmpty($str_contribution))
            ->add('contribution', [
                'minLength' => $locHelper->validationMinLength($str_contribution , 10),
                'maxLength' => $locHelper->validationMaxLength($str_contribution , 1000)
            ]);

        $validator
            ->requirePresence('contributing', 'create')
            ->notEmpty('contributing', $locHelper->validationNotEmpty($str_contributing))
            ->add('contributing', [
                'minLength' => $locHelper->validationMinLength($str_contributing , 10),
                'maxLength' => $locHelper->validationMaxLength($str_contributing , 1000)
            ]);



        $validator
            ->date('start_date')
            ->allowEmpty('start_date');

        $validator
            ->date('finish_date')
            ->allowEmpty('finish_date');

        $validator
            ->numeric('latitude')
            ->allowEmpty('latitude');

        $validator
            ->numeric('longitude')
            ->allowEmpty('longitude');

        $validator
            ->requirePresence('country_id', 'create')
            ->notEmpty('country_id', $locHelper->validationNotEmpty($str_country));

        $validator
            ->requirePresence('organization_type_id', 'create')
            ->notEmpty('organization_type_id', $locHelper->validationNotEmpty($str_organization_type));

        $validator
            ->requirePresence('project_stage_id', 'create')
            ->notEmpty('project_stage_id', $locHelper->validationNotEmpty($str_project_stage));

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
