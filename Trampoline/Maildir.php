<?php

/*
*   Handle a maildir message
*   - This script will take the message, and write it to disk
*
*/

namespace BlueHornet\Trampoline;

class MailDirException extends \Exception {};

class Maildir {

    protected $_maildirFile;
    protected $_emailSource;
    protected $_writeMode;

    public function __construct($config = array()) {
        // get our specific opts
        $opts = $config['Maildir'];

        // Check path
        if (!isset($opts['path'])) {
            throw new MailDirException("Maildir path not specified");
        }
        if (!is_file($opts['path'])) {
            // Attempt to create
            if (touch($opts['path']) !== true) {
                throw new MailDirException("Unable to create maildir file");
            }
        }
        if (!is_writeable($opts['path'])) {
            throw new MailDirException("Unable to write to maildir file");
        }
        $this->_maildirFile = $opts['path'];
        $this->_emailSource = $opts['source'] ?: 'php://stdin';
        $this->_writeMode = $opts['writeMode'] ?: FILE_APPEND;
    }

    public function run() {
        // Get message content
        $content = '';
        $stream = @fopen($this->_emailSource, 'r');
        if (!$stream) {
            throw new MailDirException("Unable to open input stream");
        }
        // The first line in the stream is a postfix message, so we discard it
        fgets($stream);
        while ($line = fgets($stream)) {
            $content .= $line;
        }
        fclose($stream);
        file_put_contents($this->_maildirFile, $content . "\r\n\r\n", $this->_writeMode);
    }

};
