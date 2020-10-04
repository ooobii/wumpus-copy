<?php

class ChannelConnection
{
    public function __construct($isSource, $guildId, $channelId, $nickname)
    {
        if (!$guildId || empty($guildId)) throw new Exception("A guild ID is required when creating a channel details model.");
        $this->GuildId = $guildId;

        if (!$channelId || empty($channelId)) throw new Exception("A channel ID is required when creating a channel details model.");
        $this->ChannelId = $channelId;

        if (!$nickname || empty($nickname)) throw new Exception("A connection nickname is required when creating a channel details model.");
        $this->Nickname = $nickname;
    }


    public function get_channel_id() {
        return $this->ChannelId;
    }
    public function get_guild_id() {
        return $this->GuildId;
    }
    public function get_nickname() {
        return $this->Nickname;
    }

}
