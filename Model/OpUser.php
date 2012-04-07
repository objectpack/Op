<?php

App::uses('Op.OpAppModel', 'Model');

class OpUser extends OpAppModel {
	
	public $validate = array(
		'email' => array(
			'required' => array(
				'rule' => array('email'),
				'message' => 'Email is invalid'
			)
		),
		'passwd' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'A password is required'
			)
		),
		'prefix' => array(
			'valid' => array(
				'rule' => array('inList', array('admin', 'user')),
				'message' => 'Please enter a valid prefix',
				'allowEmpty' => false
			)
		)
	);
	
	public function beforeSave() {
		if (isset($this->data[$this->alias]['passwd'])) {
			$this->data[$this->alias]['passwd'] = AuthComponent::password($this->data[$this->alias]['passwd']);
		}
		return true;
	}
	
}
	