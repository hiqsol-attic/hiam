hiqdev/hiam-core
----------------

## [Under development]

- Added email confirmation
    - [8b1bd8b] 2016-12-13 + proper flashes at registration [sol@hiqdev.com]
    - [a745b52] 2016-12-13 csfixed [sol@hiqdev.com]
    - [80911a9] 2016-12-13 translation [sol@hiqdev.com]
    - [ba78ce9] 2016-12-13 + return back after email confirmation [sol@hiqdev.com]
    - [a6a57e9] 2016-12-13 added email confirmation [sol@hiqdev.com]
    - [ab852e5] 2016-12-12 + Identity::findActive to find find only active users if needed [sol@hiqdev.com]
    - [5af3245] 2016-12-08 Added new validation message for email check [andreyklochok@gmail.com]
    - [f123cc2] 2016-12-12 removed local Application [sol@hiqdev.com]
    - [0ea7251] 2016-11-19 + own Application with setDefinitions() [sol@hiqdev.com]
- Removed all assets to theme
    - [7959faf] 2016-11-04 Removed all assets [andreyklochok@gmail.com]

## [0.0.3] - 2016-10-27

- Fixed restore password
    - [c7ec8ef] 2016-10-27 improved description [sol@hiqdev.com]
    - [4f693e1] 2016-10-27 finished restore/reset password [sol@hiqdev.com]
- Added translation to russian
    - [d53afc0] 2016-10-27 csfixed [sol@hiqdev.com]
    - [7482f9a] 2016-10-25 csfixed [sol@hiqdev.com]
    - [4359d09] 2016-10-25 translations [sol@hiqdev.com]
    - [bda5e2b] 2016-10-25 added translations [sol@hiqdev.com]
    - [aecdaaa] 2016-10-25 added all views, moved from hisite-core [sol@hiqdev.com]
    - [7004f83] 2016-10-25 changed mail rendering, used main View instead of mail own, moved mailer config to hisite-core [sol@hiqdev.com]
    - [3a78c72] 2016-10-24 moved mail templates to views/mail and added translations [sol@hiqdev.com]
    - [919cbd3] 2016-10-24 adding translations [sol@hiqdev.com]
    - [d6189ab] 2016-10-24 added language bootstrapping [sol@hiqdev.com]
- Changed: redone with use of `hiqdev/yii2-mfa`
    - [e066369] 2016-10-24 preparing release [sol@hiqdev.com]
    - [d437448] 2016-10-22 moved notAllowedIp view to yii2-mfa [sol@hiqdev.com]
    - [8589bce] 2016-10-22 enabling debug [sol@hiqdev.com]
    - [2b643b5] 2016-10-22 inlined callbacks in SiteController [sol@hiqdev.com]
    - [1f8b5cb] 2016-10-22 added and used getUser in SiteController [sol@hiqdev.com]
    - [d1c1325] 2016-10-22 used ValidateAction for signup-validate action [sol@hiqdev.com]
    - [7cfbd11] 2016-10-22 removed Mailer, sendToken -> confirmator mailToken, moved totp and allowed ips checking to yii2-mfa [sol@hiqdev.com]
    - [ceb33a6] 2016-10-21 redoing yii2-totp to yii2-mfa [sol@hiqdev.com]
    - [bd4ff1c] 2016-10-21 added TOTP validation [sol@hiqdev.com]
    - [f1c9b95] 2016-10-21 Changed footer-copyright css styled, removed position absolute [andreyklochok@gmail.com]
    - [f61ebb3] 2016-10-19 + require `yii2-totp` [sol@hiqdev.com]
- Added use of `hidev/php-confirmator` for confirmation tokens
    - [fc5b59f] 2016-10-13 used confirmator for restore password token [sol@hiqdev.com]
