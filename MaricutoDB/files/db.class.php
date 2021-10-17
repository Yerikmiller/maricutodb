<?php
#########################################
# MaricutoDB
# Copyright (c) | Yorman Maricuto 2018 |
# Github: Yerikmiller
# http://maricuto.website
#
# MaricutoDB | MDB
# Create, Read, Update, Delete (CRUD)
# Create collections of databases like 'firebase system'
# each collection will represent a single json file or a group of them
#########################################

use function PHPSTORM_META\type;

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
	public static function strNoAccent($str)
	{
		if(!is_string($str)){return FALSE;}
		$str = str_replace('á', 'a', $str);
		$str = str_replace('é', 'e', $str);
		$str = str_replace('í', 'i', $str);
		$str = str_replace('ó', 'o', $str);
		$str = str_replace('ú', 'u', $str);
		return $str;
	}

/*
*
*
* This create a folder, and this 
* class will be used in Create::DB method
* 
*
*/

	public static function CreateFolderDB( $db_name )
	{
		#########################
		$db_encrypted = $db_name;
		$NewDBInsert = $db_encrypted;
		$db_name = Generate::hash($db_name);
		$time = GET::TIME( $GLOBALS['timezone'] );
		##########################
		if(!file_exists(DB_LIBS_FOLDER.$db_name)){
			mkdir(DB_LIBS_FOLDER.$db_name, 0755);}
		file_put_contents(DB_LIBS_FOLDER.$db_name.'/.htaccess', 'Options -Indexes');		
		return TRUE;
	}


	public static function getInvalidActions()
	{
		return ["onblur","oncanplay","oncanplaythrough","onchange","onclick","oncontextmenu","oncopy","oncut","ondblclick","ondrag","ondragend","ondragenter","ondragleave","ondragover","ondragstart","ondrop","ondurationchange","onended","onerror","onfocus","onfocusin","onfocusout","onfullscreenchange","onfullscreenerror","onhashchange","oninput","oninvalid","onkeydown","onkeypress","onkeyup","onload","onloadeddata","onloadedmetadata","onloadstart","onmousedown","onmouseenter","onmouseleave","onmousemove","onmouseover","onmouseout","onmouseup","onresize","onreset","onscroll","onsearch","onseeked","onseeking","onselect","onshow","onsubmit","onsuspend","ontoggle","ontouchcancel","ontouchend","ontouchmove","ontouchstart","ontransitionend","onunload","onvolumechange","onwaiting","onwheel","onaltKey","onaltKey","onanimationName","onbubbles","onbutton","onbuttons","oncancelable","oncharCode","ondata","ondefaultPrevented","javascript:"];
	}

	public static function replaceAllInvalids($string)
	{
		$null = "-avoid-xss-";
		$invalids = self::getInvalidActions();
		$pattern = implode("|", $invalids);
		$pattern = "/$pattern/i";
		
		####
		# $string = preg_split($pattern, $string);
		# $string = implode("--", $string);
		####
		$string = preg_replace($pattern, "-", $string);
		return $string;
	}

	public static function securityParseText($string)
	{

		$null = "-avoid-xss-";


		$string = str_replace("<", "&lt;", $string);
		$string = str_replace(">", "&gt;", $string);
		$string = str_replace("javascript:", $null, $string);

		# $string = self::replaceAllInvalids($string);

	    return $string;
	}

/*
*
*
*	Generate a JSON file (DBTable) , and include in a folder(DB_NAME)
*	these are in md5 encrypt
*
*
*/

	public static function CreateDB( $db_name, $__id__ ) 
	{
		########################
		if(file_exists(DB_LIBS_FOLDER.$db_name)){return null;}
		else{self::CreateFolderDB( $db_name );}
		$time = GET::TIME( $GLOBALS['timezone'] );
		$unixTime = time(); # only Unix Time
		########################
		$db_url = FindFile::JSON($db_name, $__id__);
		if(file_exists($db_url)){return NULL;}
		###
		$put_data  =  "{" . PHP_EOL;
		$put_data .= 	'"CreationDate": ' .'"'. $time .'",'. PHP_EOL;
		$put_data .= 	'"time": ' .'"'. $unixTime .'",'. PHP_EOL;
		$put_data .= 	'"FromDB": ' .'"'. $db_name .'",'. PHP_EOL;
		$put_data .= 	'"__id__": ' .'"'. $__id__ .'"'. PHP_EOL;
		$put_data .=  "}" . PHP_EOL;
		###
		file_put_contents($db_url, $put_data);

		
		# create cache file on create...
		self::createCacheFileOnUpdate($db_url, $db_name);
	}


