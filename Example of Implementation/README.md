# Wordpress Installation with MySQL Cluster as its Database

## Jumpto
1. [Architecture](#architecture)
2. [Pre-Requisite](#pre-requisite)
3. [Instalasi Wordpress](#installation)
    1. [Node Baru / Node Proxy?](#pilih-node-aplikasi)
    2. [Langkah-langkah instalasi Wordpress](#langkah-langkah-install-wordpress)
    3. [Langkah-langkah instalasi Apache Jmeter](#langkah-langkah-install-apache-jmeter)
4. Aaa
## Architecture


## Pre-Requisite
1. MyCluster Installed , [klik disini](https://github.com/abaar/distributed-database/blob/master/README.md) jika anda belum menginstall-nya.
2. Apache JMeter - [how to install](https://www.youtube.com/watch?v=M-iAXz8vs48)

## Installation
### Pilih Node Aplikasi
Langkah pertama yang harus dilakukan adalah kita pilih Node dimana kita akan menjalakan Wordpress, ada 2 pilihan, Node baru / Node Proxy. 
Apabila anda menginstallnya di proxy maka lanjut ke langkah [berikut ini](#langkah-langkah-install-wordpress).
Karena pada kesempatan kali ini kita akan menginstall Wordpress pada `Node` baru, maka kita perlu menambahkan node baru pada Vagrant.
#### Tambah Node Aplikasi
Langkah pertamanya adalah menambahkan script berikut agar bisa dibuat oleh vagrant pada `Vagrantfile`. Atau anda bisa skip bagian ini apabila anda menggunakan 
Vagrantfile pada `GIT` ini.
```
  config.vm.define "app1" do |app1|
    app1.vm.box="bento/ubuntu-16.04"
    app1.vm.hostname="app1"
    
    app1.vm.provider "virtualbox" do |vb|
      vb.gui=false
      vb.name="app1-bdt"
      vb.memory="1536"
    end
  
    app1.vm.network "private_network", ip: "192.168.31.232"
    app1.vm.provision "shell", path: "provision/application-layer/bootstrap.sh", privileged:false
    app1.vm.provision "shell", path: "provision/application-layer/bootstrap-app1.sh", privileged:false
  end
```
Selanjutnya mulai pembuatan dengan `vagrant up app1`. Applikasi selesai ter-install. Tinggal lanjut buat konten `Wordpress` aja.

### Langkah langkah Install Wordpress
#### 1. Update dan Install Apache
```
sudo apt-get update -y
sudo apt-get install php7.0 php7.0-mysql libapache2-mod-php7.0 php7.0-cli php7.0-cgi php7.0-gd  -y
```
Seharusnya `APACHE` telah terinstall, jalankan `sudo systemctl status apache2` dan cek apakah hasil yang dikeluarkan sama dengan foto berikut.

![foto status apache]()

#### 2. Update hosts pada `app1`
```
sudo cp /vagrant/config/application-layer/hosts /etc/hosts
sudo ufw allow from proxy
```
#### 3. Update hosts & rule pada `Proxy`
```
sudo ufw allow from 192.168.31.232
```

#### 4. Download Wordpress
Download wordpress di direktori mana saja , karena kita akan memindahkannya ke `/var/www/html/`
```
wget -c http://wordpress.org/latest.tar.gz
```

#### 5. Ekstrak Wordpress
Ekstrak Wordpress dengan perintah berikut.
```
sudo tar -xzvf latest.tar.gz
```
Seharusnya akan terbuat sebuah folder `wordpress` yang berisi aplikasi `wordpress`.

#### 6. Sync ke `/var/www/html/`
```
sudo rsync -av wordpress/* /var/www/html/
```

#### 7. Ubah kepemilikan file
```
sudo chown -R www-data:www-data /var/www/html/
sudo chmod -R 755 /var/www/html/
```

#### 8. Ubah file wp-config.php
```
...
define( 'DB_NAME', 'percobaan_cluster' );
define( 'DB_USER', 'mysqlcluster' );
define( 'DB_PASSWORD', 'admin' );
define( 'DB_HOST', '192.168.31.192:6033' );
...
```
Isi `DB_NAME` dengan database pada MySQL cluster yang telah didaftarkan ke `proxy`, disini saya menggunakan database `percobaan_cluster`.
kemudian isi `USER` dan `PASSWORD` dengan akun yang sama ketika anda mengakses `service` melalui `proxy` atau menggunakan `proxy` melalui `HeidiSQL`.
Lalu `HOST` berisikan alamat `proxy` lengkap dengan `port` yang disediakan oleh `ProxySQL`.


Atau anda bisa menjalankan perintah berikut apabila anda menggunakan `resource` pada `GIT` ini.
```
sudo cp /vagrant/config/application-layer/wp-config.php /var/www/html/

```

#### 9. Restart Apache
```
sudo systemctl restart apache2
```

#### 10. Instal Wordpress Melalui Web Browser
Tahap selanjutnya adalah menginstall melalui web browser, akseslah wordpress dengan `IP APP1` , maka akan muncul gambar pemilihan bahasa dan penambahan akun seperti 2 gambar berikut :

![language](https://github.com/abaar/distributed-database/blob/master/Example%20of%20Implementation/Screenshoot/wordpress_install_1.PNG)

![account](https://github.com/abaar/distributed-database/blob/master/Example%20of%20Implementation/Screenshoot/wordpress_install_2.PNG)

Yang hanya lakukan hanya klik `next` sampai masuk kehalaman `DASHBOARD` seperti halaman berikut :

![homepage]()

#### 11. Testing
Anda dapat mengetest apakah `Wordpress` telah terkoneksi dengan mengecek table pada `services` yang anda miliki, seperti gambar berikut yang memiliki table dan data yang sama setelah proses instalasi.

![table on service1]()

![table on service2]()

### Langkah-langkah install Apache Jmeter
#### 1. Download Jmeter
#### 2. Ekstrak
#### 3. Add Environment
#### 4. Jalankan

## Load Testing
