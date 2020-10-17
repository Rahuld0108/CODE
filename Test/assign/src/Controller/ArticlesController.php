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
/**
 * Articles Controller
 *
 * @property \App\Model\Table\ArticlesTable $Articles
 *
 * @method \App\Model\Entity\Article[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ArticlesController extends AppController
{
    Public $paginate = [
        'limit' => 10
    ];
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Users');
        $this->loadModel('Articles');
        $this->viewBuilder()->setLayout('home');
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
    }


    public function index()
    {
        $this->viewBuilder()->setLayout('home');
        
        $search_condition = array();
        $user_id = $this->Auth->user('id');
        
        /* if (!empty($this->request->getQuery('title'))) {
            $title = trim($this->request->getQuery('title'));
            $this->set('title', $title);
            $search_condition[] = "Articles.title like '%" . $title . "%'";
        }
        if (!empty($this->request->getQuery('su'))) {
            $subTitle = trim($this->request->getQuery('sub_title'));
            $this->set('sub_title', $subTitle);
            $search_condition[] = "Articles.subtitle like '%" . $subTitle . "%'";
        }
        if(!empty($search_condition)){
            $searchString = implode(" AND ",$search_condition);
        } else {
            $searchString = '';
        } */
        /* $postQuery = $this->Articles->find('all', [
            'contain' => ['Users'],
            'order' => ['Articles.id' => 'desc'],
            'conditions' => [$searchString]
        ]); */
        $postQuery = $this->Articles
            ->find()
            ->contain(['CreationBy'])
            ->where(['Articles.status' => 1]);
        $articles = $this->paginate($postQuery);
       //echo '<pre>';print_r($articles);exit;
        $this->set(compact('articles','user_id'));

    }

    /**
     * View method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $article = $this->Articles->get($id, [
            'contain' => ['CreationBy']
        ]);

        $this->set('article', $article);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $article = $this->Articles->newEntity();
        $user_id = $this->Auth->user('id');
        if ($this->request->is('post')) {
            $data  = $this->request->getData();
            //$data = $this->Sanitize->clean($data);
            $data1['name'] = $data['name'];
            $data1['tag'] = $data['tag'];
            $data1['created_on'] = date('Y-m-d');
            $data1['created_by'] = $user_id;
                
           
            $article  = $this->Articles->patchEntity($article, $data1);
           
				
            if (empty($article->errors())) {
            
                if ($this->Articles->save($article)) {
              
                $this->Flash->success(__('Data saved successfully.'));
                return $this->redirect(['controller'=>'articles', 'action' => 'index']);
                }else{
                $this->Flash->error(__('The article could not be saved. Please, try again.'));
                return $this->redirect(['controller'=>'articles', 'action' => 'add']);
                }
            }else{
                $this->Flash->error(__('The article could not be saved. Please, try again.'));
                return $this->redirect(['controller'=>'articles', 'action' => 'add']);
            }
            
        }
       
        $this->set(compact('article'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $article = $this->Articles->get($id);
        //$article = $this->Articles->newEntity();
        $user_id = $this->Auth->user('id');
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data  = $this->request->getData();
            //$data = $this->Sanitize->clean($data);
            $data1['name'] = $data['name'];
            $data1['tag'] = $data['tag'];
            $data1['modified_on'] = date('Y-m-d');
            $data1['modified_by'] = $user_id;
            $article              = $this->Articles->patchEntity($article, $data1);
            if (empty($article->errors())) {
                    if ($this->Articles->save($article)) {
                    $this->Flash->success(__('The article has been saved.'));
                    return $this->redirect(['action' => 'index']);
                    }else{
                    $this->Flash->error(__('The article could not be saved. Please, try again.'));
                    return $this->redirect(['action' => 'edit',$id]);
                    }
            }else{
            $this->Flash->error(__('The article could not be saved. Please, try again.'));
            return $this->redirect(['action' => 'edit',$id]);
            }
        }
        
       
        $this->set(compact('article'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $article = $this->Articles->get($id);
        if ($this->Articles->delete($article)) {
            $this->loadModel('ArticleTranslations');
            $this->ArticleTranslations->deleteAll(['article_id' => $id]);
            $this->Flash->success(__('The article has been deleted.'));
        } else {
            $this->Flash->error(__('The article could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getOptions($value='')
    {
        $this->viewBuilder()->layout('ajax');
        $param = $_POST['param'];
        $arrayData = array();
        if($param=='article') {
            $arrayData = $this->Articles->find('list');
        }
        $this->set('arrayData',$arrayData);
    }

    public function autoUploadFiles()
    {
        $this->viewBuilder()->layout('ajax');
        $data   = $this->request->getData();
        $result = '';
        $sessionFilesData = [];
        if($data['article_files']){
            $session = $this->request->session();
            $this->loadModel('ArticleImages');
            $articleImage = $this->ArticleImages->newEntity();            
            $uploadedFiles = $this->uploadFiles('article', $data['article_files'],'articlefiles');
            if (empty($uploadedFiles['errors'])) {
                if (!empty($data['article_id'])) {
                    $articleImage->article_id = $data['article_id'];
                }
                $articleImage = $this->ArticleImages->patchEntity($articleImage, $data);
                $articleImage->filename = $uploadedFiles['filename'];
                $articleImage->fileurl = $uploadedFiles['url'];
                $articleImage->filemime = $uploadedFiles['type'];
                $articleImage->filesize = $uploadedFiles['size'];
                $articleImage->user_id = $this->Auth->user('id');
                $articleImage->created = REQUEST_TIME;
                $articleImage->changed = REQUEST_TIME;

                if($saveArticleImage = $this->ArticleImages->save($articleImage)){
                    if (empty($data['article_id'])) {
                        if (empty($session->read('file_session'))) {
                            $session_array = array();
                        } else {
                            $session_array = $session->read('file_session');
                        }
                        array_push($session_array,$saveArticleImage->changed);
                        $session->write('file_session',$session_array);
                        //$session->delete('file_session');
                        $sessionFiles = $session->read('file_session');
                        $sessionFilesData = $this->ArticleImages->find('all') ->where(['changed IN' => $sessionFiles])->enableHydration(false)->toArray();
                    } else {
                        $sessionFilesData = $this->ArticleImages->find('all') ->where(['article_id' =>$data['article_id']])->enableHydration(false)->toArray();
                    }
                }
            } else {
                echo "error|".$uploadedFiles['errors'];
            }
        }
        $this->set('sessionFilesData',$sessionFilesData);
    }

    public function deleteArticleImage($value='')
    {
        $this->viewBuilder()->layout('ajax');
        $this->loadModel('ArticleImages');
        $data   = $this->request->getData();
        $fileData = $this->ArticleImages->get($data['id']);
        $fileName = $fileData->filename;
        if ($this->ArticleImages->delete($fileData)) {        
            $file = new File(UPLOAD_FILE . 'article/articlefiles/'.$fileName, false, 0777);
            if ($file->exists()) {
                if($file->delete()) {
                    echo "success";
                }
            }
        }
        exit();
    }

    public function deleteRow()
    {
        $this->viewBuilder()->setLayout('ajax');
        $row_id         = $_POST['id'];
        $table_name     = $_POST['table_name'];
        $custumTable    = TableRegistry::getTableLocator()->get($table_name);
        $removeQuery    = $custumTable->get($row_id);
        if($custumTable->delete($removeQuery)){
            echo 'removed';            
        }
        exit;  
    }
}
