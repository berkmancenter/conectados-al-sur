<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\View\Helper\LocHelper;

class UsersTable extends Table
{

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('users');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Genres', [
            'foreignKey' => 'genre_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Projects', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsToMany('Instances', [
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'instance_id',
            'joinTable' => 'instances_users'
        ]);
    }


    public function validationDefault(Validator $validator)
    {
        $locHelper = new LocHelper(new \Cake\View\View());
        $str_name  = __d('users','Name');
        $str_email = __d('users','Email');
        $str_pass  = __d('users','Password');

        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name', __d('users', 'Please, fill your name.'))
            ->add('name', [
                'minLength' => $locHelper->validationMinLength($str_name , 5),
                'maxLength' => $locHelper->validationMaxLength($str_name , 50)
            ]);

        $validator
            ->requirePresence('email', 'create')
            ->notEmpty('email', __d('users', 'Please, fill your email.'))
            ->add('email', [
                'unique' => $locHelper->validationUnique($str_name),
                'regex' => [
                    'rule' => 'email',
                    'message' => __d('users', 'The email is invalid.')
                ],
            ]);

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password', __d('users', 'Please, write a password.'))
            ->add('password', [
                'minLength' => $locHelper->validationMinLength($str_pass , 5),
                'maxLength' => $locHelper->validationMaxLength($str_pass , 50)
            ]);

        return $validator;
    }


    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['genre_id'], 'Genres'));

        return $rules;
    }
}
