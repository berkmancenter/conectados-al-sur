<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CitiesCountries Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Countries
 * @property \Cake\ORM\Association\BelongsTo $Cities
 *
 * @method \App\Model\Entity\CitiesCountry get($primaryKey, $options = [])
 * @method \App\Model\Entity\CitiesCountry newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CitiesCountry[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CitiesCountry|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CitiesCountry patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CitiesCountry[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CitiesCountry findOrCreate($search, callable $callback = null)
 */
class CitiesCountriesTable extends Table
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

        $this->table('cities_countries');
        $this->displayField('country_id');
        $this->primaryKey('country_id');

        $this->belongsTo('Countries', [
            'foreignKey' => 'country_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id',
            'joinType' => 'INNER'
        ]);
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
        $rules->add($rules->existsIn(['country_id'], 'Countries'));
        $rules->add($rules->existsIn(['city_id'], 'Cities'));
        return $rules;
    }
}
