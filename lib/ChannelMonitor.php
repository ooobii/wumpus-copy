<?php
use Discord\Parts\Channel\Message;
class ChannelMonitor extends ChannelConnection
{

    /**
     * Create a channel connection to listen in on for messages form a specific user..
     *
     * @param string $nickname A friendly name of the channel to monitor
     * @param float $guildId The Discord GuildID that the channel to listen in on belongs to.
     * @param float $channelId The Discord ChannelID to listen in on.
     * @param float $fromId The Discord UserID to trigger messages from.
     */
    public function __construct($channelId, $fromId, $nickname)
    {
        $this->UserId = $fromId;
        $this->Nickname = $nickname;
        parent::__construct(true, $channelId);
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
        
    }

}