- Changed: redone to be generally usable
    - [29dd03f] 2016-10-19 removed unused ContactForm [sol@hiqdev.com]
    - [513254c] 2016-10-19 csfixed [sol@hiqdev.com]
    - [2ddd559] 2016-10-19 fixed tests [sol@hiqdev.com]
    - [5e12dc1] 2016-10-19 moved signup() to user component from SignupForm [sol@hiqdev.com]
    - [d312c8a] 2016-10-19 added allowed ip validation and adding [sol@hiqdev.com]
    - [70c23f6] 2016-10-19 improved about page [sol@hiqdev.com]
    - [4bce645] 2016-10-19 + debug config [sol@hiqdev.com]
    - [9c6a2b2] 2016-10-19 + Mailer with sendToken, used in RestorePasswordForm, renamed passwordResetToken -> restorePasswordToken for consistency [sol@hiqdev.com]
    - [91eb95b] 2016-10-19 + getName to Identity [sol@hiqdev.com]
    - [fe83efc] 2016-10-18 fixed HiamRemoteUser with added rules [sol@hiqdev.com]
    - [67db162] 2016-10-18 removed last seller mentions [sol@hiqdev.com]
    - [b7df6f1] 2016-10-18 moved ProxyModel to models [sol@hiqdev.com]
    - [6271789] 2016-10-18 splitted out forms from models [sol@hiqdev.com]
    - [c8932ef] 2016-10-18 redone confirm -> confirmPassword, added confirmPasswordForm [sol@hiqdev.com]
    - [f6e67b0] 2016-10-18 improved readme [sol@hiqdev.com]
    - [8a46dc8] 2016-10-18 added default identity storage class HiamIdentity, removed mrdp specific storage classes [sol@hiqdev.com]
    - [3709de8] 2016-10-18 redone with ProxyModel [sol@hiqdev.com]
    - [b14dc25] 2016-10-17 + `seller_id` to ClientQuery [sol@hiqdev.com]
    - [78ddd05] 2016-10-17 removed name, added `first_name` and `last_name`, returned back seller [sol@hiqdev.com]
    - [9c53efa] 2016-10-17 removed `seller/_id` from Identity [sol@hiqdev.com]
    - [8b0b9bb] 2016-10-17 fixed rememberMe -> `remember_me` [sol@hiqdev.com]
    - [c15c0bf] 2016-10-17 + `site/terms` action [sol@hiqdev.com]
    - [02f4b9b] 2016-10-17 renamed findByEmail -> findIdentityByEmail [sol@hiqdev.com]
    - [dfe5dd3] 2016-10-17 refactored findIdentity -> findIdentityByToken in OauthController, added returning token in `oauth/resource` action, fixed typo in isAuthorizedClient [sol@hiqdev.com]
    - [f8bbc50] 2016-10-14 require `robthree/twofactorauth` instead of phpgangsta [sol@hiqdev.com]
    - [a8968a7] 2016-10-14 + require `phpgangsta/googleauthenticator` for two factor authorization [sol@hiqdev.com]
    - [28f0ec6] 2016-10-14 added attributeLabels to forms [sol@hiqdev.com]
    - [1b28077] 2016-10-13 simplified login and reset-password actions [sol@hiqdev.com]
    - [b1345f7] 2016-10-12 + require `hiqdev/php-confirmator` [sol@hiqdev.com]
    - [13eea6d] 2016-10-11 reorganized RemoteUser [sol@hiqdev.com]
    - [09daf33] 2016-10-11 added basic RemoteUser tests [sol@hiqdev.com]
    - [b33555f] 2016-10-11 + tests namespace [sol@hiqdev.com]
    - [6fd1972] 2016-10-10 renamed request password reset -> restore password [sol@hiqdev.com]
    - [66db0bd] 2016-10-10 renamed disallowSignup/RestorePassword -> disable [sol@hiqdev.com]
    - [f0e290e] 2016-10-10 simplified LoginForm, moved logic to controller [sol@hiqdev.com]
    - [b40c8f0] 2016-10-10 improved use of findIdentity [sol@hiqdev.com]
    - [9b8923f] 2016-10-09 added disallowSignup and disallowRestorePassword [sol@hiqdev.com]
    - [b15d117] 2016-10-08 added disallowSignup config option [sol@hiqdev.com]
    - [b6d93fa] 2016-10-07 + check access for restore-password if available [sol@hiqdev.com]
    - [e2dc3d2] 2016-10-06 fixed sending password reset token mail [sol@hiqdev.com]
    - [7fe9d03] 2016-10-06 enabled mailing [sol@hiqdev.com]
    - [148be43] 2016-10-06 fixed signup again [sol@hiqdev.com]
    - [3e4793b] 2016-10-05 added translations [sol@hiqdev.com]
    - [b146af5] 2016-10-05 separated models and storage [sol@hiqdev.com]
    - [77d4861] 2016-10-04 renamed findUser -> findIdentity [sol@hiqdev.com]
    - [6a9ff3c] 2016-10-04 renamed back role -> type [sol@hiqdev.com]
    - [d14e5a2] 2016-10-04 fixed signup [sol@hiqdev.com]
    - [28f36e1] 2016-10-04 improved UserQuery with andWhere [sol@hiqdev.com]
    - [041ed81] 2016-10-04 BIG redone of User with UserQuery, removed login, `seller_id`, `type_id`, `state_id` [sol@hiqdev.com]
    - [3d5f5aa] 2016-10-04 used User::findByEmail [sol@hiqdev.com]
    - [4f8b6a7] 2016-10-04 fixed RemoteUser::set [sol@hiqdev.com]
    - [e90b3a4] 2016-10-03 used ClientInterface [sol@hiqdev.com]
    - [e79cd05] 2016-10-03 removed authManager [sol@hiqdev.com]
    - [f183798] 2016-10-03 removed old junk [sol@hiqdev.com]
    - [0829300] 2016-09-28 yii don't follow semver [sol@hiqdev.com]
    - [7497d69] 2016-09-28 + require `hiqdev/yii2-pnotify` [sol@hiqdev.com]
    - [0031ade] 2016-09-28 + empty scope for GitHub oauth to require only read-only access [sol@hiqdev.com]
    - [559b5f5] 2016-09-28 added catching exception from getUserAttributes [sol@hiqdev.com]
    - [888f43e] 2016-09-21 simplified SiteController, extended from hisite [sol@hiqdev.com]
    - [d90276b] 2016-09-19 + enforce state for oauth2 [sol@hiqdev.com]
    - [398956a] 2016-09-20 Added footer-copyright class to css [andreyklochok@gmail.com]
    - [38a60b8] 2016-09-15 used filsh/yii2-oauth2-server version 2.0.1.x-dev@dev [sol@hiqdev.com]
    - [5e28cc4] 2016-09-15 fixed typo [sol@hiqdev.com]
    - [1870e4b] 2016-09-15 fixed requirements constraint for filsh/yii2-oauth2-server [sol@hiqdev.com]
    - [c4f1143] 2016-09-15 added hiam.authorizedClients param option [sol@hiqdev.com]
    - [6f259df] 2016-09-14 removed Alert widget [sol@hiqdev.com]
    - [7f29249] 2016-09-03 redone bumping with `chkipper` [sol@hiqdev.com]
