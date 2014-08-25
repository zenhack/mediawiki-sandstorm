#!/bin/bash

set -e

cp -r /etc/service /tmp
test -d /var/log || cp -r /var_original/* /var

exec /sbin/my_init
