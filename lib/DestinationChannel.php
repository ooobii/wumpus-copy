<?php
use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\Parts\GuildRepository;
require_once __DIR__ . "/ChannelMonitor.php";

class DestinationChannel extends ChannelConnection
{

    /**
     * Create a channel connection for depositing messages into from a source monitor
     *
     * @param string $nickname A friendly name of the channel to write to
     * @param float $guildId The Discord GuildID where the channel to deposit to belongs.
     * @param float $channelId The Discord ChannelID to deposit messages into.
     * @param string $fromMonitor The ChannelMonitor nickname that will be handled by this connection.
     */
    public function __construct($channelId, $fromMonitor)
    {
        $this->ConnectedMonitorNickname = $fromMonitor;
        parent::__construct(false, $channelId);
    }

    public function get_connected_monitor(config_manager $config) : ChannelMonitor
    {
        return $config->SourceMonitors[$this->ConnectedMonitorNickname];
    }


    public function process_message(config_manager $config, Discord $discord, Message $message) { 
        $parentMonitor = $this->get_connected_monitor($config);

        #abort if ChannelID of message is not the ChannelID of the monitor.
        if($message->channel_id != $parentMonitor->get_channel_id()) return;

        #go through each guild the user is a part of
        foreach ($discord->guilds as $guild) {
                if (in_array($this->get_channel_id(), array_column(json_decode(json_encode($guild->channels), true), 'id'))) {

                    var_dump($guild->channels->get('id', $this->get_channel_id()));
                    return;
                    
                }
            
        }
    }

}
