#!/bin/bash

PASS_MYSQL_ROOT=`openssl rand -base64 12` # this you need to save. 12 is chars length to password
PASS_PHPMYADMIN_APP=`openssl rand -base64 12` # can be random, won't be used again.  12 is chars length to password
PASS_PHPMYADMIN_ROOT="${PASS_MYSQL_ROOT}" # Your MySQL root pass

if [ "$(id -u)" != "0" ]; then
    echo -e "\n${Yellow} This script must be run as root ${Color_Off}"
    echo -e "${Yellow} Try change to user root: sudo su -- or sudo su - userroot ${Color_Off}"
    echo -e "${Blue} sudo su -- or ${Color_Off}"
    echo -e "${Blue} sudo su - [root username] ${Color_Off}"
    echo -e "" 1>&2
    exit 1
fi

update() {
    # Update system repos
    echo -e "\n${Purple} * Updating package repositories... ${Color_Off}"
    sudo apt-get -qq update -y
    sudo apt-get --fix-broken install --yes
    sudo apt-get list --upgradable
    # sudo apt-get upgrade # upgrade to new versions
}

installGit() {
    echo -e "\n${Cyan} * Installing Git.. ${Color_Off}"
    sudo apt-get -qy install git
}

installApache() {
    # Apache
    echo -e "\n${Cyan} * Installing Apache.. ${Color_Off}"
    sudo apt-get -qy install apache2 apache2-doc libexpat1 ssl-cert
    # check Apache configuration: apachectl configtest
}

installLetsEncryptCertbot() {
    # Let's Encrypt SSL
    echo -e "\n${Cyan} * Installing Let's Encrypt SSL.. ${Color_Off}"
    
    sudo apt-get update # update repo sources
    sudo apt-get install -y software-properties-common # required in order to add a repo
    sudo add-apt-repository ppa:certbot/certbot -y # add Certbot repo
    sudo apt-get update # update repo sources
    sudo apt-get install -y python-certbot-apache # install Certbot
}

installPHP() {
    # PHP and Modules
    echo -e "\n${Cyan} * Installing PHP 8 and common Modules.. ${Color_Off}"
    
    sudo apt-get install -qy ca-certificates apt-transport-https software-properties-common
    sudo add-apt-repository ppa:ondrej/php
    sudo apt-get -qy install php8.0 libapache2-mod-php8.0 php-curl php-dev php-gd php-gettext php-imagick php-intl php-mbstring php-mysql php-pear php-pspell php-recode php-xml php-zip
    sudo apt-get install -qy php8.0-fpm libapache2-mod-fcgid
    sudo apt-get install -qy php-mysql
    sudo apt-get install -qy php-curl
    sudo apt-get install -qy php-imagick
    sudo apt-get install -qy php-mbstring
    sudo apt-get install -qy php-xml
    
    sudo a2enmod proxy_fcgi setenvif
    sudo a2enconf php8.0-fpm
}

installMySQL() {
    # MySQL
    echo -e "\n${Cyan} * Installing MySQL.. ${Color_Off}"
    
    # set password with `debconf-set-selections` so you don't have to enter it in prompt and the script continues
  sudo debconf-set-selections <<< "mysql-server mysql-server/root_password password ${PASS_MYSQL_ROOT}" # new password for the MySQL root user
  sudo debconf-set-selections <<< "mysql-server mysql-server/root_password_again password ${PASS_MYSQL_ROOT}" # repeat password for the MySQL root user

  # DEBIAN_FRONTEND=noninteractive # by setting this to non-interactive, no questions will be asked
  DEBIAN_FRONTEND=noninteractive sudo apt-get -qy install mysql-server mysql-client
}

secureMySQL() {
    # secure MySQL install
    echo -e "\n${Green} * Securing MySQL.. ${Color_Off}"
    
  mysql --user=root --password=${PASS_MYSQL_ROOT} << EOFMYSQLSECURE
DELETE FROM mysql.user WHERE User='root' AND Host NOT IN ('localhost', '127.0.0.1', '::1');
DELETE FROM mysql.user WHERE User='';
DELETE FROM mysql.db WHERE Db='test' OR Db='test_%';
FLUSH PRIVILEGES;
EOFMYSQLSECURE
    
    # NOTE: Skipped validate_password because it'll cause issues with the generated password in this script
}

