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

# METHODS

### Single Documents Method

The single file method contains all possible methods to create JSON files with data and which in turn can be passed sub-collections within their fields. Uses the same mechanism used by the previous version of MDB. You will be able to save approximately 50.000 documents/files without overloading the server.

<a href="https://github.com/Yerikmiller/maricutodb/tree/master/MaricutoDB/readmes/Documents%20Method">Single Documents - Documentation</a>

### Collections chunks method

This method saves a collection structure within files by parts, that is, it saves "documents" in a group of JSON files divided and which is managed by metadata. This method is for higher data volumes, you will be able to save approximately 300,000-500,000 documents without overloading the server, although if each document (array) created weighs a few KB and you establish a maximum number of parts or "documents" per file, higher than 1000, this limit can be extended to 1,500,000

<a href="https://github.com/Yerikmiller/maricutodb/tree/master/MaricutoDB/readmes/Chunk%20Collections%20Method">Collections chunks - Documentation</a>