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

class MDBCollections extends mdb
{
	private $metaDocument = "metadata";
	private $lengthString = 7;
	private $maxFields = 18;
	private $libs = FALSE;
	public function __construct(string $collection, $fieldName, $maxFields)
	{
		if($collection == $this->metaDocument){
			throw new Exception("$this->metaDocument is a reserved collection.", 1);
			return FALSE;
		}
		if(!is_string($fieldName)){
			$fieldName = "collection";
		}
		$this->collection = $collection;
		$this->maxFields = $maxFields; // maxFieldsCollection
		$this->fieldName = $fieldName;
		$this->fieldNameReserved = $fieldName;
		$this->libs = dirname(__FILE__)."/libs/";
		return __CLASS__;
	}
	private function Folder($folder)
	{
		return Generate::hash($folder);
	}
	private function File($documentId)
	{
		return Generate::hash(Generate::hash($documentId));
	}
	private function getPath($folder, $document)
	{
		return $this->libs.$this->Folder($folder)."/".$this->File($document).".json";
	}
	private function updateMetaDocument($documentId)
	{
		$mdb = new mdb();
		$metaDocuments = $mdb->table($this->collection, $this->metaDocument);
		$metaDocuments->documents = json_decode($metaDocuments->documents, TRUE);
		$metaDocuments->documents[] = $documentId;

		$metaDocuments->tokenDocuments = json_decode($metaDocuments->tokenDocuments, TRUE);
		$metaDocuments->tokenDocuments[] = [
			"id" => $documentId,
			"token" => $this->File($documentId),
		];

		$mdb->updateFields($this->collection, $this->metaDocument, [
			"documents" => json_encode($metaDocuments->documents, TRUE),
			"tokenDocuments" => json_encode($metaDocuments->tokenDocuments, TRUE),
		]);
		return TRUE;
	}
	public function getField($token)
	{
		$mdb = new mdb();
		$documentId = substr($token, 0, $this->lengthString);
		$id = substr($token, $this->lengthString);
		$document = $mdb->table($this->collection, $documentId);
		$fieldName = $this->fieldName;
		$fields = json_decode($document->$fieldName ?? "[]", TRUE);
		$field = $mdb->selectData($fields, [], ["id", $id]);
		$field = $field[0] ?? FALSE;
		return $field;
	}
	private function addField($id, $document, $data, $isUpdating = FALSE)
	{
		$mdb = new mdb();
		$getField = $this->getField($document->__id__.$id);

		// if the Field exists return it.

		

		if($getField !== FALSE && $isUpdating == FALSE){
			$getField = (object) $getField;
			return $getField;
		}
		$fieldName = $this->fieldName;
		$fields = json_decode($document->$fieldName, TRUE);
		$data = (array) $data;
		$data["id"] = $id;
		$data["document"] = $document->__id__;
		$data["time"] = time();

		$data = [
			$id => $data,
		];
		/*$fields[] = $data;*/
		$items = [];


		$mdb->addElementListIntoField($this->collection, $document->__id__, $data, $this->fieldName, $id);
		/*$mdb->updateFields($this->collection, $document->__id__, [
			$this->fieldName => json_encode($fields, TRUE),
		]);*/
		return $data;
	}
	private function addDocument()
	{
		$mdb = new mdb();
		$metaDocuments = $mdb->table($this->collection, $this->metaDocument);
		$metaDocuments->documents = json_decode($metaDocuments->documents, TRUE);
		
		// last document
		$documentId = end($metaDocuments->documents);

		if($documentId == FALSE){
			$documentId = $mdb->randomString($this->lengthString, FALSE);
			$mdb->createFields($this->collection, $documentId, [
				$this->fieldName => json_encode([], TRUE),
			]);

			// update meta document
			$this->updateMetaDocument($documentId);
			return $mdb->table($this->collection, $documentId);
		}

		// create document only if max has reached.
		$document = $mdb->table($this->collection, $documentId);		
		$fieldName = $this->fieldName;
		$fields = json_decode($document->$fieldName, TRUE);
		if(count($fields) >= $this->maxFields){
			// if the max has reached created a new document;
			$documentId = $mdb->randomString($this->lengthString, FALSE);
			$mdb->createFields($this->collection, $documentId, [
				$this->fieldName => json_encode([], TRUE),
			]);

			// update meta document
			$this->updateMetaDocument($documentId);
			return $mdb->table($this->collection, $documentId);
		}else{

			// return table if has not reached the limit.
			return $mdb->table($this->collection, $documentId);
		}
		return FALSE;
	}
	private function createMetaDocument()
	{
		$mdb = new mdb();
		$mdb->createFields($this->collection, $this->metaDocument, [
			"documents" => json_encode([], TRUE),
			"tokenDocuments" => json_encode([], TRUE),
		]);
		return TRUE;
	}
	private function getTables()
	{
		$mdb = new mdb();
		$metaDocuments = $mdb->table($this->collection, $this->metaDocument);
		$files = json_decode($metaDocuments->tokenDocuments ?? "[]", TRUE);
		$orderedFiles = [];
		$folder = md5($this->collection);
		foreach ($files as $file) {
			$file = dirname(__FILE__)."/libs/$folder/".$file["token"].".json";
			if(file_exists($file)){
				$orderedFiles[] = $file;
			}
		}
		$files = $mdb->openFiles($orderedFiles);
		return $files;
	}
	public function getCount()
	{
		return count($this->getDocuments());
	}
	public function getDocuments()
	{
		$tables = $this->getTables();
		$allFields = [];
		$fieldName = $this->fieldName;
		foreach ($tables as $fields) {
			$fields = json_decode($fields->$fieldName, TRUE);
			foreach ($fields as $field) {
				$id = $field["id"];
				$id = strval($id);
				$allFields["$id"] = $field;
			}
		}
		return $allFields;
	}
	public function add($id, $data)
	{
		$mdb = new mdb();

		if(is_string($data)){
			throw new Exception('$data passed is not an array of objects. "string" given.', 1);
			return FALSE;
		}

		$data = (object) $data;

		if(!is_object($data)){
			throw new Exception('$data passed is not an array of objects. "array" given.', 1);
			return FALSE;
		}
		if($id == "randomId"){
			$id = $mdb->randomString($this->lengthString, FALSE);
		}
		$metaDocument = $mdb->table($this->collection, $this->metaDocument);
		if($metaDocument == NULL){
			$this->createMetaDocument();
			$metaDocument = $mdb->table($this->collection, $this->metaDocument);			
		}

		// add document if is applicable.
		// else return last document.
		$document = $this->addDocument();

		// create and return new Field.

		return $this->addField($id, $document, $data);
	}
	public function push($id, $data, $removeThisElement = FALSE)
	{
		return $this->update($id, $data, $removeThisElement);
	}
	public function update($id, $data, $removeThisElement = FALSE)
	{
		$mdb = new mdb();
		$documents = $this->getDocuments();
		$field = $documents[$id] ?? FALSE;
		if($field == FALSE){
			return $this->add($id, $data);
		}
		if(is_string($data)){
			throw new Exception('$data passed is not an array of objects. "string" given.', 1);
			return FALSE;
		}

		$data = (object) $data;

		if(!is_object($data)){
			throw new Exception('$data passed is not an array of objects. "array" given.', 1);
			return FALSE;
		}
		foreach ($data as $name => $value) {
			if($name == "id"||$name == "document"||$name == "time"){
				continue;
			}
			if(is_string($removeThisElement)){				
				if($name == $removeThisElement){
					unset($field[$name]);
					continue;
				}
			}
			$field[$name] = $value;
		}


		$data = [
			($field["id"]) => $field,
		];
		/*$fields[] = $data;*/
		$data = $mdb->addElementListIntoField($this->collection, $field["document"], $data, $this->fieldName, $field["id"], "save");

		return $data;
	}
	private function getBy($fieldName, string $id = NULL, string $dataField = NULL)
	{
		return $this->get($id, $dataField, $fieldName);
	}
	public function get(string $id = NULL, string $dataField = NULL, string $name = "id")
	{
		$mdb = new mdb();
		if(strpos($id, "../") !== FALSE){
			$getBy = explode("../", $id)[1];
			if($getBy == FALSE){
				throw new Exception("You need to place a word after ../", 1);
			}
			return $this->getBy($getBy, $dataField);
		}
		$files = $mdb->getData($this->collection);
		$elements = [];
		foreach ($files as $file) {
			$table = $mdb->openFiles( [$file] );
			foreach ($table as $rows) {
				foreach ($rows as $field => $row) {
					if($field == $this->fieldName){						
						$documents = json_decode($row, TRUE);

						foreach ($documents as $key => $document) {
							if(!isset($document[$name])){ continue; }
							if($document[$name] == $id && $id !== NULL){
								
								if(is_string($dataField) == TRUE){
									$elements = $document[$dataField];
								}else{
									$elements[] = $document;
								}
							}else if($id == NULL){
								$elements[] = $document;
							}
							
						}
					}
				}
			}
		}

		return $elements;
	}
	public function query($value, $query, $field)
	{
		$mdb = new mdb();
		$this->documentsAvailablesFromQuery = [];
		$documents = $mdb->documents($this->collection)->documents([
			"query" => $query,
			"field" => $field,
			"value" => $value,
		])->all(function($document, $props){
			$collection_field = $this->fieldName;
			if(!isset($document->$collection_field)){ return FALSE; }
			$documents = json_decode($document->$collection_field, TRUE);
			foreach ($documents as $id => $subcollection) {
				if(!isset($subcollection[$props["field"]])){ continue; }
				$content = $subcollection[$props["field"]];
				$success = FALSE;
				switch ($props["query"]) {
					case '==':						
						if($props["value"] == $content){ $success = TRUE; }
					break;
					case '===':
						if($props["value"] === $content){ $success = TRUE; }
					break;
					case '>=':
						if($props["value"] >= $content){ $success = TRUE; }
					break;
					case '<=':
						if($props["value"] <= $content){ $success = TRUE; }
					break;
					case '>':
						if($props["value"] > $content){ $success = TRUE; }
					break;
					case '<':
						if($props["value"] < $content){ $success = TRUE; }
					break;
					case 'in':
						if(strpos($content, $props["value"]) !== FALSE){ $success = TRUE; }
					break;
					case 'not in':
						if(strpos($content, $props["value"]) == FALSE){ $success = TRUE; }
					break;
					default:
						$success = FALSE;
					break;
				}
				if($success == TRUE){					
					$this->documentsAvailablesFromQuery[] = $subcollection;
				}
			}	
		});
		return $this->documentsAvailablesFromQuery;
	}
	public function removeDocument(string $id, string $dataField = NULL)
	{
		$mdb = new mdb();
		$elements = $this->get($id, $dataField);
		foreach ($elements as $element) {
			$mdb->removeElementListIntoField($this->collection, $element["document"], $this->fieldName, $element["id"]);
		}
		return TRUE;
	}
	public function removeField(string $id, string $dataField, string $toRemove)
	{
		$elements = $this->get($id, $dataField);
		foreach ($elements as $element) {
			if(isset($element[$toRemove])){
				if($toRemove == "id" || $toRemove == "document" || $toRemove == "time"){
					continue;
				}
				$this->update($element["id"], $element, $toRemove);
			}
		}
		return $this->get($id, $dataField);
	}
	public function document($id)
	{
		return new MDBCollectionsManager( $this->collection,
		$this->maxFields,
		$this->fieldName,
		$this->fieldNameReserved,
		$this->libs );		
	}
}




