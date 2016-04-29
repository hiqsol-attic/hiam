HIAM
====

**Identity and Access Management server providing OAuth2, RBAC and logging**

[![Latest Stable Version](https://poser.pugx.org/hiqdev/hiam-core/v/stable)](https://packagist.org/packages/hiqdev/hiam-core)
[![Total Downloads](https://poser.pugx.org/hiqdev/hiam-core/downloads)](https://packagist.org/packages/hiqdev/hiam-core)
[![Build Status](https://img.shields.io/travis/hiqdev/hiam-core.svg)](https://travis-ci.org/hiqdev/hiam-core)
[![Scrutinizer Code Coverage](https://img.shields.io/scrutinizer/coverage/g/hiqdev/hiam-core.svg)](https://scrutinizer-ci.com/g/hiqdev/hiam-core/)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/hiqdev/hiam-core.svg)](https://scrutinizer-ci.com/g/hiqdev/hiam-core/)
[![Dependency Status](https://www.versioneye.com/php/hiqdev:hiam-core/dev-master/badge.svg)](https://www.versioneye.com/php/hiqdev:hiam-core/dev-master)

HIAM is Identity and Access Management server.

Provides:

- OAuth2 server
- RBAC - Role Based Access Control
- Social login: Facebook, Google, VK, LinkedIn, GitHub, Live, Yandex
- Full activity logging with searching and reporting

For the moment it is in earyly stage of development.

Based on:

- yiisoft/yii2
- bshaffer/oauth2-server-php

## Installation

The preferred way to install this yii2-extension is through [composer](http://getcomposer.org/download/).

Either run

```sh
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

## License

This project is released under the terms of the BSD-3-Clause [license](LICENSE).
Read more [here](http://choosealicense.com/licenses/bsd-3-clause).

Copyright © 2014-2016, HiQDev (http://hiqdev.com/)
