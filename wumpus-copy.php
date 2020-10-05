<?php
#load packages

use Discord\Parts\Channel\Message;

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


#create Discord API sessions for bot and selected impersonations
$discords = array(
    'deposit' => new \Discord\Discord([
        'token' => $config->get_token(),
        'logging' => FALSE
    ]),
    'monitor' => new \Discord\Discord([
        'token' => $config->get_individual_token(),
        'logging' => FALSE
    ])
);


#define bot account processing of deposit queue.
$discords['deposit']->on('ready', function ($discord) use ($config, $discords) { 
    $discords['monitor']->run();
});


#define monitor processing thread handlers
$discords['monitor']->on('ready', function($discord) use ($config, $discords) {
    #handle messages on the individual channel monitor
    $discord->on('message', function($message) use ($config) {

        #check to see if author and channel are being monitored.
        if(in_array($message->channel_id, $config->get_monitored_channels())) {
            say("[Monitor]: Found Message; adding to queue.");
            #add message to deposit queue
            $config->add_deposit_queue($message);

        }

    });
    say("Monitor Bot Ready!");


    #create loop on monitor thread for processing deposit queue
    $discord->loop->addPeriodicTimer($config->get_queue_interval(), function($discord) use ($config, $discords) {
        $queue = $config->get_deposit_queue();

        #if queue is not empty, pass messages in queue to depositors.
        if(sizeof($queue) > 0) {
            say("[Deposits]: Queue populated; processing '" . sizeof($queue) . "' message(s)... ");

            #store number of sent messages from queue
            $sent = 0;

            #loop through messages in queue.
            foreach($queue as $message) {
    
                #find all applicable destinations for each message in queue.
                $destinations = $config->get_deposits_for_source_channel($message->channel_id);

                foreach($destinations as $destination) {
    
                    #process message with destination
                    $sent += $destination->send_message($config, $discords, $message);
    
                }
    
            }
    
            #report how many queued items were processed
            say("[Deposits]: Queue processing complete; sent '" . $sent . "' message(s).");
        }

        #clear deposit queue of messages processed this cycle.
        $config->clear_deposit_queue($queue);
    });
    say("Deposit Bot Ready!");
});

#using defined handlers, begin communications with the Discord API.
$discords['deposit']->run();
