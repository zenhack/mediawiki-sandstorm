#!/bin/bash

set -e

cp -r /etc/service /tmp
test -d /var/log || cp -r /var_original/* /var
test -d /var/images || mkdir -p /var/images

# Version migration
test -e /var/VERSION || echo "1.23.2" > /var/VERSION
[[ "$(cat /var/VERSION)" == "1.24.1" ]] || (cd /opt/app && php maintenance/update.php && echo "1.24.1" > /var/VERSION)

exec /sbin/my_init
