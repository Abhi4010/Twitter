<?php
	class TweetsController extends AppController
	{
			public $components = array('Paginator','RequestHandler');

			public function beforeFilter()
			{
				//allowing page accessible without logging in
				$this->Auth->allow('profile');
			}


		public function index()
		{
			/* Posting logged in user's tweet, showing tweets of user and his followings 
			 * according to tweet posting time ascending. Pagination is applied. 10 tweets is displayed each page.
			*/
			//Fetching logged in user's id
			$userId = AuthComponent::user('user_id');
			$this->request->data['Tweet']['user_id'] = $userId;

			//Deleting requested tweet
			var_dump($this->request->params);
			if(isset( $this->request->params['pass']['0']))
				$this->deleteTweet( $this->request->params['pass']['0'], $userId);
						
			//Saving newly posted tweet
			if($this->request->is('post'))
			{
				$this->Tweet->create();
				if($this->Tweet->save($this->request->data))
				{
					if($this->RequestHandler->isAjax())
					{
						//setting tweetdata for updated view
						$this->setTweetData($userId);
						$this->render('tweet','ajax');

					}
				
				}
			

			}
			//Setting tweet data for view
			$this->setTweetData($userId);

		}

		public function profile()
		
		{
			/*User's profile shows his all tweets using pagination. Each page shows
			at most10 tweets. If tweets are private then not shown unless the profile belongs to logged in user. profile's user id is fetched by GET request.
			*/
			// Fetching logged in user's id
			$userId = AuthComponent::user('user_id');
			$this->request->data['Tweet']['user_id'] = $userId;

			//initially set to false
			$tweetShow = 0;

			//Fetching user id of the profile to show
			if(!empty($this->request->params['pass']['0']))
			{
				$user_id = $this->request->params['pass']['0'];

				//checking if tweet is shown
				$tweetShow = $this->isTweetShown($user_id,$userId);
				$conditions = array();
				if($tweetShow)
				{


					/*If tween shown, then fetching tweets using pagination.
					Showing at most 10 tweets in one page. Pagination session data
					is set.
					*/
					if (!empty($this->request->params['named']['page']))
					   $conditions = (array)$this->Session->read('_indexConditions');
					else 
					   $this->Session->delete('_indexConditions');
					if(!empty($this->request->params['pass']['0']))
					{
						$data= $this->request->params['pass']['0'];
						$name = $data;
						$conditions = array('Tweet.user_id' => $data);
						$this->Session->write('_indexConditions', $conditions);

						   
					}

					//pagination logic for query
					 $this->Paginator->settings = array(
					        'conditions' => $conditions,
					        'order' => array('Tweet.created' => 'desc'),
					        'limit' => 10
					    );
					   
					   	$this->Session->write('_indexConditions', $conditions);

					 if(!empty($conditions))
					 {
						//paginating according to the conditions set before
						 $data = $this->Paginator->paginate('Tweet');
						 if(empty($data))
						 	$data = "empty";
					 }
					 else
					 	$data = "";
				 	//Setting view data for profile
				     $this->set('tweets',$data);
				     $this->set('name',$name);
				}
			}

			$this->set('tweetShow',$tweetShow);
					     
		}

		//Deleting tweet
		function deleteTweet($tweet_id,$userId)
		{
			if($tweetPoster = $this->Tweet->findByTweetId($tweet_id))
				{
					if(isset($tweetPoster['Tweet']['user_id']))
					{
						if($tweetPoster['Tweet']['user_id'] == $userId)
						{
							$this->Tweet->delete($tweet_id);
							$this->Session->setFlash('Tweet is  deleted', 'default', array(), 'index');
						//	return $this->redirect(
					     //       array('controller' => 'tweets', 'action' => 'index')
					     //   );
						}

					}

				}
		}


		function setTweetData($userId)
		{
			// Fetching total number of followers and followings of user
			$this->set('user_id',$userId);
			$this->loadModel('Follow');
			$this->set('followee_size',$this->Follow->getFollowingCount($userId));
			$this->set('follower_size',$this->Follow->getFollowerCount($userId));

		    /* Pushing all the follwings of user who have declared their tweets not private
			 and logged in user in $followlist to get all the users whose tweets can be // shown 
			 */ 
			 $allFollowee = $this->Follow->findAllByFollowerId($userId);
			 $followlist = array();
			 foreach( $allFollowee as $followee)
			 	array_push($followlist,$followee['Follow']['followee_id'] );
			 array_push($followlist,$userId);

			 $this->loadModel('User');
			 $conditions_first = array( 'User.tweet_private' => '0'
			 	,array('User.user_id' => $followlist)
        					);
			 
			 $followlist = $this->User->find("all",array('conditions' => $conditions_first,
		 	'fields' => 'User.user_id'));

			 $tempfollowlist = array();
			 foreach( $followlist as $fList)
			 {
			 	array_push($tempfollowlist,$fList['User']['user_id'] );
			 }
			 $followlist = $tempfollowlist;
			 if(!in_array($userId, $followlist))
			 	array_push($followlist, $userId);

		
			//Settng session condtions for pagination 
			$conditions = array();
			if (!empty($this->request->params['named']['page']))
			   $conditions = (array)$this->Session->read('_indexConditions');
			 else 
			   $this->Session->delete('_indexConditions');

			 $data= $userId;
			 $name = $data;
			 $conditions = array(

       							  "IN" =>array('Tweet.user_id' => $followlist)
       							);
			 $this->Session->write('_indexConditions', $conditions);


 
			 //Pagination query conditions
			 $this->Paginator->settings = array(
			         'conditions' => array('Tweet.user_id' => $followlist),
			         'order' => array('Tweet.created' => 'desc'),
			         'limit' => 10
			     );
			    
	
			  if(!empty($conditions))
			 {
			 	 $data = $this->Paginator->paginate('Tweet');
			 	 if(empty($data))
			 	 	$data = "empty";
			 }
			  else
			  	$data = "";
			    	
	    	//Setting datas for index view
			$this->set('tweetdatas',$data);
	      	$this->set('name',$name);
			$this->set('userId',$userId);
			$this->set('tweetCount', $this->Tweet->getTweetCount($userId));
			$this->set('userLatestTweet',$this->Tweet->getLatestTweet($userId));

		}


		/*checking if tweet is shown $user_id is the desired id to show and
		*$userId is the logged in id
		*/
		function isTweetShown($user_id, $userId)
		{
			//settinng tweets visible if profile belongs to logged in user
				if( $userId == $user_id)
					return 1;
				
				else
				{
					//Checking if profile user's tweet is private
					$this->loadModel('User');
					$conditions_first = array('User.user_id' => $user_id
        					);
			 
					 $query = $this->User->find("first",array('conditions' => 
					 		  $conditions_first,
		 				'fields' => 'User.tweet_private'));

					 if(!empty($query))
					 return ( 1 - $query['User']['tweet_private']);
					 else
					 	 return  0;

				}
		}
	
	}

?>