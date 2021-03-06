#! /usr/bin/php7.3

<?php
#load packages

ini_set('memory_limit', '-1');

use Discord\Discord;
use Discord\Parts\Channel\Message;

include __DIR__ . '/vendor/autoload.php';

#load classes
require __DIR__ . '/lib/requires.php';

// START =================================
#load config from JSON; use installed config if no argument provided.
if(sizeof($argv) != 2) {
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        $configLoc = '%APPDATA%/wumpus-copy/config.json';
    } else {
        $configLoc = '/etc/wumpus-copy/config.json';
    }
} else {
    $configLoc = $argv[1];
}
$config = new config_manager($configLoc);


#create main loop for queue processing and message handling
$mainLoop = React\EventLoop\Factory::create();


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


#declare function for handling startup of the monitor instance.
$monitorReadyHandler = function(Discord $discord) use($config) {

    #declare handler for incoming messages on monitor instance
    $discord->on('message', function (Message $message) use ($config) {

        #check to see if author and channel are being monitored.
        if(in_array($message->channel_id, $config->get_monitored_channels())) {

            #add message to deposit queue
            say("[Monitor]: Found Message; adding to queue...", 0);
            if(!$config->add_deposit_queue($message)) {
                say("ERROR!");
            } else {
                say("OK!");
            }

        }

    });

    say("Monitor Instance Ready!");
    
};

#declare function for handling startup of the bot instance.
$depositReadyHandler = function(Discord $discord) use($config) {
    say("Deposit Instance Ready!");
};

#add the queue processing periodic loop to the main loop.
$queueProcessLoop = function() use ($config, $depositDiscord) {
    #copy current instance of queue as to not disturb adding new messages during queue processing.
    $queue = $config->get_deposit_queue();

    #if queue copy is not empty, pass messages to depositors.
    if(sizeof($queue) > 0) {
        
        #notify queue is populated.
        say("[Deposit]: Queue populated; processing '" . sizeof($queue) . "' message(s)... ");

        #store number of sent messages from queue
        $sent = 0;

        #store number of errors that occur from processing message queue.
        $errors = 0;

        #loop through messages in queue.
        foreach($queue as $message) {

            #find all applicable destinations for each message in queue.
            $destinations = $config->get_deposits_for_source_channel($message->channel_id);

            #loop through them.
            foreach($destinations as $destination) {

                try {

                    #process message with destination
                    $result = $destination->send_message($config, $depositDiscord, $message);
                    $sent += 1;
                    
                } catch(Throwable $ex) {

                }

            }

        }

        #report how many queued items were processed, and report errors if any
        if($sent > 0) {
            
            #if no errors occurred
            say("[Deposit]: Queue items processed successfully; sent '" . $sent . "' message(s).");

        }
    }

    #clear deposit queue of messages that were processed this cycle.
    $config->clear_deposit_queue($queue);
};
$mainLoop->addPeriodicTimer($config->get_queue_interval(), $queueProcessLoop);


#add handlers
$monitorDiscord->on('ready', $monitorReadyHandler);
$depositDiscord->on('ready', $depositReadyHandler);

#start main loop
$mainLoop->run();

