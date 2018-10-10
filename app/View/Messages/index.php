<!-- File: /app/View/Posts/index.ctp -->
<div class="container">
<div class="form-group text-left">
    <h1>Messages List</h1>
    <input type="hidden" class="page-limit" value="<?php echo $this->params['paging']['Message']['pageCount']; ?>">
</div>

<div class="form-group text-right header-line">
    <a href="/cakephp/messages/add/" class="btn btn-default btn-default-color btn-md"><i class="fa fa-plus black"></i> New Message</a>
</div>
<div class="messages-list">
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
        
    <?php
         endforeach; 

         $pagesCount = $this->params['paging']['Message']['pageCount'];
    ?>
    <div class="view-more-div"></div>
    <?php if($pagesCount > 1): ?>
        <div class="col-xs-12 text-center">
            <i class="fa fa-spinner fa-spin blue trash-info loading-icon" style="display: none;"></i>
        </div>
        <div class="form-group text-center">
            <button class="btn btn-info btn-show-more btn-md" data-page="<?php echo 2 ?>">Show More<br><i class="fa fa-chevron-down"></i></button>
        </div>
    <?php 
    endif;
    /*
        print_r($max_count);

        foreach($messages as $message){
            $_time = strtotime($message['Message']['created']);
            foreach($max_count as $k => $v){
                if($message['Message']['created'] === $max_count[$k]['messages']['created']){
                    echo "<br>".strtotime($max_count[$k]['messages']['created']);
                }
            }
        }
       
        */
    ?>
</div>
</div>