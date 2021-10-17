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