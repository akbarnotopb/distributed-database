sudo apt-get update -y

sudo cp /vagrant/config/application-layer/hosts /etc/hosts

sudo ufw allow from 192.168.31.192

sudo apt-get install php7.0 php7.0-mysql libapache2-mod-php7.0 php7.0-cli php7.0-cgi php7.0-gd  -y

sudo systemctl restart apache2

# sudo cp /vagrant/config/application-layer/wordpress.conf /etc/apache2/sites-available/

# sudo a2enmod rewrite

# sudo systemctl restart apache2

wget -c http://wordpress.org/latest.tar.gz

sudo tar -xzvf latest.tar.gz
#
sudo rsync -av wordpress/* /var/www/html/
sudo chown -R www-data:www-data /var/www/html/
sudo chmod -R 755 /var/www/html/

sudo cp /vagrant/config/application-layer/wp-config.php /var/www/html/

sudo systemctl restart apache2

# sudo touch wordpress/.htaccess

# sudo cp wordpress/wp-config-sample.php wordpress/wp-config.php

# sudo mkdir wordpress/wp-content/upgrade

# sudo cp -a wordpress/. /var/www/wordpress

# sudo chown -R www-data:www-data /var/www/wordpress

# sudo chmod -R 755 /var/www/html/