<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * InstancesUsers Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Instances
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $Roles
 * @property \Cake\ORM\Association\BelongsTo $OrganizationTypes
 *
 * @method \App\Model\Entity\InstancesUser get($primaryKey, $options = [])
 * @method \App\Model\Entity\InstancesUser newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\InstancesUser[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\InstancesUser|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InstancesUser patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\InstancesUser[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\InstancesUser findOrCreate($search, callable $callback = null)
 */
class InstancesUsersTable extends Table
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

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->allowEmpty('contact');

        $validator
            ->allowEmpty('main_organization');

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
