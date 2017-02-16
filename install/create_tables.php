<?php 

require_once(dirname(dirname(__FILE__)).'/functions.php'); 

$db = Database::getInstance();
$mysqli = $db->getConnection(); 

$vendors_sql = "CREATE TABLE IF NOT EXISTS r4me_vendors(
	id INT(11) UNSIGNED auto_increment PRIMARY KEY,
	name VARCHAR(255) NOT NULL,
	slug VARCHAR(255) NOT NULL UNIQUE KEY,
	description TEXT(65535),
	logo_url TEXT(65535),
	website_url TEXT(65535),
	api_docs_url TEXT(65535),
	is_integrated TINYINT(1),
	size VARCHAR(255)
)";

$vresult = $mysqli->query($vendors_sql);

if(!$vresult) die($mysqli->error);


$countries_sql = "CREATE TABLE IF NOT EXISTS r4me_vendor_countries(
	id INT(11) UNSIGNED auto_increment PRIMARY KEY,
	country_code VARCHAR(2) NOT NULL UNIQUE KEY,
	country_name VARCHAR(255) NOT NULL 
	)";

$cresult = $mysqli->query($countries_sql);

if(!$cresult) die($mysqli->error);


$features_sql = "CREATE TABLE IF NOT EXISTS r4me_vendor_features(
	id INT(11) UNSIGNED auto_increment PRIMARY KEY,
	name VARCHAR(255),
	slug VARCHAR(255) NOT NULL UNIQUE KEY,
	feature_group VARCHAR(255)
	)";

$fresult = $mysqli->query($features_sql);

if(!$fresult) die($mysqli->error);


$features_relations_sql = "CREATE TABLE IF NOT EXISTS r4me_vendor_feature_relationship(
	vendor_id INT(11) UNSIGNED,
	feature_id INT(11) UNSIGNED,
	primary key (vendor_id, feature_id)
	)";

$frresult = $mysqli->query($features_relations_sql);

if(!$frresult) die($mysqli->error);

$country_relations_sql = "CREATE TABLE IF NOT EXISTS r4me_vendor_country_relationship(
	vendor_id INT(11) UNSIGNED,
	country_id INT(11) UNSIGNED,
	primary key (vendor_id, country_id)
	)";

$crresult = $mysqli->query($country_relations_sql);

if(!$crresult) die($mysqli->error);

die('Congrats! tables are installed! You can delete this file');