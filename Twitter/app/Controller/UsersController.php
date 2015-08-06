<?php
App::uses('AppController', 'Controller');
App::import('Controller', 'Tweets');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
	
	public function beforeFilter()
	{
		$this->Auth->allow('register');
		$this->Auth->allow('registersucess');
	}
	public function register() {
		/*Register new user, data validation is checked both front and end
		*/
		if ($this->request->is('post'))
		{	
			$this->User->create();
			//checking if desired user Id is unique
			$isUser = $this->User->doesExists($this->request->data['User']['user_id']);
			if(!empty($isUser))
			{
				$this->Session->setFlash('User Id has to be unique','default', array(), 'register');
				$this->redirect(array("controller" => "users", 
                  "action" => "register"));

			}
			else
			{
				//encripting password
				$this->request->data['User']['password'] = 
				AuthComponent::password($this->request->data['User']['password']);
				
				if ($this->User->save($this->request->data)) {
					//If new user is created redirecting to success page	
					$this->redirect(array("controller" => "users", 
		                  "action" => "registersucess",
		                  "id" => $this->request->data['User']['user_id'],
		                 ));
				} 
				else
					$this->Session->setFlash('The user could not be saved. Please, try again','default', array(), 'register');
				
			}
		}
	}

	public function registersucess()
	{
		/*Controller for showing registration succes
		*/
		$userId = $this->request->params['named']['id'];
 		$this->set('user',$userId);
	}

	public function login()
	{
		/*authenticate log in and redirect to home page
		*/
		if($this->request->is('post'))
		{	
			if($this->Auth->login())
			{
				return $this->redirect(
				            array('controller' => 'Tweets', 'action' => 'index')
				        );
			}
			else
			{
				$this->Session->SetFlash("Invalid Username or Password!",'default', array(), 'login');
				return $this->redirect(
				            array('controller' => 'Users', 'action' => 'login')
				        );

			}
		}

	}

	public function logout()
	{
		$this->Auth->logout();
		$this->Session->destroy();
		$this->redirect(users/login);
	}

	public function find()
	{
		/*Search users using the keyword got by Get request. keyword is checked both
		 *with user Id and user name. add user as following if gets following request.
		 *Found users are shown by pagination. At most 10 users in one page
		*/
		$userId = AuthComponent::user('user_id');
		$keyword = "";
		$tweets = array();
		$tweetsDate = array();
		$doFollows= array();
				
		$conditions = array();

		if (!empty($this->request->params['named']['follow']))
		{
			//Adding user as following
			$this->loadModel('Follow');
			//checking if already following
			$tempResult = $this->Follow->isFollowing($userId, $this->request->params['named']['follow'] );
			if(empty($tempResult))
			{
				//setting data to be inserted in follow model
				$data = array(
								'Follow'=> array(
									'follower_id' => $userId, 'followee_id' => $this->params['named']['follow']
									)

								);
				if($this->Follow->save($data))
				{
					$this->Session->setFlash('You are now following '. $this->request->params['named']['follow'],'default', array(), 'find');
	

				}
			}

		}
		//Setting session data for pagination
		if (!empty($this->request->params['named']['page']))
		   $conditions = (array)$this->Session->read('_indexConditions'); 
		 else 
		   $this->Session->delete('_indexConditions');

		//checking if keyowrd not empty to search
		if(!empty($this->request->query['keyword']))
		{
			$data = $this->request->query['keyword'];
			$keyword =  $this->request->query['keyword'];
			//setting conditions for user search query
			$conditions = array('OR' => array(
			        	            			array('User.user_id LIKE' => '%'.$data.'%'),
			        	            			array('User.name LIKE' => '%'.$data.'%' ),
			        	       				 )
			      			   );
			$this->Session->write('_indexConditions', $conditions);  
			}

			 $this->Paginator->settings = array(
			        'conditions' => $conditions,
			        'limit' => 10
			    );
			   
			   	$this->Session->write('_indexConditions', $conditions);

			 if(!empty($conditions))
			{
				//doing pagination query
				 $data = $this->Paginator->paginate('User');
				 $tweets = array();
				 $tweetsDate = array();
				 $doFollows= array();
				 if(empty($data))
				 	$data = "empty";
				 else
				 {
				 	foreach($data as $d)
				 	{
				 		$isTweetPrivate =$d['User']['tweet_private'];
				 		//checking whether user follows the found user
				 		$this->loadModel('Follow');
				 		$temp = $this->Follow->isFollowing($userId,$d['User']['user_id']);
				 		if(!empty($temp) || $d['User']['user_id'] == $userId)
				 			array_push($doFollows, 1);
				 		else
				 			array_push($doFollows, 0);

						 if($isTweetPrivate == 0)
						 {
						 //load latest tweet of found user
						 	$this->loadModel('Tweet');
						 	$tempTweet =$this->Tweet->getLatestTweet($d['User']['user_id']);
						 				 	if(!empty($tempTweet))
						 	{
						 		array_push($tweets,$tempTweet['Tweet']['tweet']);
						 		array_push($tweetsDate,$tempTweet['Tweet']['created']);
						 	}
						 	else
						 	{
						 		array_push($tweets,"");
						 		array_push($tweetsDate,"");
						 		
						 	}

						 }
						 else
						 {
						 	array_push($tweets,"");
						 	array_push($tweetsDate,"");
						 }

				 	}
				 }
				 			 	 	

			}
			 else
			 	$data = "";
			 /*setting user data, tweets data, tweets date, ifFollowing data 
			 and userid for find view
			 */
		     $this->set('users',$data);
		     $this->set('tweets',$tweets);
		     $this->set('tweetsDate',$tweetsDate);
		     $this->set('doFollows',$doFollows);
		     $this->set('userId',$userId);
		     
		     if(!empty($this->request->query['keyword']))
		    	 $this->set('keyword', $this->request->query['keyword']);
		 		else
		 		  $this->set('keyword', '');		
		}
		
	}