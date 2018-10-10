<?php

class MessagesController extends AppController {
    
    public $helpers = array('Html', 'Form');

    public function index(){

    	$id = $this->Auth->user('id');
    	$message_list = $this->max_message_list($id);

	    $this->paginate = array(
		    'joins' => array(
		        array(
		            'table' => 'users',
		            'alias' => 'User',
		            'type' => 'INNER',
		            'conditions' => array(
		                'User.id = Message.from_id'
		            )
		        )
		    ),
		    'conditions' => array('OR' => array(array('Message.to_id' => $id),array('Message.from_id' => $id)), 'Message.id' => $message_list),
		    'fields' => array('User.image', 'Message.id', 'Message.from_id', 'Message.to_id', 'Message.content', 'Message.created'),
		    'limit' => 1,
		    'order' => 'Message.id DESC'
		);

		$messages = $this->paginate();

		$this->set(compact('messages','id','_message_list','message_list'));

		if ($this->request->is('ajax')) {
		    $this->autoRender = false;
			$this->layout = 'ajax';

			$this->render('/Messages/viewmore');
		}


    }

    public function view($id = null) {

        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }

        $post = $this->Message->findById($id);

        if (!$post) {
            throw new NotFoundException(__('Invalid post'));
        }

        $from = $post['Message']['from_id'];
        $to = $post['Message']['to_id'];
        $convo_id = $this->Message->field('convo_id',   array('OR' => array(array('Message.to_id' => $from, 'Message.from_id' => $to),
        	array('Message.from_id' => $from, 'Message.to_id' => $to))));
        $messages = $this->Message->find('all', array(
		    'joins' => array(
		        array(
		            'table' => 'users',
		            'alias' => 'User',
		            'type' => 'INNER',
		            'conditions' => array(
		                'User.id = Message.from_id'
		            )
		        )
		    ),
		    'conditions' => array('OR' => array(array('Message.to_id' => $from, 'Message.from_id' => $to),
        	array('Message.from_id' => $from, 'Message.to_id' => $to))),
		    'fields' => array('User.*', 'Message.*'),
		    'order' => 'Message.id DESC'
		));

        //$messages = $this->Message->find('all', array('conditions' => array('OR' => array(array('Message.to_id' => $from, 'Message.from_id' => $to),
        	//array('Message.from_id' => $from, 'Message.to_id' => $to)))));

        $sender = $this->Auth->user('id');

        if($from == $sender){
        	$recipient = $to;
        }else{
        	$recipient = $from;
        }

        $this->set(compact('messages','sender','recipient', 'convo_id'));
    }

    public function add(){

    	$m = $this->request;
    	$id = $this->Auth->user('id');

    	if ($m->is('post')) {

    		$to = $this->request->data['Message']['to_id'];

	    	$convo_id = $this->Message->field('convo_id',   array('OR' => array(array('Message.to_id' => $id, 'Message.from_id' => $to),
	        	array('Message.from_id' => $id, 'Message.to_id' => $to))));

	    	if($convo_id){

	    	}else{
	    		$convo_id = $to.$id;
	    	}

            $this->Message->create();
            $m->data['Message']['from_id'] = $id;
            $m->data['Message']['convo_id'] = $convo_id;

            if ($this->Message->save($m->data)) {

                $this->Flash->success(__('Your message has been sent.'));
                return $this->redirect(array('action' => 'index'));

            }

            $this->Flash->error(__('Unable to add your post.'));
        }

    }

    public function viewmore(){

    	$id = $this->Auth->user('id');
		$max_count = $this->Message->query("SELECT created from messages where to_id = $id or from_id = $id and created IN (Select MAX(created) from messages Group by convo_id);");

	    $this->paginate = array(
		    'joins' => array(
		        array(
		            'table' => 'users',
		            'alias' => 'User',
		            'type' => 'INNER',
		            'conditions' => array(
		                'User.id = Message.from_id'
		            )
		        )
		    ),
		    'conditions' => array('OR' => array(array('Message.to_id' => $id),array('Message.from_id' => $id))),
		    'fields' => array('User.*', 'Message.*'),
		    'group' => array('Message.convo_id'),
		    'limit' => 1,
		    'having' => array('MAX(Message.id)'),
		    'order' => 'Message.id DESC'
		);

		$messages = $this->paginate();

		$this->set(compact('messages','id','max_count'));
	    $this->autoRender = false;
		$this->layout = 'ajax';

		$this->render('/Messages/viewmore');

    }

    public function recipients(){

    	$this->autoRender = false;
		$this->loadModel('User');
		$users = $this->User->find('all', array('fields' => array('User.id', 'User.name','User.image')));
		
		return json_encode($this->User->find('list', array('fields' => array('User.id', 'User.name'))));

    }

     public function retrieve(){

     	$searched = $this->request->data['searched'];
    	$this->autoRender = false;
		$this->loadModel('User');
		$users = $this->User->find('list', array('fields' => array('User.id', 'User.name'), 'conditions' => array('User.name LIKE' => '%'.$searched.'%')));
		
		return json_encode($users);

    }

    public function reply(){
    	
    	$m = $this->request;
    	$id = $this->Auth->user('id');

	    $this->Message->create();
	    $m->data['Message']['from_id'] = $id;
	    $m->data['Message']['to_id'] = $m->data['to'];
	    $m->data['Message']['content'] = $m->data['msg'];
	    $m->data['Message']['convo_id'] = $m->data['convo_id'];
	   
	    $this->Message->save($m->data);

	    $messages = $this->Message->find('all', array(
		    'joins' => array(
		        array(
		            'table' => 'users',
		            'alias' => 'User',
		            'type' => 'INNER',
		            'conditions' => array(
		                'User.id = Message.from_id'
		            )
		        )
		    ),
		    'conditions' => array('OR' => array(array('Message.to_id' => $id, 'Message.from_id' => $m->data['to']),
        	array('Message.from_id' => $id, 'Message.to_id' => $m->data['to']))),
		    'fields' => array('User.*', 'Message.*'),
		    'order' => 'Message.id DESC'
		));

		$sender = $id;

		$this->set(compact('messages','sender'));

		$this->autoRender = false;
		$this->layout = 'ajax';
		$this->render('/Messages/reply');


    }

    public function delete(){

    	$m = $this->request;

    	$messages = $this->Message->find('all', array(
		    'conditions' => array('OR' => array(array('Message.to_id' => $this->request->data['sender'], 'Message.from_id' => $this->request->data['recipient']),
        	array('Message.from_id' => $this->request->data['sender'], 'Message.to_id' => $this->request->data['recipient']))),
		    'fields' => array('Message.id'),
		    'order' => 'Message.id DESC'
		));

		foreach($messages as $message){
			if($message['Message']['id'] <= $m->data['del']){
				$this->Message->delete($message['Message']['id']);
			}
		}

		return true;

    }

    public function max_message_list($id){

    	$message_list = array();

	    $_message_list = $this->Message->find('all', array('conditions' => array('OR' => array(array('Message.to_id' => $id),array('Message.from_id' => $id))),
		    'fields' => array('MAX(Message.id) as id'),
		    'group' => array('Message.convo_id'),
		    'order' => 'Message.id DESC'
		));

		foreach($_message_list as $ml){
			$message_list[] = $ml[0]['id'];
		}

		return $message_list;

    }

}