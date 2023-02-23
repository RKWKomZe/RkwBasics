#
# Table structure for table 'pages'
#
CREATE TABLE pages
(

	tx_rkwbasics_department     int(11) unsigned DEFAULT '0' NOT NULL,
	tx_rkwbasics_document_type  int(11) unsigned DEFAULT '0' NOT NULL,
	tx_rkwbasics_external_link  varchar(255) DEFAULT '' NOT NULL,
	tx_rkwbasics_series         int(11) unsigned DEFAULT '0' NOT NULL,
	tx_rkwbasics_enterprisesize int(11) unsigned DEFAULT '0' NOT NULL,
	tx_rkwbasics_sector         int(11) unsigned DEFAULT '0' NOT NULL,
	tx_rkwbasics_companytype    int(11) unsigned NOT NULL default '0',
);

CREATE TABLE pages_language_overlay
(

	tx_rkwbasics_teaser_text text NOT NULL,
	tx_rkwbasics_information text NOT NULL
);

#
# Table structure for table 'tx_rkwbasics_domain_model_department'
#
CREATE TABLE tx_rkwbasics_domain_model_department
(

	uid              int(11) NOT NULL auto_increment,
	pid              int(11) DEFAULT '0' NOT NULL,

	name             varchar(255) DEFAULT '' NOT NULL,
	short_name       varchar(255) DEFAULT '' NOT NULL,
	internal_name    varchar(255) DEFAULT '' NOT NULL,
	css_class        varchar(255) DEFAULT '' NOT NULL,
	main_page        varchar(255) DEFAULT '' NOT NULL,
	description      text                    NOT NULL,
	visibility       int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp           int(11) unsigned DEFAULT '0' NOT NULL,
	crdate           int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id        int(11) unsigned DEFAULT '0' NOT NULL,
	deleted          tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden           tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime        int(11) unsigned DEFAULT '0' NOT NULL,
	endtime          int(11) unsigned DEFAULT '0' NOT NULL,
	sorting          int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent      int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource  mediumblob,

	PRIMARY KEY (uid),
	KEY              parent (pid),

	KEY language (l10n_parent,sys_language_uid)

);


