# Using MySQL Cluster and Redis Sentinel @ Laravel

# Note

# Jumpto

# Configuration
## MySQL Cluster
### 1. env file
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
```
composer require predis/predis
```
### 2. config/database.php
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
