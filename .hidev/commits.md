hiqdev/hiam-core commits history
--------------------------------

## 0.0.2 Under development

- Changed: redone pictonic with use of with yii2-asset-pictonic
    - 8c1a440 2015-09-28 + require yii2-asset-pictonic (sol@hiqdev.com)
- Removed templates to yii2-theme-adminlte
    - 7ddb9b0 2015-09-28 renamed recovery to request-password-reset to be yii2 canonical (sol@hiqdev.com)
    - 05148ae 2015-09-28 all templates moved to yii2-theme-adminlte (sol@hiqdev.com)
    - 878ebdb 2015-09-28 + STATUS consts (sol@hiqdev.com)
    - 843a31b 2015-09-28 templates for error, requestPasswordResetToken and resetPassword moved to yii2-theme-adminlte (sol@hiqdev.com)
    - e17d7c5 2015-09-28 removed remoteProceed: not needed anymore (sol@hiqdev.com)
    - 390b8e0 2015-09-28 moved confirm to yii2-theme-adminlte (sol@hiqdev.com)
    - 5333f83 2015-09-28 removed contact: no contact page for HIAM, should be redirection to parent site (sol@hiqdev.com)
    - 403adf0 2015-09-28 removed junk old-signup (sol@hiqdev.com)
    - 30cf4af 2015-09-28 removed index: no index page for HIAM (sol@hiqdev.com)
    - d9a0284 2015-09-28 redone about: made more shy (sol@hiqdev.com)
    - ca89463 2015-09-27 + basic about page (sol@hiqdev.com)
    - db32fa1 2015-09-27 ~ signup page template moved to yii2-theme-adminlte (sol@hiqdev.com)
- Changed DB dsn to connect locally
    - 440b7c5 2015-09-25 * DB dsn: - host & port to connect locally (sol@hiqdev.com)
- Fixed attributes() at User model
    - eac80d8 2015-09-05 fixed User attributes() (sol@hiqdev.com)
- Fixed LoginForm to get user with configured identityClass
    - 915b59b 2015-09-03 fixed LoginForm to get user with configured identityClass (sol@hiqdev.com)
- Fixed ./yii to work, migration got working
    - 91807d3 2015-09-03 fixed ./yii to work (sol@hiqdev.com)
    - 7ad0852 2015-09-03 removed console/runtime (sol@hiqdev.com)
- Changed configuring
    - 6facf19 2015-09-01 fixed cookieValidationKey configuring for request (sol@hiqdev.com)
    - ea81c9e 2015-09-01 improved environments (sol@hiqdev.com)
    - d5915f2 2015-09-01 + cookieValidationKey param at common/config/main.php (sol@hiqdev.com)
- Removed WindowsLive login
    - 11e9923 2015-08-25 disabled windows live login (sol@hiqdev.com)
- Changed: renamed table hi3a_remote_user -> hiam_remote_user
    - 1d8fadd 2015-08-25 renamed hi3a_remote_user -> hiam_remote_user (sol@hiqdev.com)
- Fixed requires
    - 4c55df6 2015-08-25 - require cebe/yii2-gravatar and bower-asset/admin-lte (sol@hiqdev.com)
- Added use of yii2-asset-icheck
    - fad6a51 2015-08-25 + used yii2-asset-icheck (sol@hiqdev.com)
- Added use of plugin/theme/menu managers
    - c990aed 2015-08-22 + use of plugin/theme/menuManagers (sol@hiqdev.com)
    - 769fefa 2015-08-22 + poweredByName/Url params (sol@hiqdev.com)
- Changed to yii2-extension
    - 8019689 2015-08-22 fixed to yii2-extension (sol@hiqdev.com)
    - bf79d47 2015-08-22 + Plugin.php with version finding (sol@hiqdev.com)
- Fixed assets and theme
    - 541a18c 2015-08-21 fixed AppAsset (sol@hiqdev.com)
    - 83e2bc1 2015-08-21 + require hiqdev/yii2-theme-adminlte (sol@hiqdev.com)
