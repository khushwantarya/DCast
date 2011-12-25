<?php
/**
 * Questions Controller
 *
 * PHP version 5
 *
 * @question Controller
 * @package  Croogo
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class QuestionsController extends AppController {
/**
 * Controller name
 *
 * @var string
 * @access public
 */
    public $name = 'Questions';
/**
 * Models used by the Controller
 *
 * @var array
 * @access public
 */
	public $uses = array('Question', 'Event', 'Idea');
	public $helpers = array('Ideatree', 'Js', 'wordCloud');
	public $components = array('Rgraphdata');
	public $event_id = "";
	public function beforeFilter() {
		parent::beforeFilter();	
		//check if the user is logged in or not
		parent::checkFrontSession();
		//check if the user has assigned for any event or not
		parent::checkForEvent();
	}
	
	public function beforeRender()
	{
		$this->set("active_tab", $this->active_tab);	
	}
	
	public function admin_index() {
			$this->set('title_for_layout', __('Manage Questions', true));

			$this->Question->recursive = 0;
			$this->paginate['Question']['order'] = "Question.id ASC";
			$this->paginate['Question']['conditions'] = array("Question.event_id" => $this->event_id);
	
			$this->set('questions', $this->paginate());
	
	

	}
		
		
	public function admin_add() {
		$this->set("action", "add");
		$this->set('title_for_layout', __('Add New Question', true));

		if (!empty($this->data)) {
				$this->Question->create();
				$this->data['Question']['status'] = 1;
				if ($this->Question->save($this->data)) {
						$this->Session->setFlash(__('The Question has been saved', true), 'default', array('class' => 'success'));
						$this->redirect(array('action'=>'index', 'event_id' => $this->event_id));
				} else {
						$this->Session->setFlash(__('The Question could not be saved. Please, try again.', true), 'default', array('class' => 'error'));
				}
		}
	}

	public function admin_edit($id = null) {
		$this->set("action", "edit");
		$this->set('title_for_layout', __('Edit Question', true));

		if (!$id && empty($this->data)) {
				$this->Session->setFlash(__('Invalid Question', true), 'default', array('class' => 'error'));
				$this->redirect(array('action'=>'index', 'event_id' => $this->event_id));
		}
		if (!empty($this->data)) {
				if ($this->Question->save($this->data)) {
						$this->Session->setFlash(__('The Question has been saved', true), 'default', array('class' => 'success'));
						$this->redirect(array('action'=>'index', 'event_id' => $this->event_id));
				} else {
						$this->Session->setFlash(__('The Question could not be saved. Please, try again.', true), 'default', array('class' => 'error'));
				}
		}
		if (empty($this->data)) {
				$this->data = $this->Question->read(null, $id);
		}

		$this->render("admin_add");
	}

	public function admin_delete($id = null) {
		if (!$id) {
				$this->Session->setFlash(__('Invalid id for Question', true), 'default', array('class' => 'error'));
				$this->redirect(array('action'=>'index', 'event_id' => $this->event_id));
		}
		if (!isset($this->params['named']['token']) || ($this->params['named']['token'] != $this->params['_Token']['key'])) {
				$blackHoleCallback = $this->Security->blackHoleCallback;
				$this->$blackHoleCallback();
		}
		if ($this->Question->delete($id)) {
				$this->Session->setFlash(__('Question deleted', true), 'default', array('class' => 'success'));
				$this->redirect(array('action'=>'index', 'event_id' => $this->event_id));
		}
	}

	public function admin_process() {
			$action = $this->data['Question']['action'];
			$ids = array();
			foreach ($this->data['Question'] AS $id => $value) {
					if ($id != 'action' && $value['id'] == 1) {
							$ids[] = $id;
					}
			}

			if (count($ids) == 0 || $action == null) {
					$this->Session->setFlash(__('No items selected.', true), 'default', array('class' => 'error'));
					$this->redirect(array('action' => 'index', 'event_id' => $this->event_id));
			}

			if ($action == 'delete' &&
					$this->Question->deleteAll(array('Question.id' => $ids), true, true)) {
					$this->Session->setFlash(__('Questions deleted.', true), 'default', array('class' => 'success'));
			} elseif ($action == 'publish' &&
					$this->Question->updateAll(array('Question.status' => 1), array('Question.id' => $ids))) {
					$this->Session->setFlash(__('Questions published', true), 'default', array('class' => 'success'));
			} elseif ($action == 'unpublish' &&
					$this->Question->updateAll(array('Question.status' => 0), array('Question.id' => $ids))) {
					$this->Session->setFlash(__('Questions unpublished', true), 'default', array('class' => 'success'));
			} else {
					$this->Session->setFlash(__('An error occurred.', true), 'default', array('class' => 'error'));
			}

			$this->redirect(array('action' => 'index', 'event_id' => $this->event_id));
	}


	public function index() {
		$this->set('title_for_layout', __('Questions', true));

		$this->Question->recursive = 0;
		$this->paginate['Question']['order'] = "Question.id DESC";
		$this->paginate['Question']['conditions'] = array("Question.status" => 1);
		$this->set('data_array', $this->paginate());
	}
	
	public function share()
	{
		$this->active_tab = "share_ideas";	
		//get all questions for the current event id
		//$this->loadModel("Question");
		$this->Question->recursive = 2;
		$this->Idea->recursive = 2;	
    /*$this->Question->bindModel(
        array('hasMany' => array(
                'Idea' => array(
                    'className' => 'Idea',
										'foreignKey' => 'question_id',
										'conditions' => array('Idea.parent_id' => 0)
                )
            )
        )
    );*/
	
    /*$this->Idea->bindModel(
        array('hasMany' => array(
                'ChildIdea' => array(
                    'className' => 'Idea',
										'foreignKey' => 'parent_id',
										'order' => 'ChildIdea.created DESC',
										'conditions' => array('ChildIdea.status' => 1),
										'recursive'	 => 2
                )
            )
        )
    );*/


		
		$data_array = $this->Question->find("all", array("conditions" => array("Question.event_id" => $this->event_id)));
		foreach($data_array as $k => $v)
		{
			$this->Idea->bindModel(
					array('belongsTo' => array(
									'User' => array(
											'className' => 'User',
											'foreignKey' => 'user_id'
									)
							)
					)
			);		

			$this->Idea->bindModel(
					array('belongsTo' => array(
									'Question' => array(
											'className' => 'Question',
											'foreignKey' => 'question_id'
									)
							)
					)
			);	
			$this->Idea->bindModel(
					array('hasOne' => array(
									'UsersBigIdea' => array(
											'className' => 'UsersBigIdea',
											'foreignKey' => 'idea_id',
											'conditions' => array("UsersBigIdea.user_id" => $this->Session->read('Auth.User.id'))
									)
							)
					)
			);		
			//$this->Idea->unbindModel("UsersFavoriteIdea");
			$this->Idea->bindModel(
					array('hasOne' => array(
									'UsersFavoriteIdea' => array(
											'className' => 'UsersFavoriteIdea',
											'foreignKey' => 'idea_id',
											'conditions' => array("UsersFavoriteIdea.user_id" => $this->Session->read('Auth.User.id'), "UsersFavoriteIdea.id !=" => NULL)
									)
							)
					)
			);	
			$idea_array = $this->Idea->find("threaded", array("conditions" => array("Idea.event_id" => $this->event_id, "Idea.question_id" => $v["Question"]["id"]), "order" => "Idea.id DESC"));
			$data_array[$k]["Idea"] = $idea_array;
		}
		
		//$idea_array = $this->Idea->find("threaded", array("conditions" => array("Idea.event_id" => $this->event_id)));
		
		$this->set("data_array", $data_array);
		//pr($data_array);
		//pr($idea_array);
	}
	
	public function view_idea()
	{
		$this->active_tab = "see_ideas";	
		$ajax = "no";
		$tab = "";
		$live_stream_sort = "N";
		if($this->RequestHandler->isAjax())
		{
			$ajax = "yes";	
		}
		//pr($this->params["named"]);
		
		/* start for the livestream section */
		$cat_niceurl = "";
		//pr($this->params);
		if(isset($this->params["named"]["tab"]) && $this->params["named"]["tab"] != "")
		{
			$tab = $this->params["named"]["tab"];
		}
		if(isset($this->params["named"]["live_stream_sort"]) && $this->params["named"]["live_stream_sort"] != "")
		{
			$live_stream_sort = $this->params["named"]["live_stream_sort"];
		}		
		
		$conditions = array();
		$to_pass = "";
		$this->loadModel("UsersFavoriteIdea");
		$conditions[] = array("Idea.status" => 1); 
		$this->paginate = array(
			'Idea'    => array(
				'limit'    => 10,
				'order'    => array('Idea.created'    => 'desc')
			)
		);
		$this->paginate["Idea"]["conditions"] = $conditions;
		if($live_stream_sort == "N")
		{
			$this->paginate["Idea"]["order"] = array("Idea.created" => "DESC");
		}
		else if($live_stream_sort == "O")
		{
			$this->paginate["Idea"]["order"] = array("Idea.created" => "ASC");
		}
		else if($live_stream_sort == "H")
		{
			$this->paginate["Idea"]["order"] = array("Idea.score" => "DESC");
		}
		else if($live_stream_sort == "L")
		{
			$this->paginate["Idea"]["order"] = array("Idea.score" => "ASC");
		}
		$live_array = $temp_live_array = $this->paginate('Idea');
		foreach($temp_live_array as $k => $v)
		{
			$temp_array = $this->UsersFavoriteIdea->find("first", array("conditions" => array("UsersFavoriteIdea.user_id" => $this->Session->read('Auth.User.id'), "UsersFavoriteIdea.idea_id" => $v["Idea"]["id"])));
			if($temp_array)
			{
				$live_array[$k]["UsersFavoriteIdea"] = $temp_array["UsersFavoriteIdea"];
			}
			else
			{
				$live_array[$k]["UsersFavoriteIdea"] = array();
			}
		}
		/* start for the livestream section */	
		
		
		/* start for the leaderboard section */
		$this->loadModel("User");
		$this->User->recursive = 0;
		$conditions = array();
		$conditions[] = array("User.status" => 1); 
		$user_array = $this->User->find('all', array("conditions" => $conditions, "order" => array('User.idea_count' => 'desc')));
		/* start for the leaderboard section */		
		
		
		
		/* start for the word cloud section */
			$word_cloud_array = $this->Idea->find("all", array("fields" => array("GROUP_CONCAT(CONCAT(idea, ' ')) as all_idea"), "conditions" => array("Idea.status" => 1)));
			if($word_cloud_array)
			{
				$word_cloud_array = $word_cloud_array[0][0]["all_idea"];
			}
			$word_cloud_array = str_replace(",", "", $word_cloud_array);
			$word_cloud_array = explode(" ", $word_cloud_array);
			$cloud_array = array();
			foreach($word_cloud_array as $k => $v)
			{
				if(strlen($v) > 2)
				{
					if(!in_array($v, array("is", "this", "a", "for", "if", "that", "those", "these", "them")))
					{
						if(isset($cloud_array[$v]))
						{
							$cloud_array[$v] += 1;
						}
						else
						{
							$cloud_array[$v] = 0;
						}
					}
				}
			}
			/*echo "<pre>";
			print_r($cloud_array);
			echo "</pre>";*/
		/* end for the word cloud section */		
		
		
		/* start for the experts tag section */
			//get the idea_ids for the event 
			//$tags_ideas_array = $this->Idea->find("all", array("conditions" => array("Idea.event_id" => $this->event_id, "Idea.status" => 1)));
			$this->loadModel("IdeasTag");
			$this->IdeasTag->bindModel(
					array('belongsTo' => array(
									'Tag' => array(
											'className' => 'Tag',
											'foreignKey' => 'tag_id'
									)
							)
					)
			);
			$this->IdeasTag->bindModel(
					array('belongsTo' => array(
									'Idea' => array(
											'className' => 'Idea',
											'foreignKey' => 'idea_id'
									)
							)
					)
			);
			$tags_array = $this->IdeasTag->find("all", array("fields" => array("Tag.name", "count(Tag.id) as weight", "Tag.id"), "group" => array("Tag.name"), "conditions" => array("Idea.status" => 1, "Idea.event_id" => $this->event_id)));
			//pr($tags_array);
			
		
		/* end for the experts tag section */
		
		
		/* start for the Idea Map section */
		$data_array = array("id" => "1212_1212", "name" => "Discovery Cast", "data" => "This is the visualization for the discovery cast idea data.");
		$question_array = $this->Question->find("all", array("conditions" => array("Question.event_id" => $this->event_id)));

		foreach($question_array as $k => $v)
		{
			$this->Idea->recursive = -1;
			$idea_array = $this->Idea->find("threaded", array("fields" => array("Idea.idea as name", "Idea.idea as data", "Idea.id", "Idea.parent_id"), "conditions" => array("Idea.event_id" => $this->event_id, "Idea.question_id" => $v["Question"]["id"]), "order" => "Idea.id DESC"));
			$data_array["children"][$k] = array("id" => $v["Question"]["id"], "name" => $v["Question"]["keyword"], "data" => array("relation" => $v["Question"]["title"]));
			$data_array["children"][$k]["children"] = $this->Rgraphdata->set_data($idea_array);
			//$data_array[$k]["Idea"] = $idea_array;
		}
		
		$idea_map_array = json_encode($data_array);
		/* start for the Idea Map section */
		
		$this->set("live_array", $live_array);
		$this->set("user_array", $user_array);
		$this->set("tags_array", $tags_array);
		$this->set("cloud_array", $cloud_array);
		$this->set("idea_map_array", $idea_map_array);
			
		$this->set("to_pass", $to_pass);
		$this->set("ajax", $ajax);
		$this->set("tab", $tab);
	}
	
	
	
	public function admin()
	{
		$this->active_tab = "admin";

		/* start to get the untagged ideas */
		$this->Idea->bindModel(
				array('hasOne' => array(
								'UsersFavoriteIdea' => array(
										'className' => 'UsersFavoriteIdea',
										'foreignKey' => 'idea_id',
										'conditions' => array("UsersFavoriteIdea.user_id" => $this->Session->read('Auth.User.id'), "UsersFavoriteIdea.id !=" => NULL)
								)
						)
				)
		);
		$this->Idea->bindModel(
				array('hasMany' => array(
								'IdeasTag' => array(
										'className' => 'IdeasTag',
										'foreignKey' => 'idea_id',
										'conditions' => array("IdeasTag.id !=" => NULL)
								)
						)
				)
		);		
		
		$untagged_conditions = array();
		$untagged_conditions["Idea.status"] = 1;
		$untagged_conditions["Idea.event_id"] = $this->event_id;
		$this->Idea->recursive = 1;
		$untagged_array = $this->Idea->find("all", array("conditions" => $untagged_conditions));
		$this->set("untagged_array", $untagged_array);
		//echo "<pre>"; print_r($untagged_array); echo "</pre>";
		/* end to get the untagged ideas */
		
		
		/* start to get the awarded ideas */
		$this->Idea->bindModel(
				array('hasOne' => array(
								'UsersFavoriteIdea' => array(
										'className' => 'UsersFavoriteIdea',
										'foreignKey' => 'idea_id',
										'conditions' => array("UsersFavoriteIdea.user_id" => $this->Session->read('Auth.User.id'), "UsersFavoriteIdea.id !=" => NULL)
								)
						)
				)
		);	
		
		$awarded_conditions = array();
		$awarded_conditions["Idea.status"] = 1;
		$awarded_conditions["Idea.event_id"] = $this->event_id;
		$awarded_conditions["Idea.score > "] = 0;
		$awarded_array = $this->Idea->find("all", array("conditions" => $awarded_conditions));
		$this->set("awarded_array", $awarded_array);
		/* start to get the awarded ideas */
	}
	
	/*
		Author: Khushwant singh
		Uses	: This function is used to search the term using ajax and output the search result ideas lists
	*/
	
	public function search_idea()
	{
		//load the idea model to use here
		$this->loadModel("Idea");
		if($_POST)
		{
			$keyword = $_POST["keyword"];
			$keyword = explode(" ", $keyword);
			//split the keyword in the array 
			$conditions = array();
			$temp = array();
			foreach($keyword as $k => $v)
			{
				if(trim($v) != "")
				{
					$temp[] = array("Idea.idea LIKE " => "%" . $v . "%");
				}
			}
			$conditions["OR"] = $temp;
			$data_array = $this->Idea->find("all", array("fields" => array("id", "idea"), "conditions" => $conditions));
			$this->set("data_array", $data_array);
		}
	}
	
	public function add_idea()
	{
		//load the idea model to use here
		$this->loadModel("Idea");
		if($_POST)
		{
			$keyword = $_POST["keyword"];
			$parent_id = 0;
			$target = "";
			if(isset($_POST["target"]) && ($_POST["target"] != ""))
			{
				$target = $_POST["target"];	
			}		
			
			if(isset($_POST["parent_id"]) && ($_POST["parent_id"] != ""))
			{
				$parent_id = $_POST["parent_id"];
				//get the question_id by the idea_id (means parent_id)
				$question_id = $this->Idea->field('question_id', array("Idea.id" => $parent_id));
			}
			else
			{
				if(isset($_POST["question_id"]) && ($_POST["question_id"] != ""))
				{
					$question_id = $_POST["question_id"];
				}
			}
			
			$data = array();
			$data["Idea"]["parent_id"] = $parent_id;
			$data["Idea"]["event_id"] = $this->event_id;
			$data["Idea"]["question_id"] = $question_id;
			$data["Idea"]["user_id"] = $this->Session->read('Auth.User.id');
			$data["Idea"]["idea"] = $keyword;
			if(isset($_POST["type"]) && ($_POST["type"] != ""))
			{
				$data["Idea"]["type"] = $_POST["type"];
			}
			$data["Idea"]["status"] = 1;
			
			
			$this->Idea->create();
			$this->Idea->save($data, false);
			
			
			//start to update the points of the user 
				//get the  points earned before  by the user
				/*$this->loadModel("User");
				$user_array = $this->User->find("first", array("conditions" => array("User.id" => $this->Session->read('Auth.User.id'))));
				
				$added_points = $user_array["User"]["points"];

				if(!$user_array["User"]["unique_id"])
				{
					$added_points += $scoring_rule_array[Configure::read('CV.you_select_an_unique_id')]["value"];
				}
				
				//check if the user already have his avatar if it is added first time then add 50 points when adding the avatar first time
				if($user_array["User"]["avatar_id"] == 0)
				{
					$added_points += $scoring_rule_array[Configure::read('CV.you_select_an_avatar')]["value"];
				}	
				$user_data["User"]["points"] = $added_points;
							
				//add 50 points to the user account when he was adding unique_id first time
				$this->User->id = $this->Session->read('Auth.User.id');
				
				//check if the id is unique for this record
				
				$return_msg = "";
				if($_POST["unique_id"] != "")
				{
					$is_already = $this->User->field("id", array("User.unique_id" => $_POST["unique_id"], "User.id != " => $this->Session->read('Auth.User.id')));
					$user_data["User"]["unique_id"] = $_POST["unique_id"];
					if($is_already)
					{
						echo json_encode(array("type" => "error", "msg" => "Enter Username is already taken by other User."));exit;
					}
				}
				if($_POST["password"] != "")
				{
					$user_data["User"]["password"] = $_POST["password"];
				}
				
				$user_data["User"]["email_alerts"] = $_POST["email_alerts"];

				if($_POST["avatar_id"] != "")
				{
					$user_data["User"]["avatar_id"] = $_POST["avatar_id"];
				}
				$user_data["User"]["status"] = 1;
				
				

				
				
				$this->User->save($user_data, false)*/
			//end to updated the points of the usser 
			
			
			$data_array = $this->Question->find("all", array("conditions" => array("Question.id" => $question_id)));
			//get the last inserted record from the ideas table and place it in view file
			$this->Idea->bindModel(
					array('belongsTo' => array(
									'Question' => array(
											'className' => 'Question',
											'foreignKey' => 'question_id'
									)
							)
					)
			);
			$this->Idea->bindModel(
					array('belongsTo' => array(
									'User' => array(
											'className' => 'User',
											'foreignKey' => 'user_id'
									)
							)
					)
			);			
			$this->Idea->bindModel(
					array('hasOne' => array(
									'UsersBigIdea' => array(
											'className' => 'UsersBigIdea',
											'foreignKey' => 'idea_id',
											'conditions' => array("UsersBigIdea.user_id" => $this->Session->read('Auth.User.id'))
									)
							)
					)
			);		
			//$this->Idea->unbindModel("UsersFavoriteIdea");
			$this->Idea->bindModel(
					array('hasOne' => array(
									'UsersFavoriteIdea' => array(
											'className' => 'UsersFavoriteIdea',
											'foreignKey' => 'idea_id',
											'conditions' => array("UsersFavoriteIdea.user_id" => $this->Session->read('Auth.User.id'), "UsersFavoriteIdea.id !=" => NULL)
									)
							)
					)
			);
			
			if($target == "")
			{
				$idea_array = $this->Idea->find("threaded", array("conditions" => array("Idea.question_id" => $question_id, "Idea.id" => $this->Idea->id), "order" => "Idea.id DESC"));
				$data_array[0]["Idea"] = $idea_array;
				$this->set("data_array", $data_array);
			}
			else
			{
				$data_array = $this->Idea->find("all", array("conditions" => array("Idea.question_id" => $question_id, "Idea.id" => $this->Idea->id), "order" => "Idea.id DESC"));
				$this->set("data_array", $data_array);
			}

			$this->set("target", $target);
			//$this->layout = "blank";
		}
	}
	
	
	public function add_tag()
	{
		$this->loadModel("Idea");
		$this->loadModel("Tag");
		$this->loadModel("IdeasTag");
		if($_POST)
		{
			$tags = $_POST["tags"];
			$idea_id = $_POST["idea_id"];
			//explode the tag by the comman
			$tags_array = explode(",", $tags); 
		
			//loop through the tags_array 
			foreach($tags_array as $k => $v)
			{
				$tag = trim($v);
				//check if the tag is already in the tags table if it is exists then get the tag_id and insert into the ideas_tags table
				$tag_array = $this->Tag->findByName($tag);
				
				if($tag_array)
				{
					$tag_id = $tag_array["Tag"]["id"];
					//only insert the tag_id and idea_id in the ideas_tags table
					//first need to check the idea_id and tag_id is already in the ideas_tags table or not
					$ideas_tag_id = $this->IdeasTag->field("id", array("IdeasTag.tag_id" => $tag_id, "IdeasTag.idea_id" => $idea_id));
					if(!$ideas_tag_id)
					{
						//if there is no combination of this tag_id and idea_id then insert this combination
						$this->IdeasTag->create();
						$ideas_tag_data = array("idea_id" => $idea_id, "tag_id" => $tag_id);
						$this->IdeasTag->save($ideas_tag_data, false);
					}
				}
				else
				{	
					//insert the tag data in the tags table  and insert the tag_id and idea_id into the ideas_tags table
					$tag_data = array("name" => $tag, "status" => 1);
					$this->Tag->create();
					$this->Tag->save($tag_data, false);
					
					//insert into the ideas_tags table
					//$ideas_tag_id = $this->IdeasTag->field("id", array("IdeasTag.tag_id" => $this->Tag->id, "IdeasTag.idea_id" => $idea_id));
					$this->IdeasTag->create();
					$ideas_tag_data["IdeasTag"] = array("idea_id" => $idea_id, "tag_id" => $this->Tag->id);
					$this->IdeasTag->save($ideas_tag_data, false);
				}
			}
			echo 1;
			exit;
			//$this->layout = "blank";
		}
	}
	
	
	public function big_idea()
	{
		$this->loadModel("UsersBigIdea");
		if($_POST)
		{
			$idea_id = $_POST["idea_id"];
			$users_big_idea_id = $this->UsersBigIdea->field("id", array("UsersBigIdea.user_id" => $this->Session->read('Auth.User.id'), "UsersBigIdea.idea_id" => $idea_id));
			
			if($users_big_idea_id)
			{
				//delete the entery from users_big_ideas table
				$this->UsersBigIdea->deleteAll(array("UsersBigIdea.user_id" => $this->Session->read('Auth.User.id'), "UsersBigIdea.idea_id" => $idea_id));
				$image = "award-outlier-idea-off.png";
			}
			else
			{
				//add the entry into the  users_big_ideas table
				$this->UsersBigIdea->create();
				$data["UsersBigIdea"] = array("idea_id" => $idea_id, "user_id" => $this->Session->read('Auth.User.id'));
				$this->UsersBigIdea->save($data, false);
				$image = "award-outlier-idea.png";
			}
			$this->set("image", $image);
			//exit;
			//$this->layout = "blank";
		}
	}
	
	
	
	public function favorite_idea()
	{
		$this->loadModel("UsersFavoriteIdea");
		if($_POST)
		{
			$idea_id = $_POST["idea_id"];
			$users_favorite_id = $this->UsersFavoriteIdea->field("id", array("UsersFavoriteIdea.user_id" => $this->Session->read('Auth.User.id'), "UsersFavoriteIdea.idea_id" => $idea_id));
			
			if($users_favorite_id)
			{
				//delete the entery from users_big_ideas table
				//$this->UsersFavoriteIdea->deleteAll(array("UsersFavoriteIdea.user_id" => $this->Session->read('Auth.User.id'), "UsersFavoriteIdea.idea_id" => $idea_id));
				//$image = "award-outlier-idea-off.png";
			}
			else
			{
				//add the entry into the  users_big_ideas table
				$this->UsersFavoriteIdea->create();
				$data["UsersFavoriteIdea"] = array("idea_id" => $idea_id, "user_id" => $this->Session->read('Auth.User.id'));
				$this->UsersFavoriteIdea->save($data, false);
			}
			$image = "icon-yellow-star.png";
			$this->set("image", $image);
			//exit;
			//$this->layout = "blank";
		}
	}	
	
	
	/*
		Author: Khushwant Singh
		Uses	: This function is used to build on single idea, this will be a page to open with a single idea detail
	*/
	
	public function build_idea($idea_id = NULL)
	{
		$this->layout = "blank";
		
		if($idea_id == NULL)
		{
			exit("There is no Idea to get detail.");
		}
		
		$this->Idea->bindModel(
				array('hasOne' => array(
								'UsersBigIdea' => array(
										'className' => 'UsersBigIdea',
										'foreignKey' => 'idea_id',
										'conditions' => array("UsersBigIdea.user_id" => $this->Session->read('Auth.User.id'))
								)
						)
				)
		);
		$this->Idea->bindModel(
				array('hasOne' => array(
								'UsersFavoriteIdea' => array(
										'className' => 'UsersFavoriteIdea',
										'foreignKey' => 'idea_id',
										'conditions' => array("UsersFavoriteIdea.user_id" => $this->Session->read('Auth.User.id'), "UsersFavoriteIdea.id !=" => NULL)
								)
						)
				)
		);	
		$this->Idea->bindModel(
				array('hasOne' => array(
								'UserNote' => array(
										'className' => 'UserNote',
										'foreignKey' => 'idea_id',
										'conditions' => array("UserNote.user_id" => $this->Session->read('Auth.User.id'))
								)
						)
				)
		);
		//get the idea detail 
		$idea_array = $this->Idea->find("first", array("conditions" => array("Idea.id" => $idea_id, "Idea.status" => 1)));
		
		$this->Idea->bindModel(
				array('hasOne' => array(
								'UsersBigIdea' => array(
										'className' => 'UsersBigIdea',
										'foreignKey' => 'idea_id',
										'conditions' => array("UsersBigIdea.user_id" => $this->Session->read('Auth.User.id'))
								)
						)
				)
		);
		$this->Idea->bindModel(
				array('hasOne' => array(
								'UsersFavoriteIdea' => array(
										'className' => 'UsersFavoriteIdea',
										'foreignKey' => 'idea_id',
										'conditions' => array("UsersFavoriteIdea.user_id" => $this->Session->read('Auth.User.id'), "UsersFavoriteIdea.id !=" => NULL)
								)
						)
				)
		);		
		$child_idea_array = $this->Idea->find("all", array("conditions" => array("Idea.parent_id" => $idea_id, "Idea.status" => 1)));
		
		
		$parent_array = array();
		if(!empty($idea_array))
		{
			// check for the parent idea if there is a prent idea of the current idea
			$this->Idea->bindModel(
					array('hasOne' => array(
									'UsersBigIdea' => array(
											'className' => 'UsersBigIdea',
											'foreignKey' => 'idea_id',
											'conditions' => array("UsersBigIdea.user_id" => $this->Session->read('Auth.User.id'))
									)
							)
					)
			);
			$this->Idea->bindModel(
					array('hasOne' => array(
									'UsersFavoriteIdea' => array(
											'className' => 'UsersFavoriteIdea',
											'foreignKey' => 'idea_id',
											'conditions' => array("UsersFavoriteIdea.user_id" => $this->Session->read('Auth.User.id'), "UsersFavoriteIdea.id !=" => NULL)
									)
							)
					)
			);			
			$parent_array = $this->Idea->find("first", array("conditions" => array("Idea.id" => $idea_array["Idea"]["parent_id"], "Idea.status" => 1)));
		}
		
		//pr($child_idea_array);
		/*echo "Idea array";
		pr($idea_array);
		echo "Child array";
		pr($child_idea_array);
		echo "Parent array";
		pr($parent_array);*/
		
		$this->set("idea_array", $idea_array);
		$this->set("child_idea_array", $child_idea_array);
		$this->set("parent_array", $parent_array);
		//get the parent of the idea if there is a payment then need to show the  parent idea detail in the top right
		
	}
	
	public function add_note()
	{
		$this->loadModel("Idea");
		$this->loadModel("UserNote");
		if($_POST)
		{
			$note = $_POST["note"];
			$idea_id = $_POST["idea_id"];
			
			
			$user_note_array = $this->UserNote->find("first", array("conditions" => array("UserNote.user_id" => $this->Session->read('Auth.User.id'), "UserNote.idea_id" => $idea_id)));

			if($user_note_array)
			{
				$user_note_id = $user_note_array["UserNote"]["id"];
				//update the note in the user_notes table
				$this->UserNote->id = $user_note_id;
				$data = array("UserNote" => array("note" => $note));
				if($this->UserNote->save($data, false))
				{
					echo 1;
				}
				else
				{
					echo 0;
				}
			}
			else
			{	
				//save the note in the user_notes table
				$data = array("UserNote" => array("note" => $note, "idea_id" => $idea_id, "user_id" => $this->Session->read('Auth.User.id')));
				$this->UserNote->create();
				if($this->UserNote->save($data, false))
				{
					echo 1;
				}
				else
				{
					echo 0;
				}
			}
			
			exit;
		}
		exit;
	}
	
	/*
		This function is used to get the list for the wordcloud and expert tags
	*/
	public function side_list($term = NULL)
	{
		$this->loadModel("IdeasTag");
		if($_POST && $term != NULL)
		{
			$list_for = $_POST["list_for"];
			
			//whe the list for is word then search the coming term in the idea and if it is tag then search the ideas by the tag_id
			$this->Idea->bindModel(
					array('hasOne' => array(
									'UsersBigIdea' => array(
											'className' => 'UsersBigIdea',
											'foreignKey' => 'idea_id',
											'conditions' => array("UsersBigIdea.user_id" => $this->Session->read('Auth.User.id'))
									)
							)
					)
			);
			$this->Idea->bindModel(
					array('hasOne' => array(
									'UsersFavoriteIdea' => array(
											'className' => 'UsersFavoriteIdea',
											'foreignKey' => 'idea_id',
											'conditions' => array("UsersFavoriteIdea.user_id" => $this->Session->read('Auth.User.id'), "UsersFavoriteIdea.id !=" => NULL)
									)
							)
					)
			);	
			if($list_for == "idea")
			{
				$data_array = $this->Idea->find("all", array("conditions" => array("Idea.idea like " => "%" . $term . "%", "Idea.status" => 1)));
			}
			else if($list_for == "tag")
			{
				$this->Idea->bindModel(
						array('hasOne' => array(
										'IdeasTag' => array(
												'className' => 'IdeasTag',
												'foreignKey' => 'idea_id'
										)
								)
						)
				);	
				$this->IdeasTag->recursive = 2;
				$data_array = $this->Idea->find("all", array("conditions" => array("IdeasTag.tag_id" => $term, "Idea.status" => 1)));
			}
			else
			{
				$data_array = array();
			}
			/*echo "<pre>";
			print_r($data_array);
			echo "</pre>";*/
			$this->set("data_array", $data_array);
			
		}
		else
		{
			$this->set("data_array", $data_array);
		}
		//exit;
	}
	
	
	/*
		This function is used to draw a bar chart for all the ideas type i.e. parent idea, agree, disagree, modify, and question
	*/
	public function bar_chart()
	{
		$this->layout = "graph";
		App::import('Vendor', 'jpgraph/jpgraph');
		App::import('Vendor', 'jpgraph/jpgraph_bar');
		
		//load idea model
		$this->loadModel("Idea");
		
		//get the all parent ideas for 
		$question_array = $this->Question->find("all", array("conditions" => array("Question.event_id" => $this->event_id), "order" => "Question.number asc"));
		$idea_count_array = array();
		foreach($question_array as $qk => $qv)
		{
			$count_parent = $this->Idea->find('count', array('conditions' => array('Idea.question_id' => $qv["Question"]["id"], "Idea.parent_id" => 0)));	
			$count_agree = $this->Idea->find('count', array('conditions' => array('Idea.question_id' => $qv["Question"]["id"], "Idea.type" => Configure::read('CV.comments_types.agree'))));	
			$count_disagree = $this->Idea->find('count', array('conditions' => array('Idea.question_id' => $qv["Question"]["id"], "Idea.type" => Configure::read('CV.comments_types.disagree'))));	
			$count_modify = $this->Idea->find('count', array('conditions' => array('Idea.question_id' => $qv["Question"]["id"], "Idea.type" => Configure::read('CV.comments_types.modify'))));	
			$count_question = $this->Idea->find('count', array('conditions' => array('Idea.question_id' => $qv["Question"]["id"], "Idea.type" => Configure::read('CV.comments_types.question'))));	
			$idea_count_array[$qk] = array($count_parent, $count_agree, $count_disagree, $count_modify, $count_question);
		}
		
		$data1y = $idea_count_array[0];
		$data2y = $idea_count_array[1];
		$data3y = $idea_count_array[2];
		
		
		// Create the graph. These two calls are always required
		$graph = new Graph(600,380,'auto');
		$graph->SetScale("textlin");
		
		$theme_class=new UniversalTheme;
		$graph->SetTheme($theme_class);
		
		$graph->yaxis->SetTickPositions(array(0,10,20,30,40,50,60,70,80,90,100,110,120,130,140,150), array(5,15,25,35,45,55,65,75,85,95,105,125,135,145));
		$graph->SetBox(false);
		
		$graph->ygrid->SetFill(false);
		$graph->xaxis->SetTickLabels(array('Parent Idea','Agree','Disagree','Modify', 'Question'));
		$graph->yaxis->HideLine(false);
		$graph->yaxis->HideTicks(false,false);
		
		// Create the bar plots
		$b1plot = new BarPlot($data1y);
		$b2plot = new BarPlot($data2y);
		$b3plot = new BarPlot($data3y);
		
		// Create the grouped bar plot
		$gbplot = new GroupBarPlot(array($b1plot,$b2plot,$b3plot));
		// ...and add it to the graPH
		$graph->Add($gbplot);
		
		
		$b1plot->SetColor("white");
		$b1plot->SetFillColor("#1111aa");
		
		$b2plot->SetColor("white");
		$b2plot->SetFillColor("#22aaee");
		
		$b3plot->SetColor("white");
		$b3plot->SetFillColor("#cc1111");
		
		$graph->title->Set("Ideas Presentation");
		// Display the graph
		$graph->Stroke();
	}

}
?>