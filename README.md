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
- Backup and restore collections
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

METHODS

Single Documents Method
The single file method contains all possible methods to create JSON files with data and which in turn can be passed sub-collections within their fields. Uses the same mechanism used by the previous version of MDB. You will be able to save approximately 50.000 documents/files without overloading the server.

Collections chunks method
This method saves a collection structure within files by parts, that is, it saves "documents" in a group of JSON files divided and which is managed by metadata. This method is for higher data volumes, you will be able to save approximately 300,000-500,000 documents without overloading the server, although if each document (array) created weighs a few KB and you establish a maximum number of parts or "documents" per file, higher than 1000, this limit can be extended to 1,500,000

1) <a href="https://github.com/Yerikmiller/maricutodb/tree/master/MaricutoDB/readmes/Documents%20Method">Single Documents - Documentation</a>
2) <a href="https://github.com/Yerikmiller/maricutodb/tree/master/MaricutoDB/readmes/Chunk%20Collections%20Method">Collections chunks - Documentation</a>

###  - <a href="https://github.com/Yerikmiller/maricutodb/tree/master/MaricutoDB/readmes">Documentation</a>


License
---------------------
This project is licensed under the MIT License.
https://github.com/Yerikmiller/maricutodb/blob/master/LICENSE

About Author: https://maricuto.website
