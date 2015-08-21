<?php

require_once('vendor/autoload.php');

// Load our classes
$classDir = dir(__DIR__.'/Trampoline');
while (($entry = $classDir->read())) {
    if (strpos($entry, '.php') !== false) {
        require_once(__DIR__.'/Trampoline/'.$entry);
    }
}

// Read configuration
if (!is_file(__DIR__.'/trampoline.ini')) {
    $message = "No config file available";
    error_log($message);
    exit($message);
}
$config = parse_ini_file(__DIR__.'/trampoline.ini', true);
$config['Server'] = $_SERVER;
$config['Server']['ORIGINAL_RECIPIENT_USER'] = $user;
$config['Server']['ORIGINAL_RECIPIENT_DOMAIN'] = $domain;

if (!isset($_SERVER['ORIGINAL_RECIPIENT'])) {
    $message = "Bad recipient or no recipient found: " . __LINE__;
    error_log($message);
    exit($message);
}

list($user, $domain) = explode('@', $_SERVER['ORIGINAL_RECIPIENT']);

// handle user plus addressing
list($class) = explode('+', $user);
$class = ucfirst($class);

if (isset($config['debug']) && $config['debug'] == true) {
    error_log("Processing message for " . $_SERVER['ORIGINAL_RECIPIENT'] . ": $class");
}

$myClass = "BlueHornet\\Trampoline\\$class";
$handler = new $myClass($config);
$handler->run();
