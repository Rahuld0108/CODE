<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Error\Exceptions;
use Cake\Routing\Router;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Utility\Text;
use Cake\Validation\Validator;

class UsersController extends AppController
{

    public function initialize()
    {
        parent::initialize();
		$this->loadModel('Users');
        $this->loadModel('Articles');
        $this->loadModel('Contents');
        $this->loadModel('ContentImages');
        $this->Auth->allow(['registration','showFronData']);
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
    }

    public function login()
    {
        $this->viewBuilder()->setLayout('home');
		if ($this->request->getSession()->check('Auth.User')) {
            return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
        }
        $user = $this->Users->newEntity();     
        if ($this->request->is('post')) {
				$this->request->data = $_REQUEST;
				$userdata = $this->request->data;
				$email = $userdata['email'];
                $userDetails = $this->Users->find('all')->where(['email' => $email])->first();
				
                if (!empty($userDetails)) {
                    $uid = $userDetails->id;
                } else {
                    $uid = 0;
                }			
                $user = $this->Auth->identify();
                if ($user) {
					
						$user = $this->Users->find('all')->where(['id'=>$user['id']])->first();	
						$user['user'] = $user;
						$this->Auth->setUser($user);
						return $this->redirect($this->Auth->redirectUrl());	
                } else {
                  $this->Flash->error(__('Invalid credentials.'));
                }
           
        }
		$postQuery = $this->Contents
            ->find()		
            ->contain(['Articles'])
			->hydrate(false);
        $contents = $this->paginate($postQuery);
       // echo '<pre>';print_r($contents);exit;
		$this->set(compact('user','contents'));
    }

    public function logout()
    {
        $this->Flash->success(__('You have logged out successfully.'));
        $user_id = $this->request->session()->read('Auth.User.id');
        return $this->redirect($this->Auth->logout());
    }

    
    public function index()
    {
        return $this->redirect(['controller'=>'Users', 'action' => 'login']);
    }
	

    public function registration()
    {
        $this->viewBuilder()->setLayout('home');
        $user = $this->Users->newEntity();        
        if ($this->request->is('post')) {            
            $userdetails = $this->request->getData();
            $errors = array();           
            if (empty($errors)) {
                $pass = trim($userdetails['password']);
                $pass = $this->Sanitize->stripAll($pass);
                $pass = $this->Sanitize->clean($pass);
				$data1['name'] = $userdetails['name'];
                $data1['password'] = $pass;
                $data1['email'] = $userdetails['email'];
                
                $user = $this->Users->patchEntity($user,$data1);
				
				if (empty($user->errors())) {
				//echo "<pre>"; print_r($user->errors); exit;
					if ($result = $this->Users->save($user)) {
						$this->Flash->success(__('Account has been created successfully.'));
							return $this->redirect(['controller'=>'Users', 'action' => 'login']);
						
					}
				}else{				
					$error_msg = [];
					foreach( $user->errors() as $errors){
						if(is_array($errors)){
							foreach($errors as $error){
								$error_msg[]    =   $error;
							}
						}else{
							$error_msg[]    =   $errors;
						}
					}
					

					if(!empty($error_msg)){
						$this->Flash->error(
							__("Please fix the following error(s):".implode("\n \r", $error_msg))
						);
						return $this->redirect(['controller'=>'Users', 'action' => 'registration']);
					}else {

						$this->Flash->error(__('Registration could not be completed. Please try again.'));
					}
				}
				
            } else {
               
                    $this->Flash->error(__('Internal Error.Please try again'));
                }
            }
        
        $this->set(compact('user'));
    }
}
