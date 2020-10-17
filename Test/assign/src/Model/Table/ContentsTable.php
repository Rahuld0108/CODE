<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\Cache\Cache;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class ContentsTable extends Table
{

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('contents');
        $this->setPrimaryKey('id');

        $this->belongsTo('Articles', [
            'foreignKey' => 'article_id',
            'joinType' => 'LEFT'
        ]);
        $this->hasMany('ContentImages', [
            'foreignKey' => 'content_id',
            'joinType' => 'LEFT'
        ]);
        $this->hasMany('Comments', [
            'foreignKey' => 'content_id',
            'joinType' => 'LEFT'
        ]);
        
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->allowEmpty('id', 'create');

        $validator
            ->integer('article_id')
            ->notEmpty('article_id');

        return $validator;
    }

}