/*
*
*
*
*	This will insert data to a table, not for update it.
*
*
*/
	public static function InsertData( $db_name, $__id__, $ItemName, $Content, $Ispassword = FALSE )
	{
		try {
			$Content = self::securityParseText($Content);
		} catch (Exception $e) {
			throw new Exception($e, 1);
		}
		$db_url = FindFile::JSON( $db_name, $__id__ );
		$get = SearchDecodeAndConvert::JSON( $db_name, $__id__ );
		//
		$InsertData = $get;
		//
		if($Content !== "MDB__MULTIPLE_FIELDS__MDB" && !is_array($ItemName)){
			if(isset($InsertData->$ItemName)){
				return NULL;
			}
		}

		if($Content == "MDB__MULTIPLE_FIELDS__MDB" && is_array($ItemName)){
			$items = $ItemName;
			foreach ($items as $name => $value) {
				// contine if already exists.
				if(isset($InsertData->$name)){ continue; }

				if(is_array($value) || is_object($value)){
					$value = json_encode($value, TRUE);
					try {
						$value = Database::securityParseText($value);
					} catch (Exception $e) {
						throw new Exception($e, 1);
					}
				}

				try {
					$value = Database::securityParseText($value);
				} catch (Exception $e) {
					throw new Exception($e, 1);
				}

				if ($Ispassword == TRUE){
					$InsertData->$name = password_hash($value, PASSWORD_DEFAULT);
					continue;
				}
				$InsertData->$name = $value;				
			}
		}else{
			if(is_array($Content) || is_object($Content)){
				$InsertData->$ItemName = json_encode($Content, TRUE);
			}else{
				$InsertData->$ItemName = $Content;
				try {
					$InsertData->$ItemName = Database::securityParseText($InsertData->$ItemName);
				} catch (Exception $e) {
					throw new Exception($e, 1);
				}
			}			
			if ($Ispassword == TRUE){
				$InsertData->$ItemName = password_hash($InsertData->$ItemName, PASSWORD_DEFAULT);
			}
		}
		$InsertData = (array) $InsertData;
		$InsertData = json_encode( $InsertData, JSON_PRETTY_PRINT );

		file_put_contents($db_url, $InsertData);
		return TRUE;
	}


/*
*
*
*	
* 	This will search all the db_names, and ouput an ARRAY
*
*
*/


