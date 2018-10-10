<?php

// app/Controller/UsersController.php
App::uses('AppController', 'Controller');

class UsersController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        // Allow users to register and logout.
        $this->Auth->allow('add', 'logout','checkemail');
    }

    public function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {

                $_today = new DateTime();
                $_today->setTimeZone(new DateTimeZone("Asia/Hong_Kong"));
                $today = $_today->format('Y-m-d H:i:s');
                $id = $this->Auth->user('id');

                $data = array('id' => $id, 'last_login_time' => $today);
                $this->User->save($data);

                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

    public function index() {
        $this->User->recursive = 0;
        $this->set('users', $this->paginate());
    }

    public function view($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->findById($id));
    }

    public function add() {
        if ($this->request->is('post')) {
            $this->User->create();
            $this->request->data['User']['created_ip'] = $this->request->clientIp();
            if ($this->User->save($this->request->data)) {
                $this->Flash->success(__('The user has been saved'));
                return $this->redirect(array('action' => 'login'));
            }
            $this->Flash->error(
                __('The user could not be saved. Please, try again.')
            );
        }
    }

    public function checkemail(){

        $email = $this->request->data['email'];
        $this->autoRender = false;
        $check = $this->User->find('count', array(
            'conditions' => array('User.email' => $email)
        ));

        return $check;

    }

    public function edit($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Flash->success(__('The user has been saved'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->error(
                __('The user could not be saved. Please, try again.')
            );
        } else {
            $this->request->data = $this->User->findById($id);
            unset($this->request->data['User']['password']);
        }
    }

    public function update(){

        $id = $this->Auth->user('id');
        $this->User->id = $id;

        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if(isset($this->request->data['old_image'])){
                $this->request->data['User']['image'] = $this->request->data['old_image'];
            }else{
                 if(!empty($this->data['User']['image']['name']))
                {
                    $file = $this->data['User']['image']; //put the data into a var for easy use

                    $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
                    $arr_ext = array('jpg', 'jpeg', 'gif'); //set allowed extensions

                    //only process if the extension is valid
                    if(in_array($ext, $arr_ext))
                    {
                        //do the actual uploading of the file. First arg is the tmp name, second arg is
                        //where we are putting it
                        move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/uploads' . $file['name']);

                        //prepare the filename for database entry
                        $this->request->data['User']['image'] = $file['name'];
                    }
                }else{
                    $this->request->data['User']['image'] = NULL;
                }
                $this->request->trustProxy = true;
                $clientIp = $this->request-> clientIp();
                $this->request->data['User']['modified'] = $this->request-> clientIp();
            }
            if ($this->User->save($this->request->data)) {
                $this->Flash->success(__('Your Profile has been updated'));
                return $this->redirect(array('controller' => 'posts','action' => 'index'));
            }
            $this->Flash->error(
                __('Your profile could not be updated. Please, try again.')
            );

        

        } else {
            $this->request->data = $this->User->findById($id);
            $this->set('post', $this->User->findById($id));
            unset($this->request->data['User']['password']);
        }

    }

    public function delete($id = null) {
        // Prior to 2.5 use
        // $this->request->onlyAllow('post');

        $this->request->allowMethod('post');

        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->User->delete()) {
            $this->Flash->success(__('User deleted'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Flash->error(__('User was not deleted'));
        return $this->redirect(array('action' => 'index'));
    }

}