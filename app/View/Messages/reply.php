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