<?php

namespace hiam\tests\_support\Helper;

use Yii;

/**
 * Class TestMails
 *
 * @author Andrey Klochok <andreyklochok@gmail.com>
 */
class MailHelper extends \Codeception\Module
{
    private $_mailsDir;

    public function getMessages()
    {
        $ignored = ['.', '..', '.svn', '.htaccess'];
        $files = [];
        $tries = 0;
        while (!file_exists($this->getMailsDir())) {
            if ($tries++ > 15) {
                return null;
            }
            sleep(1);
        }
        foreach (scandir($this->getMailsDir()) as $file) {
            if (in_array($file, $ignored)) continue;
            $files[$file] = filemtime($this->getMailsDir() . DIRECTORY_SEPARATOR . $file);
        }

        arsort($files);
        $files = array_keys($files);

        return $files ? $files : null;
    }

    public function getLastMessage()
    {
        $messages = $this->getMessages();

        if ($messages) {
            $f = $this->getMailsDir() . DIRECTORY_SEPARATOR . reset($messages);
            $mime = mailparse_msg_parse_file($f);
            $struct = mailparse_msg_get_structure($mime);
            if (in_array('1.1', $struct)) {
                $info = mailparse_msg_get_part_data(mailparse_msg_get_part($mime, '1'));
                ob_start();
                mailparse_msg_extract_part_file(mailparse_msg_get_part($mime, '1.2'), $f);
                $body = ob_get_contents();
                ob_end_clean();

                return compact('info', 'body');
            }
        }

        return false;
    }

    public function getResetTokenUrl($f): ?string
    {
        if (preg_match("|<a.*(?=href=\"([^\"]*)\")[^>]*>([^<]*)</a>|i", $f['body'], $matches)) {
            return $matches[1];
        }

        return null;
    }

    public function getNewUserTokenUrl($f): ?string
    {
        // todo
    }


    public function clearMessages(): void
    {
        $files = glob($this->getMailsDir() . DIRECTORY_SEPARATOR . '*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }

    public function getMailsDir(): string
    {
        if (!$this->_mailsDir) {
            $this->_mailsDir = Yii::getAlias('@runtime/mail');
        }

        return $this->_mailsDir;
    }

}
