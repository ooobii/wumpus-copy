<?php
require_once __DIR__ . "/ChannelMonitor.php";

class DestinationChannel extends ChannelConnection
{

    /**
     * Create a channel connection for depositing messages into from a source monitor
     *
     * @param string $nickname A friendly name of the channel to write to
     * @param float $guildId The Discord GuildID where the channel to deposit to belongs.
     * @param float $channelId The Discord ChannelID to deposit messages into.
     * @param string $fromMonitor The ChannelMonitor nickname that will be handled by this connection.
     */
    public function __construct($guildId, $channelId, $fromMonitor)
    {
        $this->ConnectedMonitorNickname = $fromMonitor;
        parent::__construct(false, $guildId, $channelId);
    }

    public function get_connected_monitor(config_manager $config) 
    {
        return $config->SourceMonitors[$this->ConnectedMonitorNickname];
    }

}