#
# Table structure for table 'tx_rkwbasics_domain_model_documenttype'
#
CREATE TABLE tx_rkwbasics_domain_model_documenttype
(

	uid               int(11) NOT NULL auto_increment,
	pid               int(11) DEFAULT '0' NOT NULL,

	name              varchar(255) DEFAULT '' NOT NULL,
	short_name        varchar(255) DEFAULT '' NOT NULL,
	internal_name     varchar(255) DEFAULT '' NOT NULL,
	box_template_name varchar(255) DEFAULT '' NOT NULL,
	description       varchar(255) DEFAULT '' NOT NULL,
	visibility        int(11) unsigned DEFAULT '0' NOT NULL,
	type              varchar(255) DEFAULT '' NOT NULL,

	tstamp            int(11) unsigned DEFAULT '0' NOT NULL,
	crdate            int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id         int(11) unsigned DEFAULT '0' NOT NULL,
	deleted           tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden            tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime         int(11) unsigned DEFAULT '0' NOT NULL,
	endtime           int(11) unsigned DEFAULT '0' NOT NULL,
	sorting           int(11) DEFAULT '0' NOT NULL,

	sys_language_uid  int(11) DEFAULT '0' NOT NULL,
	l10n_parent       int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource   mediumblob,

	PRIMARY KEY (uid),
	KEY               parent (pid),

	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_rkwbasics_domain_model_series'
#
CREATE TABLE tx_rkwbasics_domain_model_series
(

	uid              int(11) NOT NULL auto_increment,
	pid              int(11) DEFAULT '0' NOT NULL,

	name             varchar(255) DEFAULT '' NOT NULL,
	short_name       varchar(255) DEFAULT '' NOT NULL,
	description      varchar(255) DEFAULT '' NOT NULL,
	visibility       int(11) unsigned DEFAULT '0' NOT NULL,
	type             varchar(255) DEFAULT '' NOT NULL,

	tstamp           int(11) unsigned DEFAULT '0' NOT NULL,
	crdate           int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id        int(11) unsigned DEFAULT '0' NOT NULL,
	deleted          tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden           tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime        int(11) unsigned DEFAULT '0' NOT NULL,
	endtime          int(11) unsigned DEFAULT '0' NOT NULL,
	sorting          int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent      int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource  mediumblob,

	PRIMARY KEY (uid),
	KEY              parent (pid),

	KEY language (l10n_parent,sys_language_uid)

);



#
# Table structure for table 'tx_rkwbasics_domain_model_enterprisesize'
#
CREATE TABLE tx_rkwbasics_domain_model_enterprisesize
(

	uid              int(11) NOT NULL auto_increment,
	pid              int(11) DEFAULT '0' NOT NULL,

	name             varchar(255) DEFAULT '' NOT NULL,
	short_name       varchar(255) DEFAULT '' NOT NULL,
	description      varchar(255) DEFAULT '' NOT NULL,
	visibility       int(11) unsigned DEFAULT '0' NOT NULL,
	type             varchar(255) DEFAULT '' NOT NULL,

	tstamp           int(11) unsigned DEFAULT '0' NOT NULL,
	crdate           int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id        int(11) unsigned DEFAULT '0' NOT NULL,
	deleted          tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden           tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime        int(11) unsigned DEFAULT '0' NOT NULL,
	endtime          int(11) unsigned DEFAULT '0' NOT NULL,
	sorting          int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent      int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource  mediumblob,

	PRIMARY KEY (uid),
	KEY              parent (pid),

	KEY language (l10n_parent,sys_language_uid)

);


#
# Table structure for table 'tx_rkwbasics_domain_model_sector'
#
CREATE TABLE tx_rkwbasics_domain_model_sector
(

	uid              int(11) NOT NULL auto_increment,
	pid              int(11) DEFAULT '0' NOT NULL,

	name             varchar(255) DEFAULT '' NOT NULL,
	short_name       varchar(255) DEFAULT '' NOT NULL,
	description      varchar(255) DEFAULT '' NOT NULL,
	visibility       int(11) unsigned DEFAULT '0' NOT NULL,
	type             varchar(255) DEFAULT '' NOT NULL,

	tstamp           int(11) unsigned DEFAULT '0' NOT NULL,
	crdate           int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id        int(11) unsigned DEFAULT '0' NOT NULL,
	deleted          tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden           tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime        int(11) unsigned DEFAULT '0' NOT NULL,
	endtime          int(11) unsigned DEFAULT '0' NOT NULL,
	sorting          int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent      int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource  mediumblob,

	PRIMARY KEY (uid),
	KEY              parent (pid),

	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_rkwbasics_domain_model_companytype'
#
CREATE TABLE tx_rkwbasics_domain_model_companytype
(

	uid              int(11) NOT NULL auto_increment,
	pid              int(11) DEFAULT '0' NOT NULL,

	name             varchar(255) DEFAULT '' NOT NULL,

	tstamp           int(11) unsigned DEFAULT '0' NOT NULL,
	crdate           int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id        int(11) unsigned DEFAULT '0' NOT NULL,
	deleted          tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden           tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime        int(11) unsigned DEFAULT '0' NOT NULL,
	endtime          int(11) unsigned DEFAULT '0' NOT NULL,
	sorting          int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent      int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource  mediumblob,

	PRIMARY KEY (uid),
	KEY              parent (pid),

	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_rkwbasics_domain_model_target_group'
#
CREATE TABLE tx_rkwbasics_domain_model_target_group
(

	uid              int(11) NOT NULL auto_increment,
	pid              int(11) DEFAULT '0' NOT NULL,

	name             varchar(255) DEFAULT '' NOT NULL,
	description      text                    NOT NULL,

	tstamp           int(11) unsigned DEFAULT '0' NOT NULL,
	crdate           int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id        int(11) unsigned DEFAULT '0' NOT NULL,
	deleted          tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden           tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime        int(11) unsigned DEFAULT '0' NOT NULL,
	endtime          int(11) unsigned DEFAULT '0' NOT NULL,
	sorting          int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent      int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource  mediumblob,

	PRIMARY KEY (uid),
	KEY              parent (pid),

	KEY language (l10n_parent,sys_language_uid)

);
