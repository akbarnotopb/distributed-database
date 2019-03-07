# How To Install MySQL Cluster Multi Node With a Load Balancer Using ProxySQL

Dalam kesempatan kali ini saya akan membagikan cara bagaimana menginstall MySQL Cluster Multi Node dengan Load Balancer ProxySQL. 

## Catatan Penulis
Disini saya akan menggunakan istilah `server` dengan kata VM (Virtual Machine) karena memang dalam contoh instalasi kali ini dilakukan dalam mesin lokal, dan mengganti istilah server (API) dengan kata `service` agar tidak terjadi kebingungan. Serta **semua file yang telah disediakan pada GIT ini merupakan versi MySQL Cluster yang telah sesuai dengan versi OS Ubuntu 16.04**, hanya saja nama filenya diubah untuk memudahkan pembacaan. Adapun versi MySQL Cluster yang digunakan adalah 7.6.9 . Apabila anda ingin mengganti sesuai versi OS anda , anda bisa download file nya [disini](https://dev.mysql.com/downloads/cluster/). Atau apabila anda menggunakan Ubuntu 18.04 ada sebuah tutorial berbahasa inggris yang cukup jelas [disini](https://www.digitalocean.com/community/tutorials/how-to-create-a-multi-node-mysql-cluster-on-ubuntu-18-04).

Untuk semua password instalasi MySQL dalam tutorial kali ini adalah `admin` , ubahlah sesuai kebutuhan anda.

## Pre-Requisites
Saya menggunakan Vagrant sebagai *Tools* untuk *provisioning* , jadi berikut adalah hal-hal yang perlu diketahui untuk melanjutkan ke tahap selanjutnya. Untuk virtual machine sebenarnya dapat menggunakan provider lainnya, hanya saja disini saya menggunakan Virtualbox.

1. Vagrant ready-installed
2. Vagrant basic Knowledge
3. Virtualbox ready-installed
4. Ubuntu basic scripting
5. Ubuntu Bento 16.04 64bit box

## Arsitektur
Dalam tutorial kali ini saya menggunakan **6 buah** server dengan detail sebagai berikut :

| No | IP Address | Hostname | Deskripsi |
| --- | --- | --- | --- |
| 1 | 192.168.31.100 | manager | Sebagai Node Manager |
| 2 | 192.168.31.192 | proxy | Sebagai Load Balancer (ProxySQL) |
| 3 | 192.168.31.101 | service1 | Sebagai Server 1 (API-1) |
| 4 | 192.168.31.102 | service2 | Sebagai Server 2 (API-2) |
| 5 | 192.168.31.148 | data1 | Sebagai DataNode - 1 |
| 6 | 192.168.31.149 | data2 | Sebagai DataNode - 2 |

Detail hostname ini saya simpan di file `config/hosts` untuk digunakan sebagai bahan *provisioning* ke semua VM dan detail konfigurasi tiap-tiap VM terdapat pada `vagrantfile`.

## 1. Initiating Machine
Untuk membuat ke-6 server , disini kita hanya perlu melakukan *command* berikut pada direktori dimana *vagrantfile* tersimpan.
```
$ vagrant up
```

### 1.1 Config 
Setelah menjalankan *command* diatas, akan terbuat 6 buah server dengan konfigurasi yang telah ditentukan dalam file `vagrantfile` beserta *provisioning*-nya. Sebagai contoh untuk mengatur hostname dan IP seperti kode berikut :
```
manager.vm.hostname = "manager"
manager.vm.network "private_network", ip: "192.168.31.100"
```
#### 1.1.1 Provisioning
Provisioning saya lakukan dengan memecahnya menjadi 2 bagian , yaitu provisioning umum dan provisioning khusus bagi tiap-tiap VM sesuai *role* masing-masing, sebagai contoh provisioning untuk manager :
```
manager.vm.provision "shell", path: "provision/bootstrap.sh", privileged: false
manager.vm.provision "shell", path: "provision/bootstrap-manager.sh", privileged: false
```

File `bootstrap.sh` akan dijalankan disemua Node karena perintah yang dijalankan merupakan perintah umum, yaitu untuk meng-update, copy alamat hosts , dan mengizinkan tiap-tiap node saling berkomunikasi dengan *syntax* berikut :
```
sudo apt-get update -y

sudo cp /vagrant/config/hosts /etc/hosts

sudo ufw allow from 192.168.31.100
sudo ufw allow from 192.168.31.101
sudo ufw allow from 192.168.31.102
sudo ufw allow from 192.168.31.148
sudo ufw allow from 192.168.31.149
sudo ufw allow from 192.168.31.192
```
Adapun detail provisioning yang dilakukan ada di folder `config/provision/`.

## 2. Installing
Apabila anda menggunakan template vagrant pada GIT ini, maka ketika anda menjalankan `vagrant up` , secara otomatis **Node manager, data1 , data2** sudah **siap digunakan** karena semua konfigurasi telah dilakukan ketika provisioning melalui file konfigurasi yang biasa disebut *bootstrap* seperti yang telah dijelaskan di bagian **1.1.1 Provisioning**. Akan tetapi disini saya akan mencoba menjelaskan kembali point-point penting apa yang harus dilakukan.

### 2.1 Installing Manager
#### 2.1.1 Install package Manager
Langkah pertama yang anda harus lakukan adalah mendownload debian package MySQL Cluster Management. Karena telah saya sediakan pada folder `resource/` , cukup copy file management package ke dalam VM dan install dengan syntax :
```
sudo cp /vagrant/resource/mysql-cluster-management.deb ~
sudo dpkg -i ~/mysql-cluster-management.deb
```
#### 2.1.2 Konfigurasi
Selanjutnya lakukan konfigurasi pada file `config.ini` yang akan kita simpan di folder `/var/lib/mysql-cluster/`. Karena file `config.ini` telah saya sediakan sesuai dengan arsitektur yang akan kita buat, maka jalankan perintah berikut :
```
sudo mkdir /var/lib/mysql-cluster
sudo cp /vagrant/config/manager/config.ini /var/lib/mysql-cluster
```
Pada [file](https://github/abaar/distributed-database) `config.ini` , terdapat beberapa konfigurasi yaitu :
```
...
[ndbd default]
NoOfReplicas=2 
...
```
Syntax tersebut merupakan konfigurasi berapa jumlah replikasi yang akan ada di Datanode, Isilah dengan angka, sebaiknya tidak lebih dari jumlah Datanode.
```
...
[ndb_mgmd]
hostname=#IPADDRESS Manager
datadir=#Direktori penyimpanan
...
```
Merupakan konfigurasi Manager, tidak banyak yang perlu dijelaskan...
```
...
[ndbd]
hostname=#IPADDDRESS Datanode 
NodeId=#id node
datadir=#Direktori penyimpanan

...
```
Apabila anda ingin membuat 2 atau lebih datanode maka deklarasikan `[ndbd]` sesuai banyak datanode yang anda inginkan.

```
...
[mysqld]
hostname=#IPADDRESS Service
NodeId=#id Node
...
```
Sama seperti datanode, apabila anda ingin membuat 2 atau lebih service , maka deklarasikan `[mysqld]` sesuai banyak service yang anda inginkan.

#### 2.1.3 Jalankan Manager
Untuk menjalankan service manager, jalankan perintah berikut:
```
sudo ndb_mgmd -f /var/lib/mysql-cluster/config.ini
```
Maka, seharusnya anda akan melihat notifikasi bahwa manager berhasil dijalankan

#### 2.1.4 Membuat Manager Berjalan ketika Booting
Tidak banyak yang bisa saya jelaskan disini, intinya dengan menjalankan syntax berikut , manager akan berjalan ketika booting dengan memasukkannya kedalam service. Kebetulan syntax tersebut sudah saya siapkan dalam folder `config/manager/ndb_mgmd.service`
```
sudo pkill -f ndb_mgmd #Matikan Manager yang sedang berjalan agar tidak terjadi error
sudo cp /vagrant/config/manager/ndb_mgmd.service /etc/systemd/system/ndb_mgmd.service
sudo systemctl daemon-reload
sudo systemctl enable ndb_mgmd
sudo systemctl start ndb_mgmd
```

### 2.2 Install Datanode
Hampir sama dengan cara instalasi Manager, hanya saja file konfigurasi datanode sedikit berbeda. Langkah-langkahnya sebagai berikut
#### 2.2.1 Update & Install Dependencies
Jalankan perintah berikut untuk mengupdate dan instalasi dependensi yang dibutuhkan oleh Datanode
```
sudo apt update -y
sudo apt install libclass-methodmaker-perl -y
```
#### 2.2.2 Instalasi Datanode
Sama seperti sebelumnya, copy dan install debian packagenya.
```
#copy
sudo cp /vagrant/resource/mysql-cluster-datanode.deb ~
#install
sudo dpkg -i ~/mysql-cluster-datanode.deb
```

#### 2.2.3 Konfigurasi Datanode
Karena file telah saya siapkan , maka tinggal jalankan perintah berikut :
```
sudo cp /vagrant/config/datanode/my.cnf /etc/my.cnf
sudo mkdir -p /usr/local/mysql/data #Buat folder untuk menyimpan data
```
Adapun file `my.cnf` hanya berisi alamat Manager yang telah kita buat tadi.
```
[mysql_cluster]
# Options for NDB Cluster processes:
ndb-connectstring=192.168.31.100  # location of cluster manager
```

#### 2.2.4 Jalankan Datanode
Untuk menjalankan datanode cukup dengan syntax berikut :
```
sudo ndbd
```

#### 2.2.5 Buatkan Service untuk Datanode agar Dapat Berjalan ketika Booting
Tidak ada yang perlu dijelaskan , karena pada dasarnya mirip sekali dengan step **2.1.4**
```
sudo pkill -f ndbd
sudo cp /vagrant/config/datanode/ndbd.service /etc/systemd/system/ndbd.service
sudo systemctl daemon-reload
sudo systemctl enable ndbd
sudo systemctl start ndbd
```


### 2.3 Instalasi Service
#### 2.3.1 Update & Install Dependencies

#### 2.3.2 Instalasi Service

#### 2.3.3 Jalankan Service

#### 2.3.4 Percobaan Service

### 2.4 Instalasi ProxySQL
#### 2.4.1 Update & Install Dependencies

#### 2.4.2 Instalasi ProxySQL
#### 2.4.3 Konfirugari ProxySQL
#### 2.4.4 Hubungkan Service dengan ProxySQL
#### 2.4.5 Daftarkan Service ke ProxySQL
#### 2.4.6 Buat User di Service agar dapat Diakses oleh ProxySQL
#### 2.4.7 Buat User di ProxySQL agar dapat Diakses oleh Apps

## 3. Testing
