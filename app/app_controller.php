<?php
/**
 * Application controller
 *
 * This file is the base controller of all other controllers
 *
 * PHP version 5
 *
 * @category Controllers
 * @package  Croogo
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class AppController extends Controller {
/**
 * Components
 *
 * @var array
 * @access public
 */
    public $components = array(
        'Croogo',
        'Security',
        'Acl',
        'Auth',
        'Acl.AclFilter',
        'Session',
        'RequestHandler',
				'Upload'
    );
/**
 * Helpers
 *
 * @var array
 * @access public
 */
    public $helpers = array(
        'Html',
        'Form',
        'Session',
        'Text',
        'Js',
        'Time',
        'Layout',
        'Custom',
    );
/**
 * Models
 *
 * @var array
 * @access public
 */
    public $uses = array(
        'Setting'
    );
/**
 * Cache pagination results
 *
 * @var boolean
 * @access public
 */
    public $usePaginationCache = true;
/**
 * View
 *
 * @var string
 * @access public
 */
    public $view = 'Theme';
/**
 * Theme
 *
 * @var string
 * @access public
 */
    public $theme;
	
		public $event_id = 0;
		public $active_tab = "";
	
/**
 * Constructor
 *
 * @access public
 */
    public function __construct() {
        Croogo::applyHookProperties('Hook.controller_properties');
        parent::__construct();
        if ($this->name == 'CakeError') {
            $this->_set(Router::getPaths());
            $this->params = Router::getParams();
            $this->constructClasses();
            $this->Component->initialize($this);
            $this->beforeFilter();
            $this->Component->triggerCallback('startup', $this);
        }
    }
/**
 * beforeFilter
 *
 * @return void
 */
    public function beforeFilter() {
        $this->AclFilter->auth();
        $this->RequestHandler->setContent('json', 'text/x-json');
        $this->Security->blackHoleCallback = '__securityError';

        if (isset($this->params['admin']) && $this->name != 'CakeError') {
            $this->layout = 'admin';
        }

        if ($this->RequestHandler->isAjax()) {
            $this->layout = 'ajax';
        }

        if (Configure::read('Site.theme') && !isset($this->params['admin'])) {
            $this->theme = Configure::read('Site.theme');
        } elseif (Configure::read('Site.admin_theme') && isset($this->params['admin'])) {
            $this->theme = Configure::read('Site.admin_theme');
        }

        if (!isset($this->params['admin']) && 
            Configure::read('Site.status') == 0) {
            $this->layout = 'maintenance';
            $this->set('title_for_layout', __('Site down for maintenance', true));
            $this->render('../elements/blank');
        }

        if (isset($this->params['locale'])) {
            Configure::write('Config.language', $this->params['locale']);
        }
    }
/**
 * blackHoleCallback for SecurityComponent
 *
 * @return void
 */
    public function __securityError() {
        $this->cakeError('securityError');
    }
	

	function isUploadedFile($params)

	{

		//pr($params);

		$val = is_array($params) ? array_shift($params) : "";

		//echo "Khush";

		if ((isset($val['error']) && $val['error'] == 0) ||

		(!empty($val['tmp_name']) && $val['tmp_name'] != 'none')) 

		{

			//echo "In ";

			return true; //is_uploaded_file($val['tmp_name']);

		} else {

			//echo "Out";

			return false;

		}

	}

	

	

	/*

		to create a return url from a array of values 

		parmters 

		@source_array : then main array from which we have to extract the to_pass querystring

		@include 	  : this is the array of value to include  in the to_pass querystring

		@type 		  : this is the type which tells we need to include from the main array the sent include or 

						to exclude from the main array in the newly created to_pass querystring return value

	*/

	protected function __createToPass($source_array = null, $include = null, $type = "accept")

	{

		if($source_array == null)

		{

			return false;

		}

		

		$to_pass = "";

		if($type == "deny")

		{

			foreach($source_array as $k => $v)

			{

				if(!in_array($k, $include))

				{

					$to_pass .= "/" . $k . ":" . $v;

				}

			}		

		}

		else if($type == "accept")

		{

			foreach($source_array as $k => $v)

			{

				if(in_array($k, $include) && $v != "")

				{

					if(is_array($v))

					{

						$to_pass .= "/" . $k . ":" . implode("--", $v);

					}

					else

					{

						$to_pass .= "/" . $k . ":" . $v;

					}	

				}

			}	

		}

		return $to_pass;

	}


	public function checkFrontSession()
	{
		//only check the front session if it is accessing to the front end 
    if (!isset($this->params['admin'])) 
		{
			if($this->Session->check('Auth.User.role_id'))
			{	
				//echo "logged in";
			}
			else
			{
				$this->Session->setFlash(__('Please login to get access to the  Event detail.', true), 'default', array('class' => 'error'));
				$this->redirect("/users/login");
			}
		}
	}
	
	public function checkForEvent()
	{
		// this is a reqeustAction then return true no need to check if this is a requestAction request
		//if(!isset($this->params["requested"]))
		//{
			//if($this->params["requested"])
			$this->loadModel("User");
			$this->loadModel("EventsUser");
			$this->loadModel("Event");
			if(!isset($this->params["pass"][0]))
			{
				//get the event_id base on the loggedin user's event
				$events_users_array = $this->EventsUser->find("first", array("conditions" => array("EventsUser.user_id" => $this->Session->read('Auth.User.id'))));
				//pr($events_users_array);
				if(!empty($events_users_array)) 
				{	
					// if there is an event attached with the user 
					$this->event_id = $events_users_array["EventsUser"]["event_id"];
				}
				else
				{
					//if there is no event allowed  for the loggedin User show the default event or we may require to show a error page for this
					
					$event_array = $this->Event->find("first", array("conditions" => array("Event.default" => 1)));
					//pr($event_array);
					$this->event_id = $event_array["Event"]["id"];
				}
			}
			else
			{
				//check the coming event id for the loggedin user id is it okey and not a fake or invalid id
				$events_users_array = $this->EventsUser->find("first", array("conditions" => array("EventsUser.user_id" => $this->Session->read('Auth.User.id'), "EventsUser.event_id" => $this->params["pass"][0])));
				if(!empty($events_users_array))
				{	
					$this->event_id = $events_users_array["EventsUser"]["event_id"];
				}
				else
				{
					//if there is no event allowed  for the loggedin User show the default event
					$event_array = $this->Event->find("first", array("conditions" => array("Event.default" => 1, "Event.status" => 1)));
					$this->event_id = $event_array["Event"]["id"];
				}
			}
			if(!$this->event_id)
			{
				$this->render("/home/error");
			}
			$this->set("event_id", $this->event_id);
		//}	
	}

}
?>
