<?php

class OpComponent extends Component {
	
	var $isAdmin = false;
	
	var $isScaffold = false;
	
	var $modelNames = array();
	
	public $components = array(
		'Auth' => array(
			'className' => 'Op.OpAuth'
		)
	);

	
	public function __construct(ComponentCollection $components, $settings = array()){
		Configure::load('Op.core');
		parent::__construct($components, $settings);
	}
	
/**
 * Startup callback
 */		
	public function startup($controller){
		$this->loggedInUser = $this->Auth->user();
	}
	
/**
 * Before render callback
 */	
	public function beforeRender($controller){
		
		// Set helpers
		$helpersToUnset = array('Html', 'Form');
		foreach($helpersToUnset as $helper){
			if(in_array($helper, $controller->helpers)){
				unset($controller->helpers[array_search($helper,$controller->helpers)]);
			}
		}
		$controller->helpers += array(
			'Html' => array(
				'className' => 'Op.OpHtml'
			),
			'Form' => array(
				'className' => 'Op.OpForm'
			)
		);
		
	}
	
	
}