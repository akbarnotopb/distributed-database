CREATE USER 'mysql_monitor'@'%' IDENTIFIED BY 'admin';
GRANT SELECT on sys.* to 'mysql_monitor'@'%';
FLUSH PRIVILEGES;


CREATE USER 'mysqlcluster'@'%' IDENTIFIED BY 'admin';
GRANT ALL PRIVILEGES on percobaan_cluster.* to 'mysqlcluster'@'%';
FLUSH PRIVILEGES;