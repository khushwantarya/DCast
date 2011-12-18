<?php
/**
 * Events Controller
 *
 * PHP version 5
 *
 * @event Controller
 * @package  Croogo
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class EventsController extends AppController {
/**
 * Controller name
 *
 * @var string
 * @access public
 */
    public $name = 'Events';
/**
 * Models used by the Controller
 *
 * @var array
 * @access public
 */
  public $uses = array('Event');
	public $logo_dest = "";
	public $logo_dest_small = "";
	public $pdf_dest = "";	
	public $event_id = 0;
	
    public function beforeFilter() {
		parent::beforeFilter();
		$this->logo_dest = realpath(Configure::read("CV.logo_upload_path")) . "/";
		$this->pdf_dest = realpath(Configure::read("CV.file_upload_path")) . "/";		
		//check if the user is logged in or not
		parent::checkFrontSession();
		//check if the user has assigned for any event or not
		parent::checkForEvent();
		
		if(!$this->event_id)
		{
			$this->render("home/error");
		}
		//$this->dest_small = realpath(Configure::read("CV.assoc_small_image_upload_path")) . "/";
	}
	
    public function admin_index() {
		//$this->redirect(array('action'=>'view')); 
        $this->set('title_for_layout', __('Events', true));

        $this->Event->recursive = 0;
        $this->paginate['Event']['order'] = "Event.id ASC";
        $this->set('events', $this->paginate());
    }
		
		
    public function admin_add() {
		//$this->redirect(array('action'=>'view'));
		$this->set("action", "add");
        $this->set('title_for_layout', __('Add New Event', true));

        if (!empty($this->data)) {
            $this->Event->create();
			//pr($this->data); exit;
			$upload_error = "";
			$pdf_upload_error = "";
			if($this->isUploadedFile($this->data['Event']['logo']))
			{

				// grab the file 
				$file = $this->data['Event']['logo'];
				$new_name = "logo_" . time();

				// upload the image using the upload component
				$ext =  $this->Upload->upload_file_ext($file);
				//$rules = array("size" => array(Configure::read('CV.assoc_image_small_width'), Configure::read('CV.assoc_image_small_height')), "type" => "resizemin");
				$result = $this->Upload->upload($file, $this->logo_dest, $new_name . "." . $ext, null);
				//$result = $this->Upload->upload($file, $this->dest_small, $new_name . "." . $ext, $rules);
				if (is_array($this->Upload->errors) && (!empty($this->Upload->errors)))
				{
					 $upload_error = implode("<br />", $this->Upload->errors);
				}
				else 
				{
					$this->data['Event']['logo'] = $this->Upload->result;
				}
			}
			else
			{
				unset($this->data['Event']['logo']);
			}
			
			if($this->isUploadedFile($this->data['Event']['event_information']))
			{
				// grab the file 
				$event_information = $this->data['Event']['event_information'];
				$new_event_information_name = $this->data['Event']['event_information']["name"];

				// upload the image using the upload component
				//$ext =  $this->Upload->upload_file_ext($file);

				move_uploaded_file($this->data['Event']['event_information']["tmp_name"], $this->pdf_dest . $new_event_information_name);
				$this->data['Event']['event_information'] = $new_event_information_name;		
			}
			else
			{
				unset($this->data['Event']['event_information']);
			}
			
			if($upload_error != "")
			{
				$this->Session->setFlash(__('Error in Image Upload.' . $upload_error, true), 'default', array('class' => 'error'));
			}
			else
			{
			
				$this->data['Event']['status'] = 1;
				
				//unset($this->Event->Question->validate['event_id']);
				if ($this->Event->saveAll($this->data, array('validate'=>'first'))) {
					$this->Session->setFlash(__('The Event has been saved', true), 'default', array('class' => 'success'));
					$this->redirect(array('action'=>'index'));
				} else {
					$this->Session->setFlash(__('The Event could not be saved. Please, try again.', true), 'default', array('class' => 'error'));
				}
			}
        }
    }

    public function admin_edit($id = null) {
		$this->set("action", "edit");
        $this->set('title_for_layout', __('Edit Event', true));
		if(!$id)
		{
			$data = $this->Event->find("first");
			if($data)
			{
				$id = $data["Event"]["id"];
			}
		}
        if (!$id && empty($this->data)) {
			//get the first event 
			
            $this->Session->setFlash(__('Invalid Event', true), 'default', array('class' => 'error'));
            $this->redirect(array('action'=>'add'));
        }
        if (!empty($this->data)) {
		
			if($this->isUploadedFile($this->data['Event']['logo']))
			{
				// grab the file 
				$file = $this->data['Event']['logo'];
				$new_name = "logo_" . time();
				// upload the image using the upload component
				$ext =  $this->Upload->upload_file_ext($file);
				//$rules = array("size" => array(Configure::read('CV.assoc_image_small_width'), Configure::read('CV.assoc_image_small_height')), "type" => "resizemin");
				$result = $this->Upload->upload($file, $this->logo_dest, $new_name . "." . $ext, null);
				//$result = $this->Upload->upload($file, $this->dest_small, $new_name . "." . $ext, $rules);
				if (is_array($this->Upload->errors) && (!empty($this->Upload->errors)))
				{
					 $upload_error = implode("<br />", $this->Upload->errors);
				}
				else 
				{
					$this->data['Event']['logo'] = $this->Upload->result;
				}
			}
			else
			{
				unset($this->data['Event']['logo']);
			}
			
			if($this->isUploadedFile($this->data['Event']['event_information']))
			{
				// grab the file 
				$event_information = $this->data['Event']['event_information'];
				$new_event_information_name = $this->data['Event']['event_information']["name"];
				move_uploaded_file($this->data['Event']['event_information']["tmp_name"], $this->pdf_dest . $new_event_information_name);
				$this->data['Event']['event_information'] = $new_event_information_name;		
			}
			else
			{
				unset($this->data['Event']['event_information']);
			}
		
            if ($this->Event->saveAll($this->data, array('validate'=>'first'))) {
                $this->Session->setFlash(__('The Event has been saved', true), 'default', array('class' => 'success'));
                $this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash(__('The Event could not be saved. Please, try again.', true), 'default', array('class' => 'error'));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Event->read(null, $id);
			//pr($this->data);
        }
		
		$this->render("admin_add");
    }

    public function admin_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Event', true), 'default', array('class' => 'error'));
            $this->redirect(array('action'=>'index'));
        }
        if (!isset($this->params['named']['token']) || ($this->params['named']['token'] != $this->params['_Token']['key'])) {
            $blackHoleCallback = $this->Security->blackHoleCallback;
            $this->$blackHoleCallback();
        }
        if ($this->Event->delete($id)) {
            $this->Session->setFlash(__('Event deleted', true), 'default', array('class' => 'success'));
            $this->redirect(array('action'=>'index'));
        }
    }
	
    public function admin_process() {
        $action = $this->data['Event']['action'];
        $ids = array();
        foreach ($this->data['Event'] AS $id => $value) {
            if ($id != 'action' && $value['id'] == 1) {
                $ids[] = $id;
            }
        }

        if (count($ids) == 0 || $action == null) {
            $this->Session->setFlash(__('No items selected.', true), 'default', array('class' => 'error'));
            $this->redirect(array('action' => 'index'));
        }

        if ($action == 'delete' &&
            $this->Event->deleteAll(array('Event.id' => $ids), true, true)) {
            $this->Session->setFlash(__('Events deleted.', true), 'default', array('class' => 'success'));
        } elseif ($action == 'publish' &&
            $this->Event->updateAll(array('Event.status' => 1), array('Event.id' => $ids))) {
            $this->Session->setFlash(__('Events published', true), 'default', array('class' => 'success'));
        } elseif ($action == 'unpublish' &&
            $this->Event->updateAll(array('Event.status' => 0), array('Event.id' => $ids))) {
            $this->Session->setFlash(__('Events unpublished', true), 'default', array('class' => 'success'));
		} else {
            $this->Session->setFlash(__('An error occurred.', true), 'default', array('class' => 'error'));
        }

        $this->redirect(array('action' => 'index'));
    }


	public function admin_view($id = NULL)
	{
		if($id == NULL)
		{
            $this->Session->setFlash(__('there is no id found to view the event.', true), 'default', array('class' => 'error'));
			$this->redirect("index");
		}
        $this->set('title_for_layout', __('Event Details', true));
        $data = $this->Event->find("first", array("conditions" => array("Event.id" => $id)));
		if(empty($data))
		{
            $this->Session->setFlash(__('there is no record found for the  id provided.', true), 'default', array('class' => 'error'));
			$this->redirect("index");
		}		
		
		//pr($data);
		$this->set("data", $data);
		$this->render("admin_view");
	}
	
    public function index() {		
        $this->set('title_for_layout', __('Events', true));

        $this->Event->recursive = 0;
        $this->paginate['Event']['order'] = "Event.id DESC";
		$this->paginate['Event']['conditions'] = array("Event.status" => 1);
        $this->set('data_array', $this->paginate());
    }

	public function get_event($event_id = NULL)
	{
		//pr($this->params);
		if($event_id != NULL)
		{
			$this->loadModel("Idea");
			//get the  event  detail and return it when called using requestAction functin from any view file
			//$event_data = $this->Event->find("first", array("conditions" => array("Event.id" => $event_id)));
			$event_logo = $this->Event->field('logo', array("Event.id" => $event_id));
			
			//get the counting of the users as contributer in the  ideas
			$ideas_count = $this->Idea->query("SELECT count(`id`) as ideas_count FROM ideas where event_id = " . $event_id);					
			
			//get the counting of the ideas for this event
			$users_count = $this->Idea->query("SELECT count(distinct(`user_id`)) as users_count FROM ideas where event_id = " . $event_id);	
			
		
			
			$event_data = array();
			$event_data["ideas_count"] = 0;
			if(!empty($ideas_count))
			{
				$event_data["ideas_count"] = $ideas_count[0][0]["ideas_count"];
			}
			$event_data["users_count"] = 0;
			if(!empty($users_count))
			{
				$event_data["users_count"] = $users_count[0][0]["users_count"];
			}	
			if($event_logo)
			{
				$event_data["logo"] = $event_logo;
			}
			

			
			if(!empty($event_data))
			{
				return $event_data;
			}
			else
			{
				return array();
			}
		}
		else
		{
			return array();
		}
		exit;
	}
}
?>