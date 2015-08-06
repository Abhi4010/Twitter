<?php 
	echo $this->Html->css('bootstrap.min');
	echo $this->element("header_logged_out");
	echo $this->Html->script("jquery.js", FALSE);
	echo $this->Html->script("myscript.js", FALSE);
 ?>
<?php echo $this->element("c9"); ?>
<div class="jumbotron">
<h3>Joined in Twitter</h3>
<br/>
<br/>
<h4> <?php echo $user ?> has joined twitter </h4>
<br/>
<h4> Please click on the log in button, log into twitter and tweet.
</h4>
<button type="button" class="btn btn-default">
<?php
	echo $this->Html->link("Log in",
		array('controller' => 'users','action' =>'login'));
?>
</button></div>