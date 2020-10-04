<?php
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
    public function __construct($guildId, $channelId, $fromId)
    {
        $this->UserId = $fromId;
        parent::__construct(true, $guildId, $channelId);
    }

}
