<?php

class Profile extends AppModel {

	public $validate = array(
        'birthday' => array(
            'rule' => 'notBlank'
        ),
        'hobby' => array(
            'rule' => 'notBlank'
        )
    );

}