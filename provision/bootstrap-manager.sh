sudo cp /vagrant/resource/mysql-cluster-management.deb ~
sudo dpkg -i ~/mysql-cluster-management.deb

sudo mkdir /var/lib/mysql-cluster
sudo cp /vagrant/config/manager/config.ini /var/lib/mysql-cluster

sudo ndb_mgmd -f /var/lib/mysql-cluster/config.ini

#kill it to reload at systemds
sudo pkill -f ndb_mgmd


#adding to systemds
sudo cp /vagrant/config/manager/ndb_mgmd.service /etc/systemd/system/ndb_mgmd.service


sudo systemctl daemon-reload

sudo systemctl enable ndb_mgmd

sudo systemctl start ndb_mgmd