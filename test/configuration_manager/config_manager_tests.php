<?php
use PHPUnit\Framework\TestCase;

require __DIR__ . '/../../lib/requires.php';

class tests_config_manager extends TestCase
{

    public function testParsing_Simple()
    {
        #define test variant types
        $fileVariant = 'valid_simple';
        #load the valid test configuration.
        $testConfig = new config_manager(__DIR__ . "/json/testConfig_$fileVariant.json");

        #make sure config is not empty
        $this->assertNotEmpty(
            $testConfig,
            "failed to parse the configuration file."
        );

    }

    public function testParsing_Complex()
    {
        #define test variant types
        $fileVariant = 'valid_complex';
        #load the valid test configuration.
        $testConfig = new config_manager(__DIR__ . "/json/testConfig_$fileVariant.json");

        #make sure config is not empty
        $this->assertNotEmpty(
            $testConfig,
            "failed to parse the complex configuration file."
        );

    }



    public function testMonitorMetadata_Simple()
    {
        #define test variant type
        $fileVariant = 'valid_simple';

        #load the valid test configuration.
        $testConfig = new config_manager(__DIR__ . "/json/testConfig_$fileVariant.json");

        #make sure config is not empty
        $this->assertNotEmpty($testConfig);
        $monitors = $testConfig->get_monitors();

        #verify monitor 1 exists
        $this->assertArrayHasKey(
            'source1',
            $monitors,
            "did not load the 'source1' monitor."
        );

        #verify monitor 2 exists
        $this->assertArrayHasKey(
            'source2',
            $monitors,
            "did not load the 'source2' monitor."
        );

        #get monitor 1 and test metadata
        $this->assertEquals(
            "[source1-userFilter]",
            $monitors["source1"]->get_user(),
            "failed to load the user filter from source1."
        );
        $this->assertEquals(
            "[source1-GuildId]",
            $monitors["source1"]->get_guild_id(),
            "failed to load the GuildID from source1."
        );
        $this->assertEquals(
            "[source1-ChannelId]",
            $monitors["source1"]->get_channel_id(),
            "failed to load the ChannelID from source1."
        );
        $this->assertEquals(
            "source1",
            $monitors["source1"]->get_nickname(),
            "failed to load the ChannelID from source1."
        );


        #get monitor 2 and test metadata
        $this->assertEquals(
            "[source2-userFilter]",
            $monitors["source2"]->get_user(),
            "failed to load the user filter from source2."
        );
        $this->assertEquals(
            "[source2-GuildId]",
            $monitors["source2"]->get_guild_id(),
            "failed to load the GuildID from source2."
        );
        $this->assertEquals(
            "[source2-ChannelId]",
            $monitors["source2"]->get_channel_id(),
            "failed to load the ChannelID from source2."
        );
        $this->assertEquals(
            "source2",
            $monitors["source2"]->get_nickname(),
            "failed to load the ChannelID from source2."
        );

    }

