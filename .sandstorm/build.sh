#!/bin/bash
# Checks if there's a composer.json, and if so, installs/runs composer.

set -euo pipefail

cd /opt/app/mediawiki

rm -f /opt/app/mediawiki/composer.lock
if [ -f /opt/app/mediawiki/composer.json ] ; then
    if [ ! -f composer.phar ] ; then
        curl -sS https://getcomposer.org/installer | php
    fi
    php composer.phar install --no-dev
fi
