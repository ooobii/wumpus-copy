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
#load config from JSON and 
$config = new config_manager('config.json');

#connect to Discord API
$discord = new \Discord\Discord([
    'token' => $config->get_token(),
    'logging' => FALSE
]);


#prep handling for when Discord has authenticated through REST API.
$discord->on('ready', function ($discord) use ($config) {

    #prep handling for when a  message is received on a channel this account is a member of.
    $discord->on('message', function ($message) use ($config, $discord) {
        
        #loop through monitors and, if eligible, process the connected destinations.
        foreach($config->get_monitors() as $monitor) {
            $monitor->process_message($config, $discord, $message);
        }

    });

});

#using defined handlers, begin communications with the Discord API.
$discord->run();
