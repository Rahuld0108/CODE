<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Galleries Model
 *
 * @property \App\Model\Table\GalleryCategoriesTable|\Cake\ORM\Association\BelongsTo $GalleryCategories
 *
 * @method \App\Model\Entity\Gallery get($primaryKey, $options = [])
 * @method \App\Model\Entity\Gallery newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Gallery[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Gallery|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Gallery|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Gallery patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Gallery[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Gallery findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CommentsTable extends Table
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

        $this->setTable('comments');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Articles', [
            'foreignKey' => 'article_id',
            'joinType' => 'LEFT'
        ]);

        $this->belongsTo('Contents', [
            'foreignKey' => 'content_id',
            'joinType' => 'LEFT'
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
            ->integer('article_id')
            ->allowEmpty('article_id', 'create');
            
        $validator
            ->integer('content_id')
            ->allowEmpty('content_id', 'create');

        $validator
            ->scalar('tag')
            ->requirePresence('tag', 'create')
            ->notEmpty('tag');

        $validator
            ->scalar('comments_by')
            ->requirePresence('comments_by', 'create')
            ->notEmpty('comments_by');
        
        return $validator;
    }

    
}
