<?php

App::uses('View', 'View');

class OpView extends View {
	
	
/**
 * Renders a partial file
 */
	public function partial($viewFile, $data = array(), $options = array()){
		list($plugin, $viewFile) = pluginSplit($viewFile);
		if(!$plugin && $this->plugin){
			$plugin = $this->plugin;
		}
		$paths = array(
			'../../../plugins/'.$plugin.'/View/',
			'../../Plugin/'.$plugin.'/View/',
			'../'
		);
		foreach($paths as $path){
			$el = $this->viewPath.'/_'.$viewFile;
			if(file_exists(realpath(APP.'View'.DS.'Elements'.DS.$path.$el.'.ctp'))){
				return $this->element($path.$el, $data, $options);
			}
		}	
	}
}
