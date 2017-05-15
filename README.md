# HIAM

**Identity and Access Management server providing OAuth2, multi-factor authentication and more**

[![Latest Stable Version](https://poser.pugx.org/hiqdev/hiam/v/stable)](https://packagist.org/packages/hiqdev/hiam)
[![Total Downloads](https://poser.pugx.org/hiqdev/hiam/downloads)](https://packagist.org/packages/hiqdev/hiam)
[![Build Status](https://img.shields.io/travis/hiqdev/hiam.svg)](https://travis-ci.org/hiqdev/hiam)
[![Scrutinizer Code Coverage](https://img.shields.io/scrutinizer/coverage/g/hiqdev/hiam.svg)](https://scrutinizer-ci.com/g/hiqdev/hiam/)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/hiqdev/hiam.svg)](https://scrutinizer-ci.com/g/hiqdev/hiam/)
[![Dependency Status](https://www.versioneye.com/php/hiqdev:hiam/dev-master/badge.svg)](https://www.versioneye.com/php/hiqdev:hiam/dev-master)

HIAM is Identity and Access Management server.

Provides:

- Login, registration, email confirmation, password restore
- [OAuth2] server
- [multi-factor authentication] with:
    - Google Authenticator compatible [TOTP]
    - limited access from user allowed IPs only
- Social login with Facebook, Google, VK, LinkedIn, GitHub, Live, Yandex
- [RBAC] - Role Based Access Control
- Full activity logging with searching and reporting (planned)

Based on:

- [yiisoft/yii2] - Yii2 PHP framework
- [yiisoft/yii2-authclient] - social login
- [bshaffer/oauth2-server-php] - OAuth2 server
- [hiqdev/yii2-mfa] - multi-factor authentication
- [hiqdev/php-confirmator] - confirmation tokens

[OAuth2]:                       https://oauth.net/2/
[multi-factor authentication]:  https://en.wikipedia.org/wiki/Multi-factor_authentication
[TOTP]:                         https://en.wikipedia.org/wiki/Time-based_One-time_Password_Algorithm
[RBAC]:                         https://en.wikipedia.org/wiki/Role-based_access_control
[yiisoft/yii2]:                 https://github.com/yiisoft/yii2
[yiisoft/yii2-authclient]:      https://github.com/yiisoft/yii2-authclient
[bshaffer/oauth2-server-php]:   https://github.com/bshaffer/oauth2-server-php
[hiqdev/yii2-mfa]:              https://github.com/hiqdev/yii2-mfa
[hiqdev/php-confirmator]:       https://github.com/hiqdev/php-confirmator

## Installation

The preferred way to install this yii2-extension is through [composer](http://getcomposer.org/download/).

Either run

```sh
php composer.phar require "hiqdev/hiam"
```

or add

```json
"hiqdev/hiam": "*"
```

to the require section of your composer.json.

## License

This project is released under the terms of the BSD-3-Clause [license](LICENSE).
Read more [here](http://choosealicense.com/licenses/bsd-3-clause).

Copyright © 2014-2017, HiQDev (http://hiqdev.com/)
