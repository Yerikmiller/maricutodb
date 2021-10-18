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

class Create
{
	public static function THIS( $db_name, $__id__, $ItemName, $Content, $Ispassword = FALSE )
	{
		$Content = Database::securityParseText($Content);
		if ( empty($db_name) || empty($__id__) || empty($ItemName) )
		{
			$msg  = 'You are Creating objects from empty values'.'<br>';
			$msg .= 'The three firts arguments (MaricutoDB::Create) can not be empty'.'<br>';
			echo $msg;
			return NULL;
		}
		if ( empty($Content) ){$Content = '';}
		Database::CreateDB($db_name,$__id__) ;
		Database::InsertData($db_name,$__id__,$ItemName,$Content,$Ispassword );
	}
}

class MaricutoDB
{
	public static function getmd5table($database, $file, $codified = FALSE)
	{
		// SET TRUE IF YOU HAVE A HASHED $file var.
		if($codified == FALSE){
			$file = md5(md5($file));
		}
		$file = DB_LIBS_FOLDER.md5($database).'/'.$file.'.json';
		$table = Database::Output( $file );
		return $table;
	}
	public static function Create( $db_name, $__id__, $ItemName, $Content, $Ispassword = FALSE )
	{
		$Content = Database::securityParseText($Content);
		if ( empty($db_name) || empty($__id__) || empty($ItemName) )
		{
			$msg  = 'You are Creating objects from empty values'.'<br>';
			$msg .= 'The database name, table name, and data arguments (of mdb->createFields method) can not be empty'.'<br>';
			return NULL;
		}
		if ( empty($Content) ){$Content = '';}
		Database::CreateDB($db_name,$__id__) ;
		Database::InsertData($db_name,$__id__,$ItemName,$Content,$Ispassword );

		// create cache files
		//Database::createCacheFileOnUpdate(Generate::hash(Generate::hash($__id__)), $db_name, FALSE);
	}
	public static function remove_multi_items($database, $itemName, $arrayNames)
	{
		foreach ($arrayNames as $item) 
		{
			DELETE::Item($database, $itemName, $item);
		}
	}
	public static function create_multi_items($database, $table_id, $data, $password = FALSE)
	{
		foreach ($data as $name => $value) 
		{
			MaricutoDB::Create($database, $table_id, $name, $value, $password);
		}
	}
	public static function openFiles($files)
	{
		$GetData = [];		
		foreach ($files as $file) {
			$data = Database::Output( $file );
			$GetData[] = $data;
		}	
		return $GetData;
	}
	public static function selectData($arrays, $select = FALSE, $has = [], $relative = TRUE)
	{
		// open files from pagination or whatever.
		// output just that you want!
		$arrays = json_encode($arrays, TRUE);
		$arrays = json_decode($arrays, TRUE);

		if(is_array($select) && count($select) > 0){
			$select = array_combine($select, $select);
		}

		$GetData = [];
		$no_matching_els = [];
		$i = 0;
		foreach ($arrays as $numberElement => $arrayElements) {
			$elements = $arrayElements;
			if(count($has) == 2){
				## if there's not a key to search stored as has[0]
				## ---unset---
				if(!isset($elements[$has[0]])){
					$elements[$has[0]] = NULL;
				}
			}			
			foreach ($elements as $name => $value) 
			{
				if(!isset($select[$name]) && count($select) > 0){
					## only extract when the array has more than one element.
					unset($arrayElements[$name]);					
				}else{
					## only on get data from element that has:
					if(count($has) == 2){
						if(strtolower($name) == strtolower($has[0])){
							$has[1] = trim($has[1]);
							$value = trim($value);
							if($relative == FALSE){
								// search a string in a value
								if(!is_int(strpos(strtolower($value), strtolower($has[1])))){
									$no_matching_els[$i] = $numberElement;
								}
							}else{								
								// search if is equal
								if(strtolower($value) !== strtolower($has[1])){
									$no_matching_els[$i] = $numberElement;
								}
							}				
						}
					}
				}
			}
			$i++;
			$GetData[] = $arrayElements;
		}		
		if($no_matching_els > 0){			
			// eliminate items that does not has:
			foreach ($no_matching_els as $id => $item){
				if(!isset($GetData[$item])){
					unset($GetData[$id]);
				}else{
					unset($GetData[$item]);
				}			
			}
		}
		$news = [];
		foreach ($GetData as $GetData) {
			$news[] = $GetData;
		}
		return $news;
	}
	public static function setElemets($data, $elements = [])
	{
		$data = json_encode($data, TRUE);
		$data = json_decode($data, TRUE);
		if(is_array($elements)){
			$elements = array_combine($elements, $elements);
		}
		$GetData = [];
		foreach ($elements as $element) 
		{
			
			if(isset($data[$element])){
				$GetData[$element] = $data[$element];
			}
		}
		return $GetData;
	}
	public static function sorting($GetData, $options)
	{
		if($options["itemName"] !== FALSE)
		{
			$GetData = Database::SortingData( $GetData, $options["itemName"], $options["sortby"] ?? "desc", $options["dataType"] );
			return $GetData;
		}
		$GetData = Generate::SortingFiles( $GetData, $options["sortby"] );
		return $GetData;
	}
	public static function paginate($database, $options = [], $searchfor = FALSE, $doublefilter = FALSE)
	{
		# Options
		#########################
		$Pagination = TRUE;
		$options['sortby'] = $options['sortby'] ?? "new";
		$PaginatorName = $options['PaginatorName'] ?? "paginator";
		$GLOBALS["PerPage"] = $options['PerPage'] ?? "20";
		$NextText = $options['NextText'] ?? "Next";
		$PreviusText = $options['PreviusText'] ?? "Previus";
		$NavigationNumbers = $options['NavigationNumbers'] ?? "8"; 
		#########################
		if(is_string($database)){
			$GetData = Database::GetData( $database );
		}else{
			$GetData = $database;
		}


		if($searchfor !== FALSE)
		{
			$QueryArray = Generate::query( $searchfor );
        	$GetData = Database::SearchEngine( $GetData, $QueryArray );
        	if($doublefilter !== FALSE)
        	{
        		$GetData = Database::SearchEngine( $GetData, $QueryArray );
        	}
		}
		# Sorting
		$GetData = self::sorting($GetData, $options);
		#########################
		# Ejecutamos el paginador
		# Solo copiar y pegar
		#########################
		$GLOBALS["CountData"] = count($GetData);
		$limit = Database::SliceData( $GLOBALS["PerPage"], $GLOBALS["CountData"] );
		$Paginator = $options['page_position'] ?? Generate::Paginator( $PaginatorName );
		$GetData = Database::Paginate( $GetData, $GLOBALS["PerPage"], $limit, $Paginator );
		#########################
		$data = [$limit, $Paginator, $GetData];
		return $data;
	}
}