    public function testMonitorMetadata_Complex()
    {
        #define test variant type
        $fileVariant = 'valid_complex';

        #load the valid test configuration.
        $testConfig = new config_manager(__DIR__ . "/json/testConfig_$fileVariant.json");

        #make sure config is not empty
        $this->assertNotEmpty($testConfig);
        $monitors = $testConfig->get_monitors();

        #verify monitors exist
        $this->assertCount(
            6,
            $monitors,
            "failed to load the expected 6 monitors from complex test config."
        );
        $this->assertArrayHasKey(
            'source1',
            $monitors,
            "did not load the 'source1' monitor."
        );
        $this->assertArrayHasKey(
            'source2',
            $monitors,
            "did not load the 'source2' monitor."
        );
        $this->assertArrayHasKey(
            'source3',
            $monitors,
            "did not load the 'source3' monitor."
        );
        $this->assertArrayHasKey(
            'source4',
            $monitors,
            "did not load the 'source4' monitor."
        );
        $this->assertArrayHasKey(
            'source5',
            $monitors,
            "did not load the 'source5' monitor."
        );
        $this->assertArrayHasKey(
            'source6',
            $monitors,
            "did not load the 'source6' monitor."
        );


        #get source1 and test metadata
        $this->assertEquals(
            "[source1-userFilter]",
            $monitors["source1"]->get_user(),
            "failed to load the user filter from source1."
        );
        $this->assertEquals(
            "[source1-GuildId]",
            $monitors["source1"]->get_guild_id(),
            "failed to load the GuildID from source1."
        );
        $this->assertEquals(
            "[source1-ChannelId]",
            $monitors["source1"]->get_channel_id(),
            "failed to load the ChannelID from source1."
        );
        $this->assertEquals(
            "source1",
            $monitors["source1"]->get_nickname(),
            "failed to load the ChannelID from source1."
        );

        #get source2 and test metadata
        $this->assertEquals(
            "[source2-userFilter]",
            $monitors["source2"]->get_user(),
            "failed to load the user filter from source2."
        );
        $this->assertEquals(
            "[source2-GuildId]",
            $monitors["source2"]->get_guild_id(),
            "failed to load the GuildID from source2."
        );
        $this->assertEquals(
            "[source2-ChannelId]",
            $monitors["source2"]->get_channel_id(),
            "failed to load the ChannelID from source2."
        );
        $this->assertEquals(
            "source2",
            $monitors["source2"]->get_nickname(),
            "failed to load the ChannelID from source2."
        );
        
        #get source3 and test metadata
        $this->assertEquals(
            "[source3-userFilter]",
            $monitors["source3"]->get_user(),
            "failed to load the user filter from source3."
        );
        $this->assertEquals(
            "[source3-GuildId]",
            $monitors["source3"]->get_guild_id(),
            "failed to load the GuildID from source3."
        );
        $this->assertEquals(
            "[source3-ChannelId]",
            $monitors["source3"]->get_channel_id(),
            "failed to load the ChannelID from source3."
        );
        $this->assertEquals(
            "source3",
            $monitors["source3"]->get_nickname(),
            "failed to load the ChannelID from source3."
        );
        
        #get source4 and test metadata
        $this->assertEquals(
            "[source4-userFilter]",
            $monitors["source4"]->get_user(),
            "failed to load the user filter from source4."
        );
        $this->assertEquals(
            "[source4-GuildId]",
            $monitors["source4"]->get_guild_id(),
            "failed to load the GuildID from source4."
        );
        $this->assertEquals(
            "[source4-ChannelId]",
            $monitors["source4"]->get_channel_id(),
            "failed to load the ChannelID from source4."
        );
        $this->assertEquals(
            "source4",
            $monitors["source4"]->get_nickname(),
            "failed to load the ChannelID from source4."
        );
        
        #get source5 and test metadata
        $this->assertEquals(
            "[source5-userFilter]",
            $monitors["source5"]->get_user(),
            "failed to load the user filter from source5."
        );
        $this->assertEquals(
            "[source5-GuildId]",
            $monitors["source5"]->get_guild_id(),
            "failed to load the GuildID from source5."
        );
        $this->assertEquals(
            "[source5-ChannelId]",
            $monitors["source5"]->get_channel_id(),
            "failed to load the ChannelID from source5."
        );
        $this->assertEquals(
            "source5",
            $monitors["source5"]->get_nickname(),
            "failed to load the ChannelID from source5."
        );
        
        #get source6 and test metadata
        $this->assertEquals(
            "[source6-userFilter]",
            $monitors["source6"]->get_user(),
            "failed to load the user filter from source6."
        );
        $this->assertEquals(
            "[source6-GuildId]",
            $monitors["source6"]->get_guild_id(),
            "failed to load the GuildID from source6."
        );
        $this->assertEquals(
            "[source6-ChannelId]",
            $monitors["source6"]->get_channel_id(),
            "failed to load the ChannelID from source6."
        );
        $this->assertEquals(
            "source6",
            $monitors["source6"]->get_nickname(),
            "failed to load the ChannelID from source6."
        );

    }



    public function testRelationships_Simple()
    {
        #define test variant types
        $fileVariant = 'valid_simple';

        #load the valid test configuration.
        $testConfig = new config_manager(__DIR__ . "/json/testConfig_$fileVariant.json");

        #make sure config is not empty
        $this->assertNotEmpty($testConfig);

        #get monitors and deposits
        $monitors = $testConfig->get_monitors();
        $destinations = $testConfig->get_destinations();
        $this->assertNotEmpty(
            $monitors
            , "Unable to fetch monitors from configuration class instance."
        );
        $this->assertNotEmpty(
            $destinations
            , "Unable to fetch deposit destinations from configuration class instance."
        );

        #validate source connections to destinations
        $this->assertEquals(
            array('destA' => $destinations['destA'])
            , $monitors['source1']->get_connected_destinations($testConfig)
            , "failed to create a relationship between Source 1 and Destination A."
        );
        $this->assertEquals(
            array('destB' => $destinations['destB'])
            , $monitors['source2']->get_connected_destinations($testConfig)
            , "failed to create a relationship between Source 2 and Destination B."
        );

        #validate destination connections to sources
        $this->assertEquals(
            $monitors['source1']
            , $destinations['destA']->get_connected_monitor($testConfig)
            , "failed to create a relationship between Destination A and Source 1."
        );
        $this->assertEquals(
            $monitors['source2']
            , $destinations['destB']->get_connected_monitor($testConfig)
            , "failed to create a relationship between Destination B and Source 2."
        );

    }

