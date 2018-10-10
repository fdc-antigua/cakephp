<?php

class ProfilesController extends AppController {

	public $helpers = array('Html', 'Form');

	public function index(){

		$id = $this->Auth->user('id');
        $post = $this->Profile->findById($id);

        if (!$post) {
            throw new NotFoundException(__('Invalid post'));
        }
        $this->set('post', $post);
	}

}