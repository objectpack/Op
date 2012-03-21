<?php

$config = array();

$config['Op']['upload'] = array(
	'options' => array(
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
	),
	'types' => array(
		'image' => array(
			'mimes' => array('image/jpg', 'image/jpeg', 'image/pjpeg', 'image/gif', 'image/png'),
			'extensions' => array('jpg', 'jpeg', 'gif', 'png')
		),
		'pdfs' => array(
			'mimes' => array('application/pdf', 'application/x-pdf', 'application/acrobat', 'text/pdf', 'text/x-pdf'),
			'extensions' => array('pdf')
		),
		'documents' => array(
			'mimes' => array('text/plain', 'application/msword', 'application/mspowerpoint', 'application/powerpoint', 'application/vnd.ms-powerpoint', 'application/x-mspowerpoint', 'application/x-msexcel',  'application/excel', 'application/x-excel'),
			'extensions' => array('txt', 'doc', 'docx', 'ppt', 'pptx', 'csv', 'xls', 'xlsx')
		),
		'archives' => array(
			'mimes' => array( 'application/x-compressed', 'application/x-zip-compressed', 'application/zip', 'multipart/x-zip', 'application/x-tar', 'application/x-compressed', 'application/x-gzip',  'multipart/x-gzip'),
			'extensions' => array('zip', 'gzip', 'gz', 'tar')
		),
		'graphics' => array(
			'mimes' => array('application/postscript', 'application/eps', 'application/x-eps', 'image/eps', 'image/x-eps', 'image/photoshop', 'image/x-photoshop', 'image/psd', 'application/photoshop', 'application/psd', 'zz-application/zz-winassoc-psd', 'image/tiff', 'image/x-tiff'),
			'extensions' => array('ps', 'eps', 'psd', 'tiff')
		),
		'css' => array(
			'mimes' => array('text/css'),
			'extensions' => array('css')
		),
		'js' => array(
			'mimes' => array('text/javascript', 'application/x-javascript', 'application/javascript', 'text/ecmascript', 'application/ecmascript', 'text/jscript' ),
			'extensions' => array('js')
		),
		'flash' => array(
			'mimes' => array( 'application/x-shockwave-flash' ),
			'extensions' => array('swf')
		),
		'videos' => array(
			'mimes' => array( 'application/x-shockwave-flash', 'video/quicktime', 'video/x-quicktime', 'video/avi', 'video/mpeg', 'video/x-ms-wmv' ),
			'extensions' => array('flv', 'mov', 'avi', 'mpeg', 'wmv')
		)
	)
);

