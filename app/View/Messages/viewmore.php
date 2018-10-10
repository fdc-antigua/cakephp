<?php foreach ($messages as $message): ?>
        <a href="<?php echo '/cakephp/messages/view/'.$message['Message']['id'] ?>" class="messages-item">
            <div class="panel panel-default">
                <div class="panel-body">
                        <?php if($message['Message']['to_id'] == $id){ ?>
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
                    </span>
                </div>
                <?php if($message['Message']['from_id'] == $id){ ?>
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
                </div>
                <div class="panel-footer text-right">
                    <label class="black decor-reset">
                        <?php
                            $message_sent = $this->Time->format($message['Message']['created'], '%B %e, %Y %H:%M %p');
                            echo $message_sent; 
                        ?>
                    </label>
                </div>
            </div>
        </a>
<?php endforeach; ?>