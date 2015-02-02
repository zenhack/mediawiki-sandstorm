# Use phusion/baseimage as base image. To make your builds reproducible, make
# sure you lock down to a specific version, not to `latest`!
# See https://github.com/phusion/baseimage-docker/blob/master/Changelog.md for
# a list of version numbers.
FROM phusion/baseimage:0.9.16

# Set correct environment variables.
ENV HOME /root

# Disable SSH
RUN rm -rf /etc/service/sshd /etc/my_init.d/00_regen_ssh_host_keys.sh
# Disable cron
RUN rm -rf /etc/service/cron

# Use baseimage-docker's init system.
CMD ["/sbin/my_init"]

RUN apt-get update

# Install php
RUN apt-get -y install php5 php5-sqlite

# Install nginx
RUN apt-get -y install php5-fpm nginx
RUN apt-get -y install php-apc

RUN apt-get -y install imagemagick

RUN mkdir /etc/service/nginx
ADD nginx.sh /etc/service/nginx/run

RUN mkdir /etc/service/php
ADD php.sh /etc/service/php/run

# setup nginx
ADD nginx.conf /etc/nginx/nginx.conf
RUN echo "cgi.fix_pathinfo = 0;" >> /etc/php5/fpm/php.ini
RUN sed -i 's_^listen\s*=\s*.*_listen = 127.0.0.1:9000_g' /etc/php5/fpm/pool.d/www.conf
RUN sed -i 's_^user\s*=\s*.*_user = 1000_g' /etc/php5/fpm/pool.d/www.conf
RUN sed -i 's_^group\s*=\s*.*_group = 1000_g' /etc/php5/fpm/pool.d/www.conf

ADD mediawiki-core /opt/app
ADD run_grain.sh /opt/app/run_grain.sh
ADD LocalSettings.php /opt/app/LocalSettings.php
ADD wiki.sqlite /var/opt/wiki/wiki.sqlite

EXPOSE 33411

# Clean up APT when done.
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN rm -rf /usr/share/vim /usr/share/doc /usr/share/man /var/lib/dpkg /var/lib/belocs /var/lib/ucf /var/cache/debconf /var/log/*.log
