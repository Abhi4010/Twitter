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
			if(isset( $this->request->params['pass']['0']))
			{
				$tweet_id = $this->request->params['pass']['0'];
				if($tweetPoster = $this->Tweet->findByTweetId($tweet_id))
				{
					if(isset($tweetPoster['Tweet']['user_id']))
					{
						if($tweetPoster['Tweet']['user_id'] == $userId)
						{
							$this->Tweet->delete($tweet_id);
							$this->Session->setFlash('Tweet is  deleted', 'default', array(), 'index');
							return $this->redirect(
					            array('controller' => 'tweets', 'action' => 'index')
					        );
						}

					}

				}
			}
						
			//Saving newly posted tweet
			if($this->request->is('post'))
			{
				$this->Tweet->create();
				if($this->Tweet->save($this->request->data))
				{
					if($this->RequestHandler->isAjax())
					{
									// Fetching total number of followers and followings of user
									$this->set('user_id',$userId);
									$this->loadModel('Follow');
									$data = $this->Follow->findAllByFollowerId($userId);
									$this->set('followee_size',sizeof($data));
									$data = $this->Follow->findAllByFolloweeId($userId);
									$this->set('follower_size',sizeof($data));


								    /* Pushing all the follwings of user who have declared their tweets not private
									 and logged in user in $followlist to get all the users whose tweets can be // shown 
									 */ 
									 $allFollowee = $this->Follow->findAllByFollowerId($userId);
									 $followlist = array();
									 foreach( $allFollowee as $followee)
									 {
									 	array_push($followlist,$followee['Follow']['followee_id'] );
									 }
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
									    	
									    	//Fetching user's tweet count
											$tweetCount = $this->Tweet->find("count", array('conditions'=> array('Tweet.user_id' => $userId)));
											//Fetching user's latest tweet
											$userLatestTweet  = $this->Tweet->find("first", array('conditions'=> array('Tweet.user_id' => $userId),
											'order' => array('Tweet.created' => 'desc') ));
											
											//Setting datas for index view
											$this->set('tweetdatas',$data);
									      	$this->set('name',$name);
											$this->set('userId',$userId);
											$this->set('tweetCount', $tweetCount);
											$this->set('userLatestTweet',$userLatestTweet);

								$this->render('tweet','ajax');

					}
				
				}
			

			}


			// Fetching total number of followers and followings of user
			$this->set('user_id',$userId);
			$this->loadModel('Follow');
			$data = $this->Follow->findAllByFollowerId($userId);
			$this->set('followee_size',sizeof($data));
			$data = $this->Follow->findAllByFolloweeId($userId);
			$this->set('follower_size',sizeof($data));


		    /* Pushing all the follwings of user who have declared their tweets not private
			 and logged in user in $followlist to get all the users whose tweets can be // shown 
			 */ 
			 $allFollowee = $this->Follow->findAllByFollowerId($userId);
			 $followlist = array();
			 foreach( $allFollowee as $followee)
			 {
			 	array_push($followlist,$followee['Follow']['followee_id'] );
			 }
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
			    	
			    	//Fetching user's tweet count
					$tweetCount = $this->Tweet->find("count", array('conditions'=> array('Tweet.user_id' => $userId)));
					//Fetching user's latest tweet
					$userLatestTweet  = $this->Tweet->find("first", array('conditions'=> array('Tweet.user_id' => $userId),
					'order' => array('Tweet.created' => 'desc') ));
					
					//Setting datas for index view
					$this->set('tweetdatas',$data);
			      	$this->set('name',$name);
					$this->set('userId',$userId);
					$this->set('tweetCount', $tweetCount);
					$this->set('userLatestTweet',$userLatestTweet);
		}

		public function profile()
		
		{
			/*User's profile shows his all tweets using pagination. Each page shows
			at most10 tweets. If tweets are private then not shown unless the profile belongs to logged in user. profile's user id is fetched by GET request.
			*/
			// Fetching logged in user's id
			$userId = AuthComponent::user('user_id');
			$this->request->data['Tweet']['user_id'] = $userId;

			$tweetShow = 0;

			//Fetching user id of the profile to show
			if(!empty($this->request->params['pass']['0']))
			{
				$user_id = $this->request->params['pass']['0'];

				//settinng tweets visible if profile belongs to logged in user
				if( $userId == $user_id)
				$tweetShow = 1;
				
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
					 $tweetShow = 1 - $query['User']['tweet_private'];
					 else
					 	$tweetShow = 0;

				}
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
	
	}

?>