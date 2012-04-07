<?php
// Define template variables if not defined
extract(array('nav' => null), EXTR_SKIP);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $title_for_layout; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">

<?php 
echo $this->Html->css(array(
	'Op.bootstrap/docs/assets/css/bootstrap',
	'Op.layout',
	'Op.bootstrap/docs/assets/css/bootstrap-responsive'
)); 
?>
<!--[if lt IE 9]>
	<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link rel="shortcut icon" href="images/favicon.ico">
<link rel="apple-touch-icon" href="images/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">

</head>
<body>

<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container-fluid">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<?php echo $this->Html->link('Admin', '/admin', array('class' => 'brand')); ?>
			<div class="nav-collapse">
				<ul class="nav">
					<li class="active"><?php echo $this->Html->link('Dashboard', array('admin' => true, 'plugin' => 'op', 'controller' => 'op_dashboard', 'action' => 'index')); ?></li>
				</ul>
				<p class="navbar-text pull-right">
					<?php 
					echo __d(
						'op', 
						'Logged in as %s, %s',
						$this->Html->link($_user['email'], array('admin' => true, 'plugin' => 'op', 'controller' => 'op_users', 'action' => 'view', $_user['id'])),
						$this->Html->link(__d('op', 'logout'), array('admin' => false, 'plugin' => 'op', 'controller' => 'op_users', 'action' => 'logout'))
					);
					?>
				</p>
			</div>
		</div>
	</div>
</div>

<div class="container-fluid">
	<div class="row-fluid">
		<?php if($nav): ?>
		<div class="span3">
			<?php echo $nav; ?>
		</div>
		<div class="span9">
		<?php endif; ?>
			<?php echo $content_for_layout; ?>
		<?php if($nav): ?>
		</div>
		<?php endif; ?>
	</div>

	<hr>

	<footer>
		<p>&copy; Company 2012</p>
	</footer>

</div>

<?php
echo $this->Html->script(array(
	'/css/bootstrap/docs/assets/js/jquery',
	'/css/bootstrap/docs/assets/js/bootstrap-transition',
	'/css/bootstrap/docs/assets/js/bootstrap-alert',
	'/css/bootstrap/docs/assets/js/bootstrap-modal',
	'/css/bootstrap/docs/assets/js/bootstrap-dropdown',
	'/css/bootstrap/docs/assets/js/bootstrap-scrollspy',
	'/css/bootstrap/docs/assets/js/bootstrap-tab',
	'/css/bootstrap/docs/assets/js/bootstrap-tooltip',
	'/css/bootstrap/docs/assets/js/bootstrap-popover',
	'/css/bootstrap/docs/assets/js/bootstrap-button',
	'/css/bootstrap/docs/assets/js/bootstrap-collapse',
	'/css/bootstrap/docs/assets/js/bootstrap-carousel',
	'/css/bootstrap/docs/assets/js/bootstrap-typeahead'
));
echo $scripts_for_layout;
?>

</body>
</html>