    public function testRelationships_Complex()
    {
        #define test variant types
        $fileVariant = 'valid_complex';

        #load the valid test configuration.
        $testConfig = new config_manager(__DIR__ . "/json/testConfig_$fileVariant.json");

        #make sure config is not empty
        $this->assertNotEmpty($testConfig);

        #get monitors and deposits
        $monitors = $testConfig->get_monitors();
        $destinations = $testConfig->get_destinations();
        $this->assertNotEmpty(
            $monitors
            , "Unable to fetch monitors from configuration class instance."
        );
        $this->assertNotEmpty(
            $destinations
            , "Unable to fetch deposit destinations from configuration class instance."
        );


        #validate source connections to destinations
        $this->assertEquals(
            array('destD' => $destinations['destD'])
            , $monitors['source1']->get_connected_destinations($testConfig)
            , "failed to create a relationship between Source 1 and Destination A."
        );
        $this->assertEquals(
            array('destB' => $destinations['destB'])
            , $monitors['source2']->get_connected_destinations($testConfig)
            , "failed to create a relationship between Source 2 and Destination B."
        );
        $this->assertEquals(
            array(
                'destA' => $destinations['destA']
                , 'destA0' => $destinations['destA0']
                , 'destB0' => $destinations['destB0'],
            )
            , $monitors['source3']->get_connected_destinations($testConfig)
            , "failed to create a relationship between Source 2 and Destination B."
        );
        $this->assertEquals(
            array('destC' => $destinations['destC'])
            , $monitors['source4']->get_connected_destinations($testConfig)
            , "failed to create a relationship between Source 2 and Destination B."
        );
        $this->assertEquals(
            array(
                'destC0' => $destinations['destC0']
                , 'destE' => $destinations['destE']
                , 'destE1' => $destinations['destE1']
                , 'destE3' => $destinations['destE3']
                , 'destE5' => $destinations['destE5'],
            )
            , $monitors['source5']->get_connected_destinations($testConfig)
            , "failed to create a relationship between Source 2 and Destination B."
        );
        $this->assertEquals(
            array(
                'destC1' => $destinations['destC1']
                , 'destE0' => $destinations['destE0']
                , 'destE2' => $destinations['destE2']
                , 'destE4' => $destinations['destE4']
                , 'destE6' => $destinations['destE6'],
            )
            , $monitors['source6']->get_connected_destinations($testConfig)
            , "failed to create a relationship between Source 2 and Destination B."
        );

        #validate destination connections to sources
        $this->assertEquals(
            $monitors['source3']
            , $destinations['destA']->get_connected_monitor($testConfig)
            , "failed to create a relationship between Destination A and Source 1."
        );
        $this->assertEquals(
            $monitors['source3']
            , $destinations['destA0']->get_connected_monitor($testConfig)
            , "failed to create a relationship between Destination A and Source 1."
        );
        $this->assertEquals(
            $monitors['source2']
            , $destinations['destB']->get_connected_monitor($testConfig)
            , "failed to create a relationship between Destination A and Source 1."
        );
        $this->assertEquals(
            $monitors['source3']
            , $destinations['destB0']->get_connected_monitor($testConfig)
            , "failed to create a relationship between Destination A and Source 1."
        );
        $this->assertEquals(
            $monitors['source4']
            , $destinations['destC']->get_connected_monitor($testConfig)
            , "failed to create a relationship between Destination A and Source 1."
        );
        $this->assertEquals(
            $monitors['source5']
            , $destinations['destC0']->get_connected_monitor($testConfig)
            , "failed to create a relationship between Destination A and Source 1."
        );
        $this->assertEquals(
            $monitors['source6']
            , $destinations['destC1']->get_connected_monitor($testConfig)
            , "failed to create a relationship between Destination A and Source 1."
        );
        $this->assertEquals(
            $monitors['source1']
            , $destinations['destD']->get_connected_monitor($testConfig)
            , "failed to create a relationship between Destination A and Source 1."
        );
        $this->assertEquals(
            $monitors['source5']
            , $destinations['destE']->get_connected_monitor($testConfig)
            , "failed to create a relationship between Destination A and Source 1."
        );
        $this->assertEquals(
            $monitors['source6']
            , $destinations['destE0']->get_connected_monitor($testConfig)
            , "failed to create a relationship between Destination A and Source 1."
        );
        $this->assertEquals(
            $monitors['source5']
            , $destinations['destE1']->get_connected_monitor($testConfig)
            , "failed to create a relationship between Destination A and Source 1."
        );
        $this->assertEquals(
            $monitors['source6']
            , $destinations['destE2']->get_connected_monitor($testConfig)
            , "failed to create a relationship between Destination A and Source 1."
        );
        $this->assertEquals(
            $monitors['source5']
            , $destinations['destE3']->get_connected_monitor($testConfig)
            , "failed to create a relationship between Destination A and Source 1."
        );
        $this->assertEquals(
            $monitors['source6']
            , $destinations['destE4']->get_connected_monitor($testConfig)
            , "failed to create a relationship between Destination A and Source 1."
        );
        $this->assertEquals(
            $monitors['source5']
            , $destinations['destE5']->get_connected_monitor($testConfig)
            , "failed to create a relationship between Destination A and Source 1."
        );
        $this->assertEquals(
            $monitors['source6']
            , $destinations['destE6']->get_connected_monitor($testConfig)
            , "failed to create a relationship between Destination A and Source 1."
        );

    }

}
