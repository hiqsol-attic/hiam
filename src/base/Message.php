<?php

namespace hiam\base;

class Message extends \yii\swiftmailer\Message
{
    /**
     * Renders and sets message HTML content.
     * @param string|array|null $view the view to be used for rendering the message body.
     * @param array $params the parameters (name-value pairs) that will be extracted and made available in the view file.
     * @return $this self reference.
     */
    public function renderHtmlBody($view, array $params = [])
    {
        if (!array_key_exists('message', $params)) {
            $params['message'] = $this;
        }

        return $this->setHtmlBody($this->mailer->render($view, $params, $this->mailer->htmlLayout));
    }

    /**
     * Renders and sets message plain text content.
     * @param string|array|null $view the view to be used for rendering the message body.
     * @param array $params the parameters (name-value pairs) that will be extracted and made available in the view file.
     * @return $this self reference.
     */
    public function renderTextBody($view, array $params = [])
    {
        if (!array_key_exists('message', $params)) {
            $params['message'] = $this;
        }

        return $this->setTextBody($this->mailer->render($view, $params, $this->mailer->textLayout));
    }
}
