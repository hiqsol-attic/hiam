<?php
namespace console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;

/**
 * RBAC management
 * more description
 */
class RbacController extends Controller
{
    public $defaultAction = 'index';

    static protected $roles = [
/// server roles
        'serverGuest' => [
        ],
        'serverUser' => [
            'serverGuest',
            'serversSearch','serversGetList','server/sGetInfo/Resources',
            'server/sBuy','server/sRefuse',
            'server/sRenew','server/sEnable/DisableAutorenewal',
            'server/sReboot/Reset/Shutdown','server/sPowerOn/Off',
            'server/sResetup','server/sBootLive',
            'server/sEnable/DisableVNC',
            'server/sGet/RegenRootPassword',
            'server/sGetRequestState',
        ],
        'serverReseller' => [
            'serverUser',
            'server/sEnable/DisableBlock',
            'server/sDelete',
        ],
        'serverManager' => [
            'serverReseller',
        ],
        'serverAdmin' => [
            'serverUser',
            'server/sEnable/DisableBlock',
        ],
/// client roles
        'clientGuest' => [
            'clientCheck/Create', /// only single
            'clientConfirmEmail',
            'clientRemind/SetPassword',
            'clientAddAllowedIP',
            'clientNotifyAddAllowedIP',
            'clientNotifyConfirmEmail',
        ],
        'clientUser' => [
            'clientGuest',
            'clientsSearch','clientsGetList','client/sGetInfo','client/sGetOpenInfo',
            'clientsGet/SetClassValues',
            'client/sEnable/DisablePincode',
            'client/sGetBalance',
            'clientHas/CheckPincode',
            'client/sGetPurchase',
            'clientSetLanguage',
            'clientGetDefaultContacts',
        ],
        'clientReseller' => [
            'clientUser',
            'client/sSetCredit',
            'client/sEnable/DisableBlock',
            'client/sGet/SetTariffs/Merchants',
        ],
        'clientManager' => [
            'clientReseller',
            'clientsCheck/Create',  /// bulk variants
        ],
        'clientAdmin' => [
            'clientUser',
        ],
/// general roles
        'guest' => [
            'server/clientGuest',
        ],
        'user' => [
            'server/clientUser',
        ],
        'client' => [
            'user',
        ],
        'manager' => [
            'server/clientManager',
        ],
        'admin' => [
            'server/clientAdmin',
        ],
    ];

    /**
      * init DB
      */
    public function actionInit () {
        Yii::$app->authManager->fill(self::$roles);
        return 0;
    }

    public function actionReinit () {
        Yii::$app->authManager->removeAllChildren();
        return $this->actionInit();
    }

    public function actionCheck ($user,$permission) {
        $ch = Yii::$app->authManager->checkAccess($user,$permission);
d($ch);
    }

    /**
      * Index test
      */
    public function actionIndex () {
        $this->stdout("Hello!\n", Console::BOLD | Console::FG_YELLOW);
        return 0;
    }

}
