#!/bin/bash

if [ ! -e /var/wgSecretKey.php ]; then
	key="$(dd if=/dev/urandom bs=1 count=32 | base64)"
	echo '<?php $wgSecretKey = "'"$key"'";' > /var/wgSecretKey.php
fi

CURRENT_VERSION="$(cat /opt/app/.sandstorm/version.txt)"
if [ ! -e /var/VERSION ]; then
	cp -r /opt/app/init-var/* /var/
	mkdir -p /var/lib/nginx
fi

[[ "$(cat /var/VERSION)" == "${CURRENT_VERSION}" ]] || (cd /opt/app/mediawiki && php maintenance/update.php --quick && echo $CURRENT_VERSION > /var/VERSION)

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
