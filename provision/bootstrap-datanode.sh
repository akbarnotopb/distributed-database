sudo apt update -y
sudo apt install libclass-methodmaker-perl -y

#copy
sudo cp /vagrant/resource/mysql-cluster-datanode.deb ~

#install
sudo dpkg -i ~/mysql-cluster-datanode.deb

sudo cp /vagrant/config/datanode/my.cnf /etc/my.cnf

sudo mkdir -p /usr/local/mysql/data

sudo ndbd

#killllll
sudo pkill -f ndbd

sudo cp /vagrant/config/datanode/ndbd.service /etc/systemd/system/ndbd.service

sudo systemctl daemon-reload

sudo systemctl enable ndbd

sudo systemctl start ndbd