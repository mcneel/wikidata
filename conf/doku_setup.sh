# script for installing dokuwiki on an Amazon EC2 instance
# Tested with Ubuntu Server 14.04 LTS (HVM), SSD Volume Type - ami-d05e75b8
# Micro instance
# Auto-assign Public IP
#
# Reference:
# https://www.dokuwiki.org/install:ubuntu (Ubuntu Server 14.04 and lighttpd)

#update apt-get
sudo apt-get update
sudo apt-get install lighttpd -y
sudo apt-get install php5-cgi -y
sudo apt-get install git -y


#download latest dokuwiki tarball
wget http://download.dokuwiki.org/src/dokuwiki/dokuwiki-stable.tgz
#unzip tarball
tar xvfv dokuwiki-stable.tgz
#move/rename contents to /var/www/dokuwiki
sudo mv dokuwiki-2014-09-29d/ /var/www/dokuwiki/
#change owner to www-data
sudo chown -R www-data:www-data /var/www/dokuwiki/
#configure lightttpd for php
sudo lighttpd-enable-mod fastcgi-php
#create ssh key for www-data
sudo mkdir /var/www/.ssh
sudo chown -R www-data:www-data /var/www/.ssh/
sudo -u www-data ssh-keygen -t rsa -b 4096 -C "steve@mcneel.com"


sudo bash
eval "$(ssh-agent -s)"
ssh-add /var/www/.ssh/id_rsa
exit
echo 'add the following key to github`'
cat /var/www/.ssh/id_rsa.pub


sudo -u www-data git clone git@github.com:mcneel/wikidata.git /var/www/dokuwiki/wikidata


# copy configuration files to appropriate locations
sudo cp /var/www/dokuwiki/wikidata/conf/lighttpd/lighttpd.conf /etc/lighttpd/lighttpd.conf
sudo cp /var/www/dokuwiki/wikidata/conf/dokuwiki/conf/* /var/www/dokuwiki/conf/
sudo cp -R /var/www/dokuwiki/wikidata/conf/dokuwiki/lib/plugins/* /var/www/dokuwiki/lib/plugins/
sudo cp -R /var/www/dokuwiki/wikidata/conf/dokuwiki/lib/tpl/* /var/www/dokuwiki/lib/tpl/
sudo touch /var/www/dokuwiki/conf/users.auth.php
sudo nano /var/www/dokuwiki/conf/users.auth.php


sudo chown -R www-data:www-data /var/www/dokuwiki

cd /var/www/dokuwiki/wikidata
sudo -u www-data git config user.email "steve@mcneel.com"
sudo -u www-data git config user.name "Steve Baer"


#restart lightttpd
sudo /etc/init.d/lighttpd force-reload