- Changed: redone to hisite
    - [49b442c] 2016-09-03 used empty <- isset [sol@hiqdev.com]
    - [c2333ce] 2016-09-03 used empty instead of isset [sol@hiqdev.com]
    - [f838876] 2016-09-03 + gitignore web and web configs [sol@hiqdev.com]
    - [3b86e44] 2016-09-02 splitted out authClients config [sol@hiqdev.com]
    - [7919df4] 2016-09-02 organized Asset [sol@hiqdev.com]
    - [606985e] 2016-09-02 removed junk [sol@hiqdev.com]
    - [dfd1c87] 2016-09-01 fixing config [sol@hiqdev.com]
    - [486b2e7] 2016-09-01 fixing dependencies, started redoing to hisite [sol@hiqdev.com]
    - [fdd4899] 2016-07-29 added more auth clients [sol@hiqdev.com]
- Fixed signup and password reminding
    - [c2bf0ad] 2016-07-29 Fixed SiteController::doLogin() to reset password instad of username [d.naumenko.a@gmail.com]
    - [4ff5d91] 2016-05-30 + signup validation action [sol@hiqdev.com]
    - [e707293] 2016-05-25 added passing username throughout forms [sol@hiqdev.com]
    - [3f30a02] 2016-05-23 fixed PHP requirement [sol@hiqdev.com]
    - [4797571] 2016-05-23 csfixed [sol@hiqdev.com]
    - [2784d5d] 2016-05-23 added default params [sol@hiqdev.com]
    - [5726976] 2016-05-23 fixed password reminding [sol@hiqdev.com]
    - [06c4381] 2016-05-23 fixed signup [sol@hiqdev.com]
    - [bbdb826] 2016-05-23 extended configuration [sol@hiqdev.com]
    - [e233333] 2016-05-23 required yii2-debug [sol@hiqdev.com]
- Changed: redone with composer-config-plugin
    - [018f704] 2016-05-20 redone `common` to plain dirs [sol@hiqdev.com]
    - [9d850fb] 2016-05-19 fixing config assembling [sol@hiqdev.com]
    - [a61096f] 2016-05-19 added vds.spicyhost.com to the list of authorized oauth clients [sol@hiqdev.com]
    - [0d5db63] 2016-05-19 fixing config assembling [sol@hiqdev.com]
    - [ca9b736] 2016-05-19 redoing to composer-config-plugin [sol@hiqdev.com]
    - [1015cc9] 2016-05-17 csfixed [sol@hiqdev.com]
    - [ce4d60f] 2016-05-17 removed OLD [sol@hiqdev.com]
    - [b80e0a7] 2016-05-17 removed non actual codeception tests [sol@hiqdev.com]
    - [b4924bf] 2016-05-17 csfixed [sol@hiqdev.com]
    - [5847f95] 2016-05-17 improved hisite config and added hidev config [sol@hiqdev.com]
    - [4f2111f] 2016-05-17 removed old style files: environments, requirements.php [sol@hiqdev.com]

## [0.0.2] - 2016-05-04

- Changed: redone to `hisite` style
    - [9a74e63] 2016-05-04 used bootstrapped aliases: @root, @hisite, @vendor [sol@hiqdev.com]
    - [d135511] 2016-04-29 inited tests [sol@hiqdev.com]
    - [32ff0fe] 2016-04-29 redone with local hidev and plugins [sol@hiqdev.com]
    - [41e9d8c] 2016-04-29 redone `extension-config.php` to `hisite-config.php` [sol@hiqdev.com]
    - [283674d] 2016-03-30 removed unused files [sol@hiqdev.com]
    - [cd75600] 2016-03-30 removed unused files [sol@hiqdev.com]
    - [ec9f62a] 2016-03-30 redoing to `extension-config` <- `yii2-extraconfig` [sol@hiqdev.com]
    - [e96c55b] 2016-03-21 fixed `dirname` php5 compatibility [sol@hiqdev.com]
    - [6c2d255] 2016-03-21 fixed `dirname` php5 compatibility [sol@hiqdev.com]
    - [7a8ac30] 2016-03-20 rehideved [sol@hiqdev.com]
    - [180d39d] 2016-03-19 fixed to show login page [sol@hiqdev.com]
    - [bea1ec8] 2016-02-29 simplifying extra config [sol@hiqdev.com]
    - [93d2d52] 2016-02-29 - use of `YII_DEBUG` constant in extra config [sol@hiqdev.com]
    - [3204b25] 2016-02-29 - use of `@vendor` [sol@hiqdev.com]
    - [755d2e5] 2016-02-25 - params from extra config [sol@hiqdev.com]
    - [c9522f4] 2016-02-25 - web/Request [sol@hiqdev.com]
    - [323153c] 2016-02-25 + yii2-extraconfig [sol@hiqdev.com]
    - [3fbabc1] 2016-02-25 great renaming NOT FINISHED [sol@hiqdev.com]
    - [69c4b9a] 2016-02-25 removed pictonic files [sol@hiqdev.com]
    - [a136ee9] 2016-02-25 removed pictonic files [sol@hiqdev.com]
    - [ebfd4e9] 2016-02-20 trying minii [sol@hiqdev.com]
    - [827a904] 2016-02-20 trying [sol@hiqdev.com]
    - [19ca189] 2016-02-17 + `name` attribute to User model [sol@hiqdev.com]
    - [b7b57dc] 2016-02-17 + seller to User model [sol@hiqdev.com]
    - [f8e3b49] 2016-02-17 changed filsh/yii2-oauth2-server require version to * [sol@hiqdev.com]
