<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Instances Model
 *
 * @property \Cake\ORM\Association\HasMany $Categories
 * @property \Cake\ORM\Association\HasMany $OrganizationTypes
 * @property \Cake\ORM\Association\HasMany $Projects
 * @property \Cake\ORM\Association\HasMany $Users
 *
 * @method \App\Model\Entity\Instance get($primaryKey, $options = [])
 * @method \App\Model\Entity\Instance newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Instance[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Instance|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Instance patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Instance[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Instance findOrCreate($search, callable $callback = null)
 */
class InstancesTable extends Table
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

        $this->table('instances');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->hasMany('Categories', [
            'foreignKey' => 'instance_id'
        ]);
        $this->hasMany('OrganizationTypes', [
            'foreignKey' => 'instance_id'
        ]);
        $this->hasMany('Projects', [
            'foreignKey' => 'instance_id'
        ]);
        $this->hasMany('Users', [
            'foreignKey' => 'instance_id'
        ]);
        $this->addBehavior('Utils.Uploadable', [
            'logo' => [
                'removeFileOnUpdate' => true,
                'removeFileOnDelete' => true,
                'path' => '{ROOT}{DS}{WEBROOT}{DS}img{DS}{model}{DS}',
                'fileName' => '{field}.{extension}'
            ],
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
            ->notEmpty('name')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->requirePresence('name_es', 'create')
            ->notEmpty('name_es')
            ->add('name_es', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->requirePresence('namespace', 'create')
            ->notEmpty('namespace')
            ->add('namespace', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->requirePresence('description', 'create')
            ->notEmpty('description');

        $validator
            ->requirePresence('description_es', 'create')
            ->notEmpty('description_es');

        $validator
            ->allowEmpty('logo');

        $validator
            ->boolean('use_org_types')
            ->requirePresence('use_org_types', 'create')
            ->notEmpty('use_org_types');

        $validator
            ->boolean('use_user_genre')
            ->requirePresence('use_user_genre', 'create')
            ->notEmpty('use_user_genre');

        $validator
            ->boolean('use_user_organization')
            ->requirePresence('use_user_organization', 'create')
            ->notEmpty('use_user_organization');

        $validator
            ->boolean('use_proj_cities')
            ->requirePresence('use_proj_cities', 'create')
            ->notEmpty('use_proj_cities');

        $validator
            ->boolean('use_proj_stage')
            ->requirePresence('use_proj_stage', 'create')
            ->notEmpty('use_proj_stage');

        $validator
            ->boolean('use_proj_categories')
            ->requirePresence('use_proj_categories', 'create')
            ->notEmpty('use_proj_categories');

        $validator
            ->boolean('use_proj_description')
            ->requirePresence('use_proj_description', 'create')
            ->notEmpty('use_proj_description');

        $validator
            ->boolean('use_proj_url')
            ->requirePresence('use_proj_url', 'create')
            ->notEmpty('use_proj_url');

        $validator
            ->boolean('use_proj_contribution')
            ->requirePresence('use_proj_contribution', 'create')
            ->notEmpty('use_proj_contribution');

        $validator
            ->boolean('use_proj_contributing')
            ->requirePresence('use_proj_contributing', 'create')
            ->notEmpty('use_proj_contributing');

        $validator
            ->boolean('use_proj_organization')
            ->requirePresence('use_proj_organization', 'create')
            ->notEmpty('use_proj_organization');

        $validator
            ->boolean('use_proj_location')
            ->requirePresence('use_proj_location', 'create')
            ->notEmpty('use_proj_location');

        $validator
            ->boolean('use_proj_dates')
            ->requirePresence('use_proj_dates', 'create')
            ->notEmpty('use_proj_dates');

        $validator
            ->integer('proj_max_categories')
            ->requirePresence('proj_max_categories', 'create')
            ->notEmpty('proj_max_categories');

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
        $rules->add($rules->isUnique(['name']));
        $rules->add($rules->isUnique(['name_es']));
        $rules->add($rules->isUnique(['namespace']));
        return $rules;
    }
}
