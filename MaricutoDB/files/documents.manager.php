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


// documents method allow to create single files in a folder that we'll call "collection".



class MDBdocuments 
{
    public $table = NULL;
    private $mdb = NULL;
    private $collection_exist = FALSE;
    public function __construct(string $collection)
    {
        $this->mdb = new mdb();
        $this->collection = $collection;
        
        $db_folder_name = DB_LIBS_FOLDER.Generate::hash($collection);
        if(is_dir($db_folder_name)){
           $this->collection_exist = TRUE;
        }
        return __CLASS__;
    }
    public function create($id = NULL, array $params = [])
    {
        $mdb = $this->mdb;

        if($id == NULL){
            return Database::CreateFolderDB($this->collection);
        }
        if(is_int($id)){
            $id = strval($id);
        }
		if($this->table == NULL){
			$mdb->createFields($this->collection, $id, $params);
			$this->table = $mdb->table($this->collection, $id);			
		}
        return $this->table;
    }    
    public function update($id, array $params, bool $force_update = FALSE)
    {
        $mdb = $this->mdb;
        if(is_int($id)){
            $id = strval($id);
        }
        if($this->collection_exist == TRUE){
            $this->table = $mdb->updateFields($this->collection, $id, $params);
            if($this->table == NULL){
                $this->table = $this->create($id, $params);
            }
        }else{
            $this->table = $this->create($id, $params);
        }

        return $this->table;
    }    
    public function push($id, array $params, bool $force_update = FALSE)
    {
        $this->update($id, $params, $force_update);
    }
    public function get_by($field, $fieldContent)
    {
        if($this->collection_exist == FALSE){ return NULL; }
        $mdb = new mdb();
        $id = $mdb->outputId($this->collection, $field, $fieldContent);
        return $mdb->table($this->collection, $id);
    }
    public function where(string $value, string $operator, string $field)
    {
        $props = [
            "query" => [
                "field" => $field,
                "operator" => $operator,
                "content" => $value,
            ]
        ];
        $results = $this->documents($props);
        return $results->results;
    }
    public function get($props = [])
    {
        return $this->documents($props);
    }
    public function documents($props = [])
    {
        $mdb = new mdb();
        $files = $mdb->getData($this->collection);
        $this->files = $files;
        $this->props = $props;
        return new MDBOpenFilesOperator($files, $this->collection, $props);
    }
    public function document($id)
    {
        $mdb = new mdb();
        $table = $mdb->table($this->collection, $id);
        $getter = new MDBGetFieldsOperator($this->collection, $table, $id);
        return $getter;
    }
    public function backup()
    {
        if($this->collection_exist == TRUE){
            Backup::DB( $this->collection );
        }
    }
    public function restoreBackup()
    {
        if($this->collection_exist == TRUE){
            Restore::DB( $this->collection );
        }
    }
    public function delete($backup = TRUE)
    {
        if($this->collection_exist == TRUE){
            if($backup == TRUE){
                $this->backup();
            }
            DELETE::DB( $this->collection );
        }
    }
}


class MDBOpenFilesOperator
{
    private $files = [];
    private $collection = NULL;
    public function __construct($files, string $collection, array $props)
    {
        $this->files = $files;
        $this->collection = $collection;
        $this->props = $props;
        if(isset($this->props["query"]) == TRUE){
            return $this->query($this->props["query"]);
        }
        return __CLASS__;
    }
    public function query($query)
    {
        $this->field = $query["field"];
        $this->operator = $query["operator"];
        $this->content = $query["content"];
        $this->results = [];
        switch ($this->operator) {
            case '==':
                $this->results = $this->all(function($document){
                    $field = $this->field;
                    if($document->$field == $this->content){
                        return $document;
                    }
                    return FALSE;
                });
            break;
            case '===':
                $this->results = $this->all(function($document){
                    $field = $this->field;
                    if($document->$field === $this->content){
                        return $document;
                    }
                    return FALSE;
                });
            break;
            case '!=':
                $this->results = $this->all(function($document){
                    $field = $this->field;
                    if($document->$field !== $this->content){
                        return $document;
                    }
                    return FALSE;
                });
            break;
            case '>':
                $this->results = $this->all(function($document){
                     $field = $this->field;
                    if($document->$field > $this->content){
                        return $document;
                    }
                    return FALSE;
                });
            break;
            case '>=':
                $this->results = $this->all(function($document){
                    $field = $this->field;
                    if($document->$field >= $this->content){
                        return $document;
                    }
                    return FALSE;
                });
            break;
            case '<':
                $this->results = $this->all(function($document){
                    $field = $this->field;
                    if($document->$field < $this->content){
                        return $document;
                    }
                    return FALSE;
                });
            break;
            case '<=':
                $this->results = $this->all(function($document){
                     $field = $this->field;
                    if($document->$field <= $this->content){
                        return $document;
                    }
                    return FALSE;
                });
            break;
            case 'in':
                $this->results = $this->all(function($document){
                    $field = $this->field;
                    if(strpos(strtolower($document->$field), strtolower($this->content)) !== FALSE){
                        return $document;
                    }
                    return FALSE;
                });
            break;
            case 'not-in':
                $this->results = $this->all(function($document){
                    $field = $this->field;
                    if(strpos(strtolower($document->$field), strtolower($this->content)) == FALSE){
                        return $document;
                    }
                    return FALSE;
                });
            break;

            default:
                $this->results = [];
            break;
        }
        return $this->results;
    }
    public function getDocumentByJSON(string $json_id)
    {
        $mdb = new mdb();
        $collectionJSON = Generate::hash($this->collection);
        $file = FALSE;
        
        foreach($this->files as $path){
            $file = explode($collectionJSON."/", $path)[1];
            if(!is_int(strpos($file, $json_id))){ return; }
            $file = $path;
            $file = $mdb->openFiles([$file])[0];
        }
        return $file;
    }
    public function all($filter_function = FALSE)
    {
        $mdb = new mdb();
        $files = [];
        foreach ($this->files as $file) {
            $file = $mdb->openFiles([$file])[0];

            if(is_callable($filter_function)){
                $file = $filter_function($file, $this->props);
            }

            if($file == NULL || $file == FALSE){ continue; }
            $files[] = $file;            
        }
        return $files;
    }
}


