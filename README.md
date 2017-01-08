# Yii2 RBAC Extension

An RBAC extension for yii2

# Installation

## Step 1

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer atans/yii2-rbac "*"
```

or add

```
"atans/yii2-rbac": "*"
```

to the require section of your `composer.json` file.


## Step 3

Update database schema

```
$ php yii migrate/up --migrationPath=@yii/rbac/migrations
```

Usage
-----


```php
    // config/main.php

    'modules' => [
        'rbac' => 'atans\rbac\Module',
    ],