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
        // The first line in the stream is a postfix message, so we discard it
        fgets($stream);
        while ($line = fgets($stream)) {
            $src .= $line;
        }
        fclose($stream);

        // Create a Zend\Mail\Message object with our message
        $email = new \Zend\Mail\Message(array('raw' => $src), $src);
        $headers = $email->getHeaders();
        var_dump($headers->toArray());
    }
}