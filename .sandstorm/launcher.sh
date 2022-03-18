#!/bin/bash

CURRENT_VERSION="1.25.2"
mkdir -p /var/opt/wiki
test -e /var/opt/wiki/wiki.sqlite || cp /opt/app/wiki.sqlite /var/opt/wiki/wiki.sqlite
test -e /var/VERSION || echo "1.23.2" > /var/VERSION
[[ "$(cat /var/VERSION)" == "${CURRENT_VERSION}" ]] || (cd /opt/app/mediawiki-core && php maintenance/update.php --quick && echo $CURRENT_VERSION > /var/VERSION)

# Create a bunch of folders under the clean /var that php and nginx expect to exist
mkdir -p /var/lib/nginx
mkdir -p /var/lib/php5/sessions
mkdir -p /var/log
mkdir -p /var/log/nginx
# Wipe /var/run, since pidfiles and socket files from previous launches should go away
# TODO someday: I'd prefer a tmpfs for these.
rm -rf /var/run
mkdir -p /var/run

# Make /var/mediawiki-cache since we configured MW to store some cache
# files here.
mkdir -p /var/mediawiki-cache

# If we haven't created /var/mediawiki-images to store user uploads yet,
# do that now.
test -e /var/mediawiki-images || cp -r /opt/app/mediawiki-core/images.orig /var/mediawiki-images

# TODO: update the database if necessary. See:
#
# https://www.mediawiki.org/wiki/Manual:Upgrading

# Spawn php
/usr/sbin/php5-fpm --nodaemonize --fpm-config /etc/php5/fpm/php-fpm.conf &
# Wait until php has bound its socket, indicating readiness
while [ ! -e /var/run/php5-fpm.sock ] ; do
    echo "waiting for php5-fpm to be available at /var/run/php5-fpm.sock"
    sleep .2
done

# Start nginx.
/usr/sbin/nginx -g "daemon off;"
