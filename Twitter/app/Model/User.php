<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property Tweet $Tweet
 */
class User extends AppModel {

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'user_id';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'user_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'User id can not be empty',
				'allowEmpty' => false,
			),
			'alphaNumeric' => array
			(
                'rule' => '/^[+a-zA-Z0-9_-]{4,20}$/i',
                'required' => true,
                'message' => 'user id must has letters or numbers or - only from 4 to 20 characters'
			),

		),
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Name can not be empty',
				'allowEmpty' => false,
			),
			'alphaNumeric' => array
			(
                'rule' => '/^[+a-zA-Z0-9_-]{4,20}$/i',
                'required' => true,
                'message' => 'name must has letters or numbers or - only from 4 to 20 characters'
			),


		),
		'password' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Password can not be empty',
				'allowEmpty' => false,
				'required' => true,
			),
			'alphaNumeric' => array
			(
                'rule' => '/^[+a-zA-Z0-9]{4,8}$/i',
                'required' => true,
                'message' => 'password must has letters or numbers or - only from 4 to 8 characters'
			),

		),
		'mail' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Mail must be provided',
				'allowEmpty' => false,
				'required' => true,
			),
			'alphaNumeric' => array
			(
                'rule' => '/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i',
                'required' => true,
                'message' => 'A valid mail id has to provide'
			),
		),
	);



	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Tweet' => array(
			'className' => 'Tweet',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);


	function isTweetPrivate($user_id)
	{
		$data = array();
		 $data = $this->findByUserId($user_id);
		 return $data;
	}

	function doesExists($user_id)
	{
		return $this->find('first',array('conditions' =>
			 array('user_id' => $user_id )));
	}

}
