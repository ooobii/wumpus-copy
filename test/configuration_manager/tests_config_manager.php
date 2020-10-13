<?php
use PHPUnit\Framework\TestCase;

require __DIR__ . '/../../lib/ChannelConnection.php';
require __DIR__ . '/../../lib/ChannelMonitor.php';
require __DIR__ . '/../../lib/DestinationChannel.php';
require __DIR__ . '/../../lib/config_manager.php'; 


class tests_config_manager extends TestCase
{

    public function testParsing()
    {
        #define test variant type
        $fileVariant = 'valid_simple';


        #load the valid test configuration.
        $testConfig = new config_manager("test/configuration_manager/json/testConfig_$fileVariant.json");

        
        #make sure config is not empty
        $this->assertNotEmpty($testConfig);


        #make sure both source monitors have been loaded
        $this->assertCount(
            2, 
            $testConfig->get_monitors(), 
            "Configuration manager didn't load the correct number of source monitors (File: testConfig_$fileVariant.json)."
        );


        #make sure only two destinations were created
        $this->assertCount(
            2,
            $testConfig->get_deposits(),
            "Configuration manager didn't load the correct number of deposit destinations (File: testConfig_$fileVariant.json)."
        );

    }

    public function testSerialization() 
    {
        #define test variant type
        $fileVariant = 'valid_simple';


        #load the valid test configuration.
        $testConfig = new config_manager("test/configuration_manager/json/testConfig_$fileVariant.json");

        
        #make sure config is not empty
        $this->assertNotEmpty($testConfig);

        
        #serialize configuration manager class to JSON, and compare to correct serialization.
        $this->assertStringEqualsFile(
            "test/configuration_manager/serialized/serialized_$fileVariant.array", 
            json_encode($testConfig),
            "Configuration manager failed to correctly serialize the config file (File: testConfig_$fileVariant.json)."
        );
    }

    public function testMetadata() 
    {
        #define test variant type
        $fileVariant = 'valid_simple';


        #load the valid test configuration.
        $testConfig = new config_manager("test/configuration_manager/json/testConfig_$fileVariant.json");

        
        #make sure config is not empty
        $this->assertNotEmpty($testConfig);
        $monitors = $testConfig->get_monitors();


        #verify monitor 1 exists
        $this->assertArrayHasKey(
            'source1', 
            $monitors, 
            "Configuration manager did not load the 'source1' monitor (File: testConfig_$fileVariant.json)."
        );

        #verify monitor 2 exists
        $this->assertArrayHasKey(
            'source2', 
            $monitors, 
            "Configuration manager did not load the 'source2' monitor (File: testConfig_$fileVariant.json)."
        );


        #get monitor 1 and test metadata
        $this->assertEquals(
            "[source1-userFilter]", 
            $monitors["source1"]->get_user(), 
            "Configuration manager failed to load the user filter from source1 (File: testConfig_$fileVariant.json)."
        );
        $this->assertEquals(
            "[source1-GuildId]",  
            $monitors["source1"]->get_guild_id(), 
            "Configuration manager failed to load the GuildID from source1 (File: testConfig_$fileVariant.json)."
        );
        $this->assertEquals(
            "[source1-ChannelId]",  
            $monitors["source1"]->get_channel_id(), 
            "Configuration manager failed to load the ChannelID from source1 (File: testConfig_$fileVariant.json)."
        );
        $this->assertEquals(
            "source1",  
            $monitors["source1"]->get_nickname(), 
            "Configuration manager failed to load the ChannelID from source1 (File: testConfig_$fileVariant.json)."
        );


        #get monitor 2 and test metadata
        $this->assertEquals(
            "[source2-userFilter]", 
            $monitors["source2"]->get_user(), 
            "Configuration manager failed to load the user filter from source2 (File: testConfig_$fileVariant.json)."
        );
        $this->assertEquals(
            "[source2-GuildId]",  
            $monitors["source2"]->get_guild_id(), 
            "Configuration manager failed to load the GuildID from source2 (File: testConfig_$fileVariant.json)."
        );
        $this->assertEquals(
            "[source2-ChannelId]",  
            $monitors["source2"]->get_channel_id(), 
            "Configuration manager failed to load the ChannelID from source2 (File: testConfig_$fileVariant.json)."
        );
        $this->assertEquals(
            "source2",  
            $monitors["source2"]->get_nickname(), 
            "Configuration manager failed to load the ChannelID from source2 (File: testConfig_$fileVariant.json)."
        );
    }
}