#
# Table structure for table 'tx_kjtutorials_single'
#
CREATE TABLE tx_kjtutorials_single (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	fe_group int(11) DEFAULT '0' NOT NULL,
	title tinytext NOT NULL,
	abstract text NOT NULL,
	tutorial text NOT NULL,
	tags tinytext NOT NULL,
	source tinytext NOT NULL,
	result_link tinytext NOT NULL,
	result_image blob NOT NULL,
	nofeuser_name tinytext NOT NULL,
	nofeuser_email tinytext NOT NULL,
	nofeuser_website tinytext NOT NULL,
	feuser_uid blob NOT NULL,
	allow_comments tinyint(3) DEFAULT '0' NOT NULL,
	clicks int(11) DEFAULT '0' NOT NULL,	

	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_kjtutorials_comment'
#
CREATE TABLE tx_kjtutorials_comment (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	fe_group int(11) DEFAULT '0' NOT NULL,
	comment text NOT NULL,
	tutorial_uid tinytext NOT NULL,
	nofeuser_name tinytext NOT NULL,
	nofeuser_email tinytext NOT NULL,
	nofeuser_website tinytext NOT NULL,
	feuser_uid blob NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'be_users'
#
CREATE TABLE be_users (
	tx_kjtutorials_subscription blob NOT NULL
);