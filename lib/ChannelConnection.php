<?php

class ChannelConnection
{
    public function __construct($isSource, $guildId, $channelId)
    {
        if (!$guildId) throw new Exception("A guild ID is required when creating a channel details model.");
        $this->GuildId = $guildId;

        if (!$channelId) throw new Exception("A channel ID is required when creating a channel details model.");
        $this->ChannelID = $channelId;
    }


    public function get_guildid() {
        return $this->GuildId;
    }
    public function get_channelid() {
        return $this->ChannelId;
    }

}
