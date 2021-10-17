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

/*
Copyright (c) 2018 Yorman Maricuto

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/


#############
define('DB_LIBS_FOLDER', __DIR__.'/files/libs/');
define('DB_TEMP_FOLDER', __DIR__.'/files/temp/');
define('DB_CACHE_FOLDER', __DIR__.'/files/cache/');

// set autoload
define('MDB_AUTOLOAD', dirname(dirname(__DIR__)).'/vendor/autoload.php');

if(file_exists(MDB_AUTOLOAD)){
	require_once MDB_AUTOLOAD;
}

define('typeOfHash', 'md5'); # define a type of hash
# LIST OF VALID TIMEZONES http://php.net/manual/es/timezones.php
$GLOBALS['backupfolder'] = dirname(DB_LIBS_FOLDER).'/backups/';
if (!isset($GLOBALS['timezone'])) {
	$GLOBALS['timezone'] = 'America/Caracas';
}
##############
require_once 'files/db.class.php';
##############

?>