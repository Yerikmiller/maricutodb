
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

MDB it's a lightweight database manager with flexibility and easy to use. allow create, read, update and delete: database, tables, columns and rows that are saved as JSON files *(CRUD)*. Has two methods to store collections of data: single documents per each item and chunks of JSON with any items you want.

#### Previus version readme:
**This is a new documentation, MaricutoDB still working well with previus versions**

https://github.com/Yerikmiller/maricutodb/blob/59ce856cab3c2502dcb6800dce3b5f00cbcc1abd/README.md

MDB | Features
---------------------
*Create a collections of data easily.*

- It's lightweight and hard to overload the system
- can manage up to 200.000 items per collection like users, news, etc...
- Create, Read, Update and delete data easily.
- Don't require any schema for filters or queries
- Dependency Free
- Sort the data from new to old and old to new.
- Sort the data in a alphabetical and numerical way.
- easy paginator and filter system.
- store passwords with encrypt method
- Backup DBs.
- single documents method to create single documents with data
- chunk items into files with the collection method.
- create subcollections inside fields.
- delete Database with backup System.

Getting Started
---------------------

To start using the Database only require:
```php
  require_once "init.php"; # in MaricutoDB folder
```

Modify time zone in init.php
Timezone is used to created json files and time fields.

```php
  $GLOBALS['timezone'] = 'America/Caracas'; // change this to whatever you want.
```

New Feataures | added at 2021-10-15
---------------------
- New methods to learn easily.
- Any deprecated method still working.
- Temp files generator to avoid error on editing ('updates' are made it in a temp file first).
- custom filter methods.

## How to use
---------------------

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
### Get Documents | $documents->delete()
Delete a collection of documents
```php
 $mdb = new mdb();
 $mdb->documents("users")->delete()
 
 # this will automatically generate a backup
 # if you want to avoid backup the data pass a FALSE value
 # $mdb->documents("users")->delete(FALSE);
 
 
  // any old method still working.
```

### $mdb->documents->document()

You can access to a single file with the document method

```php
  # $document = $mdb->documents($collection)->document($documentId)
  $mdb = new mdb();
  $document = $mdb->documents("users")->document("user_1");

```
From here now you can access to these methods:
`create`,
`update`,
`field`
& `delete`.

##### (in document) $mdb->documents->document->create()
```php
  # $mdb->documents($collection)->document($documentId)->create($data);
  
  $mdb = new mdb();
  $mdb->documents("users")->document("user_2")->update([
    "name" => "Jazmin"
  ]);
```

##### (in document) $mdb->documents->document->update()
```php
  # $mdb->documents($collection)->document($documentId)->update($data);
  # or:  $mdb->documents($collection)->document($documentId)->push($data);
  
  $mdb = new mdb();
  $mdb->documents("users")->document("user_3")->update([
    "name" => "Julia"
  ]);
```
##### (in document) $mdb->documents->document->updateId()
Update the id of the document
```php
  # $mdb->documents($collection)->document($documentId)->updateId($id);
  
  $mdb = new mdb();
  $mdb->documents("users")->document("user_3")->updateId("user_7");
```

##### (in document) $mdb->documents->document->delete()
it will remove or delete the document.
```php
  # $mdb->documents($collection)->document($documentId)->delete();
  
  $mdb = new mdb();
  $mdb->documents("users")->document("user_3")->delete();
```

##### (in document) $mdb->documents->document->field()
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
###### $field->update()
```php
  $mdb = new mdb();
  $field = $mdb->documents($collection)->document($documentId)->field($field);
  $field->update([
   "lastname" => "Sat"
  ])
  
```
###### $field->show()
```php
  $mdb = new mdb();
  $field = $mdb->documents($collection)->document($documentId)->field($field);
  echo $field->show();
  
```
###### $field->updateFieldName()
It will update the field name selected.
```php
  $mdb = new mdb();
  $field = $mdb->documents($collection)->document($documentId)->field($field);
  $field->updateFieldName("new-field-name");
  
```
###### $field->delete()
```php
  $mdb = new mdb();
  $field = $mdb->documents($collection)->document($documentId)->field($field);
  $field->delete();
  
```
###### $field->subcollection()
insert a field into the document that represent a subcollection.
```php
  $mdb = new mdb();
  $field = $mdb->documents($collection)->document($documentId)->field($field);
  $subcollection = $field->subcollection()->push($id, $arrayData);
  
```
### subcollections | $documents->document->field->subcollection()

