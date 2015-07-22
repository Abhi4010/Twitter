<?php
 echo $this->Html->script("jquery", FALSE);
 echo $this->Html->script("myscript", FALSE);
 echo $this->element("header_logged_out");
 echo $this->Session->flash('register');
?>

<div class="row">
  <div class="col-md-3"></div>
   <div class="col-md-5">
   	<?php echo $this->Form->create('User',array('id' =>'reg_form')); ?>
	<fieldset>
		<legend><?php echo __('Add a account'); ?></legend>
		<?php
			echo $this->Form->input('name',array('id' =>'name'));
			echo $this->Html->tag('span', '', array('id' => 'name_error','style' => 'color:red'));
			echo $this->Form->input('user_id',array('id' => 'user_id', 'type' => 'varchar'));
			echo $this->Html->tag('span', '', array('id' => 'user_id_error','style' => 'color:red'));

			echo $this->Form->input('mail', array('id' =>'mail'));
			echo $this->Html->tag('span', '', array('id' => 'mail_error','style' => 'color:red'));
			echo $this->Form->input('password',array('id' => 'password'));
			echo $this->Html->tag('span', '', array('id' => 'password_error','style' => 'color:red'));
			echo $this->Form->input('retype password',array('id' => 'retype_password','type' => 'password'));
			echo $this->Html->tag('span', '', array('id' => 'retype_password_error','style' => 'color:red'));
			echo $this->Form->input('tweet_private', array('id' => 'tweet_private'));
			echo $this->Form->submit('Register');
		?>
	</fieldset>
	<?php echo $this->Form->end(); ?>
	</div>
   <div class="col-md-4">
  </div>
</div>