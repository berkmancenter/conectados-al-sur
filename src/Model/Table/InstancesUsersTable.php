<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\View\Helper\LocHelper;

class InstancesUsersTable extends Table
{

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('instances_users');
        $this->displayField('instance_id');
        $this->primaryKey(['instance_id', 'user_id']);

        $this->belongsTo('Instances', [
            'foreignKey' => 'instance_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('OrganizationTypes', [
            'foreignKey' => 'organization_type_id',
            'joinType' => 'INNER'
        ]);
    }


    public function validationDefault(Validator $validator)
    {
        $locHelper = new LocHelper(new \Cake\View\View());
        $str_orgname = __d('users', 'Organization Name');

        $validator = $this->validationContact($validator);

        $validator
            ->requirePresence('main_organization', 'create')
            ->notEmpty('main_organization', $locHelper->validationNotEmpty($str_orgname))
            ->add('main_organization', [
                'minLength' => $locHelper->validationMinLength($str_orgname , 3),
                'maxLength' => $locHelper->validationMaxLength($str_orgname , 100)
            ]);

        return $validator;
    }

    public function validationContact(Validator $validator) {
        $locHelper = new LocHelper(new \Cake\View\View());

        $validator            
            ->requirePresence('contact', 'create')
            ->notEmpty('contact', __d('users', 'Please, fill your contact email.'))
            ->add('contact', [
                'regex' => [
                    'rule' => 'email',
                    'message' => __d('users', 'The contact email is invalid.')
                ],
            ]);

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
        $rules->add($rules->existsIn(['instance_id'], 'Instances'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['role_id'], 'Roles'));
        $rules->add($rules->existsIn(['organization_type_id'], 'OrganizationTypes'));

        return $rules;
    }
}
