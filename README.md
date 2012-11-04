# Rest O'Raptor

Simple REST Interface to MongoDB.

## Usage

Create `composer.json` file with that content:

```json
{
    "require": {
    	"rithis/restoraptor": "@dev"
    }
}
```

Run `composer update` to install.

Write your own Rest-o-Raptor application file and put it to your web document root:

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = new Restoraptor\Application('mongodb://localhost:27017', 'database_name');
$app->run();
```