installPHPMyAdmin() {
    # PHPMyAdmin
    echo -e "\n${Cyan} * Installing PHPMyAdmin.. ${Color_Off}"
    
    # set answers with `debconf-set-selections` so you don't have to enter it in prompt and the script continues
  sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/reconfigure-webserver multiselect apache2" # Select Web Server
  sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/dbconfig-install boolean true" # Configure database for phpmyadmin with dbconfig-common
  sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/mysql/app-pass password ${PASS_PHPMYADMIN_APP}" # Set MySQL application password for phpmyadmin
  sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/app-password-confirm password ${PASS_PHPMYADMIN_APP}" # Confirm application password
  sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/mysql/admin-pass password ${PASS_MYSQL_ROOT}" # MySQL Root Password
  sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/internal/skip-preseed boolean true"

  DEBIAN_FRONTEND=noninteractive sudo apt-get -qy install phpmyadmin
}

installUhppotePHP() {
    echo -e "\n${Cyan} * Installing Uhppote PHP.. ${Color_Off}"
    sudo git clone https://github.com/realashleybailey/Uhppote-PHP/ /var/www/
}

enableMods() {
    # Enable mod_rewrite, required for WordPress permalinks and .htaccess files
    echo -e "\n${Cyan} * Enabling Modules.. ${Color_Off}"
    
    sudo a2enmod rewrite
}

setPermissions() {
    # Permissions
    echo -e "\n${Green} * Setting Ownership for /var/www.. ${Color_Off}"
    sudo chown -R www-data:www-data /var/www
    # Allow Read/Write for Owner
    sudo chmod -R 0777 /var/www/Uhppote-PHP/
    # Allow to run Apache on boot up
    sudo systemctl enable apache2
    sudo systemctl start apache2
    # Adjust Firewall
    sudo ufw allow in "Apache Full"
}

restartApache() {
    # Restart Apache
    echo -e "\n${Green} * Restarting Apache.. ${Color_Off}"
    sudo service apache2 restart #or
    sudo systemctl restart apache2
}

finally () {
    # update
    sudo apt update
    sudo apt upgrade
    sudo apt-get autoremove
    sudo apt-get autoclean
}

createPassFile() {
    sudo touch /var/www/Uhppote-PHP/Passwords_DELETE.txt
    echo "UhppotePHP username is: uhppoteadmin" > /var/www/Uhppote-PHP/Passwords_DELETE.txt
    echo "UhppotePHP password is: uhppotephp" >> /var/www/Uhppote-PHP/Passwords_DELETE.txt
    echo " " >> /var/www/Uhppote-PHP/Passwords_DELETE.txt
    echo "MySQL username is: root" >> /var/www/Uhppote-PHP/Passwords_DELETE.txt
    echo "MySQL password is: ${PASS_MYSQL_ROOT}" >> /var/www/Uhppote-PHP/Passwords_DELETE.txt
}

update
installGit
installApache
installLetsEncryptCertbot
installPHP
installMySQL
secureMySQL
installPHPMyAdmin
installUhppotePHP
enableMods
setPermissions
restartApache
createFileAndOpenBrowser
update
finally
createPassFile


echo -e "${Green}";
echo -e "  ____ ___.__                          __           __________  ___ _____________  "
echo -e " |    |   \  |__ ______ ______   _____/  |_  ____   \______   \/   |   \______   \ "
echo -e " |    |   /  |  \\____ \\____ \ /  _ \   __\/ __ \   |     ___/    ~    \     ___/ "
echo -e " |    |  /|   Y  \  |_> >  |_> >  <_> )  | \  ___/   |    |   \    Y    /    |     "
echo -e " |______/ |___|  /   __/|   __/ \____/|__|  \___  >  |____|    \___|_  /|____|     "
echo -e "               \/|__|   |__|                    \/                   \/            "
echo -e "                                                                                   "
echo -e "                                                                                   "
echo -e "Your have Successfully!"
echo -e " "
echo -e "UhppotePHP username is: uhppoteadmin"
echo -e "UhppotePHP password is: uhppotephp"
echo -e " "
echo -e "MySQL username is: root"
echo -e "MySQL password is: ${PASS_MYSQL_ROOT}"
echo -e "Saved to /var/www/Uhppote-PHP/Passwords_DELETE.txt"
echo -e "${Color_Off}"
