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
     * @param float $channelIds The Discord ChannelID to deposit messages into.
     * @param string $fromMonitor The ChannelMonitor nickname that will be handled by this connection.
     */
    public function __construct($guildId, $channelIds, $fromMonitor, $nickname)
    {
        $this->ConnectedMonitorNickname = $fromMonitor;
        parent::__construct(false, $guildId, $channelIds, $nickname);
    }

    public function get_connected_monitor(config_manager $config) : ChannelMonitor
    {
        return $config->SourceMonitors[$this->ConnectedMonitorNickname];
    }


    public function send_message(config_manager $config, Discord $discord, Message $message) : int { 

        #abort if ChannelID of message is not the ChannelID of the monitor.
        if($message->channel_id != $this->get_connected_monitor($config)->get_channel_id()) return 0;

        #get instance of the guild for this deposit connector
        $guild = $discord->guilds->get('id', $this->get_guild_id());
        if(!is_null($guild)) {

            #if guild is found, get the channel for this deposit connector
            $channel = $guild->channels->get('id', $this->get_channel_id());
            if(!is_null($channel)) {

                #if channel is found, send the message to the channel for this deposit connection.
                $channel->sendMessage($message->author->username . ": ". $message->content);
                return 1;

            }
            return 0;

        }
        
        return 0;
    }

}
