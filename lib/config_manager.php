<?php

class config_manager
{
    public function __construct($filePath)
    {
        #read the file and decode the JSON data into a PHP array.
        $rawJSON = json_decode(file_get_contents($filePath), true);
        if (!$rawJSON) throw new Exception("Invalid configuration; Unable to parse JSON configuration. Validate formatting and try again.");

        #fetch token from JSON data
        if(!$rawJSON['properties']['personalToken']) throw new Exception("Invalid configuration; missing 'properties/personalToken' value.");
        $this->DiscordToken = $rawJSON['properties']['personalToken'];

        #Create Source Monitors
        $this->SourceMonitors = array();
        foreach(array_keys($rawJSON['monitors']) as $sourceNickname) {
            #focus on this monitor entry from JSON
            $source = $rawJSON['monitors'][$sourceNickname];

            #read each channel ID and user ID, and create a monitor for each combination of possible values.
            foreach($source['channelIDs'] as $sourceChanId) {

                foreach($source['fromUserIDs'] as $userId) {

                    #create a monitor record, and add it to source monitors collection
                    $monitor = new ChannelMonitor($source['guildID'], $sourceChanId, $userId);
                    $this->SourceMonitors[$sourceNickname] = $monitor;

                }

            }

        }

        #Create Destination Connections
        $this->DestinationConnections = array();
        foreach(array_keys($rawJSON['destinations']) as $destNickname) {
            #focus on this destination entry from JSON
            $dest = $rawJSON['destinations'][$destNickname];

            #read each channel ID and monitor nickname, and create a destination connection for each combination of possible values.
            foreach($dest['channelIDs'] as $destChanId) {

                foreach($dest['fromSource'] as $monitorNick) {
                    #make sure monitor has been loaded before creating connection
                    if(!$this->SourceMonitors[$monitorNick]) throw new Exception("Invalid configuration; The monitor '$monitorNick' specified in destination '$destNickname' does not exist.");

                    #create a monitor record, and add it to source monitors collection
                    $destination = new DestinationChannel($source['guildID'], $destChanId, $monitorNick);
                    $this->DestinationConnections[$destNickname] = $destination;

                }

            }

        }
    }

    public function get_token() {
        return $this->DiscordToken;
    }


    public function get_monitors() {
        return $this->SourceMonitors;
    }
    public function get_monitor($monitorNickname) {
        return $this->SourceMonitors[$monitorNickname];
    }


    public function get_destinations() {
        return $this->DestinationConnections;
    }
    public function get_destination($destinationNickname) {
        return $this->DestinationConnections[$destinationNickname];
    }

}
