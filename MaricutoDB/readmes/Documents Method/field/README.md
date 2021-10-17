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

### FIELD METHODS
Once you access to a field you can use the following methods:

#### $field->update()
```php
  $mdb = new mdb();
  $field = $mdb->documents($collection)->document($documentId)->field($field);
  $field->update([
   "lastname" => "Sat"
  ])
  
```
#### $field->show()
```php
  $mdb = new mdb();
  $field = $mdb->documents($collection)->document($documentId)->field($field);
  echo $field->show();
  
```
#### $field->updateFieldName()
It will update the field name selected.
```php
  $mdb = new mdb();
  $field = $mdb->documents($collection)->document($documentId)->field($field);
  $field->updateFieldName("new-field-name");
  
```
#### $field->delete()
```php
  $mdb = new mdb();
  $field = $mdb->documents($collection)->document($documentId)->field($field);
  $field->delete();
  
```
#### $field->subcollection()
insert a field into the document that represent a subcollection.
```php
  $mdb = new mdb();
  $field = $mdb->documents($collection)->document($documentId)->field($field);
  $subcollection = $field->subcollection()->push($id, $arrayData);
  
```