/**
 * @Modify whole document
 * @Access to field.
 */
class MDBGetFieldsOperator
{
    private $collection = NULL;
    private $table = NULL;
    private $tableId = NULL;
    public function __construct($collection, $table, $tableId)
    {
        $this->collection = $collection;
        $this->table = $table;
        $this->tableId = $tableId;
        return __CLASS__;
    }
    public function show()
    {
        return $this->table;
    }
    public function create(array $arrayContent)
    {
        return $this->update($arrayContent);
    }
    public function push(array $arrayContent)
    {
        return $this->update($arrayContent);
    }
    public function updateId(string $id)
    {
        $mdb = new mdb();
        Database::UpdateTableName( $this->collection, $this->table->__id__, $id);
        return $mdb->table($this->collection, $id);
    }
    public function update(array $arrayContent, $is_strict = FALSE)
    {
        $mdb = new mdb();

        if($is_strict == "strict"){            
            $exists = TRUE;
            foreach ($arrayContent as $name => $content) {           
                
                if(!isset($this->table->$name)){
                    $exists = $name;
                    break;
                }                
            }
            if($exists !== TRUE){
                throw new Exception("field: $exists does not exists in the document.", 1);
            }
            
        }
        if(is_int($this->tableId)){
            $this->tableId = strval($this->tableId);
        }
        if($this->table == NULL){
            $mdb->createFields($this->collection, $this->tableId, $arrayContent);
            return $mdb->table($this->collection, $this->tableId);
        }
        $mdb->updateFields($this->collection, $this->tableId, $arrayContent);
        return $mdb->table($this->collection, $this->tableId);
    }   
    public function delete()
    {
        DELETE::Table($this->collection, $this->tableId);
        return TRUE;
    }
    public function subcollection(string $subcollection)
    {
        return new MDBSubCollectionManager($this->collection, $this->table, $subcollection);
    }  
    public function field($fieldName)
    {
        return new MDBOnFieldManaging($this->collection, $this->table, $fieldName);
    }
}

/**
 * Manage CRUD in certain collection->document->field.
 */
class MDBOnFieldManaging
{
    private $collection = NULL;
    private $table = NULL;
    private $fieldName = NULL;
    private $content = NULL;
    public function __construct($collection, $table, string $fieldName)
    {
        $this->collection = $collection;
        $this->table = $table;
        $this->fieldName = $fieldName;
        $this->content = $this->table->$fieldName ?? NULL;
        return __CLASS__;
    }
    public function show()
    {
        return $this->content;
    }
    public function updateFieldName(string $name)
    {
        Database::UpdateItemName($this->collection, $this->table->__id__, $this->fieldName, $name);
    }
    public function update($content = NULL)
    {
        if($content == NULL){ return FALSE; }
        $mdb = new mdb();
        if(is_array($content) || is_object($content)){
            $content = json_encode($content, TRUE);
        }
        $id = $this->table->__id__;
        if(is_int($id)){
            $id = strval($id);
        }
        Database::UpdateContent($this->collection, $id, $this->fieldName, $content);
        $this->table = $mdb->table($this->collection, $id);
        $fieldName = $this->fieldName;
        return $this->table->$fieldName;
    }
    public function delete()
    {
        DELETE::Item($this->collection, $this->table->__id__, $this->fieldName);
        return TRUE;
    }
    public function subcollection(string $subcollection)
    {
        return new MDBSubCollectionManager($this->collection, $this->table, $subcollection, $this->content);
    }
}

