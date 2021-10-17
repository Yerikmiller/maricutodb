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

class mdb 
{	
	public function paginator(array $pushed_data, $props)
	{
		# props: 
		# sortby, dataType, field, limit, position, searchFor, fromDate, untilDate, itemNameForDates, filters.
		
		$props["sortby"] = $props["sortby"] ?? "desc";
		$props["dataType"] = $props["dataType"] ?? "OBJECT";
		$props["itemName"] = $props["field"] ?? "time";
		$props["PerPage"] = $props["limit"] ?? 30;
		$props["position"] = $props["position"] ?? 0;
		$props["searchFor"] = $props["searchFor"] ?? FALSE;
		$props["fromDate"] = $props["fromDate"] ?? FALSE;
		$props["untilDate"] = $props["untilDate"] ?? FALSE;
		$props["itemNameForDates"] = $props["itemNameForDates"] ?? "time";
		$props["filters"] = $props["filters"] ?? FALSE;

		$options = [
			"sortby" => $props["sortby"] ?? "desc",
			"dataType" => $props["dataType"] ?? "OBJECT",
			"itemName" => $props["itemName"] ?? "time", // item name to sort by
			"PerPage" => $props["PerPage"] ?? 30,
			"page_position" => $props["position"] ?? 0,
		];
		
		$paginator = new MaricutoDBPaginator();
		$paginator->data = $pushed_data;
		$paginator->props = [
			"options" => $options,
			"searchFor" => $props["searchFor"] ?? FALSE,
			"fromDate" => $props["fromDate"] ?? FALSE,
			"untilDate" => $props["untilDate"] ?? FALSE,
			"itemNameForDates" => $props["itemNameForDates"] ?? $props["itemName"] ?? "time",
			"filters" => $props["filters"] ?? FALSE
		];
		
		
		
		$data = $paginator->render();
		return $data;
	}
	public function createFields($database, $table_id, $arrayData, $password = FALSE)
	{
		return createMultiple::items($database, $table_id, $arrayData, $password);
	}
	public function updateFields($database, $table_id, $arrayData, $password = FALSE)
	{
		return editMultiple::items($database, $table_id, $arrayData, $password);
	}
	public function removeFields($database, $table_id, $arrayData)
	{
		return eliminateMultiple::items($database, $table_id, $arrayData);
	}
	public function addElementListIntoField($db, $table_id, $data, $elementName, $elementID, $save = FALSE)
	{
		# Create an array element included inside a field of a JSON data table
		return ObjectIntoTableElement::add($db, $table_id, $data, $elementName, $elementID, $save);
	}
	public function removeElementListIntoField($db, $table_id, $elementName, $elementID, $msg = FALSE)
	{
		# remove an array element included inside a field of a JSON data table
		return ObjectIntoTableElement::remove($db, $table_id, $elementName, $elementID, $msg);
	}
	public function create( $db_name, $__id__, $ItemName, $Content, $Ispassword = FALSE )
	{
		return MaricutoDB::Create($db_name, $__id__, $ItemName, $Content, $Ispassword);	
	}
	public function openFiles($files)
	{
		return MaricutoDB::openFiles($files);	
	}
	public function selectData($arrays, $select = FALSE, $has = [], $relative = TRUE)
	{
		return MaricutoDB::selectData($arrays, $select, $has, $relative);	
	}
	public function sorting($GetData, $options)
	{
		return MaricutoDB::sorting($GetData, $options);	
	}
	public function paginate($database, $options = [], $searchfor = FALSE, $doublefilter = FALSE)
	{
		return MaricutoDB::paginate($database, $options, $searchfor, $doublefilter);	
	}
	public function randomString($length = 10, $RandomLenght = TRUE, $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-')
	{
		return Generate::RandomString($length, $RandomLenght, $characters);
	}
	# methods from db.class.php
	public function createFolderDB( $db_name )
	{
		return Database::CreateFolderDB($db_name);
	}
	public function createDB( $db_name, $__id__ ) 
	{
		return Database::CreateDB($db_name, $__id__);
	}
	public function insertData( $db_name, $__id__, $ItemName, $Content, $Ispassword = FALSE )
	{
		return Database::InsertData($db_name, $__id__, $ItemName, $Content, $Ispassword);
	}
	public function searchDB( $db_name, $getAll = FALSE, $IsObject = FALSE )
	{
		return Database::SearchDB($db_name, $getAll, $IsObject);
	}
	public function getItem( $db_name, $__id__, $ItemName,  $echo = TRUE )
	{
		return Database::GetItem($db_name, $__id__, $ItemName);
	}
	public function table( $db_name, $__id__ )
	{
		return Database::Table($db_name, $__id__);
	}
	public function verifyEncryptedData( $db_name, $__id__, $ItemName, $EncryptedData )
	{
		return Database::VerifyEncryptedData($db_name, $__id__, $ItemName, $EncryptedData);
	}
	public function verifyData( $db_name, $__id__, $ItemName, $Data )
	{
		return Database::VerifyData($db_name, $__id__, $ItemName, $Data);
	}
	public function login( $User, $Pass, $con3 = TRUE, $con4 = TRUE )
	{
		return Database::Login($User, $Pass, $con3, $con4);
	}
	public function updateDBName( $db_name, $NewDBName )
	{
		return Database::UpdateDBName($db_name, $NewDBName);
	}
	public function updateItemName( $db_name, $__id__, $ItemName, $NewItemName )
	{
		return Database::UpdateItemName($db_name, $__id__, $ItemName, $NewItemName);
	}
	public function updateContent( $db_name, $__id__, $ItemName, $Content, $Ispassword = FALSE )
	{
		return Database::UpdateContent($db_name, $__id__, $ItemName, $Content, $Ispassword);
	}
	public function updateTableName($db_name, $__id__, $new_id)
	{
		return Database::UpdateTableName($db_name, $__id__, $new_id);
	}
	public function countFiles( $db_name = NULL )
	{
		return Database::CountFiles($db_name);
	}
	public function searchingFor( $coincidences, $string, $as = 'bool' )
	{
		return Database::SearchingFor($coincidences, $string, $as);
	}
	public function output( $files )
	{
		return Database::Output($files);
	}
	public function getData( $db_name = NULL, $PagePosition = '0' , $PerPage = '10', $ReturnLimit = FALSE  )
	{
		return Database::GetData($db_name, $PagePosition , $PerPage, $ReturnLimit);
	}
	public function outputId($db_name, $ItemName, $Data)
	{
		return Database::OutputId($db_name, $ItemName, $Data);
	}
	public function get_id($db_name, $ItemName, $Data)
	{
		return Database::get_id($db_name, $ItemName, $Data);
	}
	public function sliceData( $PerPage, $CountData )
	{
		return Database::SliceData($PerPage, $CountData);
	}
	public function paginateJSONFiles( $files, $PerPage, $limit, $PagePosition = '0' )
	{
		return Database::Paginate($files, $PerPage, $limit, $PagePosition);
	}
	public function sortingData( $GetData, $content, $sortby = 'asc', $dataType = 'FILES' )
	{
		return Database::SortingData($GetData, $content, $sortby, $dataType);
	}
	public function searchEngine( $GetData, $QueryArray, $is_file = TRUE )
	{
		return Database::SearchEngine($GetData, $QueryArray, $is_file);
	}
	public function deleteItem( $db_name, $__id__, $ItemName )
	{
		return DELETE::Item($db_name, $__id__, $ItemName);
	}
	public function deleteTable( $db_name, $__id__ )
	{
		return DELETE::Table($db_name, $__id__);
	}
	public function deleteDB( $db_name, $__id__ )
	{
		return DELETE::DB($db_name, $Backup = TRUE);
	}
	public static function encrypt( $data_inserted )
	{
		return password_hash($data_inserted, PASSWORD_DEFAULT);
	}
	public function constructToken($name, $data = [])
	{
		$token = $this->randomString(32, FALSE);
		$_SESSION[$name] = [
			"$token" => $data
		];
		return $token;
	}
	public function getTokenData($name, $token)
	{
		if(isset($_SESSION[$name])){
			return $_SESSION[$name][$token];
		}
		return NULL;
	}
	public function sort($array, $name, $order=SORT_ASC)
	{
		// SORT ARRAY OBJECTS
		$new_array = array();
	    $sortable_array = array();

	    if (count($array) > 0) {
	        foreach ($array as $k => $v) {
	            if (is_array($v)) {
	                foreach ($v as $k2 => $v2) {
	                    if ($k2 == $name) {
	                        $sortable_array[$k] = $v2;
	                    }
	                }
	            } else {
	                $sortable_array[$k] = $v;
	            }
	        }

	        switch ($order) {
	            case SORT_ASC:
	                asort($sortable_array);
	            break;
	            case SORT_DESC:
	                arsort($sortable_array);
	            break;
	        }

	        foreach ($sortable_array as $k => $v) {
	            $new_array[$k] = $array[$k];
	        }
	    }

	    return array_values($new_array);
	}
	public function documents(string $collection)
	{
		return new MDBdocuments($collection);
	}
	public function collection(string $collection = "", string $fieldName = "collection")
	{
		if($collection == ""){

		}
		$this->maxFieldsCollection = $this->maxFieldsCollection ?? 25;
		return new MDBCollections($collection, $fieldName, $this->maxFieldsCollection);
	}
}

?>