<?php 
	echo $this->Html->css('bootstrap.min.css');
	echo $this->Html->script('bootstrap.min.js');
	echo $this->element("header_logged_in");
	echo $this->Html->script("jquery.js", FALSE);
	echo $this->Html->script("myscript.js", FALSE);
	echo $this->Session->flash('find');
 ?>
<?php echo $this->element("c9"); ?>
<div style = "padding-left: 20px" class="jumbotron">
	<h2> <?php echo $userId ?></h2>
	<h3>Find user</h3>
	<?php 
		$paginator = $this->Paginator;
		echo $this->Form->create('User', array('type' => 'get'));
		echo $this->Form->input('keyword');
		echo $this->Form->end('Search users');
	
		if( !empty($users)  && $users !="empty")
		{
			for($i =0; $i<sizeof($users);$i++)
			{			
				echo '<div style=
					"background:#E0E6F8; 
					padding-left: 20px;
					padding-top: 10px;
				    padding-right: 20px;
				    padding-bottom: 10px" class="jumbotron">' ;
				echo $this->element("c9"); 
				echo $this->HTML->link($users[$i]['User']['user_id'],
					array('controller' => 'tweets','action' =>'profile',
						$users[$i]['User']['user_id']));
				echo " ".$users[$i]['User']['name'];
				if(!empty($tweets[$i]))
				{
					echo "<br/>";
					$linkedText = $this->Text->autoLinkUrls($tweets[$i]);
					echo $linkedText;			
					echo"<br/>";
					echo $tweetsDate[$i];
				}
				echo $this->element("c3"); 
				if($doFollows[$i] == 0)
				{
					echo $this->Form->postLink(
				   	$this->Html->tag('i', ' Follow', 
				   		array('class' => 'glyphicon glyphicon-plus')),
				        array('action' => 'find','keyword' => $keyword,
				        	'follow'=> $users[$i]['User']['user_id']),
				        array('escape'=>false),
				    	__('Are you sure you want to follow %s?',$users[$i]['User']['user_id']),
				  		 array('class' => 'btn btn-mini')
				);		
			}
			echo $this->element("c3e");
			echo "</div>";
		}
  // pagination section
       echo "<div class='paging'>";
       echo $this->Paginator->prev('<< Previous', null, null, array('class' => 'disabled'));
   	   echo $this->Paginator->next(' Next >> ', null, null, array('class' => 'disabled')); 
       echo "</div>";  
    }

 // 
	else
	{
		if ($users == "empty") 
			echo "No users found";
	}
	echo "</div>";  
?>
<?php echo $this->element("c3"); ?>
<?php echo $this->element("c3e"); ?>