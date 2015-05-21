McNeel Public Wiki
========
Source and configuration files for wiki.mcneel.com

The McNeel wiki automatically synchronizes with the text files in this git repository.

----
**To bring up a new wiki server**
- Launch new Ubuntu instance on EC2. Typical configuration:
  - Ubuntu Server 14.04 LTS (HVM), SSD Volume Type - 64 bit
  - t2.small
  - auto-assign public IP = Enable
  - check 'protect against accidental termination"
  - 8 Gb storage
  - use PublicHttpServer security group
  - use discoursekey as ssh key
- ssh into the new instance
- Update and install required modules
```bash
sudo apt-get update
sudo apt-get install lighttpd -y
sudo apt-get install php5-cgi -y
sudo apt-get install git -y
```
- The following steps can be pasted into terminal
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
- Follow the prompts to create/save a ssh key. Accept defaults
- ssh-add the new key
```bash
sudo bash
eval "$(ssh-agent -s)"
ssh-add /var/www/.ssh/id_rsa
exit
```
- Run the following line and then copy the results. Go to https://github.com/settings/ssh for your account and add this new key to your list
```bash
cat /var/www/.ssh/id_rsa.pub
```
- Clone this repository on to the new Server
```bash
sudo -u www-data git clone git@github.com:mcneel/wikidata.git /var/www/dokuwiki/wikidata
```
- configure default user for git in this local repository
```bash
cd /var/www/dokuwiki/wikidata
sudo -u www-data git config user.email "steve@mcneel.com"
sudo -u www-data git config user.name "Steve Baer"
```
- Copy files from this repo to the appropriate locations
```bash
sudo cp /var/www/dokuwiki/wikidata/conf/lighttpd/lighttpd.conf /etc/lighttpd/lighttpd.conf
sudo cp /var/www/dokuwiki/wikidata/conf/dokuwiki/conf/* /var/www/dokuwiki/conf/
sudo cp -R /var/www/dokuwiki/wikidata/conf/dokuwiki/lib/plugins/* /var/www/dokuwiki/lib/plugins/
sudo cp -R /var/www/dokuwiki/wikidata/conf/dokuwiki/lib/tpl/* /var/www/dokuwiki/lib/tpl/
```
- Set up user accounts. Our user account list is in a separate private SVN repo since we don't want the email addresses in it to be public http://subversion.mcneel.com/www/wiki/ **Paste** the contents of this list into the nano editor and save
```bash
sudo touch /var/www/dokuwiki/conf/users.auth.php
sudo nano /var/www/dokuwiki/conf/users.auth.php
```
- Make sure everything in the dokuwiki directory has the proper ownership
```bash
sudo chown -R www-data:www-data /var/www/dokuwiki
```
- Restart the web Server
```bash
#restart lightttpd
sudo /etc/init.d/lighttpd force-reload
```
- Point your browser to the public IP address for this server. If everything works :beer:
- If you're happy with the results, change the Elastic IP associated with the Wiki to point at the server instance you just launched. The elastic IP exists in the VPC->Elastic IP control panel.
- 

