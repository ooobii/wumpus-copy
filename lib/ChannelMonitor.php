<?php
use Discord\Discord;
use Discord\Parts\Channel\Message;
class ChannelMonitor extends ChannelConnection
{

    /**
     * Create a channel connection to listen in on for messages form a specific user..
     *
     * @param string $nickname A friendly name of the channel to monitor
     * @param string $guildId The Discord GuildID that the channel to listen in on belongs to.
     * @param string $channelId The Discord ChannelID to listen in on.
     * @param float $fromId The Discord UserID to trigger messages from.
     */
    public function __construct($guildId, $channelId, $fromId, $nickname)
    {
        $this->UserId = $fromId;
        parent::__construct(true, $guildId, $channelId, $nickname);
    }
    public function get_user() {
        return $this->UserId;
    }
    public function get_nickname() {
        return $this->Nickname;
    }

    public function get_connected_destinations(config_manager $config) {
        return array_filter($config->get_destinations(), function($item, $key) {
            if($item->ConnectedMonitorNickname == $this->Nickname) return true;

            return false;
        }, ARRAY_FILTER_USE_BOTH);
    }

    public function get_connected_destination_ids(config_manager $config) {
        return array_column($this->get_connected_destinations($config), "ChannelID");
    }


    public function process_message(config_manager $config, Discord $discord, Message $message) {

        #check to see if message ID is part of the monitored channel, and is from the monitored ID (if any).
        if($this->get_channel_id() == $message->channel_id && ($this->UserId == "" ? TRUE : $this->UserId == $message->author->id)) {
            echo " Found Qualified Monitor... ";

            #when part of monitored channel, process message forwarding to each connected destination.
            foreach($this->get_connected_destinations($config) as $destination) {

                $destination->send_message($config, $discord, $message);

            }

        }
        
    }

}