/*for ($e=0; $e < 10; $e++) { 
	for ($i=0; $i < 100; $i++) { 
		$collection = $mdb->collection("prueba")->update("randomId", [
			"token" => $mdb->randomString(32, FALSE),
			"name" => $mdb->randomString(6, FALSE, "ABCDEIOU"),
			"lastname" => $mdb->randomString(6, FALSE, "ABCDEIOU"),
			"type" => "elclubdeldinero",
		]);
	}
}*/

/*$collection = $mdb->collection("prueba")->update("randomId", [
	"token" => $mdb->randomString(32, FALSE),
	"name" => $mdb->randomString(6, FALSE, "ABCDEIOU"),
	"lastname" => $mdb->randomString(6, FALSE, "ABCDEIOU"),
	"type" => "elclubdeldinero",
]);*/
//$collection = $mdb->collection("prueba")->remove();
# $collection = $mdb->collection("prueba")->get();
/*
$mdb = new mdb();
$mdb->maxFieldsCollection = 40;
$collection = $mdb->collection("prueba")->get("../id", "s");
*/
# $collection = $mdb->collection("prueba")->update("T-WYnu_", [
# 	"id" => "855"
# ]);
/*
var_dump($collection);
exit();*/

# $collection = $mdb->collection("prueba")->get("../type", "elclubdeldinero");



/*$files = $mdb->getData("prueba");
$documents = $mdb->openFiles($files);
$users = [];
foreach ($documents as $document) {
	if(!isset($document->fields)){ continue; }
	$fields = json_decode($document->fields, TRUE);
	foreach ($fields as $field) {
		if(isset($field["type"])){
			if($field["type"] == "elclubdeldinero"){
				$users[] = $field;
			}
		}
	}
	
}
$collection = $users;*/



//

# $collection = $mdb->collection("prueba")->getDocuments();
# $collection = $mdb->collection("prueba")->get();

/*
####
# create with id
####

$collection = $mdb->collection("prueba")->add("1", [
	"saludo" => "hola",
	"saludo2" => "buenas tardes",
]);

####
# create with random id
####

$collection = $mdb->collection("prueba")->add("randomId", [
	"saludo" => "hola",
	"saludo2" => "buenas tardes",
]);

*/



/*



####
# create/update with id
####

$collection = $mdb->collection("prueba")->update("1", [
	"saludo" => "hola",
	"saludo2" => "buenas tardes",
]);

*/

/*
####
# create/update with random id
####

$collection = $mdb->collection("prueba")->update("randomId", [
	"saludo" => "hola",
	"saludo2" => "buenas tardes",
]);

*/

?>