class parse_data_to
{
	public static function json($data = FALSE)
	{
		###############
		if(!is_array($data)){return NULL;}
		###############
		$data = json_encode($data, FALSE);
		return $data;
	}
	public static function object($data, $type = TRUE) 
	{
		###############
		if($data == FALSE){return FALSE;}
		if(empty($data)){return NULL;}
		###############
		if($type == FALSE){
			$data = json_encode($data, FALSE);
			return $data; 
		}
		$data = json_decode($data, TRUE);
		return $data; 
	}
}

class object_into_cell
{
	public static function remove($data, $key) 
	{
		if(!isset($data[$key])){return FALSE;}
		unset($data[$key]);
		return $data;
	}
}

class json_into_cell
{

	public static function merge_objects($data = FALSE, $add_this = FALSE)
	{
		if($data == FALSE || $add_this == FALSE){return NULL;}
		$add_this = json_encode($add_this, TRUE);
		$add_this = json_decode($add_this, TRUE);		
		$data = json_decode($data, TRUE);

		foreach ($add_this as $key => $value) {
			$data[$key] = $value;
		}
		// $data = array_merge($data, $add_this);
		$data = json_encode($data, FALSE);
		return $data;
	}
	public static function modify_object($data, $key, $new) 
	{
		if(!isset($data[$key])){return FALSE;}
		$data[$key] = $new[$key];
		return $data; # Will return an array. Because it will not need to be associative.
	}
	public static function save_records($database, $table, $itemName, $data)
	{
		if(!is_string($data)){return FALSE;}
		$data = Database::UpdateContent($database, $table, $itemName, $data);
		return $data;
	}
}


