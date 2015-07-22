<?php 
	echo $this->Html->css('bootstrap.min.css');
	echo $this->Html->script('bootstrap.min.js');
	echo $this->element("header_logged_in"); 
	echo $this->Html->script("jquery.js", FALSE);
	echo $this->Html->script("myscript.js", FALSE);
	echo $this->Session->flash('follower');

?>
<?php
	echo $this->element("c9"); 
?>
 <div style = "padding-left: 20px" class="jumbotron">
	 <h2> <?php echo $userId ?> is followed by <?php echo $follower_size ?> people</h2>
	 <legend><?php echo __('Followers'); ?></legend>
	<?php 
		if($follows != 'empty')
		{	
			for( $i = 0; $i< sizeof($follows); $i++)
			{
				echo '<div style=
				"background:#E0E6F8; 
				padding-left: 20px;
				padding-top: 10px;
				padding-right: 20px;
				padding-bottom: 10px" 
				class="jumbotron">' ;
				echo $this->element("c9"); 
		
				echo $this->HTML->link($follows[$i]['Follow']['follower_id'],
				array('controller' => 'tweets','action' =>'profile',
					$follows[$i]['Follow']['follower_id']));
				echo "<br/> ".$userName[$i];
				if($tweetData[$i] != null)
				{
					echo "<br/>";
					$linkedText = $this->Text->autoLinkUrls($tweetData[$i]['tweet']);
					echo $linkedText;
					echo "<br/>";
					echo $tweetData[$i]['created'];
				}
				echo $this->element("c3");
				if($doBothFollows[$i] == 0)
				{
					 echo $this->Form->postLink(
					$this->Html->tag('i', ' Follow', array('class' => 'glyphicon glyphicon-plus')),
					    array('action' => 'follower',$userId,'follow'=> $follows[$i]['Follow']['follower_id']),
					    array('escape'=>false),
					__('Are you sure you want to follow %s?',$follows[$i]['Follow']['follower_id']),
					array('class' => 'btn btn-mini')
					);		
				}
				echo $this->element("c3e"); 
				echo '</div>';
		}
		//pagination navigator
		echo "<div class='paging'>";
		echo $this->Paginator->prev('<< Previous', null, null, array('class' => 'disabled'));
		echo $this->Paginator->next(' Next >> ', null, null, array('class' => 'disabled')); 
		echo "</div>";
	}
	else
	echo "No followers";
?>
</div>
<?php
	echo $this->element("c3");
?>
<div class="jumbotron">
<div class="row">
<div class="col-md-2"></div>

<div class="col-md-7">

<?php
 	echo "<legend>";
	echo $this->HTML->link($userId,
		array('controller' => 'tweets','action' =>'profile',
			$userId));
	echo "<br/>";
	echo "</legend>";
	
	echo $this->HTML->link("Followers:  ",
		array('controller' => 'follows','action' =>'follower',
			$userId));
	echo $follower_size;
	echo "<br/>";
	echo "<br/>";
	
		echo $this->HTML->link("Followings: ",
		array('controller' => 'follows','action' =>'following',
			$userId));
	echo $followee_size;
	echo "<br/>";
	echo "<br/>";
	
	echo $this->HTML->link("Tweets: ",
		array('controller' => 'tweets','action' =>'profile',
			$userId));
	echo $tweetCount;	

?>
</div>
  <div class="col-md-3"></div>
</div>
</div>
<?php echo $this->element("c3e"); ?>