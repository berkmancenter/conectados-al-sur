<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrganizationTypes Model
 *
 * @property \Cake\ORM\Association\HasMany $Projects
 * @property \Cake\ORM\Association\HasMany $Users
 *
 * @method \App\Model\Entity\OrganizationType get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrganizationType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OrganizationType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrganizationType|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrganizationType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrganizationType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrganizationType findOrCreate($search, callable $callback = null)
 */
class OrganizationTypesTable extends Table
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

        $this->table('organization_types');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->hasMany('Projects', [
            'foreignKey' => 'organization_type_id'
        ]);
        $this->hasMany('Users', [
            'foreignKey' => 'organization_type_id'
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

        return $validator;
    }
}
