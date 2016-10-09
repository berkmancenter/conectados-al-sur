<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\View\Helper\LocHelper;

class InstancesTable extends Table
{

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
        $this->belongsToMany('Users', [
            'foreignKey' => 'instance_id',
            'targetForeignKey' => 'user_id',
            'joinTable' => 'instances_users'
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

    public function validationDefault(Validator $validator)
    {
        $locHelper = new LocHelper(new \Cake\View\View());
        $loc_instance_name_en = $locHelper->fieldInstanceNameEn();
        $loc_instance_name_es = $locHelper->fieldInstanceNameEn();
        $str_namespace = $locHelper->fieldInstanceNamespace();
        $str_description_en = $locHelper->fieldInstanceDescriptionEn();
        $str_description_es = $locHelper->fieldInstanceDescriptionEs();
        $str_passphrase = $locHelper->fieldInstancePassphrase();


        $validator
            ->integer('id')
            ->allowEmpty('id', 'create')
            ->add('id', 'unique', [
                'rule' => 'validateUnique',
                'provider' => 'table'
            ]);

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name', $locHelper->validationNotEmpty($loc_instance_name_en))
            ->add('name', [
                'minLength' => $locHelper->validationMinLength($loc_instance_name_en , 5),
                'maxLength' => $locHelper->validationMaxLength($loc_instance_name_en , 25),
                'unique'    => $locHelper->validationUnique($loc_instance_name_en)
            ]);

        $validator
            ->requirePresence('name_es', 'create')
            ->notEmpty('name_es', $locHelper->validationNotEmpty($loc_instance_name_es))
            ->add('name_es', [
                'minLength' => $locHelper->validationMinLength($loc_instance_name_es , 5),
                'maxLength' => $locHelper->validationMaxLength($loc_instance_name_es , 25),
                'unique'    => $locHelper->validationUnique($loc_instance_name_es)
            ]);
        
        
        $validator
            ->requirePresence('namespace', 'create')
            ->notEmpty('namespace', $locHelper->validationNotEmpty($str_namespace))
            ->add('namespace', [
                'minLength' => $locHelper->validationMinLength($str_namespace , 3),
                'maxLength' => $locHelper->validationMaxLength($str_namespace , 10),
                'unique'    => $locHelper->validationUnique($str_passphrase)
            ]);

        $validator
            ->requirePresence('description', 'create')
            ->notEmpty('description', $locHelper->validationNotEmpty($str_description_en))
            ->add('description', [
                'minLength' => $locHelper->validationMinLength($str_description_en , 80),
                'maxLength' => $locHelper->validationMaxLength($str_description_en , 500)
            ]);
        $validator
            ->requirePresence('description_es', 'create')
            ->notEmpty('description_es', $locHelper->validationNotEmpty($str_description_es))
            ->add('description_es', [
                'minLength' => $locHelper->validationMinLength($str_description_es , 80),
                'maxLength' => $locHelper->validationMaxLength($str_description_es , 500)
            ]);

        $validator
            ->requirePresence('passphrase', 'create')
            ->notEmpty('passphrase', $locHelper->validationNotEmpty($str_passphrase))
            ->add('passphrase', [
                'minLength' => $locHelper->validationMinLength($str_passphrase , 5),
                'maxLength' => $locHelper->validationMaxLength($str_passphrase , 40)
            ]);


        $validator->allowEmpty('logo');

        $validator
            ->boolean('use_org_types')
            //->requirePresence('use_org_types', 'create')
            ->notEmpty('use_org_types');

        $validator
            ->boolean('use_user_genre')
            //->requirePresence('use_user_genre', 'create')
            ->notEmpty('use_user_genre');

        $validator
            ->boolean('use_user_organization')
            //->requirePresence('use_user_organization', 'create')
            ->notEmpty('use_user_organization');

        $validator
            ->boolean('use_proj_cities')
            //->requirePresence('use_proj_cities', 'create')
            ->notEmpty('use_proj_cities');

        $validator
            ->boolean('use_proj_stage')
            //->requirePresence('use_proj_stage', 'create')
            ->notEmpty('use_proj_stage');

        $validator
            ->boolean('use_proj_categories')
            //->requirePresence('use_proj_categories', 'create')
            ->notEmpty('use_proj_categories');

        $validator
            ->boolean('use_proj_description')
            //->requirePresence('use_proj_description', 'create')
            ->notEmpty('use_proj_description');

        $validator
            ->boolean('use_proj_url')
            //->requirePresence('use_proj_url', 'create')
            ->notEmpty('use_proj_url');

        $validator
            ->boolean('use_proj_contribution')
            //->requirePresence('use_proj_contribution', 'create')
            ->notEmpty('use_proj_contribution');

        $validator
            ->boolean('use_proj_contributing')
            //->requirePresence('use_proj_contributing', 'create')
            ->notEmpty('use_proj_contributing');

        $validator
            ->boolean('use_proj_organization')
            //->requirePresence('use_proj_organization', 'create')
            ->notEmpty('use_proj_organization');

        $validator
            ->boolean('use_proj_location')
            //->requirePresence('use_proj_location', 'create')
            ->notEmpty('use_proj_location');

        $validator
            ->boolean('use_proj_dates')
            //->requirePresence('use_proj_dates', 'create')
            ->notEmpty('use_proj_dates');

        $validator
            ->integer('proj_max_categories')
            //->requirePresence('proj_max_categories', 'create')
            ->notEmpty('proj_max_categories');

        return $validator;
    }

    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['id']));
        $rules->add($rules->isUnique(['name']));
        $rules->add($rules->isUnique(['name_es']));
        $rules->add($rules->isUnique(['namespace']));

        return $rules;
    }
}
