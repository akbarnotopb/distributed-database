# Using MySQL Cluster and Redis Sentinel @ Laravel

# Jumpto
1. [Architecture](#architecture)
1. [Configuration](#configuration)
    1. [MySQL Cluster](#mysql-cluster)
    2. [Redis Sentinel](#redis-sentinel)
2. [Accessing](#accessing)
    1. [MySQL Cluster](#mysql-cluster-1)
    2. [Redis Sentinel](#redis-sentinel-1)
3. [Failover & Screenshots](#failover--screenshots)
    1. [MySQL Cluster](#mysql-cluster-2)
    2. [Redis Sentinel](#redis-sentinel-2)


# Laravel App (example) Description
The app that i'll be using is one of my internship project, it is a Laravel-web-based application that allow the user Register as an `Agent` to share and get Building Properties Information. 

In this example, i'll use MySQL Cluster to store relational datas, meanwhile Location data will be stored in both Redis and MySQL Cluster. Because Location data will be requested frequently in some forms, that's where Redis work its part, and the Location data on MySQL only retrieved when the user request the properties detail.

# Architecture
I'm using this [MySQL Cluster](https://github.com/abaar/distributed-database/blob/master/README.md) and [Redis Sentinel](https://github.com/abaar/redis-implementation) architecture & installation guide.

It cover 3 MySQL Datanodes, 2 MySQL Services, 1 MySQL Manager, 1 ProxySQL. And 3 Redis Server & Sentinel.

![architecture](https://github.com/abaar/distributed-database/blob/master/Implement%20Redis%20Sentinel%20%26%20MySQL%20Cluster%20%40%20Laravel/Arsitektur%20BDT.jpeg)

# Configuration
## MySQL Cluster
### 1. env file
Using MySQL Cluster at `Laravel` is pretty easy, first thing to set up is the `env` file. You need to define the `host` to be requested. it is `192.168.31.192` on my case since i use `ProxySQL` and you need to define the `PORT` also.
```
...
DB_CONNECTION=mysql
DB_HOST=192.168.31.192 # IP of ProxySQL
DB_PORT=6033 # Port of ProxySQL
DB_DATABASE=percobaan_cluster # The DB Defined for the Cluster
DB_USERNAME=mysqlcluster # The ID 
DB_PASSWORD=admin # The Password
...
```
### 2. config/database.php
Since MySQL Cluster is a `ndb`-based engine. You need to tell `Laravel` that every MySQL Request will be using `NDB` engine. You can set it up at `config/databse.php` just like below.
```
...
    'connections' => [
        ...
        'mysql' => [
             ...
            'engine' => 'ndb',
        ],
        ...
    ]
...
```

## Redis Sentinel
### 1. Install predis
You need third party package to use `Redis` at `Laravel`. The most popular package is `predis`.
```
composer require predis/predis
```

### 2. config/database.php
And then , you need to tell `Laravel` that you'll have `Redis Sentinel`. On my case, im using `Sentinel` connection so i can keep the `default` redis for later purposes. Well you can use `Sentinel` as `Redis Default` by changing `sentinel` name to `default`.
```
'redis' => [

    'client' => 'predis',
    ...
    'sentinel' => [
        # Add the sentinel host here , followed by Sentinel's Port
        'tcp://192.168.32.232:26379?timeout=0.100',
        'tcp://192.168.32.233:26379?timeout=0.100',
        'tcp://192.168.32.234:26379?timeout=0.100',
        'options' => [
            'replication' => 'sentinel',
            'service' => env('REDIS_SENTINEL_SERVICE', 'mymaster'), # Type your master here / at env file , default mymaster
            'parameters' => [
                'password' => env('REDIS_PASSWORD', null), # Type your password here / at env file , default null
                'database' => 0,
            ],
        ],
    ...
    ],

],
```


# Accessing
## MySQL Cluster
There is no special code to access MySQL Cluster at the Controller. The same as the default MySQL because laravel will access ProxySQL like standard MySQL but using 'NDB' engine and the ProxySQL will connect the Laravel and MySQL Cluster

## Redis Sentinel
As i mentioned [before](#2--config/database--php-1) that i'll using `sentinel` connection to access `Redis Sentinel`, so you need to define which connection you are requesting. If you choose to use `Redis Sentinel` at default, just use `Redis::lrange` or other `command`.
```
...
use Illuminate\Support\Facades\Redis;
...
  public function index(){
    ...
    Redis::connection('sentinel')->lrange('kecamatan'.$request->city_id,0,-1);
    ...
  }
```

# Failover & Screenshots
## MySQL Cluster
## Redis Sentinel
