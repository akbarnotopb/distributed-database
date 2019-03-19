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
	
CREATE TABLE rc1_range (
    a INT,
    b INT
)
PARTITION BY RANGE COLUMNS(a, b) (
    PARTITION p0 VALUES LESS THAN (5, 12),
    PARTITION p3 VALUES LESS THAN (MAXVALUE, MAXVALUE)
);


#######################################################
CREATE TABLE userlogs_list (
    username VARCHAR(20) NOT NULL, 
    logdata BLOB NOT NULL,
    created DATETIME NOT NULL
)
PARTITION BY LIST COLUMNS (username)(
    PARTITION admin_12 VALUES IN('admin1','admin2'),
    PARTITION admin_34 VALUES IN('admin3','admin4')
);

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

######################################################
CREATE TABLE userslogs_hash (
    username VARCHAR(20) NOT NULL,
    logdata BLOB NOT NULL,
    created DATETIME NOT NULL,
    PRIMARY KEY(username, created)
)
PARTITION BY HASH( TO_DAYS(created) )
PARTITIONS 10;

CREATE TABLE rc1_hash (
    a INT NULL,
    b INT NULL
)
PARTITION BY HASH (a)
PARTITIONS 10;

#######################################################
CREATE TABLE userslogs_key (
    username VARCHAR(20) NOT NULL,
    logdata BLOB NOT NULL,
    created DATETIME NOT NULL,
    PRIMARY KEY(username, created)
)
PARTITION BY KEY( username )
PARTITIONS 10;

CREATE TABLE rc1_key (
    a INT NOT NULL,
    b INT NULL,
	PRIMARY KEY(a)
)
PARTITION BY KEY (a)
PARTITIONS 10;

##########################################################
INSERT INTO rc1_range (a,b) VALUES (4,11);
INSERT INTO rc1_range (a,b) VALUES (5,11);
INSERT INTO rc1_range (a,b) VALUES (6,11);
INSERT INTO rc1_range (a,b) VALUES (4,12);
INSERT INTO rc1_range (a,b) VALUES (5,12);
INSERT INTO rc1_range (a,b) VALUES (6,12);
INSERT INTO rc1_range (a,b) VALUES (4,13);
INSERT INTO rc1_range (a,b) VALUES (5,13);
INSERT INTO rc1_range (a,b) VALUES (6,13);

###########################################################

INSERT INTO rc1_list (a,b) VALUES (0,0);
INSERT INTO rc1_list (a,b) VALUES (NULL,NULL);
INSERT INTO rc1_list (a,b) VALUES (0,1);
INSERT INTO rc1_list (a,b) VALUES (1,0);
INSERT INTO rc1_list (a,b) VALUES (1,3);

###########################################################

INSERT INTO rc1_hash (a,b) VALUES (4,11);
INSERT INTO rc1_hash (a,b) VALUES (5,11);
INSERT INTO rc1_hash (a,b) VALUES (6,11);
INSERT INTO rc1_hash (a,b) VALUES (4,12);
INSERT INTO rc1_hash (a,b) VALUES (5,12);
INSERT INTO rc1_hash (a,b) VALUES (6,12);
INSERT INTO rc1_hash (a,b) VALUES (4,13);
INSERT INTO rc1_hash (a,b) VALUES (5,13);
INSERT INTO rc1_hash (a,b) VALUES (6,13);

############################################################


INSERT INTO rc1_key (a,b) VALUES (4,11);
INSERT INTO rc1_key (a,b) VALUES (5,11);
INSERT INTO rc1_key (a,b) VALUES (6,11);