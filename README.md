McNeel Public Wiki
========
Source and configuration files for wiki.mcneel.com

The McNeel wiki automatically synchronizes with the text files in this git repository.

----
**To bring up a new wiki server**
1. Launch new Ubuntu instance on EC2. Typical configuration:
  - Ubuntu Server 14.04 LTS (HVM), SSD Volume Type - 64 bit
  - t2.small
  - auto-assign public IP = Enable
  - 8 Gb storage
  - use Public Http Server security group
  - use discoursekey as ssh key
1. ssh into the new instance
1. Update and install required modules
```bash
sudo apt-get update
sudo apt-get install lighttpd -y
sudo apt-get install php5-cgi -y
sudo apt-get install git -y
```
1. The following steps can be pasted into terminal
```bash
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
```
1. Follow the prompts to create/save a ssh key
1. ssh-add the new key
```bash
sudo bash
eval "$(ssh-agent -s)"
ssh-add /var/www/.ssh/id_rsa
exit
```
1. Run the following line and then copy the results. Go to https://github.com/settings/ssh for your account and add this new key to your list
```bash
cat /var/www/.ssh/id_rsa.pub
```
1. Clone this repository on to the new Server
```bash
sudo -u www-data git clone git@github.com:mcneel/wikidata.git /var/www/dokuwiki/wikidata
```
1. configure default user for git in this local repository
```bash
cd /var/www/dokuwiki/wikidata
sudo -u www-data git config user.email "steve@mcneel.com"
sudo -u www-data git config user.name "Steve Baer"
```
1. Copy files from this repo to the appropriate locations
```bash
sudo cp /var/www/dokuwiki/wikidata/conf/lighttpd/lighttpd.conf /etc/lighttpd/lighttpd.conf
sudo cp /var/www/dokuwiki/wikidata/conf/dokuwiki/conf/* /var/www/dokuwiki/conf/
sudo cp -R /var/www/dokuwiki/wikidata/conf/dokuwiki/lib/plugins/* /var/www/dokuwiki/lib/plugins/
sudo cp -R /var/www/dokuwiki/wikidata/conf/dokuwiki/lib/tpl/* /var/www/dokuwiki/lib/tpl/
```
1. Set up user accounts. Our user account list is in a separate private SVN repo since we don't want the email addresses in it to be public http://subversion.mcneel.com/www/wiki/ **Paste** the contents of this list into the nano editor and save
```bash
sudo touch /var/www/dokuwiki/conf/users.auth.php
sudo nano /var/www/dokuwiki/conf/users.auth.php
```
1. Make sure everything in the dokuwiki directory has the proper ownership
```bash
sudo chown -R www-data:www-data /var/www/dokuwiki
```
1. Restart the web Server
```bash
#restart lightttpd
sudo /etc/init.d/lighttpd force-reload
```
1. Point your browser to the public IP address for this server. If everything works :beer:
