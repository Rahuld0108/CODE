<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class ContentImagesTable extends Table
{

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('content_images');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');


        $this->belongsTo('Contents', [
            'foreignKey' => 'content_id	',
            'joinType' => 'LEFT'
        ]);
        
        $this->belongsTo('Articles', [
            'foreignKey' => 'article_id',
            'joinType' => 'LEFT'
        ]);
        
        $this->belongsTo('Users', [
            'foreignKey' => 'uploaded_by',
            'className'  => 'Users',
            'joinType' => 'INNER'
        ]);
    }

    
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->integer('content_id')
            ->notEmpty('content_id');

        $validator
            ->integer('article_id')
            ->notEmpty('article_id');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
   /*  public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['gallery_category_id'], 'GalleryCategories'));

        return $rules;
    } */
}
