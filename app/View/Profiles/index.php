<h2>Profile</h2>
<?php
echo $this->Form->create('Profile');
echo $this->Form->input('gender');
echo $this->Form->input('birthday', array('rows' => '3'));
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end('Update Profile');
?>