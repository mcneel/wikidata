McNeel Public Wiki
========
Source and configuration files for wiki.mcneel.com

The McNeel wiki automatically synchronizes with the text files in this git repository.

----
**To bring up a new wiki server**
1. Launch new Ubuntu instance on EC2. Typical configuration:
  - Ubuntu Server 18.04 LTS (HVM), SSD Volume Type - 64 bit
  - t2.small
  - auto-assign public IP = Enable
  - check 'protect against accidental termination"
  - 8 Gb storage
  - use PublicHttpServer security group
  - use dokuwikikey as ssh key
2. ssh into the new instance
3. Update and install required modules
```bash
sudo apt-get update
sudo apt-get install lighttpd -y
sudo apt-get install php-cgi -y
sudo apt-get install php-xml -y
```
4. The following steps can be pasted into terminal
```bash
#download latest dokuwiki tarball
wget https://download.dokuwiki.org/src/dokuwiki/dokuwiki-stable.tgz
#unzip tarball
tar xvfv dokuwiki-stable.tgz
#move/rename contents to /var/www/dokuwiki
sudo mv dokuwiki-2020-07-29/ /var/www/dokuwiki/
#change owner to www-data
sudo chown -R www-data:www-data /var/www/dokuwiki/
#configure lightttpd for php
sudo lighttpd-enable-mod fastcgi-php
#create ssh key for www-data
sudo mkdir /var/www/.ssh
sudo chown -R www-data:www-data /var/www/.ssh/
sudo -u www-data ssh-keygen -t rsa -b 4096 -C "steve@mcneel.com"
```
5. Follow the prompts to create/save a ssh key. Accept defaults
6. ssh-add the new key
```bash
sudo bash
eval "$(ssh-agent -s)"
ssh-add /var/www/.ssh/id_rsa
exit
```
7. Run the following line and then copy the results. Go to https://github.com/settings/ssh for your account and add this new key to your list
```bash
cat /var/www/.ssh/id_rsa.pub
```
8. Clone this repository on to the new Server
```bash
sudo -u www-data git clone git@github.com:mcneel/wikidata.git /var/www/dokuwiki/wikidata
```
9. configure default user for git in this local repository
```bash
cd /var/www/dokuwiki/wikidata
sudo -u www-data git config user.email "steve@mcneel.com"
sudo -u www-data git config user.name "Steve Baer"
```
10. Copy files from this repo to the appropriate locations
```bash
sudo cp /var/www/dokuwiki/wikidata/conf/lighttpd/lighttpd.conf /etc/lighttpd/lighttpd.conf
sudo cp /var/www/dokuwiki/wikidata/conf/dokuwiki/conf/* /var/www/dokuwiki/conf/
sudo cp /var/www/dokuwiki/wikidata/conf/letsencrypt/renew.sh /etc/letsencrypt/renew.sh
sudo chmod 700 /etc/letsencrypt/renew.sh
sudo cp -R /var/www/dokuwiki/wikidata/conf/dokuwiki/lib/plugins/* /var/www/dokuwiki/lib/plugins/
sudo cp -R /var/www/dokuwiki/wikidata/conf/dokuwiki/lib/tpl/* /var/www/dokuwiki/lib/tpl/
```

11. Provide a DNS hostname for the server in Route53. Wait your browser resolves the domain name.
12. Install certbot:
```bash
sudo add-apt-repository ppa:certbot/certbot
sudo apt-get update
sudo apt-get install certbot
```
13. Get SSL cert:
```bash
sudo certbot certonly --webroot -w /var/www/dokuwiki -d wiki.mcneel.com -d www.wiki.mcneel.com
```

14. Set up SSL renewal:
```
sudo crontab -e
add the following line:
0 0 * * * /etc/letsencrypt/renew.sh
```

13. Set up user accounts. Our user account list is in a separate private SVN repo since we don't want the email addresses in it to be public http://subversion.mcneel.com/www/wiki/ **Paste** the contents of this list into the nano editor and save
```bash
sudo touch /var/www/dokuwiki/conf/users.auth.php
sudo nano /var/www/dokuwiki/conf/users.auth.php
```

16. Make sure everything in the dokuwiki directory has the proper ownership
```bash
sudo chown -R www-data:www-data /var/www/dokuwiki
```
17. Restart the web Server
```bash
#restart lighttpd
sudo /etc/init.d/lighttpd restart
```
18. Point your browser to the public IP address for this server. If everything works :beer:

19. If you're happy with the results, change the Elastic IP associated with the Wiki to point at the server instance you just launched. The elastic IP exists in the VPC->Elastic IP control panel.

20. To add superusers to the system
```
ssh into the server
sudo nano /var/www/dokuwiki/conf/local.protected.php
add to $conf['superuser'] line
```
