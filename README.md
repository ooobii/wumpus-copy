# WumpusCopy
[![Build Status](https://jenkins.matthewwendel.info/job/WumpusCopy/job/Wumpus-Copy-Linux-amd64/badge/icon?subject=Build:%20Linux-amd64%20(Debian))](https://jenkins.matthewwendel.info/job/WumpusCopy/job/Wumpus-Copy-Linux-amd64/)
<br>

A PHP-Based Discord bot that utilizes an individual user's token to monitor for messages that should be copied to another server that the connected bot belongs to. 

<ins>**WARNING!:** Using a personal Discord token on any client besides the official Discord client can cause a TOS strike against your account! Please use this tool with extreme caution!</ins>

## Summary

This script is primarily service based and controlled by systemd / Windows Service manager. The service unit name is **'wumpuscopy.service`** (on Windows: **'wumpuscopy.exe'**). You can run wumpuscopy as a service or directly in the currently active console session.

This script launches 2 separate Discord clients; one to connect to an individual's account, and another to connect to a bot account.
Properties for this script are located in the configuration JSON; this file is located in the following order of precedence (first encountered is used):

 - Command Line Arguments.
 - Default Install Location (/etc/wumpus-copy/config.json).
 
Once tokens are loaded, the relationships between user and bot channels are loaded based on the listening and destination channels defined in the configuration.

As messages are received by the individual token, the script will check the author and origin channel/guild, and see if a destination has been specified for the message.
If the message has a specified destination, the message is added to the processing queue.

For each iteration of queue processing (frequency defined in configuration), messages are deposited into the destination connection(s) they qualify for.
<br>

## Usage
wumpuscopy [**config_file_path**]

### Arguments
[**config_file_path**]: *(Optional)* The path pointing to the configuration.
<br>

## Configuration
The configuration file is a JSON document that provides tokens and relationships for how you'd like the script to behave. By default, the configuration is located at '/etc/wumpus-copy/config.json', but a command line argument can be provided upon startup to load settings from elsewhere.

### Properties
This property dictionary contains values required for the Discord instances to function.

  - **botToken**: The Discord API Token for the bot that has access to write messages in the destination channels specified. 
  - **individualToken**: The Discord API Token for the user that has access to the channels being monitored. 
  - **queueInterval**: The number of seconds in between each process of the message queue of messages to be copied to the destinations by the bot.

### Monitors
Multiple monitors can be defined by duplicating a child element of the "monitors" property dictionary and separating them with a comma.
Each source must have a unique nickname without spaces.

  - **sourceName1**: When overwritten, this will be the nickname of the monitor. 
    - **guildID**: The Discord Guild (Server) ID that the channel to be monitored belongs to.
    - **channelID**: The Discord Channel ID that should be watched for messages to copy.
    - **fromUserID**: *(Optional; blank or populated)* The Discord User ID (NOT token) of the user to copy messages authored by. If blank, copy messages from all users.


### Destinations
Multiple destinations can be defined by duplicating a child element of the "destinations" property dictionary and separating them with a comma.
Each destination definition must have a unique nickname without spaces.

  - **destName1**: When overwritten, this will be the nickname of the destination.
    - **guildID**: The Discord Guild (Server) ID that qualified messages should deposit into.
    - **channelIDs**: The Discord Channel ID(s) where qualified messages should be deposited into.
    
      Multiple channel IDs can be specified, as long as they are in the same guild.

    - **fromSource**: The nickname(s) of monitors to listen to messages from.
    
      Multiple monitors can be specified, no matter what guild/channel they are listening to.
