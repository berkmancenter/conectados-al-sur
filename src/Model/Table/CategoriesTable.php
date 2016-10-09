<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\View\Helper\LocHelper;

class CategoriesTable extends Table
{

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('categories');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('Instances', [
            'foreignKey' => 'instance_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsToMany('Projects', [
            'foreignKey' => 'category_id',
            'targetForeignKey' => 'project_id',
            'joinTable' => 'categories_projects'
        ]);
    }

    public function validationDefault(Validator $validator)
    {
        $locHelper = new LocHelper(new \Cake\View\View());
        $loc_cat_name_en = $locHelper->fieldCategoryNameEn();
        $loc_cat_name_es = $locHelper->fieldCategoryNameEs();

        $validator
            ->integer('id')
            ->allowEmpty('id', 'create')
            ->add('id', 'unique', [
                'rule' => 'validateUnique',
                'provider' => 'table'
            ]);

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name', $locHelper->validationNotEmpty($loc_cat_name_en))
            ->add('name', [
                'minLength' => $locHelper->validationMinLength($loc_cat_name_en , 5),
                'maxLength' => $locHelper->validationMaxLength($loc_cat_name_en , 50)
            ]);

        $validator
            ->requirePresence('name_es', 'create')
            ->notEmpty('name_es', $locHelper->validationNotEmpty($loc_cat_name_es))
            ->add('name_es', [
                'minLength' => $locHelper->validationMinLength($loc_cat_name_es , 5),
                'maxLength' => $locHelper->validationMaxLength($loc_cat_name_es , 50)
            ]);

        return $validator;
    }

    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['id']));
        $rules->add($rules->existsIn(['instance_id'], 'Instances'));

        return $rules;
    }
}
