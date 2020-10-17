<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

/**
 * Galleries Controller
 *
 */
class ContentImagesController extends AppController {
    Public $paginate = [
        'limit' => 10
    ];
    
    public function initialize() {
        parent::initialize();
        $this->viewBuilder()->setLayout('frontend');
        $this->loadModel('Users');
        $this->loadModel('Articles');
        $this->loadModel('Contents');
        $this->loadModel('ContentImages');
    }

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
    }

    public function index() {
        $search_condition = array();        
        if($this->request->is('post')) {
           /*  if (!empty($this->request->data['title'])) {
                $title1 = trim($this->request->data['title']);
                $this->set('title1', $title1);
                $search_condition[] = "Galleries.title like '%" . $title1 . "%'";
            }
            if (!empty($this->request->data['gallery_category_id'])) {
                $gallery_category_id = trim($this->request->data['gallery_category_id']);
                $this->set('gallery_category_id', $gallery_category_id);
                $search_condition[] = "Galleries.gallery_category_id like '%" . $gallery_category_id . "%'";
            }                        
            if (!empty($this->request->data['fromdate'])) {
                $date_from = Time::parse($this->request->data['fromdate']);                 
                $start_date = $date_from->i18nFormat('yyyy-MM-dd HH:mm:ss'); 
                $this->set('fromdate', $start_date);
                $search_condition[] = "DATE(Galleries.created) >= '" . $start_date . "'";
            }            
            if (!empty($this->request->data['todate'])) {                
                $date_to = Time::parse($this->request->data['todate']);              
                $date_to = $date_to->i18nFormat('yyyy-MM-dd HH:mm:ss');
                $this->set('todate', $date_to);                
                $search_condition[] = "DATE(Galleries.created) <= '" . $date_to . "'";
            }
        }
        $searchString = implode(' AND ', $search_condition);        
        $gal_photos = $this->Galleries->find('all', ['conditions' => [$searchString,'status'=>1]]); */
        $contentimages = $this->ContentImages->find('all', ['conditions' => ['status'=>1]])
        $contentimages = $this->paginate($contentimages);
        $this->set('contentimages', $contentimages);
    }

    
    
        public function add()
        {
        $contentimages = $this->ContentImages->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            foreach($data['filename'] as $val){
                    if($val['name']!=''){
                        $fileName = $this->uploadFiles('galleries', $val);
                        $data1['photos']  = $fileName['filename'];
                        $data1['article_id'] = $data['article_id'];
                        $data1['content_id'] = $data['content_id'];
                        $data1['status'] = 1;
                        $gallery = $this->ContentImages->patchEntity($contentimages, $data1);
                        $this->ContentImages->save($gallery);
                    }
            }
           return $this->redirect(['action' => 'index']);
            
        }
        
        $this->set(compact('contentimages'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Gallery id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $gallery = $this->Galleries->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $gallery = $this->Galleries->patchEntity($gallery, $data);
            if($data['filename']['name']!=''){
                $fileName = $this->uploadFiles('galleries', $data['filename']);
                $gallery->filename  = $fileName['filename'];
                $gallery->filemime  = $fileName['type'];
                $gallery->filesize  = $fileName['size'];
                $gallery->gallery_category_id  = $data['gallery_category_id'];                
                $gallery->title  = $data['title'];
            } else {
                $gallery->filename  = $data['old_filename'];
                $gallery->filemime  = $data['old_filemime'];
                $gallery->filesize  = $data['old_filesize'];
                $gallery->gallery_category_id  = $data['gallery_category_id'];                
                $gallery->title  = $data['title'];
            }
            if ($this->Galleries->save($gallery)) {
                $this->Flash->success(__('The gallery has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The gallery could not be saved. Please, try again.'));
        }
        $galleryCategories = $this->Galleries->GalleryCategories->find('list', ['limit' => 200]);
        $this->set(compact('gallery', 'galleryCategories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Gallery id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $gallery = $this->Galleries->get($id);
        if ($this->Galleries->delete($gallery)) {
            $this->Flash->success(__('The gallery has been deleted.'));
        } else {
            $this->Flash->error(__('The gallery could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
