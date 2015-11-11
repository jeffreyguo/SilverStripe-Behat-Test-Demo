<?php

global $project;
$project = 'mysite';

global $database;
$database = (defined('SS_DATABASE_NAME') ? SS_DATABASE_NAME : 'SS_mysite');

require_once 'conf/ConfigureFromEnv.php';

global $databaseConfig;
$databaseConfig = array(
	'type' => 'MySQLDatabase',
	'server' => 'localhost',
	'username' => 'root',
	'password' => '',
	'database' => 'SS_mysite',
	'path' => ''
);

// Set the site locale
i18n::set_locale('en_US');

