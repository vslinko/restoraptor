# Rest O'Raptor

Simple REST Interface to MongoDB.

## Installation

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

## Usage

**Schema-less.**<br>
That means document schema depends on your request parameters.

**Optional soft delete.**<br>
When you try to delete *ONE* object that object just marks as deleted.

**MongoId naturalize.**<br>
`MongoId` object transparently translates from `_id` property to `id`.

Now supported only JSON representation format.

Supported methods:

```
GET /{collectionName}/
DELETE /{collectionName}/
POST /{collectionName}/
GET /{collectionName}/{id}
PUT /{collectionName}/{id}
DELETE /{collectionName}/{id}
```
