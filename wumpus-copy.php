<?php
#load packages
include __DIR__ . '/vendor/autoload.php';

#load helper methods
require __DIR__ . '/lib/config_manager.php'; //config_manager

// START =================================
// load config from json
$config = new config_manager('config.json');

// Prepare historical message arrays
$srcHistories = array();
$destHistories = array();

// Connect to Discord API
$discord = new \Discord\Discord([
    'token' => $config->get_token(),
    'logging' => false,
]);

$discord->on('ready', function ($discord) use ($config) {

});

$discord->run();
