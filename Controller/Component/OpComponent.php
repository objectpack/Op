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
		$this->loggedInUser = $this->Auth->user();
		$this->_initializeComponent($controller, 'Op.OpAuth', array('alias' => 'Auth'));
		$this->_initializeComponent($controller, 'Op.OpSession', array('alias' => 'Session'));
	}
	
/**
 * Startup callback
 */		
	public function startup($controller){
		$this->loggedInUser = $this->Auth->user();
		$this->_startupComponents($controller);
	}
	
	protected function _initializeComponent($controller, $name, $options = array()){
		if(!isset($options['alias'])){
			$options['alias'] = $name;
		}
		$alias = $options['alias'];
		unset($options['alias']);
		$controller->$alias = $controller->Components->load($name, $options);
		$controller->$alias->initialize($controller);
		$this->autoComponents[] = $alias;
	}
	
	protected function _startupComponents($controller){
		foreach($this->autoComponents as $component){
			$controller->$component->startup($controller);
		}
	}
	
/**
 * Before render callback
 */	
	public function beforeRender($controller){
		
		$controller->viewClass = 'Op.Op';
		
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