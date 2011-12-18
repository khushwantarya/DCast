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
class Event extends AppModel {
/**
 * Model name
 *
 * @var string
 * @access public
 */
    public $name = 'Event';
    public $validate = array(
        'name' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'This field cannot be left blank.',
            )
        ),
        'contact_email' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'This field cannot be left blank.',
            ),
            'email' => array(
                'rule' => 'email',
                'message' => 'Please provide a valid email address.',
            )
        ),
        'organization_name' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'This field cannot be left blank.',
            )
        ),
        'contact_name' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'This field cannot be left blank.',
            )
        ),
        'mobile' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'This field cannot be left blank.',
            )
        ),
        'phone' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'This field cannot be left blank.',
            )
        ),
        'event_video' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'This field cannot be left blank.',
            )
        ),
        'video_text' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'This field cannot be left blank.',
            )
        ),
        'dc_quick_tips' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'This field cannot be left blank.',
            )
        ),
        'summary' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'This field cannot be left blank.',
            )
        )
    );
	
	
               
    var $hasMany = array(
        'Question' => array(
            'className'     => 'Question',
            'foreignKey'    => 'event_id',
            'conditions'    => array('Question.status' => '1', 'Question.title != ' => '', 'Question.keyword != ' => '')/*,
            'order'    => 'Comment.created DESC',
            'limit'        => '5',
            'dependent'=> true*/
        )
    );  

	

}
?>