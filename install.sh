#!/usr/bin/env bash

# First:
#
# sudo apt-get install php5
# sudo apt-get install php5-sqlite

if [ -d "build" ]; then
    rm -r build
fi
mkdir build

mkdir build/mediawiki
cd build/mediawiki
tar xvzf ../../arc/mediawiki-1.23.0.tar.gz 
cd ../..

cp LocalSettings_sandstorm.php build/mediawiki/mediawiki-1.23.0/LocalSettings.php
cp DefaultSettings_sandstorm.php build/mediawiki/mediawiki-1.23.0/includes/DefaultSettings.php

#if [ ! -d "/var/lib" ]; then
#    sudo mkdir /var/lib
#fi
#if [ ! -d "/var/lib/mysql" ]; then
#    sudo mkdir /var/lib/mysql
#fi

#if [ ! -d "build/data" ]; then
#    mkdir build/data
#fi
#./scripts/mysql_install_db --datadir=../../data

