#!/bin/bash

PASS_MYSQL_ROOT=`openssl rand -base64 12` # this you need to save. 12 is chars length to password
PASS_PHPMYADMIN_APP=`openssl rand -base64 12` # can be random, won't be used again.  12 is chars length to password
PASS_PHPMYADMIN_ROOT="${PASS_MYSQL_ROOT}" # Your MySQL root pass

if [ "$(whoami)" != "root" ]; then
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

installPHP() {
    # PHP and Modules
    echo -e "\n${Cyan} * Installing PHP 8 and common Modules.. ${Color_Off}"
    
    sudo add-apt-repository --yes ppa:ondrej/php
    
    sudo apt-get -qy install ca-certificates apt-transport-https software-properties-common
    sudo apt-get -qy install php8.0 php-curl php-dev php-gd php-gettext php-imagick php-intl php-mbstring php-mysql php-pear php-pspell php-recode php-xml php-zip
    sudo apt-get -qy install php8.0-fpm libapache2-mod-fcgid
    sudo apt-get -qy install php-mysql
    sudo apt-get -qy install php-curl
    sudo apt-get -qy install php-imagick
    sudo apt-get -qy install php-mbstring
    sudo apt-get -qy install php-xml
    sudo apt-get -qy install libapache2-mod-php
    
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
    sudo git clone https://github.com/realashleybailey/Uhppote-PHP/ /var/www/Uhppote-PHP
}

createVhost() {
    printf "\033c"
    read -p "What is your domain [uhhpote.example.com]: " domain
    read -p "What is your email [uhhpote@example.com]: " email
    printf "\033c"
    
    sudo touch /etc/apache2/sites-available/${domain}.conf

    echo "<VirtualHost *:80>" > /etc/apache2/sites-available/${domain}.conf
    echo "    ServerAdmin ${email}" >> /etc/apache2/sites-available/${domain}.conf
    echo "    ServerName ${domain}" >> /etc/apache2/sites-available/${domain}.conf
    echo " " >> /etc/apache2/sites-available/${domain}.conf
    echo "    DocumentRoot /var/www/Uhppote-PHP/public_html" >> /etc/apache2/sites-available/${domain}.conf
    echo " " >> /etc/apache2/sites-available/${domain}.conf
    echo "    <Directory /var/www/Uhppote-PHP/public_html>" >> /etc/apache2/sites-available/${domain}.conf
    echo "            Options Indexes FollowSymLinks" >> /etc/apache2/sites-available/${domain}.conf
    echo "            AllowOverride All" >> /etc/apache2/sites-available/${domain}.conf
    echo "            Require all granted" >> /etc/apache2/sites-available/${domain}.conf
    echo "    </Directory>" >> /etc/apache2/sites-available/${domain}.conf
    echo "</VirtualHost>" >> /etc/apache2/sites-available/${domain}.conf

    sudo a2ensite ${domain}.conf
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
    sudo chmod -R 0755 /var/www/Uhppote-PHP/public_html/
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
installPHP

printf "\033c"
read -r -p "Would you like to install MySQL? [Y/n] - Default is [Y] " input

case $input in
    [yY][eE][sS]|[yY])
        installMySQL
        secureMySQL
    ;;
    [nN][oO]|[nN])
        
    ;;
    *)
        installMySQL
        secureMySQL
    ;;
esac

printf "\033c"
read -r -p "Would you like to install PhpMyAdmin? [Y/n] - Default is [Y] " input

case $input in
    [yY][eE][sS]|[yY])
        installPHPMyAdmin
    ;;
    [nN][oO]|[nN])
        
    ;;
    *)
        installPHPMyAdmin
    ;;
esac

installUhppotePHP
createVhost
enableMods
setPermissions
restartApache
createFileAndOpenBrowser
update
finally
createPassFile


echo -e "${Green}";
echo -e "  _    _ _                       _         _____  _    _ _____   "
echo -e " | |  | | |                     | |       |  __ \| |  | |  __ \  "
echo -e " | |  | | |__  _ __  _ __   ___ | |_ ___  | |__) | |__| | |__) | "
echo -e " | |  | | '_ \| '_ \| '_ \ / _ \| __/ _ \ |  ___/|  __  |  ___/  "
echo -e " | |__| | | | | |_) | |_) | (_) | ||  __/ | |    | |  | | |      "
echo -e "  \____/|_| |_| .__/| .__/ \___/ \__\___| |_|    |_|  |_|_|      "
echo -e "              | |   | |                                          "
echo -e "              |_|   |_|                                          "
echo -e " "
echo -e " "
echo -e "Your have Successfully!"
echo -e " "
echo -e "UhppotePHP username is: uhppoteadmin"
echo -e "UhppotePHP password is: uhppotephp"
echo -e " "
echo -e "MySQL username is: root"
echo -e "MySQL password is: ${PASS_MYSQL_ROOT}"
echo -e " "
echo -e "Saved to /var/www/Uhppote-PHP/Passwords_DELETE.txt"
echo -e "${Color_Off}"
