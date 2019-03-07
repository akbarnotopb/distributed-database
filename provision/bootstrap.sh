sudo apt-get update -y

sudo cp /vagrant/config/hosts /etc/hosts

sudo ufw allow from 192.168.31.100
sudo ufw allow from 192.168.31.101
sudo ufw allow from 192.168.31.102
sudo ufw allow from 192.168.31.148
sudo ufw allow from 192.168.31.149
sudo ufw allow from 192.168.31.150
sudo ufw allow from 192.168.31.192