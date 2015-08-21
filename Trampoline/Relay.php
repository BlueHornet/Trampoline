<?php

/*
*   Handle a relay message
*   - This script will take the message, and send
*   - it back to the BlueHornet SMTP relay
*
*/

namespace BlueHornet\Trampoline;

class RelayException extends \Exception {};

class Relay {

    protected $_config;
    protected $_opts;
    protected $_emailSource;

    public function __construct($config = array()) {
        $this->_config = $config;

        // Determine our environment based on hierarchal settings
        // (currently we based this solely on ORIGINAL_RECIPIENT domain)
        preg_match('/^(dev|int|test)\./', $config['Server']['ORIGINAL_RECIPIENT_DOMAIN'], $matches);
        $env = (isset($matches[1])) ? $matches[1] : 'prod';
        $this->_opts = array_merge((array)$config['Relay:'.$env], (array)$config['Relay']);
        $this->_emailSource = $config['source'] ?: 'php://stdin';
    }

    public function run() {
        // Read the contents of the message in from the buffer
        $src = '';
        $stream = fopen($this->_emailSource, 'r');
        while ($line = fgets($stream)) {
            $src .= $line;
        }
        fclose($stream);
        // Create a MailParse object with our message
        $email = mailparse_msg_create();
        mailparse_msg_parse($email, $src);
        $structure = mailparse_msg_get_structure($email);
        foreach ($structure as $partId) {
            $part = mailparse_msg_get_part($email, $partId);
            var_dump($part['headers']);
        }
    }
}