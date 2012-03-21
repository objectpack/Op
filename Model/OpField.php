<?php

App::uses('Op.OpAppModel', 'Model');

class OpField extends OpAppModel {
	
	public $useTable = false;
	
	public $_schema = array(
		'name' => array('type' => 'string')
	);
	
}