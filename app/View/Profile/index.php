<h2>Profile</h2>
<?php
echo $this->Form->create('User');
echo $this->Form->input('name');
echo $this->Form->input('birthdate',  array('class' => 'date-to'));
echo $this->Form->input('birth',  array('class' => 'date-to'));
?>
<div class="col-xs-12 col-sm-12 col-md-6">
	<div class="form-group">
		<input type="radio" name="data[Profile][gender]" value="Male"> Male
	</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-6">
	<div class="form-group">
		<input type="radio" name="data[Profile][gender]" value="Female"> Female
	</div>
</div>
<?php
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end('Update Profile');
?>