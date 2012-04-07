<?php

// User routing
Router::connect('/register', array('plugin' => 'op', 'controller' => 'op_users', 'action' => 'register'));
Router::connect('/login', array('plugin' => 'op', 'controller' => 'op_users', 'action' => 'login'));
Router::connect('/logout', array('plugin' => 'op', 'controller' => 'op_users', 'action' => 'logout'));
Router::connect('/users/*', array('plugin' => 'op', 'controller' => 'op_users'));
//Router::connect('/user/:username', array('plugin' => 'op', 'controller' => 'op_users', 'action' => 'view'), array('pass' => array('username'), 'username' => '[a-zA-Z0-9-_]+'));


Router::connect('/admin', array('plugin' => 'op', 'controller' => 'op_dashboard', 'action' => 'index'));