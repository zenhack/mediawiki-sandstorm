#!/bin/bash

CURRENT_VERSION="1.25.2"
mkdir -p /var/opt/wiki
test -e /var/opt/wiki/wiki.sqlite || cp /opt/app/wiki.sqlite /var/opt/wiki/wiki.sqlite
test -e /var/VERSION || echo "1.23.2" > /var/VERSION
[[ "$(cat /var/VERSION)" == "${CURRENT_VERSION}" ]] || (cd /opt/app/mediawiki && php maintenance/update.php --quick && echo $CURRENT_VERSION > /var/VERSION)

# Create a bunch of folders under the clean /var that php and nginx expect to exist
mkdir -p /var/lib/nginx
mkdir -p /var/lib/php/sessions
mkdir -p /var/log
mkdir -p /var/log/nginx
# Wipe /var/run, since pidfiles and socket files from previous launches should go away
# TODO someday: I'd prefer a tmpfs for these.
rm -rf /var/run
mkdir -p /var/run/php

# Make /var/mediawiki-cache since we configured MW to store some cache
# files here.
mkdir -p /var/mediawiki-cache

# If we haven't created /var/mediawiki-images to store user uploads yet,
# do that now.
test -e /var/mediawiki-images || cp -r /opt/app/mediawiki/images.orig /var/mediawiki-images

# TODO: update the database if necessary. See:
#
# https://www.mediawiki.org/wiki/Manual:Upgrading

# Spawn php
/usr/sbin/php-fpm7.3 --nodaemonize --fpm-config /etc/php/7.3/fpm/php-fpm.conf &
# Wait until php has bound its socket, indicating readiness
while [ ! -e /var/run/php/php7.3-fpm.sock ] ; do
    echo "waiting for php7-fpm to be available at /var/run/php/php7.3-fpm.sock"
    sleep .2
done

# Start nginx.
/usr/sbin/nginx \
	-c /opt/app/.sandstorm/service-config/nginx.conf \
	-g "daemon off;"