class createMultiple
{
	public static function items($database, $table_id, $data, $password = FALSE)
	{
		if(is_array($data)){
			foreach ($data as $value) {
				if(is_array($value)){ $value = json_encode($value, TRUE); }
				try {
					Database::securityParseText($value);
				} catch (Exception $e) {
					throw new Exception($e, 1);
				}
			}
		}else if(is_string($data)){
			Database::securityParseText($data);
		}
		return MaricutoDB::Create($database, $table_id, $data, "MDB__MULTIPLE_FIELDS__MDB", $password);
	}
}
class editMultiple
{
	public static function items($database, $table_id, $data, $password = FALSE)
	{
		if(is_array($data)){
			foreach ($data as $value) {
				if(is_array($value)){ $value = json_encode($value, TRUE); }
				try {
					Database::securityParseText($value);
				} catch (Exception $e) {
					throw new Exception($e, 1);
				}
			}
		}else if(is_string($data)){
			Database::securityParseText($data);
		}
		return Database::UpdateContent($database, $table_id, $data, "MDB__MULTIPLE_FIELDS__MDB", $password);
	}
}
class eliminateMultiple
{
	public static function items($database, $table_id, $arrayNames)
	{
		foreach ($arrayNames as $item) 
		{
			DELETE::Item($database, $table_id, $item);
		}
		return TRUE;
	}
}



class ObjectIntoTableElement
{
	public static function add($db, $table_id, $data, $elementName, $elementID, $action = FALSE)
	{

		# Elementos "Restart"
		# son para reinicar la variable en caso de errores.
		$dataRestart = $data;
		################
		$data_sent = $data; # this
		$data_sentForRestart = $data_sent; # para reiniciar variable cuando se necesite
		################
		# Buscar el objeto
		# y crear vacío si no existe

		
		MaricutoDB::Create($db, $table_id, $elementName, "[]");
		$table = Database::Table($db, $table_id);
		## encontrar el objecto dentro de la tabla
		$object = parse_data_to::object($table->$elementName ?? FALSE);
		$objectForRestart = $object; # para reiniciar variable cuando se necesite


		# si se define una ID modificar el value de la KEY (ID) correspondiente
		# y si existe ya el objeto asociativo dentro de la tabla
		if($elementID !== FALSE && isset($table->$elementName))
		{
			
			# Modificar si se apunta a un elemento en concreto.
			$object = json_into_cell::modify_object($object, $elementID, $data_sent);
			
			# Intializar el json_into_cell (convierte a JSON)
			$data = parse_data_to::json($object);
			# Se pondra en modo edicion
			# si data es igual a TRUE
			$edit = TRUE;
			
			if($data == FALSE){$edit = FALSE;}
			if($edit == TRUE)
			{

				# Guardar JSON como objeto dentro de una de las instancias de la tabla
				if($action !== "return-data"){ // si se quiere retornar el campo y sus datos
					json_into_cell::save_records($db, $table_id, $elementName, $data);
					return $data_sent;
				}
				
				## Finaliza el Guardado
				################
			}
			# si el script continua en esta parte del código 
			# reiniciar las variables object y data.
			# para combinar elementos existentes con nuevos ingresados.
			######### ----- #########			
			$data 		= $dataRestart; # data existente
			$data_sent 	= $data_sentForRestart; # data enviada
			$object 	= $objectForRestart; # objeto dentro de la tabla
			######### ----- #########
			######### ----- #########
		}

		### Si se añadirá uno nuevo
		# Intializar el parse_data_to::json (convierte a JSON)
		$data = parse_data_to::json($object);
		################


	
		# Combinar el objeto nuevo con los elementos ya establecidos
		$data = json_into_cell::merge_objects($data, $data_sent);
		# Si no existe un objeto (no hay notificaciones) Crear desde 0
		if($object == FALSE){$data = parse_data_to::json($data_sent);}
		


		
		# Guardar JSON como objeto dentro de una de las instancias de la tabla	
		if($action == "return-data"){ // si se quiere retornar el campo y sus datos
			return $data;
		}else{
			json_into_cell::save_records($db, $table_id, $elementName, $data);
			return $data_sent;
		}
		

		## Finaliza el Guardado
		################
	}
	public static function remove($db, $table_id, $elementName, $elementID, $msg = FALSE)
	{

		# Buscar el objeto 
		$table = Database::Table($db, $table_id);
		## encontrar el objecto dentro de la tabla
		$object = parse_data_to::object($table->$elementName);
		$object = object_into_cell::remove($object, $elementID);
		
		if($object === FALSE){return FALSE;}
		$data = parse_data_to::json($object);

		if($data == FALSE){return FALSE;}
		json_into_cell::save_records($db, $table_id, $elementName, $data);
		return TRUE;
	}
}


