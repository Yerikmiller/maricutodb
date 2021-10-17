<h1 align="center" class="vicinity rich-diff-level-zero">
  MDB | PHP Flat File Database Manager
</h1>

<p align="center">
  <img src="https://i.ibb.co/vq8NDxT/mdb.png" title="MaricutoDB php flat file database manager" style="width: 400px" alt="MaricutoDB php flat file database manager">
</p>

<p align="center">
  <img src="https://img.shields.io/badge/author-Yorman%20Maricuto-blue.svg?longCache=true&style=flat-square" alt=" ">
  <img src="https://img.shields.io/badge/files-JSON-green.svg?longCache=true&style=flat-square" alt=" ">
  <img src="https://img.shields.io/badge/method-Chunk--Collections-green.svg?longCache=true&style=flat-square" alt=" ">
  <img src="https://img.shields.io/badge/method-Collections-green.svg?longCache=true&style=flat-square" alt=" ">
  <img src="https://img.shields.io/badge/has-CRUD-blue.svg?longCache=true&style=flat-square" alt=" ">
  <img src="https://img.shields.io/badge/Security-password__hash-blue.svg?longCache=true&style=flat-square" alt=" ">
  <img src="https://img.shields.io/badge/has-paginator%20system-orange.svg?longCache=true&style=flat-square" alt=" ">
  <img src="https://img.shields.io/badge/has-filter--engine-orange.svg?longCache=true&style=flat-square" alt=" ">
  <img src="https://img.shields.io/badge/filter-custom-blue.svg?longCache=true&style=flat-square" alt=" ">
  <img src="https://img.shields.io/badge/filter-query--based-blue.svg?longCache=true&style=flat-square" alt=" ">
</p>

### Reference a collection. | $documents() 

Reference to create data.

```php  
  $mdb = new mdb();
  $collection = $mdb->documents("users"); // set any collection name of documents you want.
  
  // deprecated method MaricutoDB::CreateDB
  // any old method still working.
```

### Create Data | $documents->create()

To create data from the documents method you can use the create() method and pass the document ID plus an array for the data. This method doesn't overwrite or update an existing document.

```php   
  # $mdb->documents($collection)->create($documentId, $data);
  $mdb = new mdb();
  
  $mdb->documents("users")->create("user_1", [
    "name" => "John",
    "lastname" => "Doe"
  ]);
  
  // Deprecated method:
  # MaricutoDB::Create('UsersDB', 'user_n_1', 'nick', 'yerikmiller');
  // any old method still working.
```
### Update Data | $documents->update()

To update data from the documents method you can use the update() method and pass the document ID plus an array for the data, if the ID does not exist it will create a new document.

```php
  # $mdb->documents($collection)->update($documentId, $data);
  # or: $mdb->documents($collection)->push($documentId, $data);
  $mdb = new mdb();
  
  $mdb->documents("users")->update("user_1", [
    "lastname" => "Doe Doe Doe"
  ]);
  
  // Deprecated method:
  # Database::UpdateContent('UsersDB', 'user_n_1', 'nick', 'yerikmiller');
  // any old method still working.
```

### Get Documents | $documents->get()
get all documents to show
```php
  # @param $filter_function {function} optional
  # $mdb->documents($collection)->get()->all($filter_function);
  $mdb = new mdb();
  
  $list = $mdb->documents("users")->get()->all();
  // $list will output an array with all elements.
  
  // Deprecated method:
  # Database::GetData('UsersDB');
  // any old method still working.
```
### Backup | $documents->backup()
Create a backup for collection of documents.
```php
 $mdb = new mdb();
 $mdb->documents("users")->backup();
 
 
  // any old method still working.
```
### Restore Backup | $documents->restoreBackup()
Create a backup for collection of documents.
```php
 $mdb = new mdb();
 $mdb->documents("users")->restoreBackup();
 
 
  // any old method still working.
```
### Delete Documents | $documents->delete()
Delete a collection of documents
```php
 $mdb = new mdb();
 $mdb->documents("users")->delete()
 
 # this will automatically generate a backup
 # if you want to avoid backup the data pass a FALSE value
 # $mdb->documents("users")->delete(FALSE);
 
 
  // any old method still working.
```