Create sub-collections of data within a document field.
###### $field->subcollection->push()
insert a field into the document that represent a subcollection.
the subcollection_field will be the name of the field where you want to store the data.
```php
  $mdb = new mdb();
  $field = $mdb->documents($collection)->document($documentId)->field($field);
  $subcollection = $field->subcollection($subcollection_field)->push($id, $arrayData);
  
```
###### $field->subcollection->show()
get the data stored in the subcollection field name.
```php
  $mdb = new mdb();
  $field = $mdb->documents($collection)->document($documentId)->field($field);
  $subcollection = $field->subcollection($subcollection_field)->show();
  
  # you cans set an id to get a certain element
  $subcollection = $field->subcollection($subcollection_field)->show($id);
  
```
###### $field->subcollection->delete()
```php
  $mdb = new mdb();
  $field = $mdb->documents($collection)->document($documentId)->field($field);
  
  # $id will represent the element you want to remove inside a subcollection.
  $subcollection = $field->subcollection($subcollection_field)->delete($id)
  
```

### Filter Documents | $documents->get->all($function)
#### Custom Filter
You can get data by passing a function in the all() method. This function will allow you to handle the documents one by one and apply the condition to it.

get all documents and pass an optional function to get certain data.
```php
  # @param $filter_function {function} optional
  # $mdb->documents($collection)->get()->all($filter_function);
  $mdb = new mdb();
  
  # @param $document will ouput current document of the iteration.
  $list = $mdb->documents("users")->get()->all(function( $document ){
      if($document->name == "John"){
        return $document;
      }
      return FALSE;
  });
  
  # $list will output an array with all elements that match the condition.
```

### Read data with query-schema | $documents->where()
#### Query-schema based filter.
The where() method uses three parameters: a field to filter, a compare operation, and a value.

```php
  # @param $filter_function {function} optional
  # $mdb->where($value, $operator, $field)
  
  $mdb = new mdb();
  $cars = $mdb->documents("users")->where("john", "in", "name");
  
  // will output any john user.
```

operators for where() method

`<` less than
`<=` less than or equal to
`==` same as
`>`  greater than
`==` equal to
`===` equal to (comparing value and type)
`! =` not equal to
`in` contains the string in field
`not-in` not contains the string in field

### Get by field | $mdb->documents->get_by()
| Variable      |  description |
|---------------|--------------|
| (string) $collection   | an existing reference to a collection |
| (string) $field   | field that you want to use to get by |
| (string) $value   | string that contains the content you are searching for |

Actually you can use this method (get_by) and the method $documents->get->all($function);

```php
  # $document = $mdb->documents($collection)->get_by($field, $value);
  
  $mdb = new mdb();
  $document = $mdb->documents($collection)->get_by($field, $value);
  
  // Deprecated method | any old method still working.
  // Database::OutputId( $db_name, $item_name, $content );
```

### Push Secure Passwords (helper)
```php
  # $document = $mdb->documents($collection)->document($documentId)->update(array $data);
  
  $mdb = new mdb();
  $mdb->documents("users")->document("user_1")->update([
    "password" => $mdb->encrypt("my_password"), // MDB use PHP password_hash to encrypt
  ]);
  
  // Deprecated method | any old method still working.
  // MaricutoDB::Create('UsersDB', 'user_n_1', 'password', 'mypass1234', TRUE);
```

### Verifying passwords
---------------------
If we have a panel to login and we need to verify the data that a user send through form with method *POST*. You can use password_verify to check it

```php
  $mdb = new mdb();
  $user = $mdb->documents($collection)->get_by("email", "john@email.com");
  $password = password_verify($POST["password"], $user->password);
  
  // Any old method still working.
```

### Paginator
---------------------
MDB has a simple paginator to slice data. You can use it with any array you want outside MDB documents.

```php
  # $mdb->paginator($users, $options);
  
  $mdb = new mdb();
  
  # let's get all users
  $users = $mdb->documents("users")->get()->all();
  
  # then we can paginate them.
  $results = $mdb->paginator($users, [
    "objectType" => "OBJECT", # default: OBJECT
    "sortby" => "asc", # or desc | default: 'desc'
    "field" => "time", # field to take in account to paginate | default: 'time'
    "limit" => "2", # max items to paginate
    "position" => "0", # from item
    "searchFor" => FALSE, # Filter by string
    "fromDate" => FALSE, # 17-10-2021 | set a date to paginate from
    "untilDate" => FALSE, # 20-10-2021  | set a date to paginate until
  ]);
  
  # dataType if the type of data you are passing (ARRAY or OBJECT)
  # Actually you can paginate any array or object data you want.
  # if you not define dataType default will be OBJECT.
  
  // Any old method still working.
```


License
---------------------
This project is licensed under the MIT License.
https://github.com/Yerikmiller/maricutodb/blob/master/LICENSE

About Author: https://maricuto.website

