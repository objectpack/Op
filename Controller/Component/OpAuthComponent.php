<?php

App::uses('AuthComponent', 'Controller/Component');

class OpAuthComponent extends AuthComponent {
	
	public $loginAction = array(
		'prefix' => null,
		'admin' => false,
		'plugin' => 'op',
		'controller' => 'op_users',
		'action' => 'login'
	);
	
	public $loginRedirect = array(
		'prefix' => 'admin',
		'admin' => true,
		'plugin' => 'op',
		'controller' => 'op_dashboard',
		'action' => 'index'
	);
	
	
	public $logoutRedirect = array(
		'prefix' => null,
		'admin' => false,
		'plugin' => 'op',
		'controller' => 'op_users',
		'action' => 'login'
	);
	
	public $flash = array(
		'element' => 'default',
		'key' => 'auth',
		'params' => array()
	);
	
	public $authenticate = array(
		'Form' => array(
			'userModel' => 'Op.User',
			'fields' => array(
				'username' => 'email',
				'password' => 'passwd'
			)
		)
	);
	
	public function __construct(ComponentCollection $components, $options){
		$this->authError = __d('op', 'You are not allowed to access this location.');
		parent::__construct($components, $options);
	}
	
}