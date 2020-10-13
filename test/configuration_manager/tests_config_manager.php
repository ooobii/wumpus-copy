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

}