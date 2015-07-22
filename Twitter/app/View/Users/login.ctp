<?php
	echo $this->Html->css('bootstrap.min');
	echo $this->element("header_logged_out");
	echo $this->Html->script("jquery.js", FALSE);
	echo $this->Html->script("myscript.js", FALSE);
	echo $this->Html->css('custom');
	echo $this->Session->flash('login');
?>

<div class="row">
  <div class="col-md-4"></div>
	<div class="col-md-4">
		<fieldset>
			<legend><?php echo __('Login'); ?></legend>
			<?php
				//login form
				echo $this->Form->create('User',array('id' => 'login_form'));
				echo $this->Form->input('user_id',array('type' => 'varchar', 'id'=>'login_user_id'));
				echo $this->Html->tag('span', '', array('id' => 'login_user_id_error','style' => 'color:red'));
				echo $this->Form->input('password',array('id' => 'login_password'));
				echo $this->Html->tag('span', '', array('id' => 'login_password_error','style' => 'color:red'));
				echo $this->Form->end('Login');
			?>
		</fieldset>
	</div>
</div>