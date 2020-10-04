<?php

class ChannelConnection
{
    public function __construct($isSource, $channelId)
    {
        if (!$channelId) throw new Exception("A channel ID is required when creating a channel details model.");
        $this->ChannelID = $channelId;
    }


    public function get_channelid() {
        return $this->ChannelId;
    }

}
