<?php

class OpSchema extends CakeSchema {

	public $name = 'Op';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $cake_sessions = array(
		'id' => array('type' => 'string', 'null' => false, 'key' => 'primary'),
		'data' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'expires' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);

	public $i18n = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'locale' => array('type' => 'string', 'null' => false, 'length' => 6, 'key' => 'index'),
		'model' => array('type' => 'string', 'null' => false, 'key' => 'index'),
		'foreign_key' => array('type' => 'integer', 'null' => false, 'length' => 10, 'key' => 'index'),
		'field' => array('type' => 'string', 'null' => false, 'key' => 'index'),
		'content' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'locale' => array('column' => 'locale', 'unique' => 0), 'model' => array('column' => 'model', 'unique' => 0), 'row_id' => array('column' => 'foreign_key', 'unique' => 0), 'field' => array('column' => 'field', 'unique' => 0))
	);
	
	public $op_users = array(
		'id' => array('type' => 'string', 'null' => false, 'key' => 'primary'),
		'email' => array('type' => 'string', 'null' => false),
		'passwd' => array('type' => 'string', 'null' => false, 'length' => 36),
		'prefix' => array('type' => 'string', 'null' => true, 'length' => 45, 'default' => 'user'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	
}