class MaricutoDBPaginator
{
	// add function to get data:
	public $props = [];
	public $AllDataByTime = [];
	public $AllDataFiltered = [];
	public function filters($data, $filters)
	{

		if(!is_array($filters) || !isset($filters[0])){
			return $data;
		}
		$results = TRUE;
		foreach ($filters as $arrayData) {
			$name = $arrayData[0];
			$value = $arrayData[1];
			switch ($value) {
				case NULL:/*do nothing*/ break;
				case FALSE:/*do nothing*/ break;
				case "N/A":/*do nothing*/ break;
				case "none":/*do nothing*/ break;			
				case "":/*do nothing*/ break;			
				default:
					$data = MaricutoDB::selectData($data, [], [$name, $value]);
					break;
			}
		}
		if($results == FALSE){
			// if one of the filters fails
			return FALSE; // original
		}
		if(!isset($data[0])){
			return FALSE; // original
		}
		/******/ # use this data to parse something.
			$this->AllDataFiltered = $data;
		/******/
		return $data;
	}
	public function output($data)
	{
		$paginateInfo = $data["paginateInfo"];
		$items = $data["items"];

		$position = $this->props["options"]["page_position"];
		$limit = $paginateInfo[0] ?? 0;
		$navigation = Write::NavigationNumbers($limit, 6, $position, "any");

		$navigation = array_unique($navigation);
		if(count($navigation) === 1){
			$navigation = [1];
		}

		return [
			"data"  => $paginateInfo[2],
			"limit" => $limit, 
			"items" => $items, 
			"navigation" => $navigation, 
			"position" => $position
		];
	}
	public function sortByTime($arrayData)
	{
		$from = $this->props["fromDate"] ?? FALSE;
		$until = $this->props["untilDate"] ?? FALSE;
		$itemName = $this->props["itemNameForDates"] ?? FALSE;
		if($from == FALSE || $until == FALSE || $itemName == FALSE){
			return $arrayData;
		}
		$from = strtotime($from);
		$until = strtotime($until);
		$getSorted = [];
		foreach ($arrayData as $key => $data) {
			// time stored in array item
			if(!isset($data[$itemName])){ continue; }
			$time = strtotime($data[$itemName]);
			if($from <= $time && $time <= $until){
				$getSorted[] = $data;
			}
		}
		/******/ # use this data to parse something.
			$this->AllDataByTime = $getSorted;
		/******/
		return $getSorted;
	}
	public function parser($arrayData)
	{
		
		$arrayData = $this->filters($arrayData, $this->props["filters"]);
		$arrayData = $this->sortByTime($arrayData);


		if($arrayData !== FALSE){
			$searchFor = $this->props["searchFor"] ?? FALSE;
			if(is_string($searchFor)){
				$QueryArray = Generate::query( $searchFor );
        		$arrayData = Database::SearchEngine( $arrayData, $QueryArray, FALSE );
			}
			$this->rawData = $arrayData;
			$paginateInfo = MaricutoDB::paginate($arrayData, $this->props["options"] ?? []);
		}else{
			$arrayData = [];
			$this->rawData = $arrayData;
			$paginateInfo = FALSE;
		}

		if($arrayData == NULL){
			$arrayData = [];
		}
		return [
			"items" => count($arrayData),
			"paginateInfo" => $paginateInfo
		];
	}
	public function render()
	{
		$data = $this->data;
		$parsed = $this->parser($data);
		return $this->output($parsed ?? FALSE);
	}
}


require_once "mdb.php";
require_once "collections.php";
require_once "collections.manager.php";
require_once "documents.manager.php";

?>