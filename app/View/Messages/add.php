<!-- File: /app/View/Posts/index.ctp -->
<div class="form-group text-left">
    <h1>New Message</h1>
</div>
<?php echo $this->Form->create('Message'); ?>
<div class="form-group">
    <div class="input-group">
        <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user"></i></span>
        <input type="text" class='auto_recipient' placeholder="Search for Recipient">
        <input type="hidden" name="data[Message][to_id]" class="recipient">
    </div>
</div>
<div class="form-group">
    <?php echo $this->Form->input('', array('rows' => '6','placeholder' => 'Message', 'name' => 'data[Message][content]')); ?>
</div>
<div class="col-xs-12">
	<button class="btn btn-primary btn-md" type="submit"><i class="fa fa-send"></i> Send Message</button>
</div>