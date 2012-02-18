<?php 
echo $this->Form->create('OpUser', array('url' => array('action' => 'register')));
echo $this->Form->inputs(array(
	'legend' => __d('op', 'Register'),
	'email' => array('label' => __d('op', 'Email')),
	'passwd' => array('label' => __d('op', 'Password'))
)); 
echo $this->Form->end(__d('op', 'Register')); 
?>