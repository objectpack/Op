<?php

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
		Configure::load('Op.core');
		parent::__construct($components, $settings);
	}
	
/**
 * Initialize callback
 */		
	public function initialize($controller){
		$this->_initializeComponent($controller, 'Op.OpAuth', array('alias' => 'Auth'));
		$this->loggedInUser = $controller->Auth->user();
	}
	
/**
 * Startup callback
 */		
	public function startup($controller){
		$this->_startupComponents($controller);
	}
	
/**
 * Adds a component to the controller if not present 
 */
	protected function _initializeComponent($controller, $component, $options = array()){
		if(!isset($options['alias'])){
			$options['alias'] = $component;
		}
		$alias = $options['alias'];
		unset($options['alias']);
		$controller->$alias = $controller->Components->load($component, $options);
		$controller->$alias->initialize($controller);
		$this->autoComponents[] = $alias;
	}
	
/**
 * Startups all the components loaded by OpComponent::_initializeComponent()
 */
	protected function _startupComponents($controller){
		foreach($this->autoComponents as $component){
			$controller->$component->startup($controller);
		}
	}
	
	public function setFlash($message, $success = false, $options = array()){
		if($options === true){
			$options = array('success' => true);
		}
		$options = $options + array('success' => false);
		
	}
	
/**
 * Before render callback
 */
	public function beforeRender($controller){
		
		$controller->viewClass = 'Op.Op';
		
		if( $this->isAdmin && $this->layout == 'default' ){
			$this->layout = 'admin';
		}
		
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