<?php


namespace hiam\controllers;

use filsh\yii2\oauth2server\models\OauthAccessTokens;
use hiam\providers\ClaimsProviderInterface;
use Yii;
use yii\filters\ContentNegotiator;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\IdentityInterface;
use yii\web\Response;

class UserinfoController extends Controller
{
    /**
     * @var ClaimsProviderInterface
     */
    private $claimsProvider;

    public function __construct($id, $module, ClaimsProviderInterface $claimsProvider, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->claimsProvider = $claimsProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'only' => ['index'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ]);
    }

    public function actionIndex()
    {
        $request = Yii::$app->request;
        $authHeader = $request->getHeaders()->get('Authorization');
        preg_match('/^Bearer\s+(.*?)$/', $authHeader ?? '', $matches);
        $tokenString = $matches[1] ?? $request->post('access_token') ?? $request->get('access_token');

        $token = OauthAccessTokens::findOne($tokenString);
        if ($token === null) {
            throw new ForbiddenHttpException(403);
        }

        /** @var IdentityInterface $identityClass */
        $identityClass = Yii::$app->user->identityClass;
        $user = $identityClass::findIdentity($token->user_id);

        $result = $this->claimsProvider->getClaims($user, $token->scope ?? 'email');
        $result->sub = (string)$token->user_id;

        return $result;
    }
}
