<?php 
	echo $this->Html->css('bootstrap.min');
	echo $this->element("header_logged_in");
	echo $this->Html->script("jquery.js", FALSE);
	echo $this->Html->script("myscript.js", FALSE);
	echo $this->Html->css('custom');
	echo $this->Session->flash('index');
	echo $this->element("c9"); 
	echo $this->element("c9"); 
?> 

<div style = "padding-left: 20px"class="jumbotron">
<?php
	echo $this->Form->create('Tweet',array('id'=>'tweet_form'));
	echo $this->Form->input('tweet',array('id' =>'tweet', 'maxlength'=>"500"));
	echo $this->Html->tag('span', '', array('id' => 'tweet_error','style' => 'color:red'));
	echo $this->Form->end('Share tweet');
	if(!empty($userLatestTweet))
	{
		echo "<br/>";
		echo "<legend>Recent tweet</legend>";
  		$linkedText = $this->Text->autoLinkUrls($userLatestTweet['Tweet']['tweet']);
		echo $linkedText;
		$dt = new DateTime($userLatestTweet['Tweet']['created']);
		echo "<br/>";
		$date = $dt->format('m/d/Y');
		echo $date;
	}
?>
</div>
<?php
//showing tweets
if( !empty($tweetdatas)  && $tweetdatas !="empty")
{
	echo '<div class="jumbotron">';	
	echo "<legend>Tweets feed</legend>";
  	foreach($tweetdatas as $tweet)
	{
		echo '<div 
		style=
		"background:#E0E6F8; 
		padding-left: 20px;
		padding-top: 10px;
	    padding-right: 20px;
	    padding-bottom: 10px;" 
	    class="jumbotron">' ;
		echo $this->element("c9"); 
		echo $this->HTML->link($tweet['Tweet']['user_id'],
		array('controller' => 'tweets','action' =>'profile',
			$tweet['Tweet']['user_id']));
		echo "<br/>";
		$linkedText = $this->Text->autoLinkUrls($tweet['Tweet']['tweet']);
			echo $linkedText;
		$dt = new DateTime($tweet['Tweet']['created']);
		echo "<br/>";
		$date = $dt->format('m/d/Y');
		echo $date;
		echo "<br/>";
		echo $this->element("c3"); 
		if($tweet['Tweet']['user_id'] == $userId)
		{
			echo $this->Form->postLink(
			   $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-remove-sign')),
			        array('action' => 'index', $tweet['Tweet']['tweet_id']),
			        array('escape'=>false),
			    __('Are you sure you want to delete this tweet'),
			   array('class' => 'btn btn-mini')
			);		

		 }
		 echo $this->element("c3e"); 
		 echo '</div>';
		
	}
	echo "<div class='paging'>";
	echo $this->Paginator->prev('<< Previous', null, null, array('class' => 'disabled'));
			echo $this->Paginator->next(' Next >> ', null, null, array('class' => 'disabled'));      
	echo "</div>";
	echo '</div>';


}



?>

<?php echo $this->element("c3"); ?>
<?php echo $this->element("c3e"); ?>
<?php echo $this->element("c3"); ?>
<div class="jumbotron">
	<div class="row">
  	<div class="col-md-2"></div>
  	<div class="col-md-7">
<?php
 	echo "<legend>";
	echo $this->HTML->link($user_id,
		array('controller' => 'tweets','action' =>'profile',
			$user_id));
	echo "<br/>";
	echo "</legend>";
	echo $this->HTML->link("Followers:  ",
		array('controller' => 'follows','action' =>'follower',
			$user_id));
	echo $follower_size;
	echo "<br/>";
	echo "<br/>";
		echo $this->HTML->link("Followings: ",
		array('controller' => 'follows','action' =>'following',
			$user_id));
	echo $followee_size;
	echo "<br/>";
	echo "<br/>";
	
	echo $this->HTML->link("Tweets: ",
		array('controller' => 'tweets','action' =>'profile',
			$user_id));
	echo $tweetCount;	

?>
</div>
  <div class="col-md-3"></div>
</div>
</div>
<?php echo $this->element("c3e"); ?>