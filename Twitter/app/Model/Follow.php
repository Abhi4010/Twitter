<?php
App::uses('AppModel', 'Model');
/**
 * Follow Model
 *
 */
class Follow extends AppModel {

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'follow_id';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'follow_id';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'follower_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'followee_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'follow_id' => array(
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
	
	function isFollowing($follower_id, $followee_id)
	{
		$follows = array();
		$follows = $this->find('first',array('conditions'=>
			 	 		array('follower_id' => $follower_id, 'followee_id' =>$followee_id)));
		return $follows;
	}

	function getFollowerCount($id)
	{
		$data = array();
		$data =   $this->findAllByFolloweeId($id);
		return(sizeof($data));
	}
	function getFollowingCount($id)
	{
		$data = array();
		$data =   $this->findAllByFollowerId($id);
		return(sizeof($data));
	}
}
