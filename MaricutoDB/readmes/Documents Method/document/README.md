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

#### (in document) $mdb->documents->document->create()
```php
  # $mdb->documents($collection)->document($documentId)->create($data);
  
  $mdb = new mdb();
  $mdb->documents("users")->document("user_2")->update([
    "name" => "Jazmin"
  ]);
```

#### (in document) $mdb->documents->document->update()
```php
  # $mdb->documents($collection)->document($documentId)->update($data);
  # or:  $mdb->documents($collection)->document($documentId)->push($data);
  
  $mdb = new mdb();
  $mdb->documents("users")->document("user_3")->update([
    "name" => "Julia"
  ]);
```
#### (in document) $mdb->documents->document->updateId()
Update the id of the document
```php
  # $mdb->documents($collection)->document($documentId)->updateId($id);
  
  $mdb = new mdb();
  $mdb->documents("users")->document("user_3")->updateId("user_7");
```

#### (in document) $mdb->documents->document->delete()
it will remove or delete the document.
```php
  # $mdb->documents($collection)->document($documentId)->delete();
  
  $mdb = new mdb();
  $mdb->documents("users")->document("user_3")->delete();
```

#### (in document) $mdb->documents->document->field()
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