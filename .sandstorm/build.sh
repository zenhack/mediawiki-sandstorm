#!/bin/bash
# Checks if there's a composer.json, and if so, installs/runs composer.

set -euo pipefail

cd /opt/app/mediawiki-core

rm -f /opt/app/mediawiki-core/composer.lock
if [ -f /opt/app/mediawiki-core/composer.json ] ; then
    if [ ! -f composer.phar ] ; then
        curl -sS https://getcomposer.org/installer | php
    fi
    php composer.phar install --no-dev
fi
