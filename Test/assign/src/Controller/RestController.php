<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Cache\Cache;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Utility\Hash;
use Cake\View\Exception\MissingTemplateException;
use Cake\Core\Configure;
use Cake\Filesystem\File;
use Cake\ORM\TableRegistry;
use Cake\View\View;
use Cake\Utility\Text;

class RestController extends AppController
{
    public function initialize()
    {
        parent::initialize();
       // $this->getEventManager()->off($this->Csrf);
        $this->loadComponent('RequestHandler');
        
        $this->loadModel('ApiArticles');
        $this->loadModel('ApiContents');
        $this->Auth->allow(['apiViewArticle','apiListArticle','addApiArticle','editApiArticle','apiArticleDeleteById','apiArticleDeleteByTag']);
    }
    
   
    public function apiListArticle()
    {
        $conts = $this->ApiArticles->find();
        $this->set([
            'conts' => $conts,
            '_serialize' => ['conts']
        ]);
        
    }
    
    public function apiListContent()
    {
        $conts = $this->ApiContents->find()->contain(['ApiContents']);
        $this->set([
            'conts' => $conts,
            '_serialize' => ['conts']
        ]);
        
    }


    public function apiViewArticle($id)
    {
        $recipe = $this->ApiArticles->get($id);
        $this->set([
            'recipe' => $recipe,
            '_serialize' => ['recipe']
        ]);
    }
    
    
    public function apiViewContent($id)
    {
        $recipe = $this->ApiContents->get($id,['contain'=>['ApiArticles']]);
        $this->set([
            'recipe' => $recipe,
            '_serialize' => ['recipe']
        ]);
    }

    public function addApiArticle()
    {
        // $this->getEventManager()->off($this->Csrf);
        $this->request->allowMethod(['post', 'put']);
        $data = $this->request->getData();
        $apiArticles = $this->ApiArticles->newEntity();
        $data1['tag'] = $data['tag'];
        $data1['name'] = $data['name'];
        $data1['created_on'] = date('Y-m-d');
        $apiArticles  = $this->ApiArticles->patchEntity($apiArticles, $data1);
       // echo '<pre>';print_r($apiArticles->errors());exit;
        if (empty($apiArticles->errors())) {
            if ($this->ApiArticles->save($apiArticles)) {
                $message = 'Saved';
            } else {
                $message = 'Error';
            }
        }else{
          $message = 'Something Wrong';  
        }
        $this->set([
            'message' => $message,
            '_serialize' => ['message']
        ]);
    }

    public function editApiArticle()
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
        $data = $this->request->getData();
        $tag = $data['tag'];
        $getApiArticles = $this->ApiArticles->find()->where(['tag LIKE' => '%'.$tag.'%'])->toArray();
        if(!empty($getApiArticles)){
        $apiArticles = $this->ApiArticles->get($getApiArticles[0]->id);
        
        $data1['name'] = $data['name'];
        $data1['modified_on'] = date('Y-m-d');
        $apiArticles = $this->ApiArticles->patchEntity($apiArticles, $data1);
         if (empty($apiArticles->errors())) {
            if ($this->ApiArticles->save($apiArticles)) {
                $message = 'Saved';
            } else {
                $message = 'Error';
            }
        }
        }else{
            $message = 'Error to fetch data';
        }
        $this->set([
            'message' => $message,
            '_serialize' => ['message']
        ]);
    }

    public function apiArticleDeleteById($id)
    {
        $this->request->allowMethod(['delete']);
        $apiArticles = $this->ApiArticles->get($id);
        
        if(!empty($apiArticles)){
            if (!$this->ApiArticles->delete($apiArticles)) {
                $message = 'Error';
            }else{
                $message = 'Deleted';
            }
        }else{
           $message = 'Error to fetch data'; 
        }
        $this->set([
            'message' => $message,
            '_serialize' => ['message']
        ]);
    }
    
     public function apiArticleDeleteByTag()
    {
        $this->request->allowMethod(['post', 'put']);
        $data = $this->request->getData();
        $tag = $data['tag'];
        $getApiArticles = $this->ApiArticles->find()->where(['tag LIKE' => '%'.$tag.'%'])->toArray();
        if(!empty($getApiArticles)){
        $apiArticles = $this->ApiArticles->get($getApiArticles[0]->id);
        
            if (!$this->ApiArticles->delete($apiArticles)) {
                $message = 'Error';
            }else{
                $message = 'Deleted';
            }
        }else{
           $message = 'Error to fetch data'; 
        }
        $this->set([
            'message' => $message,
            '_serialize' => ['message']
        ]);
    }
}