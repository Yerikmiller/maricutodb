### subcollections | $documents->document->field->subcollection()

Create sub-collections of data within a document field.
#### $field->subcollection->push()
insert a field into the document that represent a subcollection.
the subcollection_field will be the name of the field where you want to store the data.
```php
  $mdb = new mdb();
  $field = $mdb->documents($collection)->document($documentId)->field($field);
  $subcollection = $field->subcollection($subcollection_field)->push($id, $arrayData);
  
```
#### $field->subcollection->show()
get the data stored in the subcollection field name.
```php
  $mdb = new mdb();
  $field = $mdb->documents($collection)->document($documentId)->field($field);
  $subcollection = $field->subcollection($subcollection_field)->show();
  
  # you cans set an id to get a certain element
  $subcollection = $field->subcollection($subcollection_field)->show($id);
  
```
#### $field->subcollection->delete()
```php
  $mdb = new mdb();
  $field = $mdb->documents($collection)->document($documentId)->field($field);
  
  # $id will represent the element you want to remove inside a subcollection.
  $subcollection = $field->subcollection($subcollection_field)->delete($id)
  
```