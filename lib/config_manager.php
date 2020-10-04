<?php

class config_manager
{
    public function __construct($filePath)
    {
        #read the file and decode the JSON data into a PHP array.
        $rawJSON = json_decode(file_get_contents($filePath), true);
        if (!$rawJSON) throw new Exception("Invalid configuration; Unable to parse JSON configuration. Validate formatting and try again.");

        #fetch token from JSON data
        if(!$rawJSON['properties']['botToken']) throw new Exception("Invalid configuration; missing 'properties/botToken' value.");
        $this->BotToken = $rawJSON['properties']['botToken'];

        #fetch individual from JSON data
        if(!$rawJSON['properties']['individualToken']) throw new Exception("Invalid configuration; missing 'properties/individualToken' value.");
        $this->IndividualToken = $rawJSON['properties']['individualToken'];

        #Create Source Monitors
        $this->SourceMonitors = array();
        foreach(array_keys($rawJSON['monitors']) as $sourceNickname) {
            #focus on this monitor entry from JSON
            $source = $rawJSON['monitors'][$sourceNickname];

            #make sure that the channel ID isn't already monitored
            if( in_array($source['channelID'], array_column($this->SourceMonitors, 'ChannelID')) ) { throw new Exception("Invalid Configuration; The monitor definition '$sourceNickname' is attempting to monitor a channel that is already being monitored."); }

            #make sure that the monitor's nickname isn't already taken
            if( in_array($sourceNickname, array_keys($this->SourceMonitors)) ) { throw new Exception("Invalid Configuration; The monitor '$sourceNickname' is already in use."); }

            #create a monitor, and add it to source monitors collection
            $monitor = new ChannelMonitor($source['guildID'], $source['channelID'], $source['fromUserID'], $sourceNickname);
            $this->SourceMonitors[$sourceNickname] = $monitor;

        }

        #Create Destination Connections
        $this->DestinationConnections = array();
        foreach(array_keys($rawJSON['destinations']) as $destNickname) {
            #focus on this destination entry from JSON
            $dest = $rawJSON['destinations'][$destNickname];

            #read each channel ID and monitor nickname, and create a destination connection for each combination of possible values.
            $i = -1;
            foreach($dest['channelIDs'] as $destChanId) {

                foreach($dest['fromSource'] as $monitorNick) {
                    $useAltNick = FALSE;
                    if( in_array($destNickname, array_keys($this->DestinationConnections)) ) {
                        $useAltNick = TRUE;
                        $i ++;
                    } 
                    $altNick = $destNickname . "$i";

                    #make sure monitor has been loaded before creating connection
                    if(!$this->SourceMonitors[$monitorNick]) throw new Exception("Invalid configuration; The monitor '$monitorNick' specified in destination '$destNickname' does not exist.");

                    #create a monitor record, and add it to source monitors collection
                    $destination = new DestinationChannel($source['guildID'], $destChanId, $monitorNick, ($useAltNick ? $altNick : $destNickname));
                    $this->DestinationConnections[($useAltNick ? $altNick : $destNickname)] = $destination;
                }

            }

        }

    }

    public function get_token() {
        return $this->BotToken;
    }
    public function get_individual_token() {
        return $this->IndividualToken;
    }


    public function get_monitors() {
        return $this->SourceMonitors;
    }
    public function get_monitored_channels() {
        return array_column($this->get_monitors(), 'ChannelId');
    }
    public function get_monitor($monitorNickname) {
        return $this->SourceMonitors[$monitorNickname];
    }
    public function get_monitors_for_channel($channelId) {
        return array_filter($this->get_monitors(), function(ChannelMonitor $item, $key) use($channelId) {
            if($item->get_channel_id() == $channelId) return TRUE;
                
            return FALSE;
        }, ARRAY_FILTER_USE_BOTH);
    }


    public function get_destinations() {
        return $this->DestinationConnections;
    }
    public function get_destination($destinationNickname) {
        return $this->DestinationConnections[$destinationNickname];
    }

}
