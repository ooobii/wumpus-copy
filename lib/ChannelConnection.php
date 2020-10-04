<?php

class ChannelConnection
{
    public function __construct($isSource, $guildId, $channelId)
    {

        if ($guildId) {
            $this->GuildId = $guildId;
        }

        if (!$channelId) {
            throw new Exception("A channel ID is required when creating a channel details model.");
        }

        $this->ChannelID = $channelId;

        #TODO: Finish Chan class construction
    }

    #TODO: Add additional fetching capabilities to properties of Chan class.
}
