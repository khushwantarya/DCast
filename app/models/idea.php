<?php
/**
 * Role
 *
 * PHP version 5
 *
 * @category Model
 * @package  Croogo
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class Idea extends AppModel {
/**
 * Model name
 *
 * @var string
 * @access public
 */

    public $name = 'Idea';
		public $recursive = 2;	
		public $order = "Idea.created DESC";
		public $belongsTo = array(
			'User' => array(
					'className' => 'User',
					'foreignKey' => 'user_id',
					'counterCache' => true
			),
			'Question' => array(
					'className' => 'Question',
					'foreignKey' => 'question_id'
			)
		);
		
		/*public $hasOne = array(
			'UsersFavoriteIdea' => array(
				'className' => 'UsersFavoriteIdea',
				'foreignKey' => 'idea_id',
				'conditions' => array("UsersFavoriteIdea.user_id" => $this->Session->read('Auth.User.id'))
			)
		
		);*/
	



}
?>