### subcollections | $documents->document->field->subcollection()
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

Create sub-collections of data within a document field.
#### $field->subcollection->push()
insert a field into the document that represent a subcollection.
the subcollection_field will be the name of the field where you want to store the data.
```php
  $mdb = new mdb();
  $field = $mdb->documents($collection)->document($documentId)->field($field);
  $subcollection = $field->subcollection($subcollection_field)->push($id, $arrayData);
  
```
#### $field->subcollection->show()
get the data stored in the subcollection field name.
```php
  $mdb = new mdb();
  $field = $mdb->documents($collection)->document($documentId)->field($field);
  $subcollection = $field->subcollection($subcollection_field)->show();
  
  # you cans set an id to get a certain element
  $subcollection = $field->subcollection($subcollection_field)->show($id);
  
```
#### $field->subcollection->delete()
```php
  $mdb = new mdb();
  $field = $mdb->documents($collection)->document($documentId)->field($field);
  
  # $id will represent the element you want to remove inside a subcollection.
  $subcollection = $field->subcollection($subcollection_field)->delete($id)
  
```