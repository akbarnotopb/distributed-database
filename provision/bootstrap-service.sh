sudo apt update -y
sudo apt install libaio1 libmecab2 -y

sudo mkdir -p install

sudo cp /vagrant/resource/service/* ~/install/

sudo dpkg -i install/mysql-cluster-common.deb
sudo dpkg -i install/mysql-cluster-community-client.deb
sudo dpkg -i install/mysql-cluster-client.deb

sudo ufw allow 33061
sudo ufw allow 3306

#sudo dpkg -i install/mysql-cluster-community-server.deb
#sudo dpkg -i install/mysql-cluster-server.deb
#sudo cp /vagrant/config/service/1/my.cnf /etc/mysql/

#sudo systemctl restart mysql
#sudo systemctl enable mysql
