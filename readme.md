
# Object Pack (OP)

STILL IN HEAVY DEVELOPMENT

<a name="table_of_contents"></a>
## Table of contents

* [Features](#features)
* [Install](#install)
* [Naming convientions](#conventions)
* [How to contribute](#contribute)

<a name="features"></a>
## Features

* Auth
* Scaffolding
* Uploads
* I18n
* No ACL (prefix based auth)
* TwitterBootstrap
* Less.js framework
* Partials

<a name="install"></a>
## Install

### Clone repository

```bash
cd /path/to/my/app
git clone git@github.com:objectpack/Op Plugins/Op
```

### Init submodules

```bash
cd Plugins/Op
git submodule init
git submodule update
```

### Load plugin

In your /Config/bootstrap.php add :

```php
<?php
CakePlugin::load(array(
	'Op' => array(
		'bootstrap' => true,
		'routes' => true
	)
));
```
### Create schema

```bash
cake schema create Op.op
```

### Add Op component

In your /Controller/AppController.php add :

```php
<?php
class AppController extends Controller {
	public $components = array(
		'Op.Op'
	);
}
```

<a name="conventions"></a>
## Naming conventions

### Database

#### Uploads

Fields / Suffixes : _file, _image, _video, _doc, _pdf, _photo

#### Order

Field : order

<a name="contribute"></a>
## How to contribute

