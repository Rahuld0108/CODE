<?php
namespace App\Controller;

use App\View\Helper\SilverFormHelper;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;
use Cake\View\View;
use Cake\Core\Configure;

class DashboardController extends AppController
{
  public function initialize()
  {
    parent::initialize();
    $this->viewBuilder()->setLayout('dashboard');
  }

  public function beforeFilter(Event $event)
  {
    parent::beforeFilter($event);
  }
	 
	public function index(){
    $this->viewBuilder()->layout('home');
    $this->loadModel('Users');
    $name = $this->Auth->user('name');
	$search_condition = array();
        $data = $this->request->getQuery();
        $search_condition = array();
       
        if (isset($this->request->query['search_button']) && $this->request->query['search_button'] == 'pdf') {
            $name = $this->request->query['name'];

            $file_name = $this->userPdf($name);
        }
        if (!empty($data['name'])) {
            $name = trim($data['name']); 
            $this->set('name', $name);
            $search_condition[] = "Users.name like '%" . $name . "%'";
        }
        if(!empty($search_condition)){
            $searchString = implode(" AND ",$search_condition);
			
        } else {
            $searchString = '';
        }
        $userDtl = $this->Users->find('all', [
            'order' => ['Users.id' => 'desc'],
            'conditions' => [$searchString]
        ]);
        $this->paginate = ['limit' => 4];
        $users = $this->paginate($userDtl);
		$this->set(compact('users','name'));
	}
    
    
	 public function userPdf($name=null){
        if (!empty($name)) {
                $search_condition[] = "Users.name like '%" . $name . "%'";
            }
       if(!empty($search_condition)){
            $searchString = implode(" AND ",$search_condition);
			
        } else {
            $searchString = '';
        }
        $details = $this->Users->find('all', [
            'order' => ['Users.id' => 'desc'],
            'conditions' => [$searchString]
        ])->toArray();
       
        $view = new View($this->request, $this->response, null);
        $view->viewPath = '/Dashboard';
        $view->layout = 'ajax';
        $view->set(compact('details'));
        $content = $view->render('userpdf');
        $filename = $this->CreatePdf($content, 'UserDetails'.time());
        return $filename;

    }

}
