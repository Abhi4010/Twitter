<?php
	class FollowsController extends AppController
	{
			//adding paginator as component to paginate
			public $components = array('Paginator');


			public function beforeFilter()
			{
			}


		public function follower()
		{
		/*Fetching list of users along with their latest tweet(if any) who 
		follow the logged in user. following a user if user by the using user 
		id fetched by GET request
		*/	
		//fetching user's Id
		$userId = AuthComponent::user('user_id');
		//Completeing follow user request 
		if(isset($this->params['named']['follow']))
		{
			//Checking if user is actually on twitter
			$temp = $this->Follow->find('first',array('conditions'=>
			 	 		array('follower_id' => $userId, 'followee_id' =>$this->params['named']['follow'] )
			 	 		));
			if(empty($temp))
			{ 	 
				//	Setting data whis will be inserted in Follow model
				$data = array(
					'Follow'=> array(
						'follower_id' => $userId, 
						'followee_id' => $this->params['named']['follow']
						)

						);
				if($this->Follow->save($data))
					{
						// User followed confirmation
						$this->Session->setFlash
						('You are now following '.$this->params['named']['follow'], 'default', array(), 'follower');
					}
				}
		
			}

			/* Setting pagination logic for fetching followers list.
			At most 10 followers is shown in each page.
			*/ 
			$conditions = array();
			if (!empty($this->request->params['named']['page']))
			 {
			   $conditions = (array)$this->Session->read('_indexConditions');
			 } 
			 else 
			 {
			   $this->Session->delete('_indexConditions');
			 }

			 //Query conditions for fetching followers
			  $conditions = array('Follow.followee_id' => $userId);
			 $this->Session->write('_indexConditions', $conditions);

			  $this->Paginator->settings = array(
			         'conditions' => array('Follow.followee_id' => $userId),
			         'limit' => 10
			     );
			    
		
			  if(!empty($conditions))
			 {
			 	//Paginate using query condtions
			 	 $data = $this->Paginator->paginate('Follow');
			 	 $this->loadModel('Tweet');
			 	 $this->loadModel('User');
			 	 $tweetData = array();
			 	 $userName = array();
			 	 $doBothFollows = array();
			 	 foreach($data as $d)
			 	 {
			 	 	$isTweetPrivate = $this->User->findByUserId( $d['Follow']['follower_id']);
			 	 	array_push($userName, $isTweetPrivate['User']['name']);
			 	 	$isTweetPrivate = $isTweetPrivate['User']['tweet_private'];
			 	 	
			 	 	$temp = $this->Tweet->find('first', array('conditions' => array('Tweet.user_id' => $d['Follow']['follower_id']),
			 	 		'order' => array('Tweet.created' => 'desc'),'field' => array('tweet','created','User.name')));
			 	 	//Setting Tweets of followers for view
			 	 	if(!empty($temp) && !$isTweetPrivate )
			 	 		array_push($tweetData, $temp['Tweet']);
			 	 	else
			 	 		array_push($tweetData, null);
			 	 	//Checking if logged in user already follows the fetched follower
			 	 	$temp = $this->Follow->find('first',array('conditions'=>
			 	 		array('follower_id' => $userId, 'followee_id' =>$d['Follow']['follower_id'] )
			 	 		));
			 	 	//Setting flag if it is a bidirectional follow
			 	 	if(empty($temp))
			 	 		array_push($doBothFollows, 0);
			 	 	else
			 	 		array_push($doBothFollows,1);
			 	

			 	 }
			 	 if(empty($data))
			 	 	$data = "empty";
			 }
			  else
			  	$data = "";


			/*setting followlist, tweets of followlist,logged in user Id and User name for 
			  view
			 */
			$this->set('follows',$data);
			$this->set('tweetData',$tweetData);
			$this->set('userName',$userName);
			$this->set('userId',$userId);
			
			//setting follower count, followling count, tweet count for view
			$data = $this->Follow->findAllByFollowerId($userId);
			$this->set('followee_size',sizeof($data));
			$data = $this->Follow->findAllByFolloweeId($userId);
			$this->set('follower_size',sizeof($data));
			$tweetCount = $this->Tweet->find("count", array('conditions'=> array('Tweet.user_id' => $userId)));
			$this->set('tweetCount', $tweetCount);
			
			//Setting flag if it is a bidirectional follow for view
			$this->set('doBothFollows', $doBothFollows);			

		}
		public function following()
		{
			/*Fetching list of users along with their latest tweet(if any) who 
			is followed by the logged in user. unfollowing a user if user requested
			by the using user id fetched by GET request
			*/

			//fetching user's Id
			$userId = AuthComponent::user('user_id');
		
		//Completeing unfollow user request 
			if(isset($this->params['named']['unfollow']))
			{
				//checking if logged in user really follows the requested unfollow user
				$followId = $this->Follow->find('first',array(
					'conditions' => array(
					'followee_id'=> $this->params['named']['unfollow'],'follower_id' =>$userId)));
				if(!isset($follwId) && !empty($followId))
				{
					//performing unfollow request and database update
					$followId = $followId['Follow']['follow_id'];
					if($this->Follow->delete($followId))
						$this->Session->setFlash('You have unfollowed '.$this->params['named']['unfollow'], 'default', array(), 'following');
				}

			}
			/* Setting pagination logic for fetching following list.
			At most 10 followings is shown in each page.
			*/
			$conditions = array();
			if (!empty($this->request->params['named']['page']))
			 {
			   $conditions = (array)$this->Session->read('_indexConditions');
			 } 
			 else 
			 {
			   $this->Session->delete('_indexConditions');
			 }
			 //Setting query conditions for pagination
			  $conditions = array('Follow.follower_id' => $userId);
			 $this->Session->write('_indexConditions', $conditions);

			  $this->Paginator->settings = array(
			         'conditions' => array('Follow.follower_id' => $userId),
			         'limit' => 10
			     );
			    
	
			  if(!empty($conditions))
			 {
			 	//Paginating to get following list
			 	 $data = $this->Paginator->paginate('Follow');
			 	 $this->loadModel('Tweet');
			 	 $this->loadModel('User');
			 	 $tweetData = array();
			 	 $userName = array();
			 	 foreach($data as $d)
			 	 {
			 	 	$isTweetPrivate = $this->User->findByUserId( $d['Follow']['followee_id']);
			 	 	array_push($userName, $isTweetPrivate['User']['name']);
			 	 	$isTweetPrivate = $isTweetPrivate['User']['tweet_private'];
			 	 	
			 	 	/*
			 	 	checking if following's tweet is private. In that case tweet 
			 	 	is not shown of that user.
			 	 	*/
			 	 	
			 	 	$temp = $this->Tweet->find('first', array('conditions' => array('Tweet.user_id' => $d['Follow']['followee_id']),
			 	 		'order' => array('Tweet.created' => 'desc'),'field' => array('tweet','created','User.name')));
			 	 	if(!empty($temp) && !$isTweetPrivate )
			 	 		array_push($tweetData, $temp['Tweet']);
			 	 	else
			 	 		array_push($tweetData, null);

			 	 }
			 	 if(empty($data))
			 	 	$data = "empty";
			 }
			  else
			  	$data = "";

			  /*setting followinglist, tweets of followinglist,logged in user Id and User name for 
			    following view
			   */
			$this->set('follows',$data);
			$this->set('tweetData',$tweetData);
			$this->set('userName',$userName);
			$this->set('userId',$userId);
			//setting count of followers, follows and tweets for following view
			
			$data = $this->Follow->findAllByFollowerId($userId);
			$this->set('followee_size',sizeof($data));
			$data = $this->Follow->findAllByFolloweeId($userId);
			$this->set('follower_size',sizeof($data));
			$tweetCount = $this->Tweet->find("count", array('conditions'=> array('Tweet.user_id' => $userId)));
			$this->set('tweetCount', $tweetCount);


		

		}

		
	}

?>