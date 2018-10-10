<?php

class ProfileController extends AppController {

	public $helpers = array('Html', 'Form');

	public function index(){
	   
        $id = $this->Auth->user('id');
        $post = $this->Profile->findById($id);
        $this->set('profile', $post);

         if ($this->request->is(array('post', 'put'))) {
            $this->Profile->id = $id;
            if ($this->Profile->save($this->request->data)) {
                $this->Flash->success(__('Your post has been updated.'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->error(__('Unable to update your post.'));
        }

        if (!$this->request->data) {
            $this->request->data = $post;
        }
	}

}