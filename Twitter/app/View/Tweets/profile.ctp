<?php
	echo $this->Html->css('bootstrap.min');
	if ($this->Session->read('Auth.User'))
	 	echo $this->element("header_logged_in");
	else
	echo $this->element("header_logged_out");
	 
	echo $this->Html->script("jquery.js", FALSE);
	echo $this->Html->script("myscript.js", FALSE);
	echo $this->Html->css('custom');
?>
<?php
	 echo $this->element("c9"); 
?> 
<div tyle = "padding-left: 20px" class="jumbotron">
<?php if(!$tweetShow)  	echo  "<legend>Tweets are private or invalid link</legend>" ;?>


	<legend>
		<?php
			 if($tweetShow) 
			{
				 echo "Tweets of ".$name 
		?>
	</legend>
	<?php
	if( !empty($tweets)  && $tweets !="empty")
	{
		foreach($tweets as $tweet)
		{
			echo '<div style="background:#E0E6F8;padding-left: 20px" class="jumbotron">' ;

			$linkedText = $this->Text->autoLinkUrls($tweet['Tweet']['tweet']);
			echo $linkedText;
			 $dt = new DateTime($tweet['Tweet']['created']);
			 echo "<br/>";
			 $date = $dt->format('m/d/Y');
			 echo $date;
			 echo "<br/>";
			 echo "</div>";
			
		}

			echo "<div class='paging'>";
			echo $this->Paginator->prev('<< Previous', null, null, array('class' => 'disabled'));
			echo $this->Paginator->next(' Next >> ', null, null, array('class' => 'disabled')); 
		   
		echo "</div>";
		   

	}
	 echo "</div>";
	}
	
	
?>
</div>
<?php echo $this->element("c3"); ?>
<?php echo $this->element("c3e"); ?>