<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\View\Helper\LocHelper;

/**
 * OrganizationTypes Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Instances
 * @property \Cake\ORM\Association\HasMany $Projects
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

        $this->belongsTo('Instances', [
            'foreignKey' => 'instance_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Projects', [
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
        $locHelper = new LocHelper(new \Cake\View\View());
        $loc_orgtype_name_en = $locHelper->fieldOrganizationTypeNameEn();
        $loc_orgtype_name_es = $locHelper->fieldOrganizationTypeNameEs();

        $validator
            ->integer('id')
            ->allowEmpty('id', 'create')
            ->add('id', 'unique', [
                'rule' => 'validateUnique',
                'provider' => 'table'
            ]);

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name', $locHelper->validationNotEmpty($loc_orgtype_name_en))
            ->add('name', [
                'minLength' => [
                    'rule' => ['minLength', 5],
                    'message' => $locHelper->validationMinLength($loc_orgtype_name_en , 5),
                ],
                'maxLength' => [
                    'rule' => ['maxLength', 50],
                    'message' => $locHelper->validationMaxLength($loc_orgtype_name_en , 50),
                ]
            ]);

        $validator
            ->requirePresence('name_es', 'create')
            ->notEmpty('name_es', $locHelper->validationNotEmpty($loc_orgtype_name_es))
            ->add('name_es', [
                'minLength' => [
                    'rule' => ['minLength', 5],
                    'message' => $locHelper->validationMinLength($loc_orgtype_name_es , 5),
                ],
                'maxLength' => [
                    'rule' => ['maxLength', 50],
                    'message' => $locHelper->validationMaxLength($loc_orgtype_name_es , 50),
                ]
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
        $rules->add($rules->isUnique(['id']));
        $rules->add($rules->existsIn(['instance_id'], 'Instances'));

        return $rules;
    }
}
