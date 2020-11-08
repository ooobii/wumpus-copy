#!/bin/bash
set -e

# if config exists, backup to home directory real quick like
if [ -e /etc/wumpus-copy/config.json ] 
then
    echo "Dont worry, I'm backing up your config to your home directory while I install.";
    sudo cp /etc/wumpus-copy/config.json ~/wumpuscopy-backupconfigcopyfile
    echo "";
    echo "";
    sudo apt remove --purge wumpuscopy -y
    echo "";
    echo "";
fi

#test for php ppa, add if not available.
if ! [ -e /etc/apt/sources.list.d/ondref-*-php-*.list ]
then
    echo "Missing required repository! Asking if it's cool to add it...";
    echo "";
    echo "";
    sudo add-apt-repository ppa:ondrej/php;
    echo "";
    echo "";
fi

echo "Downloading package...";
if [ -e wumpuscopy_1.0-2.deb ]
then 
    rm -rf wumpuscopy_1.0-2.deb
fi
curl https://jenkins.matthewwendel.info/job/Wumpus%20Copy/job/Wumpus-Copy-Linux-amd64/lastSuccessfulBuild/artifact/build/wumpuscopy_1.0-2.deb -o wumpuscopy_1.0-2.deb &> /dev/null


echo "Installing package...";
sudo apt install -f ./wumpuscopy_1.0-2.deb
echo "";
echo "";
echo "Done!";
echo "Removing package file...";
rm -rf wumpuscopy_1.0-2.deb


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