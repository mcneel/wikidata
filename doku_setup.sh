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

# TODO:
# Edit /etc/lighttpd/lighttpd.conf
# enable mod-rewrite
# change document root to
# server.document-root        = "/var/www/dokuwiki"
# at end of file add
# url.rewrite-once = (
#        "^(/|index.php)?$" => "/doku.php",
#        "^/lib/(.*)/?$" => "/lib/$1",
#        "^/_media/(.*)?\?(.*)$" => "/lib/exe/fetch.php?media=$1&$2",
#        "^/_media/(.*)$" => "/lib/exe/fetch.php?media=$1",
#        "^/_detail/(.*)?\?(.*)$" => "/lib/exe/detail.php?media=$1&$2",
#        "^/_detail/(.*)?$" => "/lib/exe/detail.php?media=$1",
#        "^/_export/([^/]+)/(.*)$" => "/doku.php?do=export_$1&id=$2",
#        "^/(?!doku.php|feed.php|robots.txt|sitemap.xml.gz)(.*)\?(.*)/?$" => "/doku.php?id=$1&$2",
#        "^/(?!doku.php|feed.php|robots.txt|sitemap.xml.gz|lib|_media|_detail|_export)(.*)/?$" => "/doku.php?id=$1",
#)

/etc/init.d/lighttpd force-reload

#go to URL/dokuwiki/install.php to start setting up the wiki

git clone https://github.com/mcneel/wikidata.git /var/dokuwiki/wikidata
chown -R www-data:www-data /var/www/dokuwiki/wikidata
