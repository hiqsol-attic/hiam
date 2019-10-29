<?php


namespace hiam\behaviors;

use yii\base\ActionFilter;
use yii\base\Application;
use yii\base\Event;

/**
 * Class CaptchaBehavior
 * @package hiam\components
 */
class CaptchaBehavior extends ActionFilter
{
    public const PER_DAY = 24 * 60 * 60;
    public const PER_HOUR = 60 * 60;

    /**
     * @var array[]
     *
     * ```
     * [
     *     'action-id' => [(int) $maxCount, (int) $timeWindow],
     *     'some-action' => [3, CaptchaBehavior::PER_HOUR],
     * ]
     * ```
     */
    public $limitPerAction = [];

    /**
     * @var array[]
     *
     * ```
     * [
     *    'action-id' => function (Action $action, $result, CaptchaBehavior $behavior): bool {
     *       return (bool)random(0,1);
     *    }
     * ]
     * ```
     */
    public $conditionalIncrement = [];

    /**
     * @inheritDoc
     */
    public function beforeAction($action)
    {
        $actionId = $action->id;

        $limit = $this->limitPerAction[$actionId] ?? null;
        if ($limit === null) {
            return true;
        }

        $count = $this->getCountForAction($actionId);
        if ($count >= $limit[0]) {
            \Yii::$app->request->setBodyParams(array_merge(\Yii::$app->request->getBodyParams(), ['captchaIsRequired' => true]));
            $action->controller->actionParams['captchaIsRequired'] = true;
        }

        \Yii::$app->on(Application::EVENT_AFTER_REQUEST, [$this, 'afterRequest']);

        return true;
    }

    /**
     * @param Event $event
     * @throws \yii\base\InvalidConfigException
     */
    public function afterRequest(Event $event)
    {
        if (\Yii::$app->request->getBodyParams()['signupCaptcha']) {
            $this->increment('signup');
        }
    }

    /**
     * @inheritDoc
     */
    public function afterAction($action, $result)
    {
        $counterShouldIncrement = $this->conditionalIncrement[$action->id]
            ?? function () {
                return true;
            };

        if ($counterShouldIncrement()) {
            $this->increment($action->id);
        }

        return $result;
    }

    /**
     * @param string $actionId
     * @return int
     */
    private function getCountForAction(string $actionId): int
    {
        $key = $this->getCacheKey($actionId);

        return \Yii::$app->cache->get($key) ?: 0;
    }

    /**
     * @param string $actionId
     */
    private function increment(string $actionId): void
    {
        $key = $this->getCacheKey($actionId);
        $counter = \Yii::$app->cache->get($key) ?: 0;
        \Yii::$app->cache->set($key, ++$counter, $this->limitPerAction[1]);
    }

    /**
     * @param string $actionId
     * @return string[]
     */
    private function getCacheKey(string $actionId): array
    {
        $userIp = \Yii::$app->request->getUserIP();

        return [__CLASS__, $actionId, $userIp];
    }
}
