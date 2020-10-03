<?php

class config_manager {
    function __construct($filePath) {
        #read the file and decode the JSON data into a PHP array.
        $this->raw = json_decode(file_get_contents($filePath), TRUE);
        if(!$this->raw) {
            throw new Exception("Unable to parse configuration file from JSON object; validate configuration formatting and try again.");
        }
        #TODO: add decoding for new config format (containing guildid and channelid)
    }

    #TODO: add fetch for source channels as chan.php::CHAN
    #TODO: add fetch for destination channels as chan.php::CHAN
    #TODO: add fetch for user IDs to copy the messages of.


}