public static function SearchDB( $db_name, $getAll = FALSE, $IsObject = FALSE )
{
	####################
	$db_name = Generate::hash($db_name);
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
*	Output a table info if this exist. If the table (JSON file)
*	don't exist will return FALSE
*	You can show all table info with ITEMNAME->ITEMCONTENT
*	layout, setting the third argument as TRUE.
*/

	public static function Table( $db_name, $__id__ )
	{
		#####################
		$db_url = FindFile::JSON( $db_name, $__id__ );
		##########################
		if(!file_exists($db_url)){return null;}
		$data = file_get_contents( $db_url );
		$get = json_decode( $data, true );
		$get = (object) $get;
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
		$db_name = Generate::hash($db_name);
		$NewDBName = Generate::hash($NewDBName);
		$new = DB_LIBS_FOLDER.$NewDBName;
		$old = DB_LIBS_FOLDER.$db_name;
		$files = glob($old."/*.json");
		#################
		# No iniciar el script si la crpeta no existe	
		if(!file_exists($old)){echo 'The database that you are trying to change his name dont exist.';return null;}
		if(file_exists($new)){echo 'This Database Already Exist, try Another.';return null;}
		#################
			mkdir($new, 0755);
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
		try {
			$Content = self::securityParseText($Content);
		} catch (Exception $e) {
			throw new Exception($e, 1);
		}
		$db_url = FindFile::JSON( $db_name, $__id__ );
		if(!file_exists($db_url)){return NULL;}
		$get = SearchDecodeAndConvert::JSON( $db_name, $__id__ );
		if($get == NULL){return NULL;}

		$InsertData = $get;


		if($Content == "MDB__MULTIPLE_FIELDS__MDB" && is_array($ItemName)){
			$items = $ItemName;			
			foreach ($items as $name => $value) {
				if(is_array($value) || is_object($value)){
					$value = json_encode($value, TRUE);
					try {
						$value = Database::securityParseText($value);
					} catch (Exception $e) {
						throw new Exception($e, 1);
					}
				}
				try {
					$value = Database::securityParseText($value);
				} catch (Exception $e) {
					throw new Exception($e, 1);
				}				
				if ($Ispassword == TRUE){
					$InsertData->$name = password_hash($value, PASSWORD_DEFAULT);
					continue;
				}
				$InsertData->$name = $value;
			}
		}else{
			if(is_array($Content) || is_object($Content)){
				$InsertData->$ItemName = json_encode($Content, TRUE);				
				try {
					$InsertData->$ItemName = Database::securityParseText($InsertData->$ItemName);
				} catch (Exception $e) {
					throw new Exception($e, 1);
				}
			}else{
				$InsertData->$ItemName = $Content;
				try {
					$InsertData->$ItemName = Database::securityParseText($InsertData->$ItemName);
				} catch (Exception $e) {
					throw new Exception($e, 1);
				}
			}
			# Codificar el contenido
			if ($Ispassword == TRUE)
			{
				$InsertData->$ItemName = password_hash($InsertData->$ItemName, PASSWORD_DEFAULT);
			}
		}

		$InsertData = (array) $InsertData;
		$InsertData = json_encode( $InsertData, JSON_PRETTY_PRINT );
		######## temp ########
		$temp_file = basename($db_url);
		### Generating temp file
		$extTemp = '.tmp';
		$tempFolder = DB_TEMP_FOLDER.Generate::hash($db_name);
		$tempPath = $tempFolder.'/'.$temp_file.$extTemp;
		$milisecond = 1000000 * 0.05;


		# si existe el path (temporal)
		# significa que está siendo editado.
		# hacer un loop de 20seg hasta que no exista el archivo
		# ó: ha dejado de ser editado



		if(file_exists($tempPath))
		{
			### new way of edit files (partial-async) 2021-04-01
			$starttime = time();
			do{
				## Buscar si el archivo no existe
				if(!file_exists($tempPath))
				{
					# buscar de nuevo el archivo
					$get = SearchDecodeAndConvert::JSON( $db_name, $__id__ );
					$InsertData = $get;
					$statusTempFile = 'available-to-create';
					break;
				}else if((time() - filemtime($tempPath)) > 4 && file_exists($tempPath) ){
					// si el archivo sigue alli durante 4 segundos es debido a un error.
					unlink($tempPath);
					$get = SearchDecodeAndConvert::JSON( $db_name, $__id__ );
					$InsertData = $get;
					$statusTempFile = 'available-to-create';
					break;
				}
			}while (file_exists($tempPath));

			$statusTempFile = 'temp file do not was eliminate';
		}else{
			# si no existe el temp_file
			$statusTempFile = 'available-to-create';
		}
		if($statusTempFile == "available-to-create"){
			if(!file_exists($tempFolder)){
				mkdir($tempFolder, 0755);
				chmod($tempFolder, 0755);
			}
			// create temp file
			file_put_contents($tempPath, $InsertData, LOCK_EX);

			// add permissions
			chmod(DB_LIBS_FOLDER, 0755);
			chmod(DB_TEMP_FOLDER, 0755);
			chmod($db_url, 0755);
			chmod($tempPath, 0755);

			// move to real path.
			rename($tempPath, $db_url);

			return TRUE;
		}else{
			return NULL;
		}		
	}
	/**
	 * Create cache file for routes of files for collections or DB folder...
	 * used in: Database::UpdateContent
	 * @db_url {string} pass any path route to a json file in a collection or DB Folder.
	 */
	public static function createCacheFileOnUpdate(string $db_url, string $db_name, bool $is_dbUrl = TRUE)
	{
		$db_hash = Generate::hash($db_name);
		if($is_dbUrl == TRUE){
			$splitted_path = explode(Generate::hash($db_name), $db_url)[1];
			$json = $splitted_path;
		}else{
			$json = $db_url.".json";
		}
		$cacheFile = Database::getCacheJson($db_hash);		
		if($cacheFile == FALSE){
			self::createCacheFiles( $db_hash, $db_name );
		}else{
			self::pushCacheFile( $json, $db_hash, $db_name );
		}
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
		$db_name = Generate::hash($db_name);
		$__id__ = Generate::hash($__id__);  # one hash
		$__id__ = Generate::hash($__id__);	# & second time hash.
		###########
		$new_id = Generate::hash($new_id);  # one hash
		$new_id = Generate::hash($new_id);	# & second time hash.
		#############
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
		$db_name = Generate::hash($db_name);
		$iterator = new GlobIterator(DB_LIBS_FOLDER.$db_name.'/*.json');
		$NumberOfFiles = $iterator->count();
		return $NumberOfFiles;
	}
	public static function SearchingFor( $coincidences, $string, $as = 'bool' )
	{
		##############################
		if ( empty( $coincidences ) ) {return NULL;}
		##############################
		$string = strtolower($string);
		$tlwr_coincidences= array();
		# to search the total of request.
		$totalString = array_unshift($coincidences, implode(" ", $coincidences));

		foreach ($coincidences as $key => $coincidences) 
		{
			$coincidences = strtolower($coincidences);
			$coincidences = self::strNoAccent($coincidences);
			$tlwr_coincidences[$key] = $coincidences;
		}
		foreach ($tlwr_coincidences as $key => $coincidence) 
		{		
			$string = self::strNoAccent($string);
			$result = strpos( ' '.$string, $coincidence );
			if ( $result == FALSE ){return NULL;}
			else{
				if($as == 'bool'){
					return TRUE;
					break;
				}elseif ($as == 'key') {
					return $key;
					break;
				}
			}
		}
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
			try {
				$json = file_get_contents($json);
				$json = json_decode($json, FALSE);
			} catch (\Throwable $th) {
				//throw $th;
			}
			return $json;
		}
	}
	public static function getCacheJson($db_hash)
	{
		$cache = DB_CACHE_FOLDER."$db_hash.json";
		if(!file_exists($cache)){
			return FALSE;
		}
		return $cache;
	}
	public static function getRoutesCacheFiles($db_hash)
	{
		$content = self::getCacheFiles($db_hash);
		$paths = [];
		foreach ($content->files as $name => $json) {
			$paths[] = DB_LIBS_FOLDER . "$db_hash/$json";
		}
		return $paths;
	}
	public static function getCacheFiles($db_hash)
	{
		$cache = self::getCacheJson($db_hash);
		if($cache == FALSE) { return FALSE; }
		$cache = file_get_contents($cache);
		return json_decode($cache, FALSE);
	}
	public static function pushCacheFile($json, $db_hash, $db_name)
	{
		$file = DB_CACHE_FOLDER . "$db_hash.json";
		if(!file_exists($file)){ return FALSE; }
		$files = file_get_contents( $file );
		if($files == FALSE){ return FALSE; }
		$files = json_decode($files, FALSE);
		if(!isset($files->files)){ return FALSE; }
		$files->files = (array) $files->files;

		$files->files[$json] = $json;
		$files = json_encode($files, FALSE);
		file_put_contents(DB_CACHE_FOLDER . "$db_hash.json", $files, LOCK_EX);
	}
	public static function createCacheFiles( $db_hash, $db_name )
	{
		chmod(DB_CACHE_FOLDER, 0755);
		file_put_contents(DB_CACHE_FOLDER . '.htaccess', 'Options -Indexes');
		$file = DB_CACHE_FOLDER . "$db_hash.json";
		if(file_exists($file)){ return FALSE; }

		$files = GET::DB( $db_name );
		$parsedFiles = [];
		foreach ($files as $file) {
			$file = basename($file);
			$parsedFiles[$file] = $file;
		}
		$json = [
			"CreationDate" => date("Y-d-m"),
			"time" => time(),
			"FromDB" => $db_name,
			"lastmodified" => time(),
			"type" => "cache-files",
			"db_hash" => $db_hash,
			"files" => $parsedFiles
		];
		$content = json_encode($json, FALSE, JSON_PRETTY_PRINT);
		file_put_contents(DB_CACHE_FOLDER."$db_hash.json", $content, LOCK_EX);
		return $content;
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
			/*$db_hash = Generate::hash($db_name);
			$files = self::getCacheFiles($db_hash);	
			if($files !== FALSE){
				if($files->lastmodified < filemtime(DB_CACHE_FOLDER . ".")){
					$files = self::getCacheFiles($db_hash);
				}else{
					$files = GET::DB( $db_name );
					$parsedFiles = self::getParsedCacheFiles($db_hash, $files);
					self::cacheFiles($db_hash, $parsedFiles);
				}
			}else{
				$files = GET::DB( $db_name );
				$parsedFiles = self::getParsedCacheFiles($db_hash, $files);
				self::cacheFiles($db_hash, $parsedFiles);
			}*/
			/*$db_hash = Generate::hash($db_name);
			$json = self::getCacheJson($db_hash);
			if($json == FALSE){
				$files = GET::DB( $db_name );
			}else{
				$files = self::getRoutesCacheFiles( $db_hash );
			}*/
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
			if ( strtolower($GetData->$ItemName ?? '') == strtolower($Data) )
			{
				return $DataID = $GetData->__id__;
			}
		}
		return FALSE;
	}
	public static function get_id($db_name, $ItemName, $Data)
	{
		$id = self::OutputId($db_name, $ItemName, $Data);
		return $id;
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
	public static function SortingData( $GetData, $content, $sortby = 'asc', $dataType = 'FILES' )
	{
		$sorting = array();
		if($GetData == NULL){ return []; }
		foreach( $GetData as $key => $value )
		{
			switch ($dataType) 
			{
				case 'ARRAY':
					# Guardar dentro del key
					# el contenido del array
					# esto lo guarda como un string
					# y permite mostrarlo más adelante.
					$sorting[] = [
						"value_sort" => $value[$content] ?? "",
						"content" => json_encode($value, TRUE)
					];
					break;
				case 'OBJECT':
					$sorting[] = [
						"value_sort" => $value->$content ?? "",
						"content" => json_encode($value, TRUE)
					];
					break;
				default:
					# por default el intentará
					# abrir archivos y ordenar datos.
					$Get = Database::Output( $value );
					$sorting[$value] = $Get->$content;
				break;
			}
		}			
		if ( $sortby == 'desc'){arsort($sorting);}
		if ( $sortby == 'asc'){asort($sorting);}
		$sorted = array();
		
		foreach ($sorting as $key => $value) 
		{
			switch ($dataType) {
				case 'ARRAY':
					$sorted[] = json_decode($value["content"], TRUE);
					break;
				case 'OBJECT':
					$sorted[] = json_decode($value["content"], TRUE);
					break;
				default:
					# cuando se usan métodos
					# exclusivos de MDB
					$sorted[] = $value["value_sort"];
					break;
			}
		}
		return $sorted;
	}
	public static function SearchEngine( $GetData, $QueryArray, $is_file = TRUE )
	{

		$paths = [];
		foreach ($GetData as $GetData) 
		{
			if($is_file == TRUE){
				$data = Database::Output( $GetData );
			}else{
				$data = $GetData;
			}
			foreach ($data as $Searching) 
			{
				$ParseQuery = self::SearchingFor( $QueryArray, $Searching );
				if( $ParseQuery == TRUE )
				{ 
					$paths[] = $GetData;
					break;
				}
			}
		}
		if (empty($paths)){return NULL;}
		return $paths;		
	}
} 	

# Cierre de la Clase Database
# Inicio de funciones... Genera convenciones para llamar estas clases.
require_once 'functions.class.php';


?>