- Removed templates to yii2-theme-adminlte
    - [c5b0379] 2015-09-30 adding password reset not finished [sol@hiqdev.com]
    - [71a8633] 2015-09-28 - require yii2-asset-pictonic [sol@hiqdev.com]
    - [8c1a440] 2015-09-28 + require yii2-asset-pictonic [sol@hiqdev.com]
    - [7ddb9b0] 2015-09-28 renamed recovery to request-password-reset to be yii2 canonical [sol@hiqdev.com]
    - [05148ae] 2015-09-28 all templates moved to yii2-theme-adminlte [sol@hiqdev.com]
    - [878ebdb] 2015-09-28 + STATUS consts [sol@hiqdev.com]
    - [843a31b] 2015-09-28 templates for error, requestPasswordResetToken and resetPassword moved to yii2-theme-adminlte [sol@hiqdev.com]
    - [e17d7c5] 2015-09-28 removed remoteProceed: not needed anymore [sol@hiqdev.com]
    - [390b8e0] 2015-09-28 moved confirm to yii2-theme-adminlte [sol@hiqdev.com]
    - [5333f83] 2015-09-28 removed contact: no contact page for HIAM, should be redirection to parent site [sol@hiqdev.com]
    - [403adf0] 2015-09-28 removed junk old-signup [sol@hiqdev.com]
    - [30cf4af] 2015-09-28 removed index: no index page for HIAM [sol@hiqdev.com]
    - [d9a0284] 2015-09-28 redone about: made more shy [sol@hiqdev.com]
    - [ca89463] 2015-09-27 + basic about page [sol@hiqdev.com]
    - [db32fa1] 2015-09-27 ~ signup page template moved to yii2-theme-adminlte [sol@hiqdev.com]
- Changed DB dsn to connect locally
    - [440b7c5] 2015-09-25 * DB dsn: - host & port to connect locally [sol@hiqdev.com]
- Fixed attributes() at User model
    - [eac80d8] 2015-09-05 fixed User attributes() [sol@hiqdev.com]
- Fixed LoginForm to get user with configured identityClass
    - [915b59b] 2015-09-03 fixed LoginForm to get user with configured identityClass [sol@hiqdev.com]
- Fixed ./yii to work, migration got working
    - [91807d3] 2015-09-03 fixed ./yii to work [sol@hiqdev.com]
    - [7ad0852] 2015-09-03 removed console/runtime [sol@hiqdev.com]
- Changed configuring
    - [6facf19] 2015-09-01 fixed cookieValidationKey configuring for request [sol@hiqdev.com]
    - [ea81c9e] 2015-09-01 improved environments [sol@hiqdev.com]
    - [d5915f2] 2015-09-01 + cookieValidationKey param at common/config/main.php [sol@hiqdev.com]
- Removed WindowsLive login
    - [11e9923] 2015-08-25 disabled windows live login [sol@hiqdev.com]
- Changed: renamed table `hi3a_remote_user` -> `hiam_remote_user`
    - [1d8fadd] 2015-08-25 renamed `hi3a_remote_user` -> `hiam_remote_user` [sol@hiqdev.com]
- Fixed requires
    - [4c55df6] 2015-08-25 - require cebe/yii2-gravatar and bower-asset/admin-lte [sol@hiqdev.com]
- Added use of yii2-asset-icheck
    - [fad6a51] 2015-08-25 + used yii2-asset-icheck [sol@hiqdev.com]
- Added use of plugin/theme/menu managers
    - [c990aed] 2015-08-22 + use of plugin/theme/menuManagers [sol@hiqdev.com]
    - [769fefa] 2015-08-22 + poweredByName/Url params [sol@hiqdev.com]
- Changed to yii2-extension
    - [8019689] 2015-08-22 fixed to yii2-extension [sol@hiqdev.com]
    - [bf79d47] 2015-08-22 + Plugin.php with version finding [sol@hiqdev.com]
- Fixed assets and theme
    - [541a18c] 2015-08-21 fixed AppAsset [sol@hiqdev.com]
    - [83e2bc1] 2015-08-21 + require hiqdev/yii2-theme-adminlte [sol@hiqdev.com]
- Changed: renamed to hiam-core, moved to src and turned to yii2-extension
    - [29db7fa] 2015-08-21 improved configs [sol@hiqdev.com]
    - [4d2bb96] 2015-08-21 + basically working [sol@hiqdev.com]
    - [e1ff7a1] 2015-08-21 renamed to hiam-core [sol@hiqdev.com]
    - [fe0bc44] 2015-08-21 renamed to hiam-core [sol@hiqdev.com]
    - [0250205] 2015-08-20 fixed namespace [sol@hiqdev.com]
    - [aa9e0b6] 2015-08-20 * init: added  parameter [sol@hiqdev.com]
    - [061457a] 2015-08-20 moved to src [sol@hiqdev.com]
    - [d2841a0] 2015-08-20 turned to yii2-extension [sol@hiqdev.com]
- Fixed google social button
    - [085b676] 2015-08-17 fixed google social button, simplified buttonOptions [sol@hiqdev.com]
- Fixed: small fixes for production
    - [f7758c1] 2015-08-15 + require-dev [sol@hiqdev.com]
    - [ebd104b] 2015-08-15 preparing for production [sol@hiqdev.com]
    - [36be032] 2015-08-08 + `.php_cs` [sol@hiqdev.com]
- Changed: renamed to hiam
    - [d355b05] 2015-08-27 fixed common\models\User to hiam\common\models\User [sol@hiqdev.com]
    - [a5b4f43] 2015-08-10 still renaming to hiam [sol@hiqdev.com]
    - [6306a57] 2015-08-02 - require-dev and user hiqdev/yii2-hiam-authclient [sol@hiqdev.com]
    - [0b15b69] 2015-08-02 + roadmap [sol@hiqdev.com]
    - [3414550] 2015-08-02 * README: deprecated [sol@hiqdev.com]
    - [b39c135] 2015-08-02 renaming to hiam [sol@hiqdev.com]
    - [b3fe9f1] 2015-08-01 hideved [sol@hiqdev.com]
    - [1808803] 2015-07-16 fixed migration for `hi3a_remote_user` table [sol@hiqdev.com]
    - [628f67e] 2015-04-19 doc [sol@hiqdev.com]

