<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Routing\Router;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

/**
 * OnlineEnquiry Controller
 *
 * @property \App\Model\Table\OnlineEnquiryTable $OnlineEnquiry
 *
 * @method \App\Model\Entity\OnlineEnquiry[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CommentsController extends AppController
{
    Public $paginate = [
        'limit' => 10
    ];
    public function initialize()
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('home');
        $this->loadModel('Users');
        $this->loadModel('Articles');
        $this->loadModel('Contents');
        $this->loadModel('ContentImages');
        $this->Auth->allow(['viewComments','viewContent']); 
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
    }
    public function viewComments($id)
    {
       
        $comments = $this->Contents
            ->find()
            ->hydrate(false)
            ->contain(['Articles','Comments'])->where(['Contents.id' =>$id])->first();
         
        
        //echo '<pre>';print_r($comments);exit;
        $this->set(compact('comments'));

    }
     public function viewContent($id = null)
    {
       
        $contents = $this->Contents->get($id, [
            'contain' => ['Articles','ContentImages']
        ]);
        
       
        $comments = $this->Comments->newEntity();
       
        if ($this->request->is('post')) {
            $data  = $this->request->getData();
           
            //$data = $this->Sanitize->clean($data);
            $data1['article_id'] = $data['article_id'];
            $data1['content_id'] = $data['content_id'];
            $data1['tag'] = $data['tag'];
            $data1['comments_by'] = $data['comments_by'];
            $data1['comments_text'] = $data['comments_text'];
            $data1['comments_on'] = date('Y-m-d');
            $comments  = $this->Comments->patchEntity($comments, $data1);
           
				
            if (empty($comments->errors())) {
            
                if ($res = $this->Comments->save($comments)) {
                
                }else{
                $this->Flash->error(__('The comments could not be saved. Please, try again.'));
                return $this->redirect(['controller'=>'comments', 'action' => 'viewContent']);
                }
            }else{
                $this->Flash->error(__('The content could not be saved. Please, try again.'));
                return $this->redirect(['controller'=>'comments', 'action' => 'viewContent']);
            }
            
        }
        $this->set(compact('contents','comments'));
    }

   
}