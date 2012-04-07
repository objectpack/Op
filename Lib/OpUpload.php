<?php

App::uses('File', 'Utility');

if(!defined('UPLOAD_ERR_EMPTY')){
	define('UPLOAD_ERR_EMPTY',5);
}

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
		'type' => 'default',
		'extensions' => '*',
		'mimes' => '*',
		'folder' => TMP,
		'maxSize' => 8,
		'minSize' => 0,
		'createFolder' => false,
		'required' => true,
		'name' => null,
		'lowName' => true,
		'slug' => true,
		'slugReplacement' => '_',
		'onExistant' => 'suffix',
		'suffixLimit' => 100,
		'suffixSeparator' => '-',
		'lowExt' => true
	);

/**
 * Predefined configurations
 */	
	static $types = array(
		'default' => array()
	);

/**
 * Class constructor
 * 
 * @todo Custom filters
 * 
 * @param array $path Path to file var (using Set::extract('/path/to/data', $_FILES))
 * @param array $options 	(string) 	type			Maps extensions and mimes to strings
 * 							(array) 	extensions	 	List of allowed extensions
 * 							(array) 	mimes	 		List of allowed mimes
 * 							(string) 	folder	 		Where to upload the file
 * 							(float)		minSize	 		Minimum size in Mb
 * 							(float)		maxSize	 		Maximum size in Mb
 * 							(bool) 		createFolder 	Create folder if it does not exists (recursive)
 * 							(string) 	onExistant 		What to do if target file exists error, overwrite, suffix
 * 							(string) 	name 			Force the target file to have this name
 * 							(bool) 		required 		Is the upload required
 * @returns bool true if upload succeded
 */
	public static function treat($path, $options = array()) {
		
		$options = (array) $options + Configure::read('Op.Upload.options') + self::options;
		$types = Configure::read('Op.Upload.types') + self::types;
		$data = Set::extract($path, $_FILES);
		
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
			UPLOAD_ERR_INI_SIZE => __d('op', 'The uploaded file exceeds the limit (Server)'),
			UPLOAD_ERR_FORM_SIZE => __d('op', 'The uploaded file exceeds the limit (Form)'),
			UPLOAD_ERR_PARTIAL => __d('op', 'The uploaded file was only partially uploaded'),			
			UPLOAD_ERR_NO_TMP_DIR => __d('op', 'Missing a temporary folder'),
			UPLOAD_ERR_CANT_WRITE => __d('op', 'Failed to write file to disk'),
			UPLOAD_ERR_EXTENSION => __('op', 'A PHP extension stopped the file upload')
		);
		if($options['required']){
			$errors[UPLOAD_ERR_NO_FILE] = __d('op', 'No file was uploaded');
		}
		if(array_key_exists($data['error'], $errors)){
			throw new Exception($errors[$data['error']]);
			return false;
		}
		
		// No files were submited and file is not required
		if($data['error'] == UPLOAD_ERR_NO_FILE){
			return true;
		}
		
		// Preparation
		$file = new File($data['tmp_name']);
		if(isset($options['type'])){
			if(!in_array($options['type'], $types)){
				throw new Exception(__d('op', 'Undefined upload type "%s"', $options['type']));
				return false;
			}
			$options = array_merge($options, $types[$options['type']]);
		}
		
		// Mime type
		$mime = $file->mime();
		if(!in_array($mime, $options['mimes'])){
			throw new Exception(__d('op', 'Mime type "%s" not allowed', $mime));
			return false;
		}
		
		// Extension
		$ext = $file->ext();
		if(!in_array(strtolower($ext), $options['extensions'])){
			throw new Exception(__d('op', 'Extension ".%s" not allowed'), $ext);
			return false;
		}
		
		// File size
		$size = $file->size();
		if($size < (float) $options['minSize'] * 1024 * 1024 || $size > (float) $options['maxSize'] * 1024 * 1024){
			throw new Exception(__d('op', 'The file size must be between %s Mb. and %s Mb. (actualiy %s Mb.)'), round($options['minSize'], 2), round($options['maxSize'], 2), round($size, 2));
			return false;
		}
		
		// Destination directory
		$options['folder'] = rtrim(str_replace('/', DS, $folder), DS);
		if(!is_dir($options['folder'])){
			if(
				!$options['createFolder']
				|| !$folder = new Folder()
				|| !$folder->create($options['folder'])
			){
				throw new Exception(__d('op', 'Destination folder does not exist'));
				return false;
			}
		}
		
		// Destination directory writable
		if(!is_writable($options['folder'])){
			throw new Exception(__d('op', 'Destination folder is not writable by the server'));
			return false;
		}
		
		// Generate name
		$name = $file->name();
		if($options['name']){
			$name = $options['name'];
		}
		if($options['lowName']){
			$name = strtolower($name);
		}
		if($options['slug']){
			$name = Inflector::slug($name, $options['slugReplacement']);
		}
		if($options['lowExt']){
			$ext = strtolower($ext);
		}
		$fullName = $ext == false ? $name : $name.'.'.$ext;
		
		if(file_exists($options['folder'] . DS .$fullName)){
			switch($options['onExistant']){
				case 'error' : 
					throw new Exception(__d('op', 'Destination file already exists'));
					return false;
				break;
				case 'suffix' : 
					$name = self::findAvailableName(
						array(
							$name,
							$ext
						), 
						array(
							'folder' => $options['folder'],
							'limit' => $options['suffixLimit'],
							'separator' => $options['suffixSeparator']
						)
					);
					if($name === false){
						return false;
					}
				break;
			}
		}
								
		// Move file
		$fullName = $ext == false ? $name : $name.'.'.$ext;
		if(!move_uploaded_file($data['tmp_name'], $options['folder'] . DS . $fullName)){
			throw new Exception(__d('op', 'Unable to move file on server'));
			return false;
		}
				
		return true;
		
	}

	
	function findAvailableName($name, $options = array()) {
		
		$default = array(
			'folder' => TMP,
			'limit' => 1000,
			'separator' => '-',
			'suffix' => null
		);
		$options = $options + $default;
		
		extract($options);
		
		if($limit && $suffix >= $limit) {
			throw new Exception(__d('op', 'Number of generated file name suffixes exceeds the limit'));
			return false;
		}
		
		$folder = rtrim(str_replace('/', DS, $folder), DS);
		if(!is_dir($folder)){
			throw new Exception(__d('op', 'Destination folder does not exists'));
			return false;
		}
		
		if(is_array($name)) {
			list($_name, $ext) = $name;
		}
		else {
			$ext = substr(strrchr($name, '.'), 1);
			$_name = $ext === false ? $name : substr($name, 0, -(strlen($name)+1));
		}
		
		if($suffix){
			$_name .= $separator.$suffix;
		}
		
		$testName = $ext === false ? $_name : $_name.'.'.$ext;
		if( !file_exists($folder . DS . $testName) ){
			return $_name;
		}
		
		$options['suffix'] += 1;
		
		return OpUpload::findAvailableName(array($_name, $ext), $options);
		
	}	
}