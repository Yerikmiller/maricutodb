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