## [0.0.1-alpha] - 2015-04-19

- Added social login
    - [0db89ac] 2015-04-19 preparing 0.0.1-alpha [sol@hiqdev.com]
    - [247fcae] 2015-04-17 Add PictonicAsset, do social button on login page [andreyklochok@gmail.com]
    - [74bc4b5] 2015-04-17 doc [sol@hiqdev.com]
    - [86520da] 2015-04-17 doc [sol@hiqdev.com]
    - [9e6f3fd] 2015-04-17 doc [sol@hiqdev.com]
    - [8613a09] 2015-04-17 finishing social login [sol@hiqdev.com]
- Added basic functional
    - [76b2d5c] 2015-04-08 * composer.json a bit [sol@hiqdev.com]
    - [10463ca] 2015-04-08 Update README [sol@hiqdev.com]
    - [1f59733] 2015-04-08 * README and LICENSE [sol@hiqdev.com]
    - [ab1d649] 2015-04-08 GREAT moved back to filsh/oauth2 [sol@hiqdev.com]
    - [4f92e46] 2015-04-07 simplified sql [sol@hiqdev.com]
    - [91300e1] 2015-04-03 proper link at footer [sol@hiqdev.com]
    - [7c54f96] 2015-04-03 * lockscreen [sol@hiqdev.com]
    - [956e3e9] 2015-04-03 * logout: + back [sol@hiqdev.com]
    - [44c60c5] 2015-04-03 fixed MyRequest [sol@hiqdev.com]
    - [53c47d8] 2015-04-02 SiteController access fix [andreyklochok@gmail.com]
    - [58b828b] 2015-04-01 Fix CSS in Login Page [andreyklochok@gmail.com]
    - [e0d4672] 2015-04-01 Fix redirect loop [andreyklochok@gmail.com]
    - [7801725] 2015-04-01 Fix login [andreyklochok@gmail.com]
    - [dfa96bc] 2015-04-01 Do real form in login [andreyklochok@gmail.com]
    - [f52280e] 2015-04-01 Switch to AdminLTE [andreyklochok@gmail.com]
    - [57ba75c] 2015-04-01 + some rbac not finished [sol@hiqdev.com]
    - [96ca12f] 2014-12-13 INITED [andrii.vasyliev@gmail.com]

## [Development started] - 2014-12-13

