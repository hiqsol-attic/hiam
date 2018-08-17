<?php
/**
 * Identity and Access Management server providing OAuth2, multi-factor authentication and more
 *
 * @link      https://github.com/hiqdev/hiam
 * @package   hiam
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2018, HiQDev (http://hiqdev.com/)
 */

namespace hiam\tests\_support\Helper;

use Yii;

/**
 * Class TestMails.
 *
 * @author Andrey Klochok <andreyklochok@gmail.com>
 */
class MailHelper extends \Codeception\Module
{
    private $mailsDir;

    public function getMessages(): ?string
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
            if (in_array($file, $ignored, true)) {
                continue;
            }
            $files[$file] = filemtime($this->getMailsDir() . DIRECTORY_SEPARATOR . $file);
        }

        arsort($files);
        $files = array_keys($files);

        return $files ? $files : null;
    }

    public function getLastMessage(): ?string
    {
        $messages = $this->getMessages();

        if ($messages) {
            $f = $this->getMailsDir() . DIRECTORY_SEPARATOR . reset($messages);
            $mime = mailparse_msg_parse_file($f);
            $struct = mailparse_msg_get_structure($mime);
            if (in_array('1.1', $struct, true)) {
                $info = mailparse_msg_get_part_data(mailparse_msg_get_part($mime, '1'));
                ob_start();
                mailparse_msg_extract_part_file(mailparse_msg_get_part($mime, '1.2'), $f);
                $body = ob_get_contents();
                ob_end_clean();

                return compact('info', 'body');
            }
        }

        return null;
    }

    public function getResetTokenUrl($f): ?string
    {
        if (preg_match('|<a.*(?=href="([^"]*)")[^>]*>([^<]*)</a>|i', $f['body'], $matches)) {
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
        if (!$this->mailsDir) {
            $this->mailsDir = Yii::getAlias('@runtime/mail');
        }

        return $this->mailsDir;
    }
}
