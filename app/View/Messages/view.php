<!-- File: /app/View/Posts/index.ctp -->
<div class="form-group text-left">
    <h1>Messages List</h1>
    <input type="hidden" name="convo_id" class="convo_id" value="<?php echo $convo_id; ?>">
</div>
<div class="col-xs-12 col-sm-12 col-md-9 col-md-offset-3">
    <textarea rows="6" placeholder="Message" class="message-send form-control"></textarea>
</div>
<div class="col-xs-12 content-lower"></div>
<div class="col-xs-12 col-sm-12 col-md-9 col-md-offset-3 text-right">
    <div class="form=form-group">
        <button class="btn btn-default btn-send btn-default-color" data-recipient="<?php echo $recipient; ?>" type="button"><i class="fa fa-reply"> </i> Reply Message</button>
    </div>
</div>
<div class="col-xs-12 content-lower header-line"></div>
<div class="col-xs-12 content-lower"></div>
<div class="messages-list">
    <?php foreach ($messages as $message): ?>
        <div class="col-xs-12 action-delete header-line-2" data-toggle="modal" data-target="#myModal" data-message="<?php echo $message['Message']['content'] ?>" data-msg-id="<?php echo $message['Message']['id'] ?>">
            <input type="hidden" class="child-delete" value="<?php echo $message['Message']['id'] ?>">
            <div class="row">
            <?php if($message['Message']['to_id'] == $sender){ ?>
                <div class="col-xs-3 col-sm-3 col-md-3 text-left">
                <?php 
                    if($message['User']['image']){
                        $image = 'uploads/'.$message['User']['image'];
                        //echo $this->Html->image('uploads/'.$message['User']['image'], array('width' => '150px','alt'=>'aswq'));    
                    }else{
                        $image = 'uploads/user.png';
                    }
                    echo $this->Html->image($image, array('width' => '180px','alt'=>'aswq'));    
                ?>
            </div>
            <?php } ?>
            <div class="col-xs-9 col-sm-9 col-md-9">
                <span class="black">
                    <?php
                        echo $message['Message']['content'];
                    ?>
                    <div class="row text-right">
                        <?php
                             $message_sent = $this->Time->format($message['Message']['created'], '%B %e, %Y %H:%M %p');
                             echo $message_sent;
                        ?>
                    </div>
                </span>
            </div>
            <?php if($message['Message']['from_id'] == $sender){ ?>
                <div class="col-xs-3 col-sm-3 col-md-3 text-right">
                <?php 
                    if($message['User']['image']){
                        $image = 'uploads/'.$message['User']['image'];
                        //echo $this->Html->image('uploads/'.$message['User']['image'], array('width' => '150px','alt'=>'aswq'));    
                    }else{
                        $image = 'uploads/user.png';
                    }
                    echo $this->Html->image($image, array('width' => '180px','alt'=>'aswq'));    
                ?>
            </div>
            <?php } ?>
            <div class="col-xs-12 content-lower"></div>
        </div>
        </div>
    <?php endforeach; ?>    
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center bg-dark">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="white">Delete this message?</h3>
      </div>
      <div class="modal-body">
        <div class="text-center">
            <i class="fa fa-envelope-open trash-info blue"></i>
            <h4>"<span class="text-message"> </span>"</h4>
        </div>
        <input type="hidden" class="delete-message">
        <input type="hidden" class="message-sender" value="<?php echo $sender; ?>">
        <input type="hidden" class="message-recipient" value="<?php echo $recipient; ?>">
      </div>
      <div class="modal-footer bg-dark">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success btn-delete">Delete</button>
      </div>
    </div>
  </div>
</div>
