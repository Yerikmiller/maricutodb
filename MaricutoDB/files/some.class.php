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

Class Generate
{
	public static function RandomString($length = 10)
	{
	if($length < 7 || $length > 30){$length = 10;}
	$random_lenght = mt_rand(1, 4);

	if ($random_lenght       == 1) {
		$random_number = 0;
	} elseif ($random_lenght == 2) {
		$random_number = 2;
	} elseif ($random_lenght == 3) {
		$random_number = 3;
	}
	 elseif ($random_lenght  == 4) {
		$random_number = 4;
	}

    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = $random_number; $i < $length; $i++) 
	    {
	   	 $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	return $randomString;
	}


	public static function Pagination( $files, $PagePosition, $PerPage, $limit )
	{
			if  ( $PagePosition <= 1 || $PagePosition > $limit)
				{
					$PagePosition = $PagePosition * 0;
				}
			elseif ($PagePosition == 2)
				{
					$PagePosition = $PerPage;
				}
			else
				{
					$PagePosition = $PagePosition - 1;
					$PagePosition = $PagePosition * $PerPage;
				}
		$files = array_slice( $files, $PagePosition, $PerPage ); 
		return $files;
	}

	public static function ItemsPerPage( $PagePosition )
	{
		if (is_numeric($PagePosition))
		{
	  		$PagePosition = intval($PagePosition);

		  	if ( $PagePosition < 1 )
	  		{
	  			$PagePosition = 0;
	  		}
  		} else {return $PagePosition = 0;}
  	return $PagePosition;
	}
	public static function PagePosition( $PaginatorName )
	{
		if ( is_numeric( $PaginatorName ) ){
			$PagePosition = $PaginatorName;
			$PagePosition = self::ItemsPerPage( $PagePosition );
		} else{$PagePosition = 0;}
		return $PagePosition;
	}
	public static function Paginator( $PaginatorName )
	{
		if (isset($_POST[$PaginatorName])){
			return $PagePosition = self::PagePosition( $_POST[$PaginatorName] );
		} else{return $PagePosition = 0;}
	}
	public static function Row( $Get, $data, $output = 'N/A' )
	{
		if(!isset($Get->$data)){return $Get->$data = $output;}
		return $Get->$data;
	}
	public static function SortingFiles( $files, $sortby = 'new' )
	{
		$SORT_ = ($sortby == 'old') ? SORT_ASC : SORT_DESC;
		array_multisort(
		array_map( 'filemtime', $files ), SORT_NUMERIC, $SORT_, $files);
		return $files;
	}
	public static function query( $query_array )
	{
		$query_array = preg_replace('/[^\p{L}\p{N}\s]/u', '', $query_array);
		$query_array = trim($query_array);
		$specials = array('á','é','í','ó','ú', '  ');
		$i = 0;
		foreach ($specials as $specials) 
		{
			$i++;
			if ( $i == 1){$replace = 'a';}
			if ( $i == 2){$replace = 'e';}
			if ( $i == 3){$replace = 'i';}
			if ( $i == 4){$replace = 'o';}
			if ( $i == 5){$replace = 'u';}
			$query_array = str_replace($specials, $replace, $query_array);
		}
		$query_array = explode(' ', $query_array);
		return $query_array;
	}
}


/**
 * Buscar por el nombre de un archivo
 * eg: FindFile::JSON( $db_name );
**/
class FindFile
{
	public static function JSON( $db_name, $__id__ )
	{
		$__id__ = md5($__id__);
		$db_name = md5($db_name);
		$JSON = DB_LIBS_FOLDER.$db_name.'/'.md5($__id__).'.json';
		return $JSON;
	}
} 

/**
 * Buscar una base de datos
 * Buscar el contenido de un Item en una tabla
**/
class Search
{
	public static function Item( $db_name, $__id__ ){

		$db_url = FindFile::JSON( $db_name, $__id__ );
		$data = file_get_contents( $db_url );
		$get = json_decode( $data );
		foreach($get->$__id__ as $items)
		{
			$Show = $items;
		}
		$data = $items;
		return $data;
	}

