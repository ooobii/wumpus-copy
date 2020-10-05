<?php
#load packages

ini_set('memory_limit', '-1');

use Discord\Discord;
use Discord\Parts\Channel\Message;
use React\EventLoop\Factory;

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


#create main loop for queue processing and message handling
$mainLoop = Factory::create();


#declare both Discord instances using tokens from config
$monitorDiscord = new Discord([
    'token' => $config->get_individual_token(),
    'loop' => $mainLoop,
    'logging' => FALSE
]);
$depositDiscord = new Discord([
    'token' => $config->get_token(),
    'loop' => $mainLoop,
    'logging' => FALSE
]);


#declare function for handling messages incoming on monitor instance.
$monitorReadyHandler = function () use (&$config) {
    return function(Discord $discord) use($config) {

        $discord->on('message', function (Message $message) use ($config) {
            #check to see if author and channel are being monitored.
            if(in_array($message->channel_id, $config->get_monitored_channels())) {
                say("[Monitor]: Found Message; adding to queue.");
                #add message to deposit queue
                $config->add_deposit_queue($message);
            }
        });
        
    };
};


#add handlers
$monitorDiscord->on('ready', $monitorReadyHandler);

