<?php

App::uses('Controller', 'Controller');

class OpBaseController extends Controller {
	
	public $viewClass = 'Op.Op';
	
	public $components = array(
		'Auth' => array(
			'className' => 'Op.OpAuth'
		),
		'Session' => array(
			'className' => 'Op.OpSession'
		)
	);
	
	public $helpers = array(
		'Session',
		'Html' => array(
			'className' => 'Op.OpHtml'
		),
		'Form' => array(
			'className' => 'Op.OpForm'
		)
	);

	
/**
 * Before filter callback
 */	
	public function beforeFilter(){
		Configure::load('Op.core');
		$this->_user = $this->Auth->user();
		$this->_user['url_prefix'] = isset($this->request->params['prefix']) ? $this->request->params['prefix'] : null;
		parent::beforeFilter();
	}
	
/**
 * Prefix based authentication
 */	
	public function isAuthorized(){
		return empty($this->_user['url_prefix']) || $this->_user['url_prefix'] == $this->_user['prefix'] || $this->_user['prefix'] == 'admin';
	}
	
/**
 * Before render callback
 */
	public function beforeRender(){
		if( $this->_user['url_prefix'] == 'admin' ) {
			$this->layout = 'admin';
		}
		$this->set('_user', $this->_user);
		parent::beforeRender();
	}
	
}
