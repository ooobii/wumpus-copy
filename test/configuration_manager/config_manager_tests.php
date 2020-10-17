<?php
use PHPUnit\Framework\TestCase;

require __DIR__ . '/../../lib/requires.php';

class tests_config_manager extends TestCase
{

    public function testParsing()
    {
        #define test variant types
        $fileVariants = ['valid_simple', 'valid_complex'];

        foreach ($fileVariants as $fileVariant) {
            #load the valid test configuration.
            $testConfig = new config_manager(__DIR__ . "/json/testConfig_$fileVariant.json");

            #make sure config is not empty
            $this->assertNotEmpty(
                $testConfig,
                "Configuration manager failed to parse the configuration file (File: testConfig_$fileVariant.json)."
            );
        }

    }

    public function testMetadata_Monitor()
    {
        #define test variant type
        $fileVariants = ['valid_simple', 'valid_complex'];

        foreach ($fileVariants as $fileVariant) {

            #load the valid test configuration.
            $testConfig = new config_manager(__DIR__ . "/json/testConfig_$fileVariant.json");

            #make sure config is not empty
            $this->assertNotEmpty($testConfig);
            $monitors = $testConfig->get_monitors();

            switch ($fileVariant) {
                case 'valid_simple':
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
                    break;

                case 'valid_complex':
                    # code...
                    break;

                default:
                    throw new Exception("Invalid fileVariant.");
                    break;
            }

        }
    }

    public function testRelationships()
    {
        #define test variant types
        $fileVariants = ['valid_simple', 'valid_complex'];

        foreach ($fileVariants as $fileVariant) {

            #load the valid test configuration.
            $testConfig = new config_manager(__DIR__ . "/json/testConfig_$fileVariant.json");

            #make sure config is not empty
            $this->assertNotEmpty($testConfig);

            #get monitors and deposits
            $monitors = $testConfig->get_monitors();
            $destinations = $testConfig->get_destinations();
            $this->assertNotEmpty(
                $monitors
                , "Configuration Manager: Unable to fetch monitors from configuration class instance (File: testConfig_$fileVariant.json)."
            );
            $this->assertNotEmpty(
                $destinations
                , "Configuration Manager: Unable to fetch deposit destinations from configuration class instance (File: testConfig_$fileVariant.json)."
            );

            switch ($fileVariant) {
                case 'valid_simple':
                    #validate source connections to destinations
                    $this->assertEquals(
                        array('destA' => $destinations['destA'])
                        , $monitors['source1']->get_connected_destinations($testConfig)
                        , "Configuration Manager failed to create a relationship between Source 1 and Destination A (File: testConfig_$fileVariant.json)."
                    );
                    $this->assertEquals(
                        array('destB' => $destinations['destB'])
                        , $monitors['source2']->get_connected_destinations($testConfig)
                        , "Configuration Manager failed to create a relationship between Source 2 and Destination B (File: testConfig_$fileVariant.json)."
                    );


                    #validate destination connections to sources
                    $this->assertEquals(
                        $monitors['source1']
                        , $destinations['destA']->get_connected_monitor($testConfig)
                        , "Configuration Manager failed to create a relationship between Destination A and Source 1 (File: testConfig_$fileVariant.json)."
                    );
                    $this->assertEquals(
                        $monitors['source2']
                        , $destinations['destB']->get_connected_monitor($testConfig)
                        , "Configuration Manager failed to create a relationship between Destination B and Source 2 (File: testConfig_$fileVariant.json)."
                    );

                    break;

                case 'valid_complex':
                    # code...
                    break;

                default:
                    throw new Exception("improper 'file_variant'");
                    break;
            }
            #test connections between monitors

        }

    }
}
