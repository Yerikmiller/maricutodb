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