### FIELD METHODS
Once you access to a field you can use the following methods:

#### $field->update()
```php
  $mdb = new mdb();
  $field = $mdb->documents($collection)->document($documentId)->field($field);
  $field->update([
   "lastname" => "Sat"
  ])
  
```
#### $field->show()
```php
  $mdb = new mdb();
  $field = $mdb->documents($collection)->document($documentId)->field($field);
  echo $field->show();
  
```
#### $field->updateFieldName()
It will update the field name selected.
```php
  $mdb = new mdb();
  $field = $mdb->documents($collection)->document($documentId)->field($field);
  $field->updateFieldName("new-field-name");
  
```
#### $field->delete()
```php
  $mdb = new mdb();
  $field = $mdb->documents($collection)->document($documentId)->field($field);
  $field->delete();
  
```
#### $field->subcollection()
insert a field into the document that represent a subcollection.
```php
  $mdb = new mdb();
  $field = $mdb->documents($collection)->document($documentId)->field($field);
  $subcollection = $field->subcollection()->push($id, $arrayData);
  
```