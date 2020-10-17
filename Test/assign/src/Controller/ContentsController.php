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
class ContentsController extends AppController
{
    Public $paginate = [
        'limit' => 10
    ];
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Users');
        $this->loadModel('Articles');
        $this->loadModel('Contents');
        $this->loadModel('ContentImages');
       
        $this->viewBuilder()->setLayout('home');
       // $this->Auth->allow(['viewContent']);
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
    }


    public function index()
    {
        $user_id = $this->Auth->user('id');
        $postQuery = $this->Contents
            ->find()
           ->hydrate(false)
            ->contain(['Articles']);
         
        $contents = $this->paginate($postQuery);
       //echo '<pre>';print_r($contents);exit;
        $this->set(compact('contents','user_id'));

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
        $contents = $this->Contents->get($id, [
            'contain' => ['Articles']
        ]);

        $this->set('contents', $contents);
    }
    
    


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $contents = $this->Contents->newEntity();
        $user_id = $this->Auth->user('id');
        if ($this->request->is('post')) {
            $data  = $this->request->getData();
            
            //$data = $this->Sanitize->clean($data);
            $data1['article_id'] = $data['article_id'];
            $data1['content_body'] = $data['content_body'];
            $data1['status'] = 1;
            $contents  = $this->Contents->patchEntity($contents, $data1);
           
				
            if (empty($contents->errors())) {
            
                if ($res = $this->Contents->save($contents)) {
                foreach($data['photos'] as $val){
                    if($val['name']!=''){
                        $contentimg = $this->ContentImages->newEntity();
                        $ext = substr(strtolower(strrchr($val['name'], '.')), 1); //get the extension
                        $setNewFileName = time() . "_" . rand(000000, 999999);
                        $file['name'] = $setNewFileName.'.'.$ext;
                        $arr_ext = array('jpg', 'jpeg'); //set allowed extensions
                        if(in_array($ext, $arr_ext))
                        {
                            $dir = WWW_ROOT . 'uploads/';
                           if(move_uploaded_file($val['tmp_name'], $dir . $file['name'])) 
                           {   //echo 'yes';die;
                              
                                  $data2['photos'] = $file['name'];
                                  $data2['article_id'] = $data['article_id'];
                                  $data2['content_id'] = $res->id;
                                  $data2['uploaded_by'] = $user_id;
                                  $data2['uploaded_on'] = date('Y-m-d');
                                 $contentimg  = $this->ContentImages->patchEntity($contentimg, $data2);
                                 if (empty($contentimg->errors())) {
                                     if($this->ContentImages->save($contentimg)){
                                       $this -> Flash -> success(__('File Uploaded Succesfully.'));
                                     }else{
                                       $this -> Flash -> error(__('File could not be saved. Please, try again.'));
                                     }
                                 }
                            }else{
                                $this -> Flash -> error(__('File could not be saved. Please, try again.'));
                            }
                        }
                    }
                }
                $this->Flash->success(__('Data saved successfully.'));
                return $this->redirect(['controller'=>'contents', 'action' => 'index']);
                }else{
                $this->Flash->error(__('The content could not be saved. Please, try again.'));
                return $this->redirect(['controller'=>'contents', 'action' => 'add']);
                }
            }else{
                $this->Flash->error(__('The content could not be saved. Please, try again.'));
                return $this->redirect(['controller'=>'contents', 'action' => 'add']);
            }
            
        }
        $articleDtl = $this->Articles->find('list', ['keyField' => 'id','valueField' => 'name'])->where(['status'=>1,'created_by'=>$user_id])->toArray();
        $this->set(compact('contents','articleDtl'));
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
        $contents = $this->Contents->get($id,['contain' => ['Articles','ContentImages']]);
        $article_id = $contents->article_id;
        //echo '<pre>';print_r($contents);exit;
        $user_id = $this->Auth->user('id');
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data  = $this->request->getData();
          
            //$data = $this->Sanitize->clean($data);
            //$data1['article_id'] = $data['article_id'];
            $data1['content_body'] = $data['content_body'];
            $contents  = $this->Contents->patchEntity($contents, $data1);
            if (empty($contents->errors())) {
                    if ($res = $this->Contents->save($contents)) {
                        foreach($data['photos'] as $val){
                            if($val['name']!=''){
                                    $contentimg = $this->ContentImages->newEntity();
                                    $ext = substr(strtolower(strrchr($val['name'], '.')), 1); //get the extension
                                    $setNewFileName = time() . "_" . rand(000000, 999999);
                                    $file['name'] = $setNewFileName.'.'.$ext;
                                    $arr_ext = array('jpg', 'jpeg'); //set allowed extensions
                                    if(in_array($ext, $arr_ext))
                                    {
                                        $dir = WWW_ROOT . 'uploads/';
                                       if(move_uploaded_file($val['tmp_name'], $dir . $file['name'])) 
                                       {   //echo 'yes';die;
                                          
                                              $data2['photos'] = $file['name'];
                                              $data2['article_id'] = $article_id;
                                              $data2['content_id'] = $res->id;
                                              $data2['uploaded_by'] = $user_id;
                                              $data2['uploaded_on'] = date('Y-m-d');
                                             $contentimg  = $this->ContentImages->patchEntity($contentimg, $data2);
                                             if (empty($contentimg->errors())) {
                                                 if($this->ContentImages->save($contentimg)){
                                                   $this -> Flash -> success(__('File Uploaded Succesfully.'));
                                                 }else{
                                                   $this -> Flash -> error(__('File could not be saved. Please, try again.'));
                                                 }
                                             }
                                        }else{
                                            $this -> Flash -> error(__('File could not be saved. Please, try again.'));
                                        }
                                    }
                                
                            }
                        }
                    $this->Flash->success(__('The content has been saved.'));
                    return $this->redirect(['action' => 'index']);
                    }else{
                    $this->Flash->error(__('The content could not be saved. Please, try again.'));
                    return $this->redirect(['action' => 'edit',$id]);
                    }
            }else{
            $this->Flash->error(__('The content could not be saved. Please, try again.'));
            return $this->redirect(['action' => 'edit',$id]);
            }
           
        }
        
       
        $this->set(compact('contents'));
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

    public function deleteImage()
    {
        $this->viewBuilder()->layout('ajax');
        $this->loadModel('ContentImages');
        $id   = $_GET['id'];
        $fileData = $this->ContentImages->get($id);
        $fileName = $fileData->photos;
        if ($this->ContentImages->delete($fileData)) {        
            $file = new File(UPLOAD_FILE . 'uploads/'.$fileName, false, 0777);
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
