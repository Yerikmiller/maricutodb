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

require_once 'some.class.php';
require_once 'write.class.php';

/**
 *
 * Generar nueva base de datos: Genera un fichero con el nombre
 * de la base datos.
 *
**/


class Database
{

/*
*
*
*
* 
*
*
*/

	public static function CreateFolderDB( $db_name )
	{
		#########################
		$db_encrypted = $db_name;
		$NewDBInsert = $db_encrypted;
		$db_name = md5($db_name);

		# Filename to save the database name in a JSON.
		$log_DB = DB_LIBS_FOLDER.'db_list.json';
		$time = GET::TIME( $GLOBALS['timezone'] );
		##########################
		if(!file_exists(DB_LIBS_FOLDER.$db_name)){
			mkdir(DB_LIBS_FOLDER.$db_name, 0600);}
		if(!file_exists($log_DB)){file_put_contents($log_DB, ''); return null;}

		$GetDataDBs = file_get_contents($log_DB);
		$GetDataDBs = json_decode($GetDataDBs, FALSE);
		$GetDataDBs->ListModificationDate = $time;
		$GetDataDBs->$db_encrypted = $time;
		$GetDataDBs = json_encode($GetDataDBs, JSON_PRETTY_PRINT);
		file_put_contents($log_DB, $GetDataDBs);
		file_put_contents(DB_LIBS_FOLDER.$db_name.'/.htacces', 'Options -Indexes');
		return TRUE;
	}

/*
*
*
*	Genera un archivo .JSON su nombre viene dado de la ___id___
*	Además es codificado con MD5 para dar seguridad a la base de datos.
*
*
*/

	public static function CreateDB( $db_name, $__id__ ) 
	{
		########################
		if(file_exists(DB_LIBS_FOLDER.$db_name)){return null;}
		else{self::CreateFolderDB( $db_name );}
		$time = GET::TIME( $GLOBALS['timezone'] );
		########################
		$db_url = FindFile::JSON($db_name, $__id__);
		if(file_exists($db_url)){return null;}
		###
		$put_data  =  "{" . PHP_EOL;
		$put_data .= 	'"CreationDate": ' .'"'. $time .'",'. PHP_EOL;
		$put_data .= 	'"FromDB": ' .'"'. $db_name .'",'. PHP_EOL;
		$put_data .= 	'"__id__": ' .'"'. $__id__ .'"'. PHP_EOL;
		$put_data .=  "}" . PHP_EOL;
		###
		file_put_contents($db_url, $put_data);
	}


/*
*
*
*
*
*
*
*/
	public static function InsertData( $db_name, $__id__, $ItemName, $Content, $Ispassword = FALSE )
	{

		$db_url = FindFile::JSON( $db_name, $__id__ );
		$get = SearchDecodeAndConvert::JSON( $db_name, $__id__ );
		//
		$InserData = $get;
		//
		if (!isset($InserData->$ItemName))
		{
			$InserData->$ItemName = "$Content";
			# Codificar el contenido
			if ($Ispassword == TRUE)
			{
				$InserData->$ItemName = password_hash($InserData->$ItemName, PASSWORD_DEFAULT);
			}

			$InserData = (array) $InserData;
			$InserData = json_encode( $InserData, JSON_PRETTY_PRINT );
			file_put_contents($db_url, $InserData);
		}

	}


/*
*
*
*	
*
*
*
*/


public static function SearchDB( $db_name, $getAll = FALSE, $IsObject = FALSE )
{
	####################
	$db_name = md5($db_name);
	#############
	if(!file_exists(DB_LIBS_FOLDER.$db_name)){echo 'Database dont exist';return null;}
	foreach(glob(DB_LIBS_FOLDER.$db_name."/*") as $JSONFiles) 
	{
		$dataJSONs = file_get_contents($JSONFiles);
		$get = json_decode( $dataJSONs );
		
		if ($getAll == TRUE && $IsObject == TRUE)
			{
			   var_dump($get);
			}
		elseif ($getAll == TRUE && $IsObject == FALSE) 
		{
			$getAsStrings = nl2br($dataJSONs);
			echo($getAsStrings.'<br>');
		}
		elseif ($getAll == FALSE && $IsObject == FALSE)
		{
			return TRUE;
		}
	}
}

/*
*
*
*
*
*
*
*/

	public static function SearchAllDB()
	{
		######################################
		$log_DB = DB_LIBS_FOLDER.'db_list.json';
		if(!file_exists($log_DB)){file_put_contents($log_DB, '');}
		$GetDataDBs = file_get_contents($log_DB);
		$GetDataDBs = json_decode($GetDataDBs, FALSE);
		foreach ($GetDataDBs as $GetDataDBs => $value) {
			echo($value).' | ';
			echo($GetDataDBs).'<br>';
		}
		######################################

		
	}

/*
*
*
*
*	Get An Item Content  
*
*
*/



	public static function GetItem( $db_name, $__id__, $ItemName,  $echo = TRUE )
	{
		#####################
		$db_url = FindFile::JSON( $db_name, $__id__ );
		if(!file_exists($db_url)){return null;}
		$get = SearchDecodeAndConvert::JSON( $db_name, $__id__ );
		##########################
		if (!isset($get->$ItemName)){return null;}
		if ($echo == TRUE){}else{return $get;}
		echo $get->$ItemName;
		return $get->$ItemName;
	}
/*
*
*
*
*
*
*
*/

