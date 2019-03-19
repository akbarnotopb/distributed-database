# Menggunakan MySQL Partition pada InnoDB

## Jumpto
1. [Memulai Contoh Partisi Create & Insert](#memulai-create-table-dengan-masing-masing-metode-partisi)
   1. [Range Partition](#range-partition)
   2. [List Partition](#list-partition)
   3. [Hash Partition](#hash-partition)
   4. [Key Partition](#key-partition)
2. [A Typical Use Case: Time Series Data](#a-typical-use-case-time-series-data)
   1. [Import](#import)
   2. [Explain](#explain)
   3. [Select and Benchmark](#select)
   4. [Delete and Benchmark](#big-delete)

## Pre-Requisites
1. MySQL Installed
2. Ekstensi `PARTITION` ada dan aktif

## Pengecekan Ekstensi `PARTITION`
Untuk mengecek apakah di MySQL Partition Aktif / Tidak gunakanlah command ini
```
SELECT
    PLUGIN_NAME as Name,
    PLUGIN_VERSION as Version,
    PLUGIN_STATUS as Status
    FROM INFORMATION_SCHEMA.PLUGINS
    WHERE PLUGIN_TYPE='STORAGE ENGINE';
```
Maka akan muncul semua plugin bertipe `STORAGE ENGINE` seperti gambar dibawah ini:

![SS Partisi Aktif](https://github.com/abaar/distributed-database/blob/master/MySQL%20Partition%20InnoDB/Resource/Screenshoot/partition_active.png)

## Kenapa tidak pakai Engine NDB?
Karena Engine NDB memiliki keterbatasan metode Partisi yaitu metode `KEY` saja, selengkapnya di [link disini](https://dev.mysql.com/doc/refman/5.7/en/partitioning-limitations-storage-engines.html).
Berikut contoh perintah yang dapat dilakukan di `ENGINE=NDB`
```
CREATE TABLE serverlogs4 (
    serverid INT NOT NULL, 
    logdata BLOB NOT NULL,
    created DATETIME NOT NULL,
    UNIQUE KEY (serverid)
)ENGINE=NDB
PARTITION BY KEY();
```

## Memulai Create Table dengan Masing Masing Metode Partisi
Semua code `create table` dan `insert` data ada [disini](https://github.com/abaar/distributed-database/blob/master/MySQL%20Partition%20InnoDB/Resource/bdt.sql)

### >Range Partition
Untuk membuat partisi dengan `range` tertentu dapat dibuat dengan perintah

#### >>userlogs
```
CREATE TABLE userslogs_range (
    username VARCHAR(20) NOT NULL,
    logdata BLOB NOT NULL,
    created DATETIME NOT NULL,
    PRIMARY KEY(username, created)
)
PARTITION BY RANGE( YEAR(created) )(
    PARTITION from_2013_or_less VALUES LESS THAN (2014),
    PARTITION from_2014 VALUES LESS THAN (2015),
    PARTITION from_2015 VALUES LESS THAN (2016),
    PARTITION from_2016_and_up VALUES LESS THAN MAXVALUE);
```

![Hasil Userlogs_range](https://github.com/abaar/distributed-database/blob/master/MySQL%20Partition%20InnoDB/Resource/Screenshoot/2.%20userlogs_range_succeed.PNG)

#### >>rc1
```
CREATE TABLE rc1_range (
    a INT,
    b INT
)
PARTITION BY RANGE COLUMNS(a, b) (
    PARTITION p0 VALUES LESS THAN (5, 12),
    PARTITION p3 VALUES LESS THAN (MAXVALUE, MAXVALUE)
);
```

![Hasil rc1_range](https://github.com/abaar/distributed-database/blob/master/MySQL%20Partition%20InnoDB/Resource/Screenshoot/2.%20rc1_range_succeed.PNG)

Untuk `INSERT` data dengan melakukan `QUERY` seperti berikut;
```
INSERT INTO rc1_range (a,b) VALUES (4,11);
INSERT INTO rc1_range (a,b) VALUES (5,11);
INSERT INTO rc1_range (a,b) VALUES (6,11);
INSERT INTO rc1_range (a,b) VALUES (4,12);
INSERT INTO rc1_range (a,b) VALUES (5,12);
INSERT INTO rc1_range (a,b) VALUES (6,12);
INSERT INTO rc1_range (a,b) VALUES (4,13);
INSERT INTO rc1_range (a,b) VALUES (5,13);
INSERT INTO rc1_range (a,b) VALUES (6,13);
```
![Hasil rc1_query_range](https://github.com/abaar/distributed-database/blob/master/MySQL%20Partition%20InnoDB/Resource/Screenshoot/2.%20rc1_range_query_succeed.PNG)

![Hasil rc1_explain_range](https://github.com/abaar/distributed-database/blob/master/MySQL%20Partition%20InnoDB/Resource/Screenshoot/2.%20rc1_range_explain_succeed.PNG)

### >List Partition
Untuk membuat partisi dengan `list` tertentu dapat dibuat dengan perintah
#### >>userlogs
```
CREATE TABLE userlogs_list (
    username VARCHAR(20) NOT NULL, 
    logdata BLOB NOT NULL,
    created DATETIME NOT NULL
)
PARTITION BY LIST COLUMNS (username)(
    PARTITION admin_12 VALUES IN('admin1','admin2'),
    PARTITION admin_34 VALUES IN('admin3','admin4')
);
```

![Hasil userlogs_list](https://github.com/abaar/distributed-database/blob/master/MySQL%20Partition%20InnoDB/Resource/Screenshoot/2.%20userlogs_list_succeed.PNG)

#### >>rc1
```
CREATE TABLE rc1_list (
    a INT NULL,
    b INT NULL
)
PARTITION BY LIST COLUMNS(a,b) (
    PARTITION p0 VALUES IN( (0,0), (NULL,NULL) ),
    PARTITION p1 VALUES IN( (0,1), (0,2), (0,3), (1,1), (1,2) ),
    PARTITION p2 VALUES IN( (1,0), (2,0), (2,1), (3,0), (3,1) ),
    PARTITION p3 VALUES IN( (1,3), (2,2), (2,3), (3,2), (3,3) )
);
```

![Hasil rc1_list](https://github.com/abaar/distributed-database/blob/master/MySQL%20Partition%20InnoDB/Resource/Screenshoot/2.%20rc1_list_succeed.PNG)

Untuk `INSERT` data dengan melakukan `QUERY` seperti berikut;
```
INSERT INTO rc1_list (a,b) VALUES (0,0);
INSERT INTO rc1_list (a,b) VALUES (NULL,NULL);
INSERT INTO rc1_list (a,b) VALUES (0,1);
INSERT INTO rc1_list (a,b) VALUES (1,0);
INSERT INTO rc1_list (a,b) VALUES (1,3);
```
![Hasil rc1_query_key](https://github.com/abaar/distributed-database/blob/master/MySQL%20Partition%20InnoDB/Resource/Screenshoot/2.%20rc1_list_query_succeed.PNG)

![Hasil rc1_explain_key](https://github.com/abaar/distributed-database/blob/master/MySQL%20Partition%20InnoDB/Resource/Screenshoot/2.%20rc1_list_explain_succeed.PNG)

### >Hash Partition
Untuk membuat partisi dengan `hash` dapat dibuat dengan perintah
#### >>userlogs
```
CREATE TABLE userslogs_hash (
    username VARCHAR(20) NOT NULL,
    logdata BLOB NOT NULL,
    created DATETIME NOT NULL,
    PRIMARY KEY(username, created)
)
PARTITION BY HASH( TO_DAYS(created) )
PARTITIONS 10;
```

![Hasil userlogs_hash](https://github.com/abaar/distributed-database/blob/master/MySQL%20Partition%20InnoDB/Resource/Screenshoot/2.%20userlogs_hash_succeed.PNG)

#### >>rc1
```
CREATE TABLE rc1_hash (
    a INT NULL,
    b INT NULL
)
PARTITION BY HASH (a)
PARTITIONS 10;
```

![Hasil rc1_hash](https://github.com/abaar/distributed-database/blob/master/MySQL%20Partition%20InnoDB/Resource/Screenshoot/2.%20rc1_hash_succeed.PNG)

Untuk `INSERT` data dengan melakukan `QUERY` seperti berikut;
```
INSERT INTO rc1_hash (a,b) VALUES (4,11);
INSERT INTO rc1_hash (a,b) VALUES (5,11);
INSERT INTO rc1_hash (a,b) VALUES (6,11);
INSERT INTO rc1_hash (a,b) VALUES (4,12);
INSERT INTO rc1_hash (a,b) VALUES (5,12);
INSERT INTO rc1_hash (a,b) VALUES (6,12);
INSERT INTO rc1_hash (a,b) VALUES (4,13);
INSERT INTO rc1_hash (a,b) VALUES (5,13);
INSERT INTO rc1_hash (a,b) VALUES (6,13);
```
![Hasil rc1_query_key](https://github.com/abaar/distributed-database/blob/master/MySQL%20Partition%20InnoDB/Resource/Screenshoot/2.%20rc1_hash_query_succeed.PNG)

![Hasil rc1_explain_key](https://github.com/abaar/distributed-database/blob/master/MySQL%20Partition%20InnoDB/Resource/Screenshoot/2.%20rc1_hash_explain_succeed.PNG)

### >Key Partition
Untuk membuat partisi dengan `hash` dapat dibuat dengan perintah
#### >>userlogs
```
CREATE TABLE userslogs_key (
    username VARCHAR(20) NOT NULL,
    logdata BLOB NOT NULL,
    created DATETIME NOT NULL,
    PRIMARY KEY(username, created)
)
PARTITION BY KEY( username )
PARTITIONS 10;
```

![Hasil userlogs_key](https://github.com/abaar/distributed-database/blob/master/MySQL%20Partition%20InnoDB/Resource/Screenshoot/2.%20userlogs_key_succeed.PNG)

#### >>rc1
```
CREATE TABLE rc1_key (
    a INT NOT NULL,
    b INT NULL,
	PRIMARY KEY(a)
)
PARTITION BY KEY (a)
PARTITIONS 10;
```

![Hasil rc1_key](https://github.com/abaar/distributed-database/blob/master/MySQL%20Partition%20InnoDB/Resource/Screenshoot/2.%20rc1_key_succeed.PNG)

Untuk `INSERT` data dengan melakukan `QUERY` seperti berikut;
```
INSERT INTO rc1_key (a,b) VALUES (4,11);
INSERT INTO rc1_key (a,b) VALUES (5,11);
INSERT INTO rc1_key (a,b) VALUES (6,11);
```
![Hasil rc1_query_key](https://github.com/abaar/distributed-database/blob/master/MySQL%20Partition%20InnoDB/Resource/Screenshoot/2.%20rc1_key_query_succeed.PNG)

![Hasil rc1_explain_key](https://github.com/abaar/distributed-database/blob/master/MySQL%20Partition%20InnoDB/Resource/Screenshoot/2.%20rc1_key_explain_succeed.PNG)


## A Typical Use Case: Time Series Data
### Import
Lakukan import data +-(40MB) yang bisa anda dapatkan di halaman [berikut](https://www.vertabelo.com/blog/technical-articles/everything-you-need-to-know-about-mysql-partitions)

### Explain
Untuk melihat plan eksekusi anda dapat menjalankannya dengan perintah `EXPLAIN` seperti gambar berikut :
![explain big query](https://github.com/abaar/distributed-database/blob/master/MySQL%20Partition%20InnoDB/Resource/Screenshoot/explain_benchmark.PNG)

![explain big delete](https://github.com/abaar/distributed-database/blob/master/MySQL%20Partition%20InnoDB/Resource/Screenshoot/explain_benchmark_delete.PNG)

### Select
Benchmark / Perbandigan kecepatan `SELECT` pada kedua table `measure` yang ter-partisi dengan yang tidak dapat dilihat di gambar berikut.

![benchmark select](https://github.com/abaar/distributed-database/blob/master/MySQL%20Partition%20InnoDB/Resource/Screenshoot/benchmark%20select.PNG)

### Big Delete
Benchmark / Perbandigan kecepatan `DELETE` pada kedua table `measure` yang ter-partisi dengan yang tidak dapat dilihat di gambar berikut.

![benchmark delete](https://github.com/abaar/distributed-database/blob/master/MySQL%20Partition%20InnoDB/Resource/Screenshoot/benchmark_delete.PNG)

