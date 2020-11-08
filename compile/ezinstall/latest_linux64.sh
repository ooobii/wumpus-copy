#!/bin/bash

# if config exists, backup to home directory real quick like
if [ -e /etc/wumpus-copy/config.json ] 
then
    echo "Dont worry, I'm backing up your config to your home directory while I install.";
    sudo cp /etc/wumpus-copy/config.json ~/wumpuscopy-backupconfigcopyfile
    sudo apt remove --purge wumpuscopy -y
fi

#test for php ppa, add if not available.
if ! [ -e /etc/apt/sources.list.d/ondrej-*-php-*.list ]
then
    echo "Missing required repository! Asking if it's cool to add it...";
    echo "";
    sudo add-apt-repository ppa:ondrej/php;
    echo "";
fi

echo "Running install...";
if [ -e wumpuscopy_1.0-2.deb ]
then 
    rm -rf wumpuscopy_1.0-2.deb
fi
curl https://jenkins.matthewwendel.info/job/Wumpus%20Copy/job/Wumpus-Copy-Linux-amd64/lastSuccessfulBuild/artifact/build/wumpuscopy_1.0-2.deb -o wumpuscopy_1.0-2.deb && sudo dpkg -i wumpuscopy_1.0-2.deb && sudo apt install -f -y && rm -rf wumpuscopy_1.0-2.deb


echo "";
echo "";

echo "The latest version of wumpus copy has been installed!";
if [ -e ~/wumpuscopy-backupconfigcopyfile ]
then 
    echo "Restoring previous config over current config...";
    sudo cp ~/wumpuscopy-backupconfigcopyfile /etc/wumpus-copy/config.json
    rm -rf ~/wumpuscopy-backupconfigcopyfile
    echo "";
    echo "Take a look at the man page to make sure that your configuration is still valid for the new version!";
fi
echo "";
echo "";
echo "All Done! You can run Wumpus Copy in the foreground by running the 'wumpuscopy' command, or";
echo "execute it as a service using the 'sudo systemctl start wumpuscopy' command!";
echo "";