	public static function Table( $db_name, $__id__, $Show = FALSE)
	{
		#####################
		$db_url = FindFile::JSON( $db_name, $__id__ );
		##########################
		if(!file_exists($db_url)){return null;}
		
		$data = file_get_contents( $db_url );
		$get = json_decode( $data, true );
		$get = (object) $get;
		if ($Show == TRUE){
			foreach ($get as $get => $value) {
				echo($get).' | ';
				echo($value).'<br>';
				
			}
		}
		return $get;
	}
/*
*
*
* 	Search for an existing data and output his id...
*
*
*
*/
	public static function OutputId($db_name, $ItemName, $Data)
	{
		#####################
		$GetData = GET::TablesFrom( $db_name );
		#####################	
		foreach ($GetData as $GetData) 
		{	
			if ( strtolower($GetData->$ItemName) == strtolower($Data) )
			{
				return $DataID = $GetData->__id__;
			}
		}
		return FALSE;
	}





/*
*
*
*
*	THIS IS FOR VERIFY ANY PASSWORD WHEN THE CLIENT ACCESS TO THE LOGIN
*
*
*/

	public static function VerifyEncryptedData( $db_name, $__id__, $ItemName, $EncryptedData)
	{
		#####################
		$get = self::GetItem( $db_name, $__id__, $ItemName,  $echo = FALSE );
		if (!isset($get->$ItemName)){return FALSE;}
		if ( password_verify($EncryptedData, $get->$ItemName) ){return TRUE;}else {return FALSE;};
		#####################	
	}
/*
*
*
*
*	THIS IS FOR VERIFY ANY DATA FOR $_POST AND $_GET METHOD 
*
*
*/

	public static function VerifyData( $db_name, $__id__, $ItemName, $Data)
	{
		#####################
		$get = self::GetItem( $db_name, $__id__, $ItemName,  $echo = FALSE );
		if (!isset($get->$ItemName)){return FALSE;}
		if ( $get->$ItemName == $Data ){return TRUE;}else {return FALSE;};
		#####################	
	}
/*
*
*
* 		Verify Username and Password
*
*
*
*/
	public static function Login( $User, $Pass, $con3 = TRUE, $con4 = TRUE )
	{
		if ( $User == TRUE && $Pass == TRUE && $con3 == TRUE && $con4 == TRUE )
		{
			return TRUE;
		}
		else {
			return FALSE;
		}
	}


/*
*
*
* 		Update the DB NAME
*
*
*
*/

	public static function UpdateDBName( $db_name, $NewDBName )
	{
		
		#################
		$db_name = md5($db_name);
		$NewDBName = md5($NewDBName);
		$new = DB_LIBS_FOLDER.$NewDBName;
		$old = DB_LIBS_FOLDER.$db_name;
		$files = glob($old."/*.json");
		#################
		# No iniciar el script si la crpeta no existe	
		if(!file_exists($old)){echo 'The database that you are trying to change his name dont exist.';return null;}
		if(file_exists($new)){echo 'This Database Already Exist, try Another.';return null;}
		#################
			mkdir($new, 0600);
			foreach ($files as $paths) 
			{
				$just_name = basename($paths);
				copy($paths, $new.'/'.$just_name);
				unlink($paths);
			}
			chmod($old, 0755);
			rmdir($old);
	}
/*
*
*
* 		Update the Db Table
*		__id__ it is a identifier for DB tables. Need to be unique in each case.
*		So old_id pint to a specific existing JSON File. New_id create another one.
*
*/

	public static function UpdateTableName($db_name, $__id__, $new_id)
	{
		##########################
		$db_url = FindFile::JSON( $db_name, $__id__ );
		$db_name = md5($db_name);
		$new_id = md5($new_id);
		$NewJSON = DB_LIBS_FOLDER.$db_name.'/'.md5($__id__).'.json';
		##########################
		if(!file_exists($db_url)){echo 'This table (__ID__) dont Exist.';return null;}
		if(file_exists($NewJSON)){echo 'This table (__ID__) Already Exist.';return null;}
		$data = file_get_contents( $db_url );
		file_put_contents($NewJSON, $data);
		unlink($db_url);
	}
/*
*
*
* 		Update the Item Name
*
*
*
*/

	public static function UpdateItemName( $db_name, $__id__, $ItemName, $NewItemName )
	{
		$get = self::GetItem( $db_name, $__id__, $ItemName,  FALSE );
		if (!isset($get->$ItemName)){return null;}
		$Content = $get->$ItemName;
		##########################
		DELETE::Item( $db_name, $__id__, $ItemName );
		self::InsertData( $db_name, $__id__, $NewItemName, $Content);
	}
/*
*
*
* 		Update the Item Content
*
*
*
*/

	public static function UpdateContent( $db_name, $__id__, $ItemName, $Content, $Ispassword = FALSE )
	{
		$db_url = FindFile::JSON( $db_name, $__id__ );
		if(!file_exists($db_url)){return null;}
		$get = SearchDecodeAndConvert::JSON( $db_name, $__id__ );
		//
		$InserData = $get;
		//
		$InserData->$ItemName = "$Content";
		# Codificar el contenido
		if ($Ispassword == TRUE)
			{
				$InserData->$ItemName = password_hash($InserData->$ItemName, PASSWORD_DEFAULT);
			}
		$InserData = (array) $InserData;
		$InserData = json_encode( $InserData, JSON_PRETTY_PRINT );
		file_put_contents($db_url, $InserData);
	}






} 	# Cierre de la Clase Database
	# Inicio de funciones... Genera convenciones para llamar estas clases.
require_once 'functions.class.php';
?>