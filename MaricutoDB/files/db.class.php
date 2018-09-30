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
		$time = GET::TIME( $GLOBALS['timezone'] );
		##########################
		if(!file_exists(DB_LIBS_FOLDER.$db_name)){
			mkdir(DB_LIBS_FOLDER.$db_name, 0600);}
		file_put_contents(DB_LIBS_FOLDER.$db_name.'/.htacces', 'Options -Indexes');		
		return TRUE;
	}

/*
*
*
*	Genera un archivo .JSON su nombre viene dado de la __id___
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
*	Return all databases created
* 	This can be used for check how many Dbs we have.
*	And anothers functions like including many DBs data throght
*  	this JSON list.
*/

	public static function names()
	{
		$dirs = array_filter(glob(DB_LIBS_FOLDER.'*'), 'is_dir');
		$each_db = array();
		foreach ($dirs as $JSONFiles) 
		{
			$searching = glob($JSONFiles."/*.json");
			foreach ($searching as $paths) 
			{
				$each_db[] = $paths;
				break;
			}
		}
		$each_name = array();
		foreach ($each_db as $each_path) 
		{
			$each_path = file_get_contents($each_path);
			$each_path = json_decode($each_path, TRUE);
			$each_name[] = $each_path;
		}
		$db_names = array();
		foreach ($each_name as $names) 
		{
			$db_names[$names['FromDB']] = $names['FromDB'];
		}
		return $db_names;
	}

/*
*
*
*
*	Exclude items from the name list of DBs
*	$exclusion must be contain a string separated with commas
*
*/

	public static function exclude( $names, $exclusions )
	{
		$exclusions = explode(', ', $exclusions);
		foreach ($exclusions as $exclusion) 
		{
			$keyUnset = array_search($exclusion, $names);
			unset( $names[$keyUnset]);
		}
		return $names;
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
		if ($Show == TRUE)
		{
			foreach ($get as $get => $value) 
			{
				echo($get).' | ';
				echo($value).'<br>';
				
			}
		}
		return $get;
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
		self::UpdateContent( $db_name, $__id__, '__id__', $new_id );
		##########################
		$db_name = md5($db_name);
		$__id__ = md5(md5($__id__));
		$new_id = md5(md5($new_id));
		$db_url = DB_LIBS_FOLDER.$db_name.'/'.$__id__.'.json';
		if(!file_exists($db_url)){return null;}
		$new_url = DB_LIBS_FOLDER.$db_name.'/'.$new_id.'.json';
		if(file_exists($new_url)){return null;}
		rename ( $db_url , $new_url );
		return TRUE;
		##########################
	}

	public static function CountFiles( $db_name = NULL )
	{
		if ($db_name == NULL)
		{
			$dirs = array_filter(glob(DB_LIBS_FOLDER.'*'), 'is_dir');
			$NumberOfFiles = 0;
			foreach ($dirs as $paths) 
			{
				$iterator = new GlobIterator( $paths.'/*.json' );
				$iterator = $iterator->count();
				$NumberOfFiles = $iterator + $NumberOfFiles;
			}
			return $NumberOfFiles;
		}
		$db_name = md5($db_name);
		$iterator = new GlobIterator(DB_LIBS_FOLDER.$db_name.'/*.json');
		$NumberOfFiles = $iterator->count();
		return $NumberOfFiles;
	}
	public static function SearchingFor( $coincidences, $string )
	{
		##############################
		if ( empty( $coincidences ) ) {return NULL;}
		##############################
		$string = strtolower($string);
		$tlwr_coincidences= array();
		foreach ($coincidences as $coincidences) 
		{
			$coincidences = strtolower($coincidences);
			$tlwr_coincidences[] = $coincidences;
		}
		foreach ($tlwr_coincidences as $coincidence) 
		{
			$result = strpos( ' '.$string, $coincidence );
			if ( $result == FALSE ){return NULL;}
		}
		return TRUE;
	}
	public static function Output( $files )
	{	
		if (is_array($files))
		{
			$GetDataFrom = array();
			foreach ($files as $json) 
			{
				$json = file_get_contents($json);
				$json = json_decode($json);
				$GetDataFrom[] = $json;
			}
			$JsonData = (object) $GetDataFrom;
			$JsonData = json_encode($JsonData, FALSE);
			$JsonData = json_decode($JsonData, FALSE);
			return $JsonData;
		}
		else
		{
			$json = $files;
			$json = file_get_contents($json);
			$json = json_decode($json, FALSE);
			return $json;
		}
	}
	public static function GetData( $db_name = NULL, $PagePosition = '0' , $PerPage = '10', $ReturnLimit = FALSE  )
	{
		# if we are searching in all Dbs
		if ($db_name == NULL)
		{
			$files = GET::DBs();
			return $files;
		}
		# if we are searching in one specific DB
		elseif ( $db_name !== NULL )
		{	
			$files = GET::DB( $db_name );
			return $files;
		}	
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
		$GetData = self::GetData( $db_name );
		$GetData = self::Output( $GetData );
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
	public static function SliceData( $PerPage, $CountData )
	{
		if( !is_numeric($PerPage )){$PerPage = '10';}
		$limit = $CountData / $PerPage;
		if (is_float($limit))
		{
			$limit = intval( $limit + 1 );
		}
		return $limit;
	}
	public static function Paginate( $files, $PerPage, $limit, $PagePosition = '0' )
	{
		$PerPage = intval($PerPage);
		$files = Generate::Pagination( $files, $PagePosition, $PerPage, $limit );
		return $files;
	}
} 	# Cierre de la Clase Database
	# Inicio de funciones... Genera convenciones para llamar estas clases.
require_once 'functions.class.php';
?>
