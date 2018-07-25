<?php

namespace hiam\tests\_support\Helper;

use Codeception\Lib\ModuleContainer;

/**
 * Class TestMails
 *
 * @author Andrey Klochok <andreyklochok@gmail.com>
 */
class TestMails extends \Codeception\Module
{
    /**
     * @var string
     */
    private $mailsDir;

    public function __construct(ModuleContainer $moduleContainer, $config = null)
    {
        parent::__construct($moduleContainer, $config);

        $this->mailsDir = getcwd() . '/runtime/debug/mail';
    }

    public function getMessages(): ?array
    {
        $ignored = ['.', '..', '.svn', '.htaccess'];

        $files = [];
        foreach (scandir($this->mailsDir, SCANDIR_SORT_NONE) as $fileName) {
            if (\in_array($fileName, $ignored, true)) {
                continue;
            }
            $files[$fileName] = filemtime($this->mailsDir . '/' . $fileName);
        }

        arsort($files);
        $files = array_keys($files);

        return !empty($files) ? $files : null;
    }

    public function getLastMessage()
    {
        $messages = $this->getMessages();

        return $messages ? reset($messages) : false;
    }

    public function clearMessages(): void
    {
        foreach (glob($this->mailsDir . '/*') as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
}
