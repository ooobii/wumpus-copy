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

    /**
     * Return the User ID this monitor must listen to.
     *
     * @return string
     */
    public function get_user() : string {
        return $this->UserId;
    }

    /**
     * With the current configuration, find the destinations that relate to this source.
     *
     * @param config_manager $config
     * @return array
     */
    public function get_connected_destinations(config_manager $config) {
        return array_filter($config->get_destinations(), function($item, $key) {
            if($item->ConnectedMonitorNickname == $this->Nickname) return true;

            return false;
        }, ARRAY_FILTER_USE_BOTH);
    }

    /**
     * With the current configuration, find the destination IDs that relate to this source.
     *
     * @param config_manager $config
     * @return void
     */
    public function get_connected_destination_ids(config_manager $config) {
        return array_column($this->get_connected_destinations($config), "ChannelId");
    }


    /**
     * Verify that the message qualifies to be delivered, and send it to the attached channel.
     *
     * @param config_manager $config The current configuration loaded from 'config.json'
     * @param Discord $discord The $depositDiscord instance of the primary loop.
     * @param Message $message The message to be duplicated to the connected channel.
     * @return void
     */
    public function process_message(config_manager $config, Discord $discord, Message $message) {

        #check to see if message ID is part of the monitored channel, and is from the monitored ID (if any).
        if($this->get_channel_id() == $message->channel_id && ($this->UserId == "" ? TRUE : $this->UserId == $message->author->id)) {
            echo " Found Qualified Monitor... ";

            #when part of monitored channel, process message forwarding to each connected destination.
            foreach($this->get_connected_destinations($config) as $destination) {

                #process the message at the destination.
                $destination->send_message($config, $discord, $message);

            }

        }
        
    }

}
