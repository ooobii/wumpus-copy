<?php
use PHPUnit\Framework\TestCase;

require __DIR__ . '/../../lib/requires.php';

class ConfigurationManagerTests extends TestCase
{
    public function testInvalid_Parsing_1() {
        $this->expectException(Exception::class);
        $testConfig = new config_manager(__DIR__ . "/json/testConfig_invalid_badjson1.json");

    }
    public function testInvalid_Parsing_2() {
        $this->expectException(Exception::class);
        $testConfig = new config_manager(__DIR__ . "/json/testConfig_invalid_badjson2.json");
        
    }
    public function testInvalid_Parsing_3() {
        $this->expectException(Exception::class);
        $testConfig = new config_manager(__DIR__ . "/json/testConfig_invalid_badjson3.json");
        
    }


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
            "failed to parse the configuration file."
        );

    }



    public function testMonitor_Metadata_Simple()
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
            "failed to load the nickname from source1."
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
            "failed to load the nickname from source2."
        );

    }

    public function testMonitor_Metadata_Complex()
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
            "failed to load the nickname from source1."
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
            "failed to load the nickname from source2."
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
            "failed to load the nickname from source3."
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
            "failed to load the nickname from source4."
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
            "failed to load the nickname from source5."
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
            "failed to load the nickname from source6."
        );

    }



    public function testDestination_Metadata_Simple()
    {
        #define test variant type
        $fileVariant = 'valid_simple';

        #load the valid test configuration.
        $testConfig = new config_manager(__DIR__ . "/json/testConfig_$fileVariant.json");

        #make sure config is not empty
        $this->assertNotEmpty($testConfig);
        $destinations = $testConfig->get_destinations();

        #verify destination 1 exists
        $this->assertArrayHasKey(
            'destA',
            $destinations,
            "did not load the 'destA' destination."
        );

        #verify destination 2 exists
        $this->assertArrayHasKey(
            'destB',
            $destinations,
            "did not load the 'destB' destination."
        );

        #get destination 1 and test metadata
        $this->assertEquals(
            "[destA-GuildId]",
            $destinations["destA"]->get_guild_id(),
            "failed to load the GuildID from destA."
        );
        $this->assertEquals(
            "[destA-Channel1]",
            $destinations["destA"]->get_channel_id(),
            "failed to load the ChannelID from destA."
        );
        $this->assertEquals(
            "destA",
            $destinations["destA"]->get_nickname(),
            "failed to load the nickname from destA."
        );


        #get destination 2 and test metadata
        $this->assertEquals(
            "[destB-GuildId]",
            $destinations["destB"]->get_guild_id(),
            "failed to load the GuildID from destB."
        );
        $this->assertEquals(
            "[destB-Channel1]",
            $destinations["destB"]->get_channel_id(),
            "failed to load the ChannelID from destB."
        );
        $this->assertEquals(
            "destB",
            $destinations["destB"]->get_nickname(),
            "failed to load the nickname from destB."
        );

    }

    public function testDestination_Metadata_Complex()
    {
        #define test variant type
        $fileVariant = 'valid_complex';

        #load the valid test configuration.
        $testConfig = new config_manager(__DIR__ . "/json/testConfig_$fileVariant.json");

        #make sure config is not empty
        $this->assertNotEmpty($testConfig);
        $destinations = $testConfig->get_destinations();

        #verify destinations exist
        $this->assertArrayHasKey(
            'destA',
            $destinations,
            "did not load the 'destA' destination."
        );
        $this->assertArrayHasKey(
            'destA0',
            $destinations,
            "did not load the 'destA0' destination."
        );
        $this->assertArrayHasKey(
            'destB',
            $destinations,
            "did not load the 'destB' destination."
        );
        $this->assertArrayHasKey(
            'destB0',
            $destinations,
            "did not load the 'destB0' destination."
        );
        $this->assertArrayHasKey(
            'destC',
            $destinations,
            "did not load the 'destC' destination."
        );
        $this->assertArrayHasKey(
            'destC0',
            $destinations,
            "did not load the 'destC0' destination."
        );
        $this->assertArrayHasKey(
            'destC1',
            $destinations,
            "did not load the 'destC1' destination."
        );
        $this->assertArrayHasKey(
            'destD',
            $destinations,
            "did not load the 'destD' destination."
        );
        $this->assertArrayHasKey(
            'destE',
            $destinations,
            "did not load the 'destE' destination."
        );
        $this->assertArrayHasKey(
            'destE1',
            $destinations,
            "did not load the 'destE1' destination."
        );
        $this->assertArrayHasKey(
            'destE2',
            $destinations,
            "did not load the 'destE2' destination."
        );
        $this->assertArrayHasKey(
            'destE3',
            $destinations,
            "did not load the 'destE3' destination."
        );
        $this->assertArrayHasKey(
            'destE4',
            $destinations,
            "did not load the 'destE4' destination."
        );
        $this->assertArrayHasKey(
            'destE5',
            $destinations,
            "did not load the 'destE5' destination."
        );
        $this->assertArrayHasKey(
            'destE6',
            $destinations,
            "did not load the 'destE6' destination."
        );


        #get destA and test metadata
        $this->assertEquals(
            "[destA-GuildId]",
            $destinations["destA"]->get_guild_id(),
            "failed to load the GuildID from destA."
        );
        $this->assertEquals(
            "[destA-Channel1]",
            $destinations["destA"]->get_channel_id(),
            "failed to load the ChannelID from destA."
        );
        $this->assertEquals(
            "destA",
            $destinations["destA"]->get_nickname(),
            "failed to load the nickname from destA."
        );
        #get destA0 and test metadata
        $this->assertEquals(
            "[destA-GuildId]",
            $destinations["destA0"]->get_guild_id(),
            "failed to load the GuildID from destA0."
        );
        $this->assertEquals(
            "[destA-Channel2]",
            $destinations["destA0"]->get_channel_id(),
            "failed to load the ChannelID from destA0."
        );
        $this->assertEquals(
            "destA0",
            $destinations["destA0"]->get_nickname(),
            "failed to load the nickname from destA0."
        );


        #get destB and test metadata
        $this->assertEquals(
            "[destB-GuildId]",
            $destinations["destB"]->get_guild_id(),
            "failed to load the GuildID from destB."
        );
        $this->assertEquals(
            "[destB-Channel1]",
            $destinations["destB"]->get_channel_id(),
            "failed to load the ChannelID from destB."
        );
        $this->assertEquals(
            "destB",
            $destinations["destB"]->get_nickname(),
            "failed to load the nickname from destB."
        );
        #get destB0 and test metadata
        $this->assertEquals(
            "[destB-GuildId]",
            $destinations["destB0"]->get_guild_id(),
            "failed to load the GuildID from destB0."
        );
        $this->assertEquals(
            "[destB-Channel1]",
            $destinations["destB0"]->get_channel_id(),
            "failed to load the ChannelID from destB0."
        );
        $this->assertEquals(
            "destB0",
            $destinations["destB0"]->get_nickname(),
            "failed to load the nickname from destB0."
        );


        #get destC and test metadata
        $this->assertEquals(
            "[destC-GuildId]",
            $destinations["destC"]->get_guild_id(),
            "failed to load the GuildID from destC."
        );
        $this->assertEquals(
            "[destC-Channel1]",
            $destinations["destC"]->get_channel_id(),
            "failed to load the ChannelID from destC."
        );
        $this->assertEquals(
            "destC",
            $destinations["destC"]->get_nickname(),
            "failed to load the nickname from destC."
        );
        #get destC0 and test metadata
        $this->assertEquals(
            "[destC-GuildId]",
            $destinations["destC0"]->get_guild_id(),
            "failed to load the GuildID from destC0."
        );
        $this->assertEquals(
            "[destC-Channel1]",
            $destinations["destC0"]->get_channel_id(),
            "failed to load the ChannelID from destC0."
        );
        $this->assertEquals(
            "destC0",
            $destinations["destC0"]->get_nickname(),
            "failed to load the nickname from destC0."
        );
        #get destC1 and test metadata
        $this->assertEquals(
            "[destC-GuildId]",
            $destinations["destC1"]->get_guild_id(),
            "failed to load the GuildID from destC1."
        );
        $this->assertEquals(
            "[destC-Channel1]",
            $destinations["destC1"]->get_channel_id(),
            "failed to load the ChannelID from destC1."
        );
        $this->assertEquals(
            "destC1",
            $destinations["destC1"]->get_nickname(),
            "failed to load the nickname from destC1."
        );

        
        #get destD and test metadata
        $this->assertEquals(
            "[destD-GuildId]",
            $destinations["destD"]->get_guild_id(),
            "failed to load the GuildID from destD."
        );
        $this->assertEquals(
            "[destD-Channel1]",
            $destinations["destD"]->get_channel_id(),
            "failed to load the ChannelID from destD."
        );
        $this->assertEquals(
            "destD",
            $destinations["destD"]->get_nickname(),
            "failed to load the nickname from destD."
        );


        #get destE and test metadata
        $this->assertEquals(
            "[destE-GuildId]",
            $destinations["destE"]->get_guild_id(),
            "failed to load the GuildID from destE."
        );
        $this->assertEquals(
            "[destE-Channel1]",
            $destinations["destE"]->get_channel_id(),
            "failed to load the ChannelID from destE."
        );
        $this->assertEquals(
            "destE",
            $destinations["destE"]->get_nickname(),
            "failed to load the nickname from destE."
        );
        #get destE0 and test metadata
        $this->assertEquals(
            "[destE-GuildId]",
            $destinations["destE0"]->get_guild_id(),
            "failed to load the GuildID from destE0."
        );
        $this->assertEquals(
            "[destE-Channel1]",
            $destinations["destE0"]->get_channel_id(),
            "failed to load the ChannelID from destE0."
        );
        $this->assertEquals(
            "destE0",
            $destinations["destE0"]->get_nickname(),
            "failed to load the nickname from destE0."
        );
        #get destE1 and test metadata
        $this->assertEquals(
            "[destE-GuildId]",
            $destinations["destE1"]->get_guild_id(),
            "failed to load the GuildID from destE1."
        );
        $this->assertEquals(
            "[destE-Channel2]",
            $destinations["destE1"]->get_channel_id(),
            "failed to load the ChannelID from destE1."
        );
        $this->assertEquals(
            "destE1",
            $destinations["destE1"]->get_nickname(),
            "failed to load the nickname from destE1."
        );
        #get destE2 and test metadata
        $this->assertEquals(
            "[destE-GuildId]",
            $destinations["destE2"]->get_guild_id(),
            "failed to load the GuildID from destE2."
        );
        $this->assertEquals(
            "[destE-Channel2]",
            $destinations["destE2"]->get_channel_id(),
            "failed to load the ChannelID from destE2."
        );
        $this->assertEquals(
            "destE2",
            $destinations["destE2"]->get_nickname(),
            "failed to load the nickname from destE2."
        );
        #get destE3 and test metadata
        $this->assertEquals(
            "[destE-GuildId]",
            $destinations["destE3"]->get_guild_id(),
            "failed to load the GuildID from destE3."
        );
        $this->assertEquals(
            "[destE-Channel3]",
            $destinations["destE3"]->get_channel_id(),
            "failed to load the ChannelID from destE3."
        );
        $this->assertEquals(
            "destE3",
            $destinations["destE3"]->get_nickname(),
            "failed to load the nickname from destE3."
        );
        #get destE4 and test metadata
        $this->assertEquals(
            "[destE-GuildId]",
            $destinations["destE4"]->get_guild_id(),
            "failed to load the GuildID from destE4."
        );
        $this->assertEquals(
            "[destE-Channel3]",
            $destinations["destE4"]->get_channel_id(),
            "failed to load the ChannelID from destE2."
        );
        $this->assertEquals(
            "destE4",
            $destinations["destE4"]->get_nickname(),
            "failed to load the nickname from destE4."
        );
        #get destE5 and test metadata
        $this->assertEquals(
            "[destE-GuildId]",
            $destinations["destE5"]->get_guild_id(),
            "failed to load the GuildID from destE5."
        );
        $this->assertEquals(
            "[destE-Channel4]",
            $destinations["destE5"]->get_channel_id(),
            "failed to load the ChannelID from destE5."
        );
        $this->assertEquals(
            "destE5",
            $destinations["destE5"]->get_nickname(),
            "failed to load the nickname from destE5."
        );
        #get destE6 and test metadata
        $this->assertEquals(
            "[destE-GuildId]",
            $destinations["destE6"]->get_guild_id(),
            "failed to load the GuildID from destE6."
        );
        $this->assertEquals(
            "[destE-Channel4]",
            $destinations["destE6"]->get_channel_id(),
            "failed to load the ChannelID from destE2."
        );
        $this->assertEquals(
            "destE6",
            $destinations["destE6"]->get_nickname(),
            "failed to load the nickname from destE6."
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
            , "failed to create a relationship between Source 3 and Destinations A, A0, and B0."
        );
        $this->assertEquals(
            array('destC' => $destinations['destC'])
            , $monitors['source4']->get_connected_destinations($testConfig)
            , "failed to create a relationship between Source 4 and Destination C."
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
            , "failed to create a relationship between Source 5 and Destinations C0, E, E1, E3, and E5."
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
            , "failed to create a relationship between Source 6 and Destinations C1, E0, E2, E4, and E6."
        );

        #validate destination connections to sources
        $this->assertEquals(
            $monitors['source3']
            , $destinations['destA']->get_connected_monitor($testConfig)
            , "failed to create a relationship between Destination A and Source 3."
        );
        $this->assertEquals(
            $monitors['source3']
            , $destinations['destA0']->get_connected_monitor($testConfig)
            , "failed to create a relationship between Destination A0 and Source 3."
        );
        $this->assertEquals(
            $monitors['source2']
            , $destinations['destB']->get_connected_monitor($testConfig)
            , "failed to create a relationship between Destination B and Source 2."
        );
        $this->assertEquals(
            $monitors['source3']
            , $destinations['destB0']->get_connected_monitor($testConfig)
            , "failed to create a relationship between Destination B and Source 3."
        );
        $this->assertEquals(
            $monitors['source4']
            , $destinations['destC']->get_connected_monitor($testConfig)
            , "failed to create a relationship between Destination C and Source 4."
        );
        $this->assertEquals(
            $monitors['source5']
            , $destinations['destC0']->get_connected_monitor($testConfig)
            , "failed to create a relationship between Destination C0 and Source 5."
        );
        $this->assertEquals(
            $monitors['source6']
            , $destinations['destC1']->get_connected_monitor($testConfig)
            , "failed to create a relationship between Destination C1 and Source 6."
        );
        $this->assertEquals(
            $monitors['source1']
            , $destinations['destD']->get_connected_monitor($testConfig)
            , "failed to create a relationship between Destination D and Source 1."
        );
        $this->assertEquals(
            $monitors['source5']
            , $destinations['destE']->get_connected_monitor($testConfig)
            , "failed to create a relationship between Destination E and Source 5."
        );
        $this->assertEquals(
            $monitors['source6']
            , $destinations['destE0']->get_connected_monitor($testConfig)
            , "failed to create a relationship between Destination E0 and Source 6."
        );
        $this->assertEquals(
            $monitors['source5']
            , $destinations['destE1']->get_connected_monitor($testConfig)
            , "failed to create a relationship between Destination E1 and Source 5."
        );
        $this->assertEquals(
            $monitors['source6']
            , $destinations['destE2']->get_connected_monitor($testConfig)
            , "failed to create a relationship between Destination E2 and Source 6."
        );
        $this->assertEquals(
            $monitors['source5']
            , $destinations['destE3']->get_connected_monitor($testConfig)
            , "failed to create a relationship between Destination E3 and Source 5."
        );
        $this->assertEquals(
            $monitors['source6']
            , $destinations['destE4']->get_connected_monitor($testConfig)
            , "failed to create a relationship between Destination E4 and Source 6."
        );
        $this->assertEquals(
            $monitors['source5']
            , $destinations['destE5']->get_connected_monitor($testConfig)
            , "failed to create a relationship between Destination E5 and Source 5."
        );
        $this->assertEquals(
            $monitors['source6']
            , $destinations['destE6']->get_connected_monitor($testConfig)
            , "failed to create a relationship between Destination E6 and Source 6."
        );

    }

}
