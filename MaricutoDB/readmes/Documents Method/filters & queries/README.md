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

`<` less than <br>
`<=` less than or equal to <br>
`==` same as <br>
`>`  greater than <br>
`==` equal to <br>
`===` equal to (comparing value and type) <br>
`! =` not equal to <br>
`in` contains the string in field <br>
`not-in` not contains the string in field <br>

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