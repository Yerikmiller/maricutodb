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