
# Object Pack (OP)

## Table of contents

* [Features](#features)
* [Install](#install)
* [Conventions](#conventions)

<a name="features"></a>
## Features

* TwitterBootstrap
* Partials
* Uploads
* I18n
* No ACL (prefix based auth)
* Scaffolding

<a name="install"></a>
## Install

### Clone repository

### Load plugin

In your /Config/bootstrap.php add

```php
CakePlugin::load(array(
	'Op' => array(
		'bootstrap' => true,
		'routes' => true
	)
));
```

### Add Op component

In your /Controller/AppController.php add

```php
public $components = array(
	'Op.Op'
);
```


<a name="conventions"></a>
## Naming conventions :

### Database :

* Automatic uploads :

