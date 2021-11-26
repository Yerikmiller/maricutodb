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


### $mdb->documents->document()

You can access to a single file with the document method

```php
  # $document = $mdb->documents($collection)->document($documentId)
  $mdb = new mdb();
  
  # to return object:
  $document = $mdb->documents("users")->document("user_1")->render();

```
From here now you can access to these methods:
`create`,
`update`,
`field`
& `delete`.

#### (in document) $mdb->documents->document->create()
```php
  # $mdb->documents($collection)->document($documentId)->create($data);
  
  $mdb = new mdb();
  $mdb->documents("users")->document("user_2")->update([
    "name" => "Jazmin"
  ]);
```

#### (in document) $mdb->documents->document->update()
```php
  # $mdb->documents($collection)->document($documentId)->update($data);
  # or:  $mdb->documents($collection)->document($documentId)->push($data);
  
  $mdb = new mdb();
  $mdb->documents("users")->document("user_3")->update([
    "name" => "Julia"
  ]);
```
#### (in document) $mdb->documents->document->updateId()
Update the id of the document
```php
  # $mdb->documents($collection)->document($documentId)->updateId($id);
  
  $mdb = new mdb();
  $mdb->documents("users")->document("user_3")->updateId("user_7");
```

#### (in document) $mdb->documents->document->delete()
it will remove or delete the document.
```php
  # $mdb->documents($collection)->document($documentId)->delete();
  
  $mdb = new mdb();
  $mdb->documents("users")->document("user_3")->delete();
```

#### (in document) $mdb->documents->document->field()
it allow you to access methods for a certain field in a document.
Methods allowed after instance a field method:
`update,`
`show,`
`delete,`
`updateFieldName,`
`subcollection`

```php
  # $mdb->documents($collection)->document($documentId)->field($field);
  
  $mdb = new mdb();
  $field = $mdb->documents("users")->document("user_1")->field("name");
```