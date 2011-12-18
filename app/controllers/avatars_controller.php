<?php
/**
 * Avatars Controller
 *
 * PHP version 5
 *
 * @avatar Controller
 * @package  Croogo
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class AvatarsController extends AppController {
/**
 * Controller name
 *
 * @var string
 * @access public
 */
    public $name = 'Avatars';
/**
 * Models used by the Controller
 *
 * @var array
 * @access public
 */
    public $uses = array('Avatar');
	public $image_dest = "";
	
    public function beforeFilter() {
		parent::beforeFilter();
		$this->image_dest = realpath(Configure::read("CV.avatar_upload_path")) . "/";		
		//$this->redirect(array('controller' => 'events', 'action'=>'index')); 
		//$this->dest_small = realpath(Configure::read("CV.assoc_small_image_upload_path")) . "/";
	}
	
    public function admin_index() {

        $this->set('title_for_layout', __('Avatars', true));

        $this->Avatar->recursive = 0;
        $this->paginate['Avatar']['order'] = "Avatar.id ASC";
        $this->set('avatars', $this->paginate());
    }
		
		
    public function admin_add() {
		//$this->redirect(array('action'=>'edit'));
		$this->set("action", "add");
        $this->set('title_for_layout', __('Add New Avatar', true));

        if (!empty($this->data)) {
            $this->Avatar->create();
			$upload_error = "";
			$pdf_upload_error = "";
			if($this->isUploadedFile($this->data['Avatar']['image']))
			{

				// grab the file 
				$file = $this->data['Avatar']['image'];
				$new_name = "avatar_" . time();

				// upload the image using the upload component
				$ext =  $this->Upload->upload_file_ext($file);
				//$rules = array("size" => array(Configure::read('CV.assoc_image_small_width'), Configure::read('CV.assoc_image_small_height')), "type" => "resizemin");
				$result = $this->Upload->upload($file, $this->image_dest, $new_name . "." . $ext, null);
				//$result = $this->Upload->upload($file, $this->dest_small, $new_name . "." . $ext, $rules);
				if (is_array($this->Upload->errors) && (!empty($this->Upload->errors)))
				{
					 $upload_error = implode("<br />", $this->Upload->errors);
				}
				else 
				{
					$this->data['Avatar']['image'] = $this->Upload->result;
				}
			}
			else
			{
				unset($this->data['Avatar']['image']);
			}
			
			if($upload_error != "")
			{
				$this->Session->setFlash(__('Error in Image Upload.' . $upload_error, true), 'default', array('class' => 'error'));
			}
			else
			{

				$this->data['Avatar']['status'] = 1;
				if ($this->Avatar->save($this->data)) {
					$this->Session->setFlash(__('The Avatar has been saved', true), 'default', array('class' => 'success'));
					$this->redirect(array('action'=>'index'));
				} else {
					$this->Session->setFlash(__('The Avatar could not be saved. Please, try again.', true), 'default', array('class' => 'error'));
				}
			}
        }
    }

    public function admin_edit($id = null) {
		//$this->set("action", "edit");
        $this->set('title_for_layout', __('Edit Avatar', true));
		$this->set("action", "edit");
		if(!$id)
		{
			$data = $this->Avatar->find("first");
			if($data)
			{
				$id = $data["Avatar"]["id"];
			}
		}
		

        if (!$id && empty($this->data)) {
		
			//get the first avatar 
			
            $this->Session->setFlash(__('Invalid Avatar', true), 'default', array('class' => 'error'));
            $this->redirect(array('action'=>'add'));
        }
        if (!empty($this->data)) {
			//pr($this->data);
			//die;
			if($this->isUploadedFile($this->data['Avatar']['image']))
			{
				// grab the file 
				$file = $this->data['Avatar']['image'];
				$new_name = "avatar_" . time();
				// upload the image using the upload component
				$ext =  $this->Upload->upload_file_ext($file);
				//$rules = array("size" => array(Configure::read('CV.assoc_image_small_width'), Configure::read('CV.assoc_image_small_height')), "type" => "resizemin");
				$result = $this->Upload->upload($file, $this->image_dest, $new_name . "." . $ext, null);
				//$result = $this->Upload->upload($file, $this->dest_small, $new_name . "." . $ext, $rules);
				if (is_array($this->Upload->errors) && (!empty($this->Upload->errors)))
				{
					 $upload_error = implode("<br />", $this->Upload->errors);
				}
				else 
				{
					$this->data['Avatar']['image'] = $this->Upload->result;
					//here we need to remove the old image if this is exists
					@unlink($this->image_dest . $this->data['Avatar']['old_image']);
				}
			}
			else
			{
				unset($this->data['Avatar']['image']);
			}
		
		
            if ($this->Avatar->save($this->data)) {
                $this->Session->setFlash(__('The Avatar has been saved', true), 'default', array('class' => 'success'));
                $this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash(__('The Avatar could not be updated. Please, try again.', true), 'default', array('class' => 'error'));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Avatar->read(null, $id);
        }
		
		$this->render("admin_add");
    }

    public function admin_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Avatar', true), 'default', array('class' => 'error'));
            $this->redirect(array('action'=>'index'));
        }
        if (!isset($this->params['named']['token']) || ($this->params['named']['token'] != $this->params['_Token']['key'])) {
            $blackHoleCallback = $this->Security->blackHoleCallback;
            $this->$blackHoleCallback();
        }
        if ($this->Avatar->delete($id)) {
            $this->Session->setFlash(__('Avatar deleted', true), 'default', array('class' => 'success'));
            $this->redirect(array('action'=>'index'));
        }
    }
	
    public function admin_process() {
        $action = $this->data['Avatar']['action'];
        $ids = array();
        foreach ($this->data['Avatar'] AS $id => $value) {
            if ($id != 'action' && $value['id'] == 1) {
                $ids[] = $id;
            }
        }

        if (count($ids) == 0 || $action == null) {
            $this->Session->setFlash(__('No items selected.', true), 'default', array('class' => 'error'));
            $this->redirect(array('action' => 'index'));
        }

        if ($action == 'delete' &&
            $this->Avatar->deleteAll(array('Avatar.id' => $ids), true, true)) {
            $this->Session->setFlash(__('Avatars deleted.', true), 'default', array('class' => 'success'));
        } elseif ($action == 'publish' &&
            $this->Avatar->updateAll(array('Avatar.status' => 1), array('Avatar.id' => $ids))) {
            $this->Session->setFlash(__('Avatars published', true), 'default', array('class' => 'success'));
        } elseif ($action == 'unpublish' &&
            $this->Avatar->updateAll(array('Avatar.status' => 0), array('Avatar.id' => $ids))) {
            $this->Session->setFlash(__('Avatars unpublished', true), 'default', array('class' => 'success'));
		} else {
            $this->Session->setFlash(__('An error occurred.', true), 'default', array('class' => 'error'));
        }

        $this->redirect(array('action' => 'index'));
    }

	
    public function index() {		
        $this->set('title_for_layout', __('Avatars', true));

        $this->Avatar->recursive = 0;
        $this->paginate['Avatar']['order'] = "Avatar.id DESC";
		$this->paginate['Avatar']['conditions'] = array("Avatar.status" => 1);
        $this->set('data_array', $this->paginate());
    }

}
?>