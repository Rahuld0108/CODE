<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

require_once(ROOT . DS . 'vendor' . DS . "setasign" . DS . "fpdf/fpdf.php");
require_once(ROOT . DS . 'vendor' . DS . "setasign" . DS . "fpdi/fpdi.php");

use Cake\Cache\Cache;
use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Utility\Hash;
use App\View\Helper\SilverFormHelper;
use Cake\View\View;
use FPDI;
use finfo;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
 
 class PDF extends FPDI {
    protected $_tplIdx;
    public function Header()
    {
        if (null === $this->_tplIdx) {
            $this->setSourceFile('letterhead.pdf');
            $this->_tplIdx = $this->importPage(1);
        }
        $this->useTemplate($this->_tplIdx);
    }

    public function Footer(){
        $this->SetY(0);
    }
}

class HPDF extends FPDI {
    protected $_tplIdx;
    public function Header(){
    }

    public function Footer(){
    }
}

class DEMOPDF extends FPDI {
    protected $_tplIdx;
    
     public function Header(){
    }

    function RotatedText($x, $y, $txt, $angle) {
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }

    public function Footer(){
        
    }
}

class AppController extends Controller
{
    
    public $languages;
    
    public $SilverForm;
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */ 
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Sanitize');
        $this->loadComponent('Flash', ['clear' => true]);
        $this->loadComponent('Paginator');
        $this->loadComponent('Auth', [
        'authorize'=> 'Controller',
            'authenticate' => [
                'Form' => ['userModel' => 'Users',
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password'
                    ]
                ]
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
            'loginRedirect' => [
                'controller' => 'Dashboard',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
             // If unauthorized, return them to page they were just on
            'unauthorizedRedirect' => $this->referer(),

            'authorize'            => 'Controller',
            'flash'                => [
                'element' => 'error',
            ],
        ]);

        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
    }

    public function beforeFilter(Event $event)
    {
        $userArray = $this->Auth->user();
        $this->set('userArray',$userArray);
        $params = $this->request->getAttribute('params');

        parent::beforeFilter($event);
    }

    public function beforeRender(Event $event)
    {
        $this->set('Configure', new Configure);
    }

    public function isAuthorized($user = null)
    {
 
        return true;
    }

    
	public function CreatePdf($content, $title, $image=NULL){
        $this->autoRender = false;
        
        $pdf = new DEMOPDF($image);
        $pdf->AddPage();
        $pdf->SetTopMargin(20);
        $pdf->SetLeftMargin(20);
        $pdf->SetFillColor(53,127,63);
        $pdf->SetFont('times', 'R', 12);
        $pdf->SetFont('courier', 'R', 12);
        $pdf->SetFont('Helvetica', 'R', 12);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetCompression(true);
        $pdf->SetTitle($title);
        $pdf->writeHTML($content, false, false, false, false, 'L');
        $tempfile = $title.date("Y").'.pdf';
        $pdf->Output($tempfile,'I');
        exit();
    }

    
}
