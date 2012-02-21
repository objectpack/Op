<?php 

$options = array(
	'legend' => __d('op', 'Login'),
	'url' => array()
);
extract($options, EXTR_SKIP);

echo $this->Form->create('OpUser', array('url' => $url));
echo $this->Form->inputs(array(
	'legend' => $legend,
	'email' => array(
		'label' => __d('op', 'Email')
	),
	'passwd' => array(
		'label' => __d('op', 'Password'),
		'value' => ''
	)
)); 
echo $this->Form->end($legend); 
?>