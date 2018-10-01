
MaricutoDB | PHP Flat File Database Manager.
====================
Copyright (c) | Yorman Maricuto 2018 | Yerikmiller@gmail.com

http://maricuto.xyz

MaricutoDB follow the CRUD System: Create, Read, Update and delete: 
database, tables, items and his content... all data will be stored in .JSON files.

Getting Started
---------------------
To start using the Database only require:
```php
  require_once "init.php"; # in MaricutoDB folder
```

MaricutoDB | Features
---------------------
*Create a Database Easily.*

- Have a strong system security for stored passwords.
- It is hard to overload the server with *MaricutoDB*.
- Read the databases dinamically and with flexibility.
- Update Content Easily: DB, Tables, Rows (ItemNames) and Colums (ItemContent).
- Update passwords Easily.
- Verify if a data in login panel is correct, as passwords and usernames.
- Sort the data from new to old and old to new the data.
- Make backups of your DBs.
- Have a paginator system to load tables dinamically.
- Can Delete Database with BackUp System.

New Feataures | added at 2018/09/30
---------------------
Now MaricutoDB have a simple search engine. 

> *This can overload the server if there are many tables*

*The paginator function eliminate the reading "file by file" to get contents*. This make MaricutoDB a good database manager for many projects, like small blogs, portfolios webpage, and more.


## How to use
---------------------

### Creating a Database
You only need one line to create a database, and insert data setting four variables
- $var1 = it's the DB_NAME
- $var2 = it's the TABLE_ID
- $var3 = it's the ITEM_NAME
- $var4 = it's the ITEM_CONTENT

```php
  MaricutoDB::Create($db_name, $table_id, $item_name, $item_content);
  
  # Let's create a table with a user data, in a DB called 'UsersDB'
  MaricutoDB::Create('UsersDB', 'user_n_1', 'name', 'Yorman');  
```

### Insert more data in a created table 
you can add more data to the same user, you only need to be secure to point to the same ID. in this case (above) 'user_n_1' and in the same DB ('UsersDB').

```php
  # let's add a lastname to our firts user:
  MaricutoDB::Create('UsersDB', 'user_n_1', 'lastname', 'Maricuto');
  
  #let's add a NickName
  MaricutoDB::Create('UsersDB', 'user_n_1', 'nick', 'yerikmiller');
```
### Insert and secured a password
To make it you only need to set a fifth argument to TRUE

```php
  # let's add a password
  # MaricutoDB encrypt with "password_hash()"
  MaricutoDB::Create('UsersDB', 'user_n_1', 'password', 'mypass1234', TRUE);
  
  # this is the most recently method for PHP to encrypt passwords.
```
Getting created data
---------------------
To simply get a user with a known ID_TABLE just use:
> $Get = Database::Table( $db_name, $table_id );

```php
	
	$Get = Database::Table('UsersDB', 'user_n_1');

  # At this point the '$Get' variable will give us a StdClass Object with the content created. We can get each one just like this:

  echo 'This is my name: '.$Get->name.'<br>';
  echo 'This is my lastname: '.$Get->lastname.'<br>';
```

## Getting a common item tables
---------------------
This function can be useful when we try to get a common item from each table of a DB. If we have something like 10 products in a DB called *'books'*, each book represent a *Database Table* and we can get all without calling one by one and without knowledge of their *table_id*

> This method only need one argument. it's the database that you need to get a common ITEMNAME from their tables.

```php
  
  # The simple syntax for this method is:
  # using as an example we have a DB called books
  $GetData = Database::GetData( 'books' );

  # Now we need to Sorting the data.
  # There are two options 'new' and 'old'
  # The firts argument it's the $GetData variable above
  $GetData = Generate::SortingFiles( $GetData, 'new' );

# Now you can give a layout and style to all data that we are getting from the DB
# first we need to implement the 'Output' method from the database Class


```
```html
  
  <table>
    <tr>
    <?php
    foreach( $GetData as $GetData )
    {
      # The 'Output' method will open each json.
      $GetData = Database::Output($GetData);

      # layout
       $rows  = '<tr>';
       $rows .= '<td>';
       $rows .= Generate::Row( $GetData, "name_book" ); # it's the same if we use $GetData->name_book
       $rows .= '</td>';
       $rows .= '<td>';
       $rows .= Generate::Row( $GetData, "author" );# it's the same if we use $GetData->author
       $rows .= '</td>';
       $rows .= '</tr>';
       echo   $rows;
    }
    ?>
    </tr>
  </table>


```

