<?php

global $project;
$project = 'mysite';

global $databaseConfig;
$databaseConfig = array(
	'type' => 'MySQLPDODatabase',
	'server' => 'localhost',
	'username' => 'root',
	'password' => '',
	'database' => 'vpoint',
	'path' => ''
);

// Set the site locale
i18n::set_locale('en_US');
SiteConfig::add_extension("CustomSiteConfig");
Member::add_extension("CustomMember");
Director::set_environment_type("dev");
date_default_timezone_set('Asia/Jakarta');
