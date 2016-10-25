<?php

/*
 * Identity and Access Management server providing OAuth2, RBAC and logging
 *
 * @link      https://github.com/hiqdev/hiam-core
 * @package   hiam-core
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2016, HiQDev (http://hiqdev.com/)
 */

namespace hiam\base;

use Yii;

class Message extends \yii\swiftmailer\Message
{
    /**
     * Renders and sets message HTML content.
     * @param string|array|null $view the view to be used for rendering the message body
     * @param array $params the parameters (name-value pairs) that will be extracted and made available in the view file
     * @return $this self reference
     */
    public function renderHtmlBody($view, array $params = [])
    {
        if (!array_key_exists('message', $params)) {
            $params['message'] = $this;
        }

        return $this->setHtmlBody($this->render($view, $params, $this->mailer->htmlLayout));
    }

    /**
     * Renders and sets message plain text content.
     * @param string|array|null $view the view to be used for rendering the message body
     * @param array $params the parameters (name-value pairs) that will be extracted and made available in the view file
     * @return $this self reference
     */
    public function renderTextBody($view, array $params = [])
    {
        if (!array_key_exists('message', $params)) {
            $params['message'] = $this;
        }

        return $this->setTextBody($this->render($view, $params, $this->mailer->textLayout));
    }

    /**
     * Renders the specified view with optional parameters and layout.
     * The view will be rendered using the [[view]] component.
     * @param string $view the view name or the path alias of the view file.
     * @param array $params the parameters (name-value pairs) that will be extracted and made available in the view file.
     * @param string|boolean $layout layout view name or path alias. If false, no layout will be applied.
     * @return string the rendering result.
     */
    public function render($view, $params = [], $layout = false)
    {
        $output = $this->getView()->render($view, $params, $this->mailer);
        if ($layout !== false) {
            return $this->getView()->render($layout, ['content' => $output, 'message' => $this], $this->mailer);
        } else {
            return $output;
        }
    }

    public function getView()
    {
        return Yii::$app->getView();
    }
}
