<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\Cache\Cache;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class ApiArticlesTable extends Table
{

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('api_articles');
        $this->setPrimaryKey('id');


        $this->hasMany('ApiContents', [
            'foreignKey' => 'api_article_id',
            'className'  => 'Contents',
        ]);
      
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('name')
            ->notEmpty('name');

        $validator
            ->scalar('tag')
            ->notEmpty('tag');

        return $validator;
    }

    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['tag']));
        return $rules;
    }
}