	public static function DB( $db_name )
	{
		$db_folder = $db_name;
		$db_folder = md5($db_folder);
		if(file_exists(DB_LIBS_FOLDER.$db_folder)){
			return TRUE;
		}   return;
	}
}

class SearchDecodeAndConvert
{
	public static function JSON( $db_name, $__id__ )
	{
		$db_url = FindFile::JSON( $db_name, $__id__ );
		if(!file_exists($db_url)){return null;}
		$data = file_get_contents( $db_url );
		$get = json_decode( $data, true );
		$get = (object) $get;
		return $get;
	}
}

class Decode
{
	public static function DBList()
	{
		$log_DB = DB_LIBS_FOLDER.'db_list.json';
		if(!file_exists($log_DB)){return null;}
		$data = file_get_contents( $log_DB );
		$get = json_decode( $data, TRUE );
		$get = (object) $get;
		return $get;
	}
}


class GET
{
	public static function Table( $db_name, $__id__ )
	{
		#####################
		$db_folder_name = DB_LIBS_FOLDER.$db_name;
		$files = $db_folder_name.'/'.$__id__;
		##########################
		if(!file_exists($db_folder_name)){echo 'The table Dont Exist.<br>';return null;}
		$data = file_get_contents( $files );
		$get = json_decode( $data, true );
		$get = (object) $get;
		return $get;
	}
	# Obtener PATHS de todos los archivos JSON de cada DB
	public static function DBs()
	{
		$dirs = array_filter(glob(DB_LIBS_FOLDER.'*'), 'is_dir');
		$each_db = array();
		foreach ($dirs as $JSONFiles) 
		{
			$searching = glob($JSONFiles."/*.json");
			$each_db[] = $searching;

		}
		$JSONFiles = array();
		foreach ($each_db as $files) 
		{
			# se iguala files a un array con todos los paths
			# en este caso nos dejara un array, cada array representa una carpta
			# los strings separados por " |--| " representan los path de cada DB
			$files = implode(' |--| ', $files);
			$JSONFiles[] = $files;
		}
		# ahora combinaremos todos los path
		$JSONFiles = implode( ' |--| ', $JSONFiles);
		# Ahora que todos los paths estan en un string, convertimos a un solo array
		# que contiene todos los paths
		$JSONFiles = explode( ' |--| ', $JSONFiles);
		# ¡listo!
		return $JSONFiles;
	}
	public static function OnlyOneDB( $db_name )
	{
		$db_name = md5($db_name);
		if (!file_exists( DB_LIBS_FOLDER.$db_name )){return FALSE;}
		$files = glob(DB_LIBS_FOLDER.$db_name."/*.json");
		return $files;
	}
	# Obtener PATHS de todos los archivos JSON de varios DB especificos
	public static function DB( $db_names )
	{
		if ( !is_array( $db_names ) )
		{
			$files = self::OnlyOneDB( $db_names );
			return $files;
		} 
		else
		{
			$each_db = array(); # variable para almacenar rutas en arrays separados..
			foreach ( $db_names as $db_name) 
			{
				$db_name = md5($db_name);
				if (!file_exists( DB_LIBS_FOLDER.$db_name ))
				{/* No hacer nada si un DB no existe y seguir con el loop.*/}
				else
				{
					$JSONFiles = glob( DB_LIBS_FOLDER.$db_name."/*.json" );
					$each_db[] = $JSONFiles; # Guardar en array separados cada DB
				}
			}
			$JSONFiles = array();
			foreach ($each_db as $files) 
			{
				$files = implode(' |--| ', $files);
				$JSONFiles[] = $files;
			}
		$JSONFiles = implode( ' |--| ', $JSONFiles);
		$JSONFiles = explode( ' |--| ', $JSONFiles);
		return $JSONFiles;
		}

	}
	public static function TIME( $timezone )
	{
		date_default_timezone_set($timezone);
		$time = date("Y").'-'.date("m").'-'.date("d");
		return $time;
	}

}

###################
###################
###################
###################
# DELETE CONTENT
###################
###################


