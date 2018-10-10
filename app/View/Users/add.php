<!-- app/View/Users/add.ctp -->
<div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3">
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Register'); ?></legend>
	    <?php 
	        echo $this->Form->input('name');
	        echo $this->Form->input('email', array('type' => 'email','class' => 'check_email'));
	    ?>
	    <p class="email_info"></p>
	    <?php
	        echo $this->Form->input('password');
	       /* echo $this->Form->input('role', array(
	            'options' => array('admin' => 'Admin', 'author' => 'Author')
	        ));*/
	    ?>
    </fieldset>
    <div class="form-group">
    	<button class="btn btn-success btn-lg btn-reg" type="submit">Register</button>
    </div>
</div>