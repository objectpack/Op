<?php

App::uses('Op.OpAppController', 'Controller');

class OpUsersController extends OpAppController {
	
	public $acaffold = 'admin';
	
	public function login(){
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				return $this->redirect($this->Auth->redirect());
			}
			else {
				$this->Session->setFlash(__d('op', 'Username or password is incorrect'), 'default', array(), 'auth');
			}
    	}
	}
	
	public function logout(){
		$this->Session->setFlash(__d('op', 'Good bye !'));
		$this->redirect($this->Auth->logout());
	}
	
	public function register(){
		if($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->request->data['User']['id'] = $this->User->id;
				$this->Auth->login($this->request->data['User']);
				$this->Session->setFlash(__d('op', 'Account created'));
				$this->redirect($this->Auth->redirect());
			}
			else {
				$this->Session->setFlash(__d('op', 'The %s could not be saved. Please, try again.', __d('op', 'User')));
			}
		}
	}
	
}
