<?php

App::uses('SessionComponent', 'Controller/Component');

class OpSessionComponent extends SessionComponent {
	
	public function success($message, $options = array()){
		$options = $options + array(
			'element' => 'default',
			'params' => array(
				'class' => 'success'
			),
			'key' => 'flash'
		);
		$this->setFlash($message, $options['element'], $options['params'], $options['key']);
	}
	
	public function error($message, $options = array()){
		$options = $options + array(
			'element' => 'default',
			'params' => array(
				'class' => 'error'
			),
			'key' => 'flash'
		);
		$this->setFlash($message, $options['element'], $options['params'], $options['key']);
	}
	
}