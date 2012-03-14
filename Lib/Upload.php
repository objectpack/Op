<?php

class Upload extends Object {
	
	public $options = array();
	
/**
 * $_FILES[$key] data
 */
	public $data = null;
	
/**
 * Error message
 */
	public $error = null;

/**
 * Class constructor
 * @param array $path Path to file var (using Set::extract('/path/to/data', $_FILES))
 * @param array $options 
 */
	public function __construct($path, $options = array()) {
		$this->options = $this->options + (array) $options;
		$this->data = Set::extract($path, $_FILES);
	}
	
/**
 * Upload error
 */
	public function uploadError($data = null) {
		if ($data === null){
			$data = $this->data;
		}
		;
		if (
			!is_array($data)
			|| !array_reduce(array('name', 'type', 'tmp_name', 'error', 'size'), function($value, $key) use ($data) {
				return $value && isset($data[$key]);
			}, true)
		){
			$this->error = __d('op', 'Invalid upload');
			return false;
		}
		$errors = array(
			1 => __d('op', 'File too big (server limit)'),
			2 => __d('op', 'File too big (form limit)'),
			3 => __d('op', 'Upload interrupted'),
			4 => __d('op', 'No files were submited'),
			5 => __d('op', 'Tmp directory doesn\'t exist'),
			6 => __d('op', 'Unable to write Tmp directory')
		);
		if(array_key_exists($data['error'], $errors)){
			$this->error = $errors[$data['error']];
			return false;
		}
		return true;
	}
	
	public function __destruct() {
		
	}
	
}