<div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3">
<?php echo $this->Flash->render('auth'); ?>
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend>
            <?php echo __('Please enter your email and password'); ?>
        </legend>
        <?php echo $this->Form->input('email', array('type' => 'email',));
        echo $this->Form->input('password');
    ?>
    </fieldset>
<div class="form-group">
    	<button class="btn btn-primary btn-lg btn-reg" type="submit">Login</button>
    </div>
</div>