<?php

namespace Helper;

class TestMails extends \Codeception\Module
{
    private $mailsDir;

    public function __construct()
    {
        $this->mailsDir = getcwd() . '/runtime/debug/mail';
    }

    public function getMessages()
    {
        $ignored = ['.', '..', '.svn', '.htaccess'];
        $files = [];
        foreach (scandir($this->mailsDir) as $file) {
            if (in_array($file, $ignored)) continue;
            $files[$file] = filemtime($dir . '/' . $file);
        }

        arsort($files);
        $files = array_keys($files);

        return ($files) ? $files : false;
    }

    public function getLastMessage()
    {
        $messages = $this->getMessages();

        return ($messages) ? reset($messages) : false;
    }

    public function clearMessages(): void
    {
        $files = glob($this->mailsDir . '/*');
        foreach ($files as $file) {
            if (is_file($file))
                unlink($file);
        }
    }
}
