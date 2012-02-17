<?php

// User routing
Router::connect('/users/*', array('plugin' => 'op', 'controller' => 'op_users'));