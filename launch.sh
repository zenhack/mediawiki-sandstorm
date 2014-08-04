#!/bin/bash

set -e

echo "making var"
if [ ! -d "/var/opt" ]; then
    mkdir /var/opt
fi
if [ ! -d "/var/opt/wiki" ]; then
    mkdir /var/opt/wiki
    cp wiki.sqlite /var/opt/wiki
fi
if [ ! -d "/var/lib" ]; then
    mkdir /var/lib
fi
if [ ! -d "/var/lib/php5" ]; then
    mkdir /var/lib/php5
fi
#find /var

echo "launching server"
cd mediawiki-core
php5 -S 127.0.0.1:10000
