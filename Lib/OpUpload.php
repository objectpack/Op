<?php

App::uses('File', 'Utility');
/**
 * Upload class
 * 
 * @usage
 * 
 * try {
 * 		OpUpload::treat('/Model/field', array(
 * 			'folder' => APP . 'webroot' . DS . 'img'
 * 		));
 * }
 * catch(e) {
 * 		trigger_error(e->getMessage(), E_USER_WARNING);
 * }
 * 
 */	
class OpUpload extends Object {
	
/**
 * Default options
 * 
 * @see OpUpload::treat
 */
	static $options = array(
		'folder' => TMP,
		'createFolder' => false,
		'onExistant' => 'suffix',
		'name' => null,
		'type' => 'default',
		'required' => true,
		'mimes' => '*',
		'extensions' => '*',
		'maxSize' => 8,
		'minSize' => 0
	);
	
	static $types = array(
		'default' => array()
	);

/**
 * Class constructor
 * 
 * @todo Error management try, catch
 * 
 * @param array $path Path to file var (using Set::extract('/path/to/data', $_FILES))
 * @param array $options 	(string) 	type			Maps extensions and mimes to strings
 * 							(array) 	extensions	 	List of allowed extensions
 * 							(array) 	mimes	 		List of allowed mimes
 * 							(string) 	folder	 		Where to upload the file
 * 							(bool) 		createFolder 	Create folder if it does not exists (recursive)
 * 							(string) 	onExistant 		What to do if target file exists error, overwrite, suffix
 * 							(string) 	name 			Force the target file to have this name
 * 							(bool) 		required 		Is the upload required
 */
	public static function treat($path, $options = array()) {
		$options = self::options + Configure::read('Op.Upload.options') + (array) $options;
		$types = self::types + Configure::read('Op.Upload.types');
		$data = Set::extract($path, $_FILES);
		$result = array('success' => false, 'message' => null, 'file' => null, 'path' => null);
		
		// Upload validity
		if (
			!is_array($data)
			|| !array_reduce(array('name', 'type', 'tmp_name', 'error', 'size'), function($value, $key) use ($data) {
				return $value && isset($data[$key]);
			}, true)
		){
			throw new Exception(__d('op', 'Invalid upload'));
			return false;
		}
		
		// Upload errors
		$errors = array(
			1 => __d('op', 'File too big (server limit)'),
			2 => __d('op', 'File too big (form limit)'),
			3 => __d('op', 'Upload interrupted'),
			5 => __d('op', 'Tmp directory doesn\'t exist'),
			6 => __d('op', 'Unable to write Tmp directory')
		);
		if($options['required']){
			$errors[4] = __d('op', 'No files were submited');
		}
		if(array_key_exists($data['error'], $errors)){
			throw new Exception($errors[$data['error']]);
			return false;
		}
		if($data['error'] == 4){
			return true;
		}
		
		// Preparation
		$f = new File($data['tmp_name']);
		if(isset($options['type'])){
			if(!in_array($options['type'], $types)){
				throw new Exception(__d('op', 'Undefined upload type "%s"', $options['type']));
				return false;
			}
			$options = array_merge($options, $types[$options['type']]);
		}
		
		// Mime type
		$mime = $f->mime();
		if(!in_array($mime, $options['mimes'])){
			throw new Exception(__d('op', 'Mime type "%s" not allowed', $mime));
			return false;
		}
		
		// Extension
		$ext = $f->ext();
		if(!in_array($ext, $options['extensions'])){
			throw new Exception(__d('op', 'Extension "%s" not allowed'), $ext);
			return false;
		}
		
		// File size
		$size = $f->size();
		if($size < $options['minSize'] || $size > $options['maxSize']){
			throw new Exception(__d('op', 'The file size must be between %s Mo. and %s Mo. (actualiy %s Mo.)'), round($options['minSize'], 2), round($options['maxSize'], 2), round($size, 2));
			return false;
		}
		
		// Custom filters
		
		// Destination directory
		
		// Destination directory writable
				
		// Move file
		
		return true;
	}
	
}