If we have a Database with two books and their authors the code above will ouput:

|     Book      |    Author     |
| ------------- | ------------- |
| The Breathing Method  | Stephen King  |
| Hickory Dickory Dock  | Agatha Christie |

The *Generate::Row* method will output the data like '$GetData->book_name' or '$GetData->author'. The difference it is: if a ITEMNAME don't exist the row method will output N/A. 

We can set a last argument in *Generate::Row* to change the default 'N/A' to another string just like this:
```php

Generate::Row( $GetData, "author", 'unknown' );


```

## Getting an unknow ID item
---------------------
MaricutoDB has the method to generate 'RandomString' and use like a ID to create tables. This is to make the table creations easily, also we don't need to know the *TABLE ID* to Get the Data.
> $RandomString = Generate::RandomString();

Let's create a table with a random id.

```php

# This will output a unique random ID for our next table to create
$RandomString = Generate::RandomString();

# Create the table
MaricutoDB::Create( 'UsersDB', $RandomString, 'nick', 'gituser_1' );
MaricutoDB::Create( 'UsersDB', $RandomString, 'name', 'Carlos' );
MaricutoDB::Create( 'UsersDB', $RandomString, 'lastname', 'Medina' );
MaricutoDB::Create( 'UsersDB', $RandomString, 'password', 'medinacarlos-1234', TRUE );

```

The code above will create a new table in 'UsersDB' table with a random id. We can get the id from another known unique data like nickname (username), using the *OutputId* method.
> $id = Database::OutputId( $db_name, $item_name, $content );

```php

# This will output the unknown table id generated above.
$id = Database::OutputId( "UsersDB", "nick", "gituser_1" );

# Now we can use the id to get all the data.

$Get = Database::Table('UsersDB', $id);
echo 'This is my name: '.$Get->name.'<br>';
// this will print 'Carlos' because that was the name ick we was create above.

```

## Veryfing data and passwords
---------------------
If we have a panel to login and we need to verify the data that a user send through form *POST* MaricutoDB has the correct method for it. First we need to make a PHP code that will be excuted only when users submit a form.


```php
// $_POST["UserLogin"] is the input name for the username
// $_POST["PassLogin"] is the input name for the password


if ( isset( $_POST['UserLogin']) && isset( $_POST['PassLogin']) )
{
  // If they both are send verify data:
  $_POST["UserLogin"] = $User;
  $_POST["PassLogin"] = $Pass;

  # First We need to use the OuputId Method to search if a user exist
  $id = Database::OutputId( "UsersDB", "nick", $User );
  # If the user don't exist will ouput FALSE.

  # Now we need to verify if the username and passwords match for the same table ID.
  function Login( $id, $User, $Pass )
  {
    if ( $id == FALSE ){return NULL;}


    # Method to verify Data 
    $User = Database::VerifyData( "UsersDB", $id, "nick", $User );


    # Method to verify encrypted Data (like passwords) 
    $Pass = Database::VerifyEncryptedData( "UsersDB", $id, "password", $Pass );


    # Now Using the method below we can get a FALSE if the user and pass don't match and TRUE if they match
    $Login = Database::Login( $User, $Pass );
    if ( $Login == TRUE )
    {
      # Start a Session 
      session_start();

      # Getting the table from the user when all it's correct
      $Get = Database::Table( "UsersDB", $id );
      # Creating a SessionID
      $_SESSION["SessionUserID"] = md5( $Get->__id__ );
    }
  }
# executing function
Login( $id, $User, $Pass );
} # close the "if" sentence. 

```



License
---------------------
This project is licensed under the MIT License.

# To check the latest Documentation versions visit:

http://maricuto.xyz/maricutodb

