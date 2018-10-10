<h2>Profile</h2>

<?php
//echo $this->Form->create('User');
	echo $this->Form->create('User', array('type' => 'file'));
	if($post['User']['image']){
		$pro_pic = "/cakephp/img/uploads/".$post['User']['image'];
	}else{
		$pro_pic = "/cakephp/img/uploads/user.png";
	}
?>
<div id="image-preview" style="background-image: url('<?php echo $pro_pic ?>'); background-size: 250px 200px;">
					
</div>
<input type="file" class="image-upload" name="data[User][image]" id="image-upload">
<?php 
	if($post['User']['image']):
?>
	<input type="hidden" name="old_image" value="<?php echo $post['User']['image'] ?>">
<?php
	endif;
?>
<?php
echo $this->Form->input('name');
?>
<div class="form-group">
	<img class="image_upload_preview">
</div>
<div class="form-group">
	<label>Birthdate</label>
	<input type="text" name="data[User][birthdate]" class="date-br" value="<?php echo $post['User']['birthdate'] ?>">
</div>
<div class="form-group">
	<label>Gender</label>
</div>
<div class="form-group">
	<input type="radio" name="data[User][gender]" value="1" <?php if($post['User']['gender'] == 1){echo "checked";} ?> > Male
</div>
<div class="form-group">
	<input type="radio" name="data[User][gender]" value="2" <?php if($post['User']['gender'] == 2){echo "checked";} ?> > Female
</div>
<?php
	echo $this->Form->input('hobby', array('rows' => '3'));
	echo $this->Form->input('id', array('type' => 'hidden'));
	echo $this->Form->end('Update Profile');
?>