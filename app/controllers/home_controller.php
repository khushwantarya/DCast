<?php
/**
 * Events Controller
 *
 * PHP version 5
 *
 * @blog Controller
 * @package  Croogo
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class HomeController extends AppController {
/**
 * Controller name
 *
 * @var string
 * @access public
 */
  public $name = 'Home';

/**
 * Models used by the Controller
 *
 * @var array
 * @access public
 */
	public $uses = array('Home', 'Event');
	
	public $components = array(
			'Email',
	);
	
	public function beforeFilter($event_id = NULL) {
	
		parent::beforeFilter();	
		//check if the user is logged in or not
		parent::checkFrontSession();
		//check if the user has assigned for any event or not
		parent::checkForEvent();
		
		/*if(!$this->event_id)
		{
			$this->render("home/error");
		}*/
			
		
	}
	
	public function beforeRender()
	{
		$this->set("active_tab", $this->active_tab);	
	}
	
	public function home()
	{
		$this->active_tab = "view_challenge";
		//pr($this->params);
		//get the  blogs from the blogss table
		$event_array = $this->Event->find("first", array("conditions" => array("Event.status" => 1), "order" => "Event.id asc"));
		$this->set("event_array", $event_array);
	}
	
	public function help()
	{
		$this->active_tab = "help";	
	}
	
	public function send_contact_email()
	{
		if($_POST)
		{
			//load the User detail from the users table for logged in user
			$this->loadModel("User");
			$user_array = $this->User->find("first", array("conditions" => array("User.id" => $this->Session->read('Auth.User.id'))));
			$data["post"] = $_POST;
			$data["user"] = $user_array;			
			
			//$this->Email->from = Configure::read('Site.title') . ' ' . '<' . Configure::read('Site.email') . '>';
			$this->Email->to = Configure::read('Site.email');
			$this->Email->bcc = "khushwantarya@gmail.com";
			$this->Email->subject = __('Contact Detail [' . Configure::read('Site.title') . ']', true);
			$this->Email->template = 'contact_email';
			$this->Email->sendAs = 'both';
			$this->set('data', $data);
			$this->Email->send();
			echo 1;
			exit;
		}	
		else 
		{
			exit;
		}	
	}

}
?>