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
class Create
{
	public static function THIS( $db_name, $__id__, $ItemName, $Content, $Ispassword = FALSE )
	{
		Database::CreateDB($db_name,$__id__) ;
		Database::InsertData($db_name,$__id__,$ItemName,$Content,$Ispassword );
	}
}

class MaricutoDB
{
	public static function Create( $db_name, $__id__, $ItemName, $Content, $Ispassword = FALSE )
	{
		Database::CreateDB($db_name,$__id__) ;
		Database::InsertData($db_name,$__id__,$ItemName,$Content,$Ispassword );
	}
}

?>