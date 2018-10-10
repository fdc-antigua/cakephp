<?php

class Message extends AppModel {

	public $validate = array(
        'to_id' => array(
            'rule' => 'notBlank'
        ),
        'content' => array(
            'rule' => 'notBlank'
        )
    );

}