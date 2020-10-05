<?php

class ChannelConnection
{
    public function __construct($isSource, $guildId, $channelId, $nickname)
    {
        #verify Guild Id is provided.
        if (!$guildId || empty($guildId)) throw new Exception("A guild ID is required when creating a channel details model.");
        $this->GuildId = $guildId;

        #verify Channel Id is provided.
        if (!$channelId || empty($channelId)) throw new Exception("A channel ID is required when creating a channel details model.");
        $this->ChannelId = $channelId;

        #verify Nickname is provided.
        if (!$nickname || empty($nickname)) throw new Exception("A connection nickname is required when creating a channel details model.");
        $this->Nickname = $nickname;
    }

    /**
     * Return the Channel ID this connection is responsible for.
     *
     * @return string
     */
    public function get_channel_id() : string {
        return $this->ChannelId;
    }
    /**
     * Return the Guild ID this channel connection is connected to.
     *
     * @return string
     */
    public function get_guild_id() : string {
        return $this->GuildId;
    }
    /**
     * Return the nickname of this connection.
     *
     * @return string
     */
    public function get_nickname() : string {
        return $this->Nickname;
    }

}
