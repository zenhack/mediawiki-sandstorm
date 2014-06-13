#!/usr/bin/env bash

# First:
#
# sudo apt-get install php5
# sudo apt-get install php5-sqlite

cp LocalSettings_sandstorm.php core/LocalSettings.php
cp DefaultSettings_sandstorm.php core/includes/DefaultSettings.php
