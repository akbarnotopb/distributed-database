# How To Install MySQL Cluster Multi Node With a Load Balancer Using ProxySQL

Dalam kesempatan kali ini saya akan membagikan cara bagaimana menginstall MySQL Cluster Multi Node dengan Load Balancer ProxySQL. 

## Pre-Requisites
Saya menggunakan Vagrant sebagai *Tools* untuk *provisioning* , jadi berikut adalah hal-hal yang perlu diketahui untuk melanjutkan ke tahap selanjutnya. Untuk virtual machine sebenarnya dapat menggunakan provider lainnya, hanya saja disini saya menggunakan Virtualbox.

1. Vagrant ready-installed
2. Vagrant basic Knowledge
3. Virtualbox ready-installed
4. Ubuntu basic scripting

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

Detail hostname ini saya simpan di file `config/hosts` untuk digunakan sebagai bahan *provisioning* ke semua server.

## Installing
Untuk membuat ke-6 server , disini kita hanya perlu melakukan *command* berikut pada direktori dimana *vagrantfile* tersimpan.
```
$ vagrant up
```

### Config 
Setelah menjalankan *command* diatas, akan terbuat 6 buah server beserta *provisioning*-nya.
#### Provisioning
