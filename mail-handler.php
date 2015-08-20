#!/usr/bin/php
<?php

set_include_path(__DIR__ . PATH_SEPARATOR . get_include_path());

if (!isset($_ENV['ORIGINAL_RECIPIENT'])) {
    exit("Bad recipient or no recipient found");
}

echo "Processing message for {$_ENV['ORIGINAL_RECIPIENT']}...\n";
list($user, $domain) = explode('@', $_ENV['ORIGINAL_RECIPIENT']);

// handle user plus addressing
list($script) = explode('+', $user);

if (!file_exists('php-handlers/'.$script)) {
    exit("Bad recipient or no recipient found");
}

// Read configuration
if (!is_file('config.ini')) {
    exit("No config file available");
}
$config = parse_ini_file("config.ini", true);

require_once('php-handlers/'.$script);