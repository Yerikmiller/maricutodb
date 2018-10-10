<?php
#########################################
# MaricutoDB
# Copyright (c) | Yorman Maricuto 2018 |
# Yerikmiller@gmail.com
# http://maricuto.site90.com
# 
#
# This follow the CRUD System: Create, Read, Update and delete: 
# database, table, items and content...
#
# MaricutoDB
# Can Create Database Easily.
# Can Create Hashes with Strong Security to store passwords.
# Can Read the databases dinamically and with flexibility.
# Can Update Content Easily: DB, Tables, Rows (ItemNames) and Colums (ItemContent).
# Can Update passwords Easily.
# Can Verify if a data in login panel is correct, as passwords and usenames.
# Can Sort from new to old and old to new the data.
# Can Make backups of your DBs.
# Can Delete Database with BackUp System.
#########################################



#############
define('DB_LIBS_FOLDER', __DIR__.'/files/libs/');
# LIST OF VALID TIMEZONES http://php.net/manual/es/timezones.php
$GLOBALS['backupfolder'] = dirname(DB_LIBS_FOLDER).'/backups/';
if (!isset($GLOBALS['timezone'])) {
	$GLOBALS['timezone'] = 'America/Lima';
}
##############
require_once 'files/db.class.php';
##############

?>