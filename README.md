
<h1 align="center" class="vicinity rich-diff-level-zero">
  MDB | PHP Flat File Database Manager
</h1>

<p align="center">
  <img src="https://i.ibb.co/vq8NDxT/mdb.png" title="MaricutoDB php flat file database manager" style="width: 400px" alt="MaricutoDB php flat file database manager">
</p>

<p align="center">
  <img src="https://img.shields.io/badge/contributor-Yorman%20Maricuto-blue.svg?longCache=true&style=flat-square" alt=" ">
  <img src="https://img.shields.io/badge/Files-JSON-green.svg?longCache=true&style=flat-square" alt=" ">
  <img src="https://img.shields.io/badge/System-CRUD-blue.svg?longCache=true&style=flat-square" alt=" ">
  <img src="https://img.shields.io/badge/Security-password__hash-blue.svg?longCache=true&style=flat-square" alt=" ">
  <img src="https://img.shields.io/badge/has-paginator%20system-orange.svg?longCache=true&style=flat-square" alt=" ">
  <img src="https://img.shields.io/badge/has-search--engine-orange.svg?longCache=true&style=flat-square" alt=" ">
</p>

MDB it's a lightweight database manager with flexibility and easy to use. allow create, read, update and delete: database, tables, columns and rows that are saved as JSON files *(CRUD)*. Has two methods to store collections of data: single documents per each item and chunks of JSON with any items you want.

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

MDB | Features
---------------------
*Create a collections of data easily.*

- It's lightweight and hard to overload the system
- can manage up to 200.000 items per collection like users, news, etc...
- Create, Read, Update and delete data easily.
- Don't require any schema for filters or queries
- Dependency Free
- Verify data in login panel as passwords and usernames.
- Sort the data from new to old and old to new.
- Sort the data in a alphabetical and numerical way.
- Paginator and filter system.
- Can Delete Database with BackUp System.
- store passwords with encrypt method
- Backup DBs.

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
cretae data (does not overwrite or write in an existing document).

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

### Filter Documents | $documents->get->all($function)
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


### $mdb->documents->document()

You can access to a single file with the document method

```php
  # $document = $mdb->documents($collection)->document($documentId)
  $mdb = new mdb();
  $document = $mdb->documents("users")->document("user_1");
  
  # From here now you can access to these methods: 
  # subcollection, update, field, delete
```
### $mdb->documents->document->update()
| Variable      |  description |
|---------------|--------------|
| (string) $collection   | an existing reference to a collection |
| (string) $documentId   | document id we'll reference |
| (array) $data   | data you'll insert to the document |

```php
  # $document = $mdb->documents($collection)->document($documentId)
  
  $mdb = new mdb();
  $mdb->documents("users")->document("user_1")->update([
    "name" => "Julia"
  ]);
```

### Get by field | $mdb->documents->get_by()
| Variable      |  description |
|---------------|--------------|
| (string) $collection   | an existing reference to a collection |
| (string) $field   | field that you want to use to get by |
| (string) $match   | string that contains the content you are searching for |

Actually you can use this method (get_by) and the method $documents->get->all($function);

```php
  # $document = $mdb->documents($collection)->get_by($field, $match);
  
  $mdb = new mdb();
  $document = $mdb->documents($collection)->get_by($field, $match);
  
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
MDB has a simple paginator to slice data.

```php
  # $mdb->paginator($users, $options);
  
  $mdb = new mdb();
  
  # let's get all users
  $users = $mdb->documents("users")->get()->all();
  
  # then we can paginate them.
  $results = $mdb->paginator($users, [
    "sortby" => "asc", // or desc
    "field" => "time", // field to take in account to paginate
    "limit" => "50", // max items to paginate
    "position" => "0" // from item
    "searchFor" => FALSE, // Filter by string
    "fromDate" => FALSE, // 17-10-2021 | set a date to paginate from
    "untilDate" => FALSE, // 20-10-2021  | set a date to paginate until
  ]);
  
  // Any old method still working.
```

Update Database
---------------------

```php

# To update the DB_NAME
Database::UpdateDBName( "old_db_name", "new_db_name");

# To update the table_name (ID_TABLE)
Database::UpdateTableName( "db_name", "old_table_id", "new_table_id");

# To Update an Item_name
Database::UpdateItemName( "db_name", "table_id", "old_item_name", "new_item_name");

# To Update the content
Database::UpdateContent( "db_name", "table_id", "item_name", "New_Content_Here");


```

Backups
---------------------

Simply use this method:

```php

Backup::DB( "db_name" );

```
Delete data
---------------------

```php

# eliminate DB without backup
DELETE::DB( "db_to_eliminate" );

# eliminate DB with backup
DELETE::DB( "db_to_eliminate", TRUE );

# Eliminate table
DELETE::Table( "db_name", "Table_ID" );

# Eliminate item and his content.
# for example to eliminate a name, address or whatever you want.
DELETE::Item( "db_name","Table_ID","ItemName" );

```
Restore a backup
---------------------
```php

Restore::DB( "db_name" );

```


License
---------------------
This project is licensed under the MIT License.
https://github.com/Yerikmiller/maricutodb/blob/master/LICENSE

author: https://maricuto.website

