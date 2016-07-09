<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProjectStages Model
 *
 * @property \Cake\ORM\Association\HasMany $Projects
 *
 * @method \App\Model\Entity\ProjectStage get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProjectStage newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ProjectStage[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProjectStage|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProjectStage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProjectStage[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProjectStage findOrCreate($search, callable $callback = null)
 */
class ProjectStagesTable extends Table
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

        $this->table('project_stages');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->hasMany('Projects', [
            'foreignKey' => 'project_stage_id'
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
