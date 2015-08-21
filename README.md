Identity and Access Management server providing OAuth2, ABAC and logging
------------------------------------------------------------------------

- IAM - Identity and Access Management
- ABAC - Attribute Based Access Control
- Social login: Facebook, Google, VK, LinkedIn, GitHub, Live, Yandex
- Full activity logging with searching and reporting


[![Latest Stable Version](https://poser.pugx.org/hiqdev/hiam-core/v/stable.png)](https://packagist.org/packages/hiqdev/hiam-core)
[![Total Downloads](https://poser.pugx.org/hiqdev/hiam-core/downloads.png)](https://packagist.org/packages/hiqdev/hiam-core)

## Installation

The preferred way to install this yii2-extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require "hiqdev/hiam-core"
```

or add

```json
"hiqdev/hiam-core": "*"
```

to the require section of your composer.json.

## Configuration

Configure at your project''s frontend/config/params_local.php

```php
return [
    'op'    => 'value',
];
```

## Licence

[BSD-3-Clause](http://choosealicense.com/licenses/bsd-3-clause)

Copyright © 2014-2015, HiQDev (https://hiqdev.com/)
