<?php
$dbTable['radacct'] = <<<EOSQL
CREATE TABLE IF NOT EXISTS radacct (
	radacctid bigint(21) NOT NULL auto_increment,
	acctsessionid varchar(64) NOT NULL default '',
	acctuniqueid varchar(32) NOT NULL default '',
	username varchar(64) NOT NULL default '',
	groupname varchar(64) NOT NULL default '',
	realm varchar(64) default '',
	nasipaddress varchar(15) NOT NULL default '',
	nasportid varchar(15) default NULL,
	nasporttype varchar(32) default NULL,
	acctstarttime datetime NULL default NULL,
	acctstoptime datetime NULL default NULL,
	acctsessiontime int(12) default NULL,
	acctauthentic varchar(32) default NULL,
	connectinfo_start varchar(50) default NULL,
	connectinfo_stop varchar(50) default NULL,
	acctinputoctets bigint(20) default NULL,
	acctoutputoctets bigint(20) default NULL,
	calledstationid varchar(50) NOT NULL default '',
	callingstationid varchar(50) NOT NULL default '',
	acctterminatecause varchar(32) NOT NULL default '',
	servicetype varchar(32) default NULL,
	framedprotocol varchar(32) default NULL,
	framedipaddress varchar(15) NOT NULL default '',
	acctstartdelay int(12) default NULL,
	acctstopdelay int(12) default NULL,
	xascendsessionsvrkey varchar(10) default NULL,
	PRIMARY KEY  (radacctid),
	KEY username (username),
	KEY framedipaddress (framedipaddress),
	KEY acctsessionid (acctsessionid),
	KEY acctsessiontime (acctsessiontime),
	KEY acctuniqueid (acctuniqueid),
	KEY acctstarttime (acctstarttime),
	KEY acctstoptime (acctstoptime),
	KEY nasipaddress (nasipaddress)
) ;
EOSQL;

$dbTable['radcheck'] = <<<EOSQL
CREATE TABLE IF NOT EXISTS radcheck (
	id int(11) unsigned NOT NULL auto_increment,
	username varchar(64) NOT NULL default '',
	attribute varchar(64)  NOT NULL default '',
	op char(2) NOT NULL DEFAULT '==',
	value varchar(253) NOT NULL default '',
	PRIMARY KEY  (id),
	KEY username (username(32))
) ;
EOSQL;

$dbTable['radgroupcheck'] = <<<EOSQL
CREATE TABLE IF NOT EXISTS radgroupcheck(
	id int( 11 ) unsigned NOT null auto_increment,
	groupname varchar( 64 ) NOT null default '',
	attribute varchar( 64 )  NOT null default '',
	op char( 2 ) NOT null DEFAULT '==',
	value varchar( 253 )  NOT null default '',
	PRIMARY KEY( id ),
	KEY groupname( groupname( 32 ) )
) ;
EOSQL;

$dbTable['radgroupreply'] = <<<EOSQL
CREATE TABLE IF NOT EXISTS radgroupreply(
	id int( 11 ) unsigned NOT null auto_increment,
	groupname varchar( 64 ) NOT null default '',
	attribute varchar( 64 )  NOT null default '',
	op char( 2 ) NOT null DEFAULT '=',
	value varchar( 253 )  NOT null default '',
	PRIMARY KEY( id ),
	KEY groupname( groupname( 32 ) )
) ;
EOSQL;


$dbTable['radreply'] = <<<EOSQL
CREATE TABLE IF NOT EXISTS radreply(
	id int( 11 ) unsigned NOT null auto_increment,
	username varchar( 64 ) NOT null default '',
	attribute varchar( 64 ) NOT null default '',
	op char( 2 ) NOT null DEFAULT '=',
	value varchar( 253 ) NOT null default '',
	PRIMARY KEY( id ),
	KEY username( username( 32 ) )
) ;
EOSQL;

$dbTable['radusergroup'] = <<<EOSQL
CREATE TABLE IF NOT EXISTS radusergroup(
	username varchar( 64 ) NOT null default '',
	groupname varchar( 64 ) NOT null default '',
	priority int( 11 ) NOT null default '1',
	KEY username( username( 32 ) )
) ;
EOSQL;


$dbTable['radpostauth'] = <<<EOSQL
CREATE TABLE IF NOT EXISTS radpostauth(
	id int( 11 ) NOT null auto_increment,
	username varchar( 64 ) NOT null default '',
	pass varchar( 64 ) NOT null default '',
	reply varchar( 32 ) NOT null default '',
	authdate timestamp NOT null,
	PRIMARY KEY( id )
) ;
EOSQL;

$dbTable['nas'] = <<<EOSQL
CREATE TABLE IF NOT EXISTS nas (
	id int(10) NOT NULL auto_increment,
	nasname varchar(128) NOT NULL,
	shortname varchar(32),
	type varchar(30) DEFAULT 'other',
	ports int(5),
	secret varchar(60) DEFAULT 'secret' NOT NULL,
	server varchar(64),
	community varchar(50),
	description varchar(200) DEFAULT 'RADIUS Client',
	PRIMARY KEY (id),
	KEY nasname (nasname)
 );
EOSQL;


$dbTable['rmadmin'] = <<<EOSQL
CREATE TABLE IF NOT EXISTS rmadmin
(
	fullname VARCHAR (255) NOT NULL,
	email VARCHAR (255) UNIQUE NOT NULL,
	username VARCHAR (255) PRIMARY KEY,
	password VARCHAR (40) NOT NULL
);
EOSQL;

$dbTable['rmsettings'] = <<<EOSQL
CREATE TABLE IF NOT EXISTS rmsettings
(
	settingid INT PRIMARY KEY AUTO_INCREMENT,
	vkey VARCHAR (255) NOT NULL UNIQUE,
	data LONGTEXT DEFAULT NULL
);
EOSQL;

$dbTable['alterRadcheck'] = <<<EOSQL
ALTER TABLE radcheck ADD COLUMN fullname VARCHAR (255) NOT NULL, ADD COLUMN email VARCHAR (255) UNIQUE NOT NULL;
EOSQL;


$dbTable['insertDisableGroup'] = <<<EOSQL
INSERT INTO radgroupcheck  (groupname,attribute,op,value) VALUES ('freeRADIUS-Disabled-Users','Auth-Type',':=','Reject');
EOSQL;
