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