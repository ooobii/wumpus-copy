<?php
#load packages
include __DIR__ . '/vendor/autoload.php';

#load classes
require __DIR__ . '/lib/say.php';
require __DIR__ . '/lib/ChannelConnection.php';
require __DIR__ . '/lib/ChannelMonitor.php';
require __DIR__ . '/lib/DestinationChannel.php';
require __DIR__ . '/lib/config_manager.php'; 

// START =================================
// load config from JSON and 
$config = new config_manager('config.json');

// Connect to Discord API
$discord = new \Discord\Discord([
    'token' => $config->get_token(),
    'logging' => false,
]);

$discord->on('ready', function ($discord) use ($config) {

    $discord->on('message', function ($message) use ($config) {
        foreach($config->get_monitors() as $monitor) {
            $monitor->process_message($config, $message);
        }
    });

});

$discord->run();
