<?php

App::uses('Op.OpAppModel', 'Model');

class OpModel extends OpAppModel {
	
	public $useTable = false;
	
	public $_schema = array(
		'name' => array('type' => 'string')
	);
	
}