- Changed: renamed to hiam-core, moved to src and turned to yii2-extension
    - 29db7fa 2015-08-21 improved configs (sol@hiqdev.com)
    - 4d2bb96 2015-08-21 + basically working (sol@hiqdev.com)
    - e1ff7a1 2015-08-21 renamed to hiam-core (sol@hiqdev.com)
    - fe0bc44 2015-08-21 renamed to hiam-core (sol@hiqdev.com)
    - 0250205 2015-08-20 fixed namespace (sol@hiqdev.com)
    - aa9e0b6 2015-08-20 * init: added  parameter (sol@hiqdev.com)
    - 061457a 2015-08-20 moved to src (sol@hiqdev.com)
    - d2841a0 2015-08-20 turned to yii2-extension (sol@hiqdev.com)
- Fixed google social button
    - 085b676 2015-08-17 fixed google social button, simplified buttonOptions (sol@hiqdev.com)
- Fixed: small fixes for production
    - f7758c1 2015-08-15 + require-dev (sol@hiqdev.com)
    - ebd104b 2015-08-15 preparing for production (sol@hiqdev.com)
    - 36be032 2015-08-08 + .php_cs (sol@hiqdev.com)
- Changed: renamed to hiam
    - d355b05 2015-08-27 fixed common\models\User to hiam\common\models\User (sol@hiqdev.com)
    - a5b4f43 2015-08-10 still renaming to hiam (sol@hiqdev.com)
    - 6306a57 2015-08-02 - require-dev and user hiqdev/yii2-hiam-authclient (sol@hiqdev.com)
    - 0b15b69 2015-08-02 + roadmap (sol@hiqdev.com)
    - 3414550 2015-08-02 * README: deprecated (sol@hiqdev.com)
    - b39c135 2015-08-02 renaming to hiam (sol@hiqdev.com)
    - b3fe9f1 2015-08-01 hideved (sol@hiqdev.com)
    - 1808803 2015-07-16 fixed migration for hi3a_remote_user table (sol@hiqdev.com)
    - 628f67e 2015-04-19 doc (sol@hiqdev.com)

## 0.0.1-alpha 2015-04-19

- Added social login
    - 0db89ac 2015-04-19 preparing 0.0.1-alpha (sol@hiqdev.com)
    - 247fcae 2015-04-17 Add PictonicAsset, do social button on login page (andreyklochok@gmail.com)
    - 74bc4b5 2015-04-17 doc (sol@hiqdev.com)
    - 86520da 2015-04-17 doc (sol@hiqdev.com)
    - 9e6f3fd 2015-04-17 doc (sol@hiqdev.com)
    - 8613a09 2015-04-17 finishing social login (sol@hiqdev.com)
- Added basic functional
    - 76b2d5c 2015-04-08 * composer.json a bit (sol@hiqdev.com)
    - 10463ca 2015-04-08 Update README (sol@hiqdev.com)
    - 1f59733 2015-04-08 * README and LICENSE (sol@hiqdev.com)
    - ab1d649 2015-04-08 GREAT moved back to filsh/oauth2 (sol@hiqdev.com)
    - 4f92e46 2015-04-07 simplified sql (sol@hiqdev.com)
    - 91300e1 2015-04-03 proper link at footer (sol@hiqdev.com)
    - 7c54f96 2015-04-03 * lockscreen (sol@hiqdev.com)
    - 956e3e9 2015-04-03 * logout: + back (sol@hiqdev.com)
    - 44c60c5 2015-04-03 fixed MyRequest (sol@hiqdev.com)
    - 53c47d8 2015-04-02 SiteController access fix (andreyklochok@gmail.com)
    - 58b828b 2015-04-01 Fix CSS in Login Page (andreyklochok@gmail.com)
    - e0d4672 2015-04-01 Fix redirect loop (andreyklochok@gmail.com)
    - 7801725 2015-04-01 Fix login (andreyklochok@gmail.com)
    - dfa96bc 2015-04-01 Do real form in login (andreyklochok@gmail.com)
    - f52280e 2015-04-01 Switch to AdminLTE (andreyklochok@gmail.com)
    - 57ba75c 2015-04-01 + some rbac not finished (sol@hiqdev.com)

## v0.1.0 2014-12-13

- Added: inited
    - 96ca12f 2014-12-13 INITED (andrii.vasyliev@gmail.com)

## Development started 2014-12-13

