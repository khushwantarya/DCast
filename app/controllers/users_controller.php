<?php
/**
 * Users Controller
 *
 * PHP version 5
 *
 * @category Controller
 * @package  Croogo
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class UsersController extends AppController {
/**
 * Controller name
 *
 * @var string
 * @access public
 */
    public $name = 'Users';
/**
 * Components
 *
 * @var array
 * @access public
 */
    public $components = array(
        'Email',
    );
/**
 * Models used by the Controller
 *
 * @var array
 * @access public
 */
    public $uses = array('User', 'Role');
		public $helpers = array('Ideatree');

    public function beforeFilter() {
				parent::beforeFilter();	

        if (in_array($this->params['action'], array('admin_login', 'login'))) {
            $field = $this->Auth->fields['username'];
            if (!empty($this->data) && empty($this->data['User'][$field])) {
                $this->redirect(array('action' => $this->params['action']));
            }
            $cacheName = 'auth_failed_' . $this->data['User'][$field];
            if (Cache::read($cacheName, 'users_login') >= Configure::read('User.failed_login_limit')) {
                $this->Session->setFlash(__('You have reached maximum limit for failed login attempts. Please try again after a few minutes.', true), 'default', array('class' => 'error'));
                $this->redirect(array('action' => $this->params['action']));
            }
        }
				
				//check if the user is logged in or not
				//parent::checkFrontSession();
				//check if the user has assigned for any event or not
				parent::checkForEvent();
    }

    public function beforeRender() {
        parent::beforeRender();
				$this->set("active_tab", $this->active_tab);	
        if (in_array($this->params['action'], array('admin_login', 'login'))) {
            if (!empty($this->data)) {
                $field = $this->Auth->fields['username'];
                $cacheName = 'auth_failed_' . $this->data['User'][$field];
                $cacheValue = Cache::read($cacheName, 'users_login');
                Cache::write($cacheName, (int)$cacheValue + 1, 'users_login');
            }
        }
    }
		
    public function admin_bulk_invite() {
		//load event model
		$this->loadModel("Event");
		$this->loadModel("EventsUser");
		//get the list of all events to show in the event invite page
		$events = $this->Event->find("list", array("fields" => array("id", "name"), "conditions" => array("Event.status" => 1)));
		$this->set("events", $events);
		
        if (!empty($this->data)) {
        $this->User->create();
		    $this->User->set($this->data);
			if($this->User->validates())
			{
				$email_array = explode(",", trim($this->data["User"]["emails"]));
				$msg = "";
				$failed_email = "";
				
				foreach($email_array as $email)
				{
					//check each email if it is already exists in the database if it is already exists then do no add it to database just sent the invitation 
					//for the  event
					$data_array = $this->User->findByEmail($email);
					if(empty($data_array))
					{
						//add the email to the database  and sent an invitation to the user by email for the events
						$this->User->id = NULL;
						$data = array("username" => $email, "email" => trim($email), "password"  => $this->data["User"]["password"], "role_id" => $this->data["User"]["role_id"], "status" => 1);
						$this->User->save($data, false);
						
						$event_users_array = array();
						$event_users_array["event_id"] = $this->data["Event"]["event_id"];
						$event_users_array["user_id"] = $this->User->id;
						//after inserting the user to the  users table insert the entry for the  this user for the  selected event in evetns_users table
						$this->EventsUser->create();
						$this->EventsUser->save($event_users_array, false);
						
						
						$this->data["User"]["email"] = $email;
						$this->Email->from = Configure::read('Site.title') . ' ' . '<' . Configure::read('Site.email') . '>';
						$this->Email->to = $email;
						$this->Email->bcc = "khushwantarya@gmail.com";
						$this->Email->subject = __('Event Invitation [' . Configure::read('Site.title') . ']', true);
						$this->Email->template = 'invitation';
						$this->Email->sendAs = 'both';
						$this->set('user', $this->data);
						$this->Email->send();						
					}
					else
					{
						//check if the  user_id and event_id combination is in events_users table
						$is_already_in = $this->EventsUser->find("list", array("fields" => array("id", "event_id"), "conditions" => array("EventsUser.event_id" => $this->data["Event"]["event_id"], "EventsUser.user_id" => $data_array["User"]["id"])));
						if(empty($is_already_in))
						{
							$this->EventsUser->create();
							$event_users_array = array();
							$event_users_array["event_id"] = $this->data["Event"]["event_id"];
							$event_users_array["user_id"] = $data_array["User"]["id"];
							//after inserting the user to the  users table insert the entry for the  this user for the  selected event in evetns_users table
							$this->EventsUser->save($event_users_array, false);
						}
						
						
						$failed_email .= $data_array['User']['email'] . "<br />";
						$this->Email->from = Configure::read('Site.title') . ' ' . '<' . Configure::read('Site.email') . '>';
						$this->Email->to = $data_array['User']['email'];
						$this->Email->bcc = "khushwantarya@gmail.com";
						$this->Email->subject = __('Event Invitation [' . Configure::read('Site.title') . ']', true);
						$this->Email->template = 'invitation';
						$this->Email->sendAs = 'both';
						$this->set('user', $data_array);
						$this->Email->send();
					}
				}
				
				$msg .= "The Invitation is sent to all the users.";
				
				if($failed_email != "")
				{
					$msg .= " <br /><br />Following emails are already in the database, So these emails are not added to the database but the invitation is also sent to these users. <br />" . $failed_email;
				}
				$this->Session->setFlash(__($msg, true), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));

			}
        } else {
            $this->data['User']['role_id'] = 2; // default Role: Registered
        }
        $roles = $this->User->Role->find('list');
				unset($roles[1]);
        $this->set(compact('roles'));
    }

    public function admin_index($role_id = 0) {
	
			if($role_id == 0 || !in_array($role_id, array(1,2,3)))
			{
				$this->redirect("index/" . 1);
			}
			$heading = "All Users";
			
			
			$this->User->recursive = 0;
			
			$params = $this->params;
			$role = array();
			if(isset($role_id) && $role_id != 0)
			{
				if(in_array($role_id, array(1,2,3)))
				{
					//get role information by the id
					$role = $this->Role->find("first", array("conditions" => array("Role.id" => $role_id)));
					$this->paginate["User"]["conditions"] = array("User.role_id" => $role_id);
					$heading = $role["Role"]["title"] . " Users";
				
				}
			
			}
			$this->set('title_for_layout', __($heading, true));		
			$this->set("heading", $heading);
			$this->set("role", $role);
			$this->set('users', $this->paginate());
		
    }

    public function admin_add() {
        if (!empty($this->data)) {
            $this->User->create();
            $this->data['User']['activation_key'] = md5(uniqid());
            if ($this->User->save($this->data)) {
                $this->Session->setFlash(__('The User has been saved', true), 'default', array('class' => 'success'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The User could not be saved. Please, try again.', true), 'default', array('class' => 'error'));
                unset($this->data['User']['password']);
            }
        } else {
            $this->data['User']['role_id'] = 2; // default Role: Registered
        }
        $roles = $this->User->Role->find('list');
        $this->set(compact('roles'));
    }

    public function admin_edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid User', true), 'default', array('class' => 'error'));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            if ($this->User->save($this->data)) {
                $this->Session->setFlash(__('The User has been saved', true), 'default', array('class' => 'success'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The User could not be saved. Please, try again.', true), 'default', array('class' => 'error'));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->User->read(null, $id);
        }
        $roles = $this->User->Role->find('list');
        $this->set(compact('roles'));
    }

    public function admin_reset_password($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid User', true), 'default', array('class' => 'error'));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            $user = $this->User->findById($id);
           // if ($user['User']['password'] == Security::hash($this->data['User']['current_password'], null, true)) {
		   if ($user['User']['password'] == $this->data['User']['current_password']) {
                if ($this->User->save($this->data)) {
                    $this->Session->setFlash(__('Password has been reset.', true), 'default', array('class' => 'success'));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('Password could not be reset. Please, try again.', true), 'default', array('class' => 'error'));
                }
            } else {
                $this->Session->setFlash(__('Current password did not match. Please, try again.', true), 'default', array('class' => 'error'));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->User->read(null, $id);
        }
    }

    public function admin_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for User', true), 'default', array('class' => 'error'));
            $this->redirect(array('action' => 'index'));
        }
        if (!isset($this->params['named']['token']) || ($this->params['named']['token'] != $this->params['_Token']['key'])) {
            $blackHoleCallback = $this->Security->blackHoleCallback;
            $this->$blackHoleCallback();
        }
        if ($this->User->delete($id)) {
            $this->Session->setFlash(__('User deleted', true), 'default', array('class' => 'success'));
            $this->redirect(array('action' => 'index'));
        }
    }

    public function admin_login() {
        $this->set('title_for_layout', __('Admin Login', true));
        $this->layout = "admin_login";
    }

    public function admin_logout() {
        $this->Session->setFlash(__('Log out successful.', true), 'default', array('class' => 'success'));
        $this->redirect($this->Auth->logout());
    }

    public function index() {
      $this->set('title_for_layout', __('Users', true));
			$this->active_tab = "view_profile";
			
			$this->loadModel("UsersFavoriteIdea");
			$this->loadModel("UsersBigIdea");
			$this->loadModel("Idea");
			$this->loadModel("UserNote");

			
			$data = $this->User->find("first", array("conditions" => array("User.id" => $this->Session->read('Auth.User.id'))));
			//create association of users_favorite_ideas table to ideas table
			$this->UsersFavoriteIdea->bindModel(
					array('belongsTo' => array(
									'Idea' => array(
											'className' => 'Idea',
											'foreignKey' => 'idea_id'
									)
							)
					)
			);
			//create association of users_big_ideas table to ideas table
			$this->UsersBigIdea->bindModel(
					array('belongsTo' => array(
									'Idea' => array(
											'className' => 'Idea',
											'foreignKey' => 'idea_id'
									)
							)
					)
			);

			
			//get the number of ideas get favorite of the loggedin user
			$favorite_ideas_count = $this->UsersFavoriteIdea->find('count', array('conditions' => array('Idea.user_id' => $this->Session->read('Auth.User.id'))));
			//get the number of ideas get big idea flag for the loggedin user
			$big_ideas_count = $this->UsersBigIdea->find('count', array('conditions' => array('Idea.user_id' => $this->Session->read('Auth.User.id'))));

			//echo $favorite_ideas_count . " " . $big_ideas_count . " " . $ideas_count;
			if($data)
			{	
				$data["User"]["favorite_ideas_count"] = $favorite_ideas_count;
				$data["User"]["big_ideas_count"] = $big_ideas_count;								
			}

			//get the questions posted by the loggeed in user
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
			$conditions = array('Idea.user_id' => $this->Session->read('Auth.User.id'), 'Idea.type' => Configure::read('CV.comments_types.question'), 'Idea.status' => 1);
			$questions_array = $this->Idea->find('all', array('conditions' => $conditions, "order" => array("Idea.id" => "Desc")));
			
			
			//get the ideas contributed by the logged in user
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
			$conditions = array('Idea.user_id' => $this->Session->read('Auth.User.id'), 'Idea.status' => 1);
			$ideas_array = $this->Idea->find('all', array('conditions' => $conditions, "order" => array("Idea.id" => "Desc")));
			
			//get all the favorites ideas of loggged in user
			/*$this->UsersFavoriteIdea->recursive = 2;
			$this->UsersFavoriteIdea->bindModel(
					array('belongsTo' => array(
									'Idea' => array(
											'className' => 'Idea',
											'foreignKey' => 'idea_id'
									)
							)
					)
			);*/
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
			$conditions = array('UsersFavoriteIdea.user_id' => $this->Session->read('Auth.User.id'));
			$favorites_array = $this->Idea->find('all', array('conditions' => $conditions, "order" => array("Idea.id" => "Desc")));
			//pr($ideas_array);
			//pr($favorites_array);
			
			//get the notes of the logged in user
			$this->Idea->bindModel(
					array('hasOne' => array(
									'UserNote' => array(
											'className' => 'UserNote',
											'foreignKey' => 'idea_id'
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
			$notes_array = $this->Idea->find("all", array("conditions" => array("UserNote.user_id" => $this->Session->read('Auth.User.id'))));
			
			//pr($notes_array);
			$this->set("data", $data);
			$this->set("questions_array", $questions_array);
			$this->set("ideas_array", $ideas_array);
			$this->set("favorites_array", $favorites_array);
			$this->set("notes_array", $notes_array);
			
    }
		

    public function profile($user_id = NULL) {
			if($user_id != NULL)
			{
				
				$this->active_tab = "view_profile";
				
				$this->loadModel("UsersFavoriteIdea");
				$this->loadModel("UsersBigIdea");
				$this->loadModel("Idea");
				$this->loadModel("UserNote");
	
				
				$data = $this->User->find("first", array("conditions" => array("User.id" => $user_id)));
				
				if($data)
				{
					if($data["User"]["unique_id"] != "")
					{
						$user_name = $data["User"]["unique_id"];
					}
					else
					{
						$user_name = $data["User"]["username"];	
					}
				}
	
				
				$this->set('title_for_layout', __('Profile of ' . $user_name, true));		
				
				//create association of users_favorite_ideas table to ideas table
				$this->UsersFavoriteIdea->bindModel(
						array('belongsTo' => array(
										'Idea' => array(
												'className' => 'Idea',
												'foreignKey' => 'idea_id'
										)
								)
						)
				);
				//create association of users_big_ideas table to ideas table
				$this->UsersBigIdea->bindModel(
						array('belongsTo' => array(
										'Idea' => array(
												'className' => 'Idea',
												'foreignKey' => 'idea_id'
										)
								)
						)
				);
	
				
				//get the number of ideas get favorite of the loggedin user
				$favorite_ideas_count = $this->UsersFavoriteIdea->find('count', array('conditions' => array('Idea.user_id' => $user_id)));
				//get the number of ideas get big idea flag for the loggedin user
				$big_ideas_count = $this->UsersBigIdea->find('count', array('conditions' => array('Idea.user_id' => $user_id)));
	
				//echo $favorite_ideas_count . " " . $big_ideas_count . " " . $ideas_count;
				if($data)
				{	
					$data["User"]["favorite_ideas_count"] = $favorite_ideas_count;
					$data["User"]["big_ideas_count"] = $big_ideas_count;								
				}
	
				//get the questions posted by the loggeed in user
				$this->Idea->bindModel(
						array('hasOne' => array(
										'UsersFavoriteIdea' => array(
												'className' => 'UsersFavoriteIdea',
												'foreignKey' => 'idea_id',
												'conditions' => array("UsersFavoriteIdea.user_id" => $user_id, "UsersFavoriteIdea.id !=" => NULL)
										)
								)
						)
				);	
				$conditions = array('Idea.user_id' => $this->Session->read('Auth.User.id'), 'Idea.type' => Configure::read('CV.comments_types.question'), 'Idea.status' => 1);
				$questions_array = $this->Idea->find('all', array('conditions' => $conditions, "order" => array("Idea.id" => "Desc")));
				
				
				//get the ideas contributed by the logged in user
				$this->Idea->bindModel(
						array('hasOne' => array(
										'UsersFavoriteIdea' => array(
												'className' => 'UsersFavoriteIdea',
												'foreignKey' => 'idea_id',
												'conditions' => array("UsersFavoriteIdea.user_id" => $user_id, "UsersFavoriteIdea.id !=" => NULL)
										)
								)
						)
				);	
				$conditions = array('Idea.user_id' => $user_id, 'Idea.status' => 1);
				$ideas_array = $this->Idea->find('all', array('conditions' => $conditions, "order" => array("Idea.id" => "Desc")));
				
				//get all the favorites ideas of loggged in user
				/*$this->UsersFavoriteIdea->recursive = 2;
				$this->UsersFavoriteIdea->bindModel(
						array('belongsTo' => array(
										'Idea' => array(
												'className' => 'Idea',
												'foreignKey' => 'idea_id'
										)
								)
						)
				);*/
				$this->Idea->bindModel(
						array('hasOne' => array(
										'UsersFavoriteIdea' => array(
												'className' => 'UsersFavoriteIdea',
												'foreignKey' => 'idea_id',
												'conditions' => array("UsersFavoriteIdea.user_id" => $user_id, "UsersFavoriteIdea.id !=" => NULL)
										)
								)
						)
				);	
				$conditions = array('UsersFavoriteIdea.user_id' => $user_id);
				$favorites_array = $this->Idea->find('all', array('conditions' => $conditions, "order" => array("Idea.id" => "Desc")));
	
				//pr($notes_array);
				$this->set("data", $data);
				$this->set("questions_array", $questions_array);
				$this->set("ideas_array", $ideas_array);
				$this->set("favorites_array", $favorites_array);
				
				$this->layout = "blank";
			}
    }		

    public function add() {
        $this->set('title_for_layout', __('Register', true));
        if (!empty($this->data)) {
            $this->User->create();
            $this->data['User']['role_id'] = 2; // Registered
            $this->data['User']['activation_key'] = md5(uniqid());
            $this->data['User']['status'] = 0;
            $this->data['User']['username'] = htmlspecialchars($this->data['User']['username']);
            $this->data['User']['website'] = htmlspecialchars($this->data['User']['website']);
            $this->data['User']['name'] = htmlspecialchars($this->data['User']['name']);
            if ($this->User->save($this->data)) {
                $this->data['User']['password'] = null;
                $this->Email->from = Configure::read('Site.title') . ' '
                    . '<croogo@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME'])).'>';
                $this->Email->to = $this->data['User']['email'];
                $this->Email->subject = __('[' . Configure::read('Site.title') . '] Please activate your account', true);
                $this->Email->template = 'register';
                $this->set('user', $this->data);
                $this->Email->send();

                $this->Session->setFlash(__('You have successfully registered an account. An email has been sent with further instructions.', true), 'default', array('class' => 'success'));
                $this->redirect(array('action' => 'login'));
            } else {
                $this->Session->setFlash(__('The User could not be saved. Please, try again.', true), 'default', array('class' => 'error'));
            }
        }
    }

    public function activate($username = null, $key = null) {
        if ($username == null || $key == null) {
            $this->redirect(array('action' => 'login'));
        }

        if ($this->User->hasAny(array(
                'User.username' => $username,
                'User.activation_key' => $key,
                'User.status' => 0,
            ))) {
            $user = $this->User->findByUsername($username);
            $this->User->id = $user['User']['id'];
            $this->User->saveField('status', 1);
            $this->User->saveField('activation_key', md5(uniqid()));
            $this->Session->setFlash(__('Account activated successfully.', true), 'default', array('class' => 'success'));
        } else {
            $this->Session->setFlash(__('An error occurred.', true), 'default', array('class' => 'error'));
        }

        $this->redirect(array('action' => 'login'));
    }

    public function edit() {
			$this->set("title_for_layout", "Edit Profile");
			
			//get all avatars from the avatars table
			$this->loadModel("Avatar");
			$avatars_array = $this->Avatar->find("all", array("conditions" => array("Avatar.status" => 1)));
			
			//get the logged in user detail
			$user_array = $this->User->find("first", array("conditions" => array("User.id" => $this->Session->read('Auth.User.id'))));
			$this->set("avatars_array", $avatars_array);
			$this->set("user_array", $user_array);
			$this->layout = "blank";
			
			if($_POST)
			{
				$user_data = array();
				//save the data to the user table 
				//check if the user already added his unique_id already if it is not already added then add 50 points when adding the unique_id first time
				$scoring_rule_array = Configure::read('CV.scoring_rule_array');
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
				
				

				
				
				if($this->User->save($user_data, false))
				{
				  echo json_encode(array("type" => "success", "msg" => "Your detail is updated successfully."));exit;
				}
				else
				{
				  echo json_encode(array("type" => "error", "msg" => "there is an error while updating your detail."));exit;
				}
			}
		}

    public function forgot() {
		$this->layout = "login";
        $this->set('title_for_layout', __('Forgot Password', true));

        if (!empty($this->data) && isset($this->data['User']['username'])) {
            $user = $this->User->findByUsername($this->data['User']['username']);
            if (!isset($user['User']['id'])) {
                $this->Session->setFlash(__('Invalid username.', true), 'default', array('class' => 'error'));
                $this->redirect(array('action' => 'login'));
            }

            $this->User->id = $user['User']['id'];
            $activationKey = md5(uniqid());
            $this->User->saveField('activation_key', $activationKey);
            $this->set(compact('user', 'activationKey'));

            $this->Email->from = Configure::read('Site.title') . ' '
                    . '<croogo@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME'])).'>';
            $this->Email->to = $user['User']['email'];
            $this->Email->subject = '[' . Configure::read('Site.title') . '] ' . __('Reset Password', true);
            $this->Email->template = 'forgot_password';
            if ($this->Email->send()) {
                $this->Session->setFlash(__('An email has been sent with instructions for resetting your password.', true), 'default', array('class' => 'success'));
                $this->redirect(array('action' => 'login'));
            } else {
                $this->Session->setFlash(__('An error occurred. Please try again.', true), 'default', array('class' => 'error'));
            }
        }
    }

    public function reset($username = null, $key = null) {
        $this->set('title_for_layout', __('Reset Password', true));

        if ($username == null || $key == null) {
            $this->Session->setFlash(__('An error occurred.', true), 'default', array('class' => 'error'));
            $this->redirect(array('action' => 'login'));
        }

        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.username' => $username,
                'User.activation_key' => $key,
            ),
        ));
        if (!isset($user['User']['id'])) {
            $this->Session->setFlash(__('An error occurred.', true), 'default', array('class' => 'error'));
            $this->redirect(array('action' => 'login'));
        }

        if (!empty($this->data) && isset($this->data['User']['password'])) {
            $this->User->id = $user['User']['id'];
            $user['User']['password'] = Security::hash($this->data['User']['password'], null, true);
            $user['User']['activation_key'] = md5(uniqid());
            if ($this->User->save($user['User'])) {
                $this->Session->setFlash(__('Your password has been reset successfully.', true), 'default', array('class' => 'success'));
                $this->redirect(array('action' => 'login'));
            } else {
                $this->Session->setFlash(__('An error occurred. Please try again.', true), 'default', array('class' => 'error'));
            }
        }

        $this->set(compact('user', 'username', 'key'));
    }

    public function login() {
			//$this->Auth->fields = array('username' => 'email', 'password' => 'password');
			$this->layout = "login";
      $this->set('title_for_layout', __('Log in', true));
    }

    public function logout() {
        $this->Session->setFlash(__('Log out successful.', true), 'default', array('class' => 'success'));
        $this->redirect($this->Auth->logout());
    }

    public function view($username) {
        $user = $this->User->findByUsername($username);
        if (!isset($user['User']['id'])) {
            $this->Session->setFlash(__('Invalid User.', true), 'default', array('class' => 'error'));
            $this->redirect('/');
        }

        $this->set('title_for_layout', $user['User']['name']);
        $this->set(compact('user'));
    }
    
}
?>