/*
*
*
*
*	 Delete Item and his content
*
*
*/
class DELETE
{
	public static function Item( $db_name, $__id__, $ItemName )
	{
		$db_url = FindFile::JSON( $db_name, $__id__ );
		$Delete = SearchDecodeAndConvert::JSON( $db_name, $__id__ );
		//
		$DeleteData = $Delete;
		//
		unset($DeleteData->$ItemName);
		$DeleteData = json_encode( $DeleteData, JSON_PRETTY_PRINT );
		file_put_contents($db_url, $DeleteData);
	}


/*
*
*
*
*	 Delete a table
*
*
*/

	public static function Table( $db_name, $__id__ )
	{
		$db_url = FindFile::JSON( $db_name, $__id__ );
		if (!file_exists($db_url)){return null;}
		unlink($db_url);
		return;
	}


/*
*
*
*
*	 Delete a Database can't be undone
*
*
*/

	public static function DB( $db_name, $Backup = TRUE )
	{
		#################
		$DatabaseListed = $db_name;
		$db_name = md5($db_name);
		$db_folder_name = DB_LIBS_FOLDER.$db_name;
		$files = glob($db_folder_name."/*.json");
		#################
		$get = Decode::DBList();
		$DeleteDBListed = $get;
		$log_DB = DB_LIBS_FOLDER.'db_list.json';
		$MakeBackup = $GLOBALS['backupfolder'].$db_name;
		#################
		if(!file_exists($db_folder_name)){return null;}
		if( $Backup == TRUE )
		{
			if(!file_exists($MakeBackup))
			{
				mkdir($MakeBackup, 0755);
			}
			foreach ($files as $paths) 
			{
				$just_name = basename($paths);
				copy($paths, $MakeBackup.'/'.$just_name);
				unlink($paths);
			}
			copy($db_folder_name.'/.htacces', $MakeBackup.'/.htacces');
			unlink($db_folder_name.'/.htacces');
		}
		else 
		{

		foreach ($files as $paths) 
			{
				unlink($paths);
			}
		copy($db_folder_name.'/.htacces', $MakeBackup.'/.htacces');
		unlink($db_folder_name.'/.htacces');
		}
		# ELIMINATE DB
		chmod($db_folder_name, 0755);
		rmdir($db_folder_name);

		# Eliminate Item (listed DB in JSON file)
		unset($DeleteDBListed->$DatabaseListed);
		$DeleteDBListed = json_encode( $DeleteDBListed, JSON_PRETTY_PRINT );
		file_put_contents($log_DB, $DeleteDBListed);
	}

}


class Backup
{
	public static function DB( $db_name )
	{
		##################################
		$db_name = md5($db_name);
		$db_folder_name = DB_LIBS_FOLDER.$db_name;
		$files = glob($db_folder_name."/*.json");
		$MakeBackup = $GLOBALS['backupfolder'].$db_name;
		##################################
		if(!file_exists($db_folder_name)){return null;}
		if(!file_exists($MakeBackup))
		{
			mkdir($MakeBackup, 0755);
		} else{return null;}
		foreach ($files as $paths) 
		{
			$just_name = basename($paths);
			copy($paths, $MakeBackup.'/'.$just_name);
		}
		copy($db_folder_name.'/.htacces', $MakeBackup.'/.htacces');
	}
}

class Restore 
{
	public static function DB( $db_name )
	{
		##################################
		$db_name = md5($db_name);
		$db_folder_name = DB_LIBS_FOLDER.$db_name;
		$BackupFolder = $GLOBALS['backupfolder'].$db_name;
		$files = glob($BackupFolder."/*.json");
		##################################
		if(!file_exists($BackupFolder)){return null;}
		if(!file_exists($db_folder_name))
		{
			mkdir($db_folder_name, 0755);
		}
		else{return null;}
		foreach ($files as $paths) 
		{
			$just_name = basename($paths);
			copy($paths, $db_folder_name.'/'.$just_name);
		}
		copy($BackupFolder.'/.htacces', $db_folder_name.'/.htacces');
	}
}

?>