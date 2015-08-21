<?php

chdir(__DIR__.'/..');

$_SERVER = array_merge(array (
    'USER' => 'handler',
    'DOMAIN' => 'dev.cloud.emailsendr.net',
    'LOGNAME' => 'handler',
    'CLIENT_PROTOCOL' => 'ESMTP',
    'ORIGINAL_RECIPIENT' => $argv[1].'@dev.cloud.emailsendr.net',
    'LOCAL' => 'handler',
    'PATH' => '/usr/bin:/bin',
    'SENDER' => 'randy@bluehornet.com',
    'LANG' => 'C',
    'CLIENT_ADDRESS' => '10.24.228.19',
    'MAIL_CONFIG' => '/etc/postfix',
    'PWD' => '/var/spool/postfix',
    'RECIPIENT' => 'handler@dev.cloud.emailsendr.net',
    'CLIENT_HOSTNAME' => 'unknown',
    'CLIENT_HELO' => 'dev.bluehornet.com',
), $_SERVER);

require_once('mail-handler.php');
