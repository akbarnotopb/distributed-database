# Menggunakan MySQL Partition pada InnoDB

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

## Memulai Percobaan Masing-Masing Metode