/**
 * Create, update, read, and remove subcollections
 */
class MDBSubCollectionManager 
{
    private $collection = NULL;
    private $table = NULL;
    private $subcollection = NULL;
    public function __construct(string $collection, $table, string $subcollection)
    {
        $this->collection = $collection;
        $this->table = $table;
        $this->subcollection = $subcollection; // fieldName
        return __CLASS__;
    }
    public function show($id = NULL)
    {
        $subcollection = $this->subcollection;
        if(is_string($id)){
            $data = $this->table->$subcollection;
            $data = json_decode($data, TRUE);
            $data = $data[$id] ?? [];
            return $data;
        }
        $data = $this->table->$subcollection;
        if(is_string($data)){
            $data = json_decode($data, TRUE);
        }
        return $data;
    }
    public function push($id, array $arrayContent)
    {
        $mdb = new mdb();
        if(is_int($id)){
            $id = strval($id);
        }
        $table = $this->table;
        if(!isset($table->$id)){
            $arrayContent["time"] = time();
        }
        $arrayContent["modified"] = time();
        $arrayContent["id"] = $id;
        $subcollection = $this->subcollection;
        $records = [
			$id => $arrayContent
		];
        
        return $mdb->addElementListIntoField($this->collection, $table->__id__, $records, $subcollection, $id);
    }
    public function delete(string $id)
    {
        $mdb = new mdb();
        $subcollection = $this->subcollection;
        return $mdb->removeElementListIntoField($this->collection, $this->table->__id__, $subcollection, $id);
    }
}
/*
$mdb = new mdb();
$user = $mdb->documents("users")->create("123", [
    "firstname" => "Yorman",
    "lastname" => "Maricuto",
]);*/

// $transactions = $mdb->documents("transactions")->create();
// $mdb->documents("users")->document("123")->show();
/*

$user = $mdb->documents("users")->document("123")->update([
    "firstnsasme" => "José",
], "strict");

$user = $mdb->documents("users")->document("123")->update([
    "firstnsasme" => "José",
]);

*/
// $mdb->documents("users")->document("123")->delete();
// $mdb->documents("users")->document()->all($filter_function);
// $mdb->documents("users")->document()->all($filter_function);
// $mdb->documents("users")->document("123")->field("lastname")->show();
// $mdb->documents("users")->document("123")->field("lastname")->update();
// $mdb->documents("users")->document("123")->field("firstname")->delete();

/*
$user = $mdb->documents("users")->document("123")->field("firstname")->update([
    "primer_nombre" => "yorman",
    "segundo_nombre" => "josé"
]);
*/

/*
$transactions = $mdb->documents("transactions")->create();


$documents = $mdb->documents("transactions")->documents()->all(function($document){
    if($document->username === "usuario numero 40000"){
        return $document;
    }
});

var_dump($documents);
exit();

*/





/*
for ($i=9000; $i < 50000; $i++) {   
    $mdb = new mdb();
    $document = $i;
    $transaction = $mdb->documents("transactions")->document($document)->push([
        "colecciones" => "creada en: ".time(),
        "username" => "usuario numero ".$i
    ]);

    

    for ($i2=1; $i2 < 1; $i2++) { 
        $mdb = new mdb();
        $HASH = $mdb->randomString(32, FALSE)."__$i2";
        $TransactionId = $mdb->randomString(8, FALSE);
        $mdb->documents("transactions")->document($document)->subcollection("mi_coleccion")->push($TransactionId, [
            "price:hash" => $HASH,
            "type:hash" => $HASH,
            "currency:hash" => $HASH,
            "city:hash" => $HASH,
            "payment:hash" => $HASH,
            "status:hash" => $HASH,
        ]);
        
    }
}



var_dump($mdb->documents("transactions")->documents()->all());
exit();*/
/*
$mdb = new mdb();
$mdb->maxFieldsCollection = 500;
for ($i=28419; $i < 50000; $i++) { 
    $HASH = $mdb->randomString(32, FALSE);
    $mdb->collection("transactions_stripe")->push($HASH, [
        "type:hash" => $HASH,
    ]);
}*/


// var_dump($mdb->collection("transactions_stripe")->getCount());



/*
$mdb->documents("transactions")->update("848154416__56", [
    "saludo" => "hola de nuevo",
]);*/

?>