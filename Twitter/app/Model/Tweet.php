<?php
App::uses('AppModel', 'Model');
/**
 * Tweet Model
 *
 * @property User $User
 */
class Tweet extends AppModel {

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'tweet_id';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'tweet_id';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'tweet_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),


		),
	
		'user_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	function getTweet($id)
	{
		$tweet = array();
		$tweet = $this->find('first', array('conditions' => array('Tweet.user_id' => $id),
			 	 		'order' => array('Tweet.created' => 'desc'),'field' => array('tweet','created','User.name')));
		return $tweet;
	}
	function getTweetCount($id)
	{
		return $this->find("count", array('conditions'=> array('Tweet.user_id' => $id)));
	}

	function getLatestTweet($id)
	{
		return $this->find("first", array('conditions'=> array('Tweet.user_id' => $id),
					'order' => array('Tweet.created' => 'desc') ));
					
	}
}