[e707293]: https://github.com/hiqdev/hiam-core/commit/e707293
[3f30a02]: https://github.com/hiqdev/hiam-core/commit/3f30a02
[4797571]: https://github.com/hiqdev/hiam-core/commit/4797571
[2784d5d]: https://github.com/hiqdev/hiam-core/commit/2784d5d
[5726976]: https://github.com/hiqdev/hiam-core/commit/5726976
[06c4381]: https://github.com/hiqdev/hiam-core/commit/06c4381
[bbdb826]: https://github.com/hiqdev/hiam-core/commit/bbdb826
[e233333]: https://github.com/hiqdev/hiam-core/commit/e233333
[018f704]: https://github.com/hiqdev/hiam-core/commit/018f704
[9d850fb]: https://github.com/hiqdev/hiam-core/commit/9d850fb
[a61096f]: https://github.com/hiqdev/hiam-core/commit/a61096f
[0d5db63]: https://github.com/hiqdev/hiam-core/commit/0d5db63
[ca9b736]: https://github.com/hiqdev/hiam-core/commit/ca9b736
[1015cc9]: https://github.com/hiqdev/hiam-core/commit/1015cc9
[ce4d60f]: https://github.com/hiqdev/hiam-core/commit/ce4d60f
[b80e0a7]: https://github.com/hiqdev/hiam-core/commit/b80e0a7
[b4924bf]: https://github.com/hiqdev/hiam-core/commit/b4924bf
[5847f95]: https://github.com/hiqdev/hiam-core/commit/5847f95
[4f2111f]: https://github.com/hiqdev/hiam-core/commit/4f2111f
[9a74e63]: https://github.com/hiqdev/hiam-core/commit/9a74e63
[d135511]: https://github.com/hiqdev/hiam-core/commit/d135511
[32ff0fe]: https://github.com/hiqdev/hiam-core/commit/32ff0fe
[41e9d8c]: https://github.com/hiqdev/hiam-core/commit/41e9d8c
[283674d]: https://github.com/hiqdev/hiam-core/commit/283674d
[cd75600]: https://github.com/hiqdev/hiam-core/commit/cd75600
[ec9f62a]: https://github.com/hiqdev/hiam-core/commit/ec9f62a
[e96c55b]: https://github.com/hiqdev/hiam-core/commit/e96c55b
[6c2d255]: https://github.com/hiqdev/hiam-core/commit/6c2d255
[7a8ac30]: https://github.com/hiqdev/hiam-core/commit/7a8ac30
[180d39d]: https://github.com/hiqdev/hiam-core/commit/180d39d
[bea1ec8]: https://github.com/hiqdev/hiam-core/commit/bea1ec8
[93d2d52]: https://github.com/hiqdev/hiam-core/commit/93d2d52
[3204b25]: https://github.com/hiqdev/hiam-core/commit/3204b25
[755d2e5]: https://github.com/hiqdev/hiam-core/commit/755d2e5
[c9522f4]: https://github.com/hiqdev/hiam-core/commit/c9522f4
[323153c]: https://github.com/hiqdev/hiam-core/commit/323153c
[3fbabc1]: https://github.com/hiqdev/hiam-core/commit/3fbabc1
[69c4b9a]: https://github.com/hiqdev/hiam-core/commit/69c4b9a
[a136ee9]: https://github.com/hiqdev/hiam-core/commit/a136ee9
[ebfd4e9]: https://github.com/hiqdev/hiam-core/commit/ebfd4e9
[827a904]: https://github.com/hiqdev/hiam-core/commit/827a904
[19ca189]: https://github.com/hiqdev/hiam-core/commit/19ca189
[b7b57dc]: https://github.com/hiqdev/hiam-core/commit/b7b57dc
[f8e3b49]: https://github.com/hiqdev/hiam-core/commit/f8e3b49
[c5b0379]: https://github.com/hiqdev/hiam-core/commit/c5b0379
[71a8633]: https://github.com/hiqdev/hiam-core/commit/71a8633
[8c1a440]: https://github.com/hiqdev/hiam-core/commit/8c1a440
[7ddb9b0]: https://github.com/hiqdev/hiam-core/commit/7ddb9b0
[05148ae]: https://github.com/hiqdev/hiam-core/commit/05148ae
[878ebdb]: https://github.com/hiqdev/hiam-core/commit/878ebdb
[843a31b]: https://github.com/hiqdev/hiam-core/commit/843a31b
[e17d7c5]: https://github.com/hiqdev/hiam-core/commit/e17d7c5
[390b8e0]: https://github.com/hiqdev/hiam-core/commit/390b8e0
[5333f83]: https://github.com/hiqdev/hiam-core/commit/5333f83
[403adf0]: https://github.com/hiqdev/hiam-core/commit/403adf0
[30cf4af]: https://github.com/hiqdev/hiam-core/commit/30cf4af
[d9a0284]: https://github.com/hiqdev/hiam-core/commit/d9a0284
[ca89463]: https://github.com/hiqdev/hiam-core/commit/ca89463
[db32fa1]: https://github.com/hiqdev/hiam-core/commit/db32fa1
[440b7c5]: https://github.com/hiqdev/hiam-core/commit/440b7c5
[eac80d8]: https://github.com/hiqdev/hiam-core/commit/eac80d8
[915b59b]: https://github.com/hiqdev/hiam-core/commit/915b59b
[91807d3]: https://github.com/hiqdev/hiam-core/commit/91807d3
[7ad0852]: https://github.com/hiqdev/hiam-core/commit/7ad0852
[6facf19]: https://github.com/hiqdev/hiam-core/commit/6facf19
[ea81c9e]: https://github.com/hiqdev/hiam-core/commit/ea81c9e
[d5915f2]: https://github.com/hiqdev/hiam-core/commit/d5915f2
[11e9923]: https://github.com/hiqdev/hiam-core/commit/11e9923
[1d8fadd]: https://github.com/hiqdev/hiam-core/commit/1d8fadd
[4c55df6]: https://github.com/hiqdev/hiam-core/commit/4c55df6
[fad6a51]: https://github.com/hiqdev/hiam-core/commit/fad6a51
[c990aed]: https://github.com/hiqdev/hiam-core/commit/c990aed
[769fefa]: https://github.com/hiqdev/hiam-core/commit/769fefa
[8019689]: https://github.com/hiqdev/hiam-core/commit/8019689
[bf79d47]: https://github.com/hiqdev/hiam-core/commit/bf79d47
[541a18c]: https://github.com/hiqdev/hiam-core/commit/541a18c
[83e2bc1]: https://github.com/hiqdev/hiam-core/commit/83e2bc1
[29db7fa]: https://github.com/hiqdev/hiam-core/commit/29db7fa
[4d2bb96]: https://github.com/hiqdev/hiam-core/commit/4d2bb96
[e1ff7a1]: https://github.com/hiqdev/hiam-core/commit/e1ff7a1
[fe0bc44]: https://github.com/hiqdev/hiam-core/commit/fe0bc44
[0250205]: https://github.com/hiqdev/hiam-core/commit/0250205
[aa9e0b6]: https://github.com/hiqdev/hiam-core/commit/aa9e0b6
[061457a]: https://github.com/hiqdev/hiam-core/commit/061457a
[d2841a0]: https://github.com/hiqdev/hiam-core/commit/d2841a0
[085b676]: https://github.com/hiqdev/hiam-core/commit/085b676
[f7758c1]: https://github.com/hiqdev/hiam-core/commit/f7758c1
[ebd104b]: https://github.com/hiqdev/hiam-core/commit/ebd104b
[36be032]: https://github.com/hiqdev/hiam-core/commit/36be032
[d355b05]: https://github.com/hiqdev/hiam-core/commit/d355b05
[a5b4f43]: https://github.com/hiqdev/hiam-core/commit/a5b4f43
[6306a57]: https://github.com/hiqdev/hiam-core/commit/6306a57
[0b15b69]: https://github.com/hiqdev/hiam-core/commit/0b15b69
[3414550]: https://github.com/hiqdev/hiam-core/commit/3414550
[b39c135]: https://github.com/hiqdev/hiam-core/commit/b39c135
[b3fe9f1]: https://github.com/hiqdev/hiam-core/commit/b3fe9f1
[1808803]: https://github.com/hiqdev/hiam-core/commit/1808803
[628f67e]: https://github.com/hiqdev/hiam-core/commit/628f67e
[0db89ac]: https://github.com/hiqdev/hiam-core/commit/0db89ac
[247fcae]: https://github.com/hiqdev/hiam-core/commit/247fcae
[74bc4b5]: https://github.com/hiqdev/hiam-core/commit/74bc4b5
[86520da]: https://github.com/hiqdev/hiam-core/commit/86520da
[9e6f3fd]: https://github.com/hiqdev/hiam-core/commit/9e6f3fd
[8613a09]: https://github.com/hiqdev/hiam-core/commit/8613a09
[76b2d5c]: https://github.com/hiqdev/hiam-core/commit/76b2d5c
[10463ca]: https://github.com/hiqdev/hiam-core/commit/10463ca
[1f59733]: https://github.com/hiqdev/hiam-core/commit/1f59733
[ab1d649]: https://github.com/hiqdev/hiam-core/commit/ab1d649
[4f92e46]: https://github.com/hiqdev/hiam-core/commit/4f92e46
[91300e1]: https://github.com/hiqdev/hiam-core/commit/91300e1
[7c54f96]: https://github.com/hiqdev/hiam-core/commit/7c54f96
[956e3e9]: https://github.com/hiqdev/hiam-core/commit/956e3e9
[44c60c5]: https://github.com/hiqdev/hiam-core/commit/44c60c5
[53c47d8]: https://github.com/hiqdev/hiam-core/commit/53c47d8
[58b828b]: https://github.com/hiqdev/hiam-core/commit/58b828b
[e0d4672]: https://github.com/hiqdev/hiam-core/commit/e0d4672
[7801725]: https://github.com/hiqdev/hiam-core/commit/7801725
[dfa96bc]: https://github.com/hiqdev/hiam-core/commit/dfa96bc
[f52280e]: https://github.com/hiqdev/hiam-core/commit/f52280e
[57ba75c]: https://github.com/hiqdev/hiam-core/commit/57ba75c
[96ca12f]: https://github.com/hiqdev/hiam-core/commit/96ca12f
[49b442c]: https://github.com/hiqdev/hiam-core/commit/49b442c
[c2333ce]: https://github.com/hiqdev/hiam-core/commit/c2333ce
[f838876]: https://github.com/hiqdev/hiam-core/commit/f838876
[3b86e44]: https://github.com/hiqdev/hiam-core/commit/3b86e44
[7919df4]: https://github.com/hiqdev/hiam-core/commit/7919df4
[606985e]: https://github.com/hiqdev/hiam-core/commit/606985e
[dfd1c87]: https://github.com/hiqdev/hiam-core/commit/dfd1c87
[486b2e7]: https://github.com/hiqdev/hiam-core/commit/486b2e7
[fdd4899]: https://github.com/hiqdev/hiam-core/commit/fdd4899
[c2bf0ad]: https://github.com/hiqdev/hiam-core/commit/c2bf0ad
[4ff5d91]: https://github.com/hiqdev/hiam-core/commit/4ff5d91
[d53afc0]: https://github.com/hiqdev/hiam-core/commit/d53afc0
[4f693e1]: https://github.com/hiqdev/hiam-core/commit/4f693e1
[7482f9a]: https://github.com/hiqdev/hiam-core/commit/7482f9a
[4359d09]: https://github.com/hiqdev/hiam-core/commit/4359d09
[bda5e2b]: https://github.com/hiqdev/hiam-core/commit/bda5e2b
[aecdaaa]: https://github.com/hiqdev/hiam-core/commit/aecdaaa
[7004f83]: https://github.com/hiqdev/hiam-core/commit/7004f83
[3a78c72]: https://github.com/hiqdev/hiam-core/commit/3a78c72
[919cbd3]: https://github.com/hiqdev/hiam-core/commit/919cbd3
[d6189ab]: https://github.com/hiqdev/hiam-core/commit/d6189ab
[e066369]: https://github.com/hiqdev/hiam-core/commit/e066369
[d437448]: https://github.com/hiqdev/hiam-core/commit/d437448
[8589bce]: https://github.com/hiqdev/hiam-core/commit/8589bce
[2b643b5]: https://github.com/hiqdev/hiam-core/commit/2b643b5
[1f8b5cb]: https://github.com/hiqdev/hiam-core/commit/1f8b5cb
[d1c1325]: https://github.com/hiqdev/hiam-core/commit/d1c1325
[7cfbd11]: https://github.com/hiqdev/hiam-core/commit/7cfbd11
[ceb33a6]: https://github.com/hiqdev/hiam-core/commit/ceb33a6
[bd4ff1c]: https://github.com/hiqdev/hiam-core/commit/bd4ff1c
[f1c9b95]: https://github.com/hiqdev/hiam-core/commit/f1c9b95
[f61ebb3]: https://github.com/hiqdev/hiam-core/commit/f61ebb3
[29dd03f]: https://github.com/hiqdev/hiam-core/commit/29dd03f
[513254c]: https://github.com/hiqdev/hiam-core/commit/513254c
[2ddd559]: https://github.com/hiqdev/hiam-core/commit/2ddd559
[5e12dc1]: https://github.com/hiqdev/hiam-core/commit/5e12dc1
[d312c8a]: https://github.com/hiqdev/hiam-core/commit/d312c8a
[70c23f6]: https://github.com/hiqdev/hiam-core/commit/70c23f6
[4bce645]: https://github.com/hiqdev/hiam-core/commit/4bce645
[9c6a2b2]: https://github.com/hiqdev/hiam-core/commit/9c6a2b2
[91eb95b]: https://github.com/hiqdev/hiam-core/commit/91eb95b
[fe83efc]: https://github.com/hiqdev/hiam-core/commit/fe83efc
[67db162]: https://github.com/hiqdev/hiam-core/commit/67db162
[b7df6f1]: https://github.com/hiqdev/hiam-core/commit/b7df6f1
[6271789]: https://github.com/hiqdev/hiam-core/commit/6271789
[c8932ef]: https://github.com/hiqdev/hiam-core/commit/c8932ef
[f6e67b0]: https://github.com/hiqdev/hiam-core/commit/f6e67b0
[8a46dc8]: https://github.com/hiqdev/hiam-core/commit/8a46dc8
[3709de8]: https://github.com/hiqdev/hiam-core/commit/3709de8
[b14dc25]: https://github.com/hiqdev/hiam-core/commit/b14dc25
[78ddd05]: https://github.com/hiqdev/hiam-core/commit/78ddd05
[9c53efa]: https://github.com/hiqdev/hiam-core/commit/9c53efa
[8b0b9bb]: https://github.com/hiqdev/hiam-core/commit/8b0b9bb
[c15c0bf]: https://github.com/hiqdev/hiam-core/commit/c15c0bf
[02f4b9b]: https://github.com/hiqdev/hiam-core/commit/02f4b9b
[dfe5dd3]: https://github.com/hiqdev/hiam-core/commit/dfe5dd3
[f8bbc50]: https://github.com/hiqdev/hiam-core/commit/f8bbc50
[a8968a7]: https://github.com/hiqdev/hiam-core/commit/a8968a7
[28f0ec6]: https://github.com/hiqdev/hiam-core/commit/28f0ec6
[fc5b59f]: https://github.com/hiqdev/hiam-core/commit/fc5b59f
[1b28077]: https://github.com/hiqdev/hiam-core/commit/1b28077
[b1345f7]: https://github.com/hiqdev/hiam-core/commit/b1345f7
[13eea6d]: https://github.com/hiqdev/hiam-core/commit/13eea6d
[09daf33]: https://github.com/hiqdev/hiam-core/commit/09daf33
[b33555f]: https://github.com/hiqdev/hiam-core/commit/b33555f
[6fd1972]: https://github.com/hiqdev/hiam-core/commit/6fd1972
[66db0bd]: https://github.com/hiqdev/hiam-core/commit/66db0bd
[f0e290e]: https://github.com/hiqdev/hiam-core/commit/f0e290e
[b40c8f0]: https://github.com/hiqdev/hiam-core/commit/b40c8f0
[9b8923f]: https://github.com/hiqdev/hiam-core/commit/9b8923f
[b15d117]: https://github.com/hiqdev/hiam-core/commit/b15d117
[b6d93fa]: https://github.com/hiqdev/hiam-core/commit/b6d93fa
[e2dc3d2]: https://github.com/hiqdev/hiam-core/commit/e2dc3d2
[7fe9d03]: https://github.com/hiqdev/hiam-core/commit/7fe9d03
[148be43]: https://github.com/hiqdev/hiam-core/commit/148be43
[3e4793b]: https://github.com/hiqdev/hiam-core/commit/3e4793b
[b146af5]: https://github.com/hiqdev/hiam-core/commit/b146af5
[77d4861]: https://github.com/hiqdev/hiam-core/commit/77d4861
[6a9ff3c]: https://github.com/hiqdev/hiam-core/commit/6a9ff3c
[d14e5a2]: https://github.com/hiqdev/hiam-core/commit/d14e5a2
[28f36e1]: https://github.com/hiqdev/hiam-core/commit/28f36e1
[041ed81]: https://github.com/hiqdev/hiam-core/commit/041ed81
[3d5f5aa]: https://github.com/hiqdev/hiam-core/commit/3d5f5aa
[4f8b6a7]: https://github.com/hiqdev/hiam-core/commit/4f8b6a7
[e90b3a4]: https://github.com/hiqdev/hiam-core/commit/e90b3a4
[e79cd05]: https://github.com/hiqdev/hiam-core/commit/e79cd05
[f183798]: https://github.com/hiqdev/hiam-core/commit/f183798
[0829300]: https://github.com/hiqdev/hiam-core/commit/0829300
[7497d69]: https://github.com/hiqdev/hiam-core/commit/7497d69
[0031ade]: https://github.com/hiqdev/hiam-core/commit/0031ade
[559b5f5]: https://github.com/hiqdev/hiam-core/commit/559b5f5
[888f43e]: https://github.com/hiqdev/hiam-core/commit/888f43e
[d90276b]: https://github.com/hiqdev/hiam-core/commit/d90276b
[398956a]: https://github.com/hiqdev/hiam-core/commit/398956a
[38a60b8]: https://github.com/hiqdev/hiam-core/commit/38a60b8
[5e28cc4]: https://github.com/hiqdev/hiam-core/commit/5e28cc4
[1870e4b]: https://github.com/hiqdev/hiam-core/commit/1870e4b
[c4f1143]: https://github.com/hiqdev/hiam-core/commit/c4f1143
[6f259df]: https://github.com/hiqdev/hiam-core/commit/6f259df
[7f29249]: https://github.com/hiqdev/hiam-core/commit/7f29249
[c7ec8ef]: https://github.com/hiqdev/hiam-core/commit/c7ec8ef
[8b1bd8b]: https://github.com/hiqdev/hiam-core/commit/8b1bd8b
[a745b52]: https://github.com/hiqdev/hiam-core/commit/a745b52
[80911a9]: https://github.com/hiqdev/hiam-core/commit/80911a9
[ba78ce9]: https://github.com/hiqdev/hiam-core/commit/ba78ce9
[a6a57e9]: https://github.com/hiqdev/hiam-core/commit/a6a57e9
[ab852e5]: https://github.com/hiqdev/hiam-core/commit/ab852e5
[f123cc2]: https://github.com/hiqdev/hiam-core/commit/f123cc2
[5af3245]: https://github.com/hiqdev/hiam-core/commit/5af3245
[0ea7251]: https://github.com/hiqdev/hiam-core/commit/0ea7251
[7959faf]: https://github.com/hiqdev/hiam-core/commit/7959faf
[Under development]: https://github.com/hiqdev/hiam-core/compare/0.0.3...HEAD
[0.0.3]: https://github.com/hiqdev/hiam-core/compare/0.0.2...0.0.3
[0.0.2]: https://github.com/hiqdev/hiam-core/compare/0.0.1-alpha...0.0.2
[0.0.1-alpha]: https://github.com/hiqdev/hiam-core/releases/tag/0.0.1-alpha
