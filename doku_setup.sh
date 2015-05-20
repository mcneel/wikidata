# script for installing dokuwiki on an Amazon EC2 instance
# Tested with Ubuntu Server 14.04 LTS (HVM), SSD Volume Type - ami-d05e75b8
# Micro instance
# Auto-assign Public IP
#
# Reference:
# https://www.dokuwiki.org/install:ubuntu (Ubuntu Server 14.04 and lighttpd)


#update apt-get
apt-get update
apt-get install lighttpd -y
apt-get install php5-cgi -y
apt-get install git -y

#download latest dokuwiki tarball
wget http://download.dokuwiki.org/src/dokuwiki/dokuwiki-stable.tgz
#unzip tarball
tar xvfv dokuwiki-stable.tgz
#move/rename contents to /var/www/dokuwiki
mv dokuwiki-2014-09-29d/ /var/www/dokuwiki/

#change owner to www-data
chown -R www-data:www-data /var/www/dokuwiki/

#configure lightttpd for php
lighttpd-enable-mod fastcgi-php

git clone https://github.com/mcneel/wikidata.git /var/dokuwiki/wikidata
chown -R www-data:www-data /var/www/dokuwiki/wikidata

# copy configuration files to appropriate locations
cp /var/www/dokuwiki/wikidata/conf/lighttpd/lighttpd.conf /etc/lighttpd.conf

cp /var/www/dokuwiki/wikidata/conf/dokuwiki/conf/* /var/www/dokuwiki/conf/
cp /var/www/dokuwiki/wikidata/conf/dokuwiki/lib/plugins/* /var/www/dokuwiki/lib/plugins/
cp /var/www/dokuwiki/wikidata/conf/dokuwiki/lib/tpl/* /var/www/dokuwiki/lib/tpl/
#restart lightttpd
/etc/init.d/lighttpd force-reload
