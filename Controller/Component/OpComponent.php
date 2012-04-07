<?php

App::uses('Component', 'Controller');

class OpComponent extends Component {
	
	var $isAdmin = false;
	
	var $isScaffold = false;
	
	var $modelNames = array();
	
	public $components = array();
	
/**
 * List of components the must be manually initialized
 */
	protected $autoComponents = array();

	
	public function __construct(ComponentCollection $components, $settings = array()){
		
		parent::__construct($components, $settings);
	}
	
	public function setFlash($message, $success = false, $options = array()){
		if($options === true){
			$options = array('success' => true);
		}
		$options = $options + array('success' => false);
	}
	
}