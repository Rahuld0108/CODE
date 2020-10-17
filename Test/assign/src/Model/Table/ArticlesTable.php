<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\Cache\Cache;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class ArticlesTable extends Table
{

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('articles');
        $this->setPrimaryKey('id');


        $this->hasMany('Contents', [
            'foreignKey' => 'article_id',
            'className'  => 'Contents',
        ]);
        
        $this->belongsTo('CreationBy', [
            'foreignKey' => 'created_by',
            'joinType' => 'INNER',
            'className'  => 'Users',
        ]);
        
        $this->belongsTo('ModificationBy', [
            'foreignKey' => 'modified_by',
            'joinType' => 'INNER',
            'className'  => 'Users',
            
        ]);
        
       
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('name')
            ->notEmpty('title');

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
