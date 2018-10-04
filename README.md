
<h1 align="center" class="vicinity rich-diff-level-zero">
  MaricutoDB | PHP Flat File Database Manager.
</h1>




<p align="center">
  <img src="http://maricuto.xyz/default/public/html_base/img/maricutodb/logo.svg" title="MaricutoDB php flat file database manager" style="width: 200px" alt="MaricutoDB php flat file database manager">
</p>

<p align="center">
  <img src="https://img.shields.io/badge/contributor-Yorman%20Maricuto-blue.svg?longCache=true&style=flat-square" alt=" ">
  <img src="https://img.shields.io/badge/Files-JSON-green.svg?longCache=true&style=flat-square" alt=" ">
  <img src="https://img.shields.io/badge/System-CRUD-blue.svg?longCache=true&style=flat-square" alt=" ">
  <img src="https://img.shields.io/badge/Security-password__hash-blue.svg?longCache=true&style=flat-square" alt=" ">
  <img src="https://img.shields.io/badge/has-paginator%20system-orange.svg?longCache=true&style=flat-square" alt=" ">
  <img src="https://img.shields.io/badge/has-search--engine-orange.svg?longCache=true&style=flat-square" alt=" ">
</p>

<p align="center">
  Copyright (c) | Yorman Maricuto 2018 | 
  <a href="mailto:yerikmiller@gmail.com">
    Yerikmiller@gmail.com
  </a>
  <br>
  <a href="http://maricuto.xyz">author website of the project</a>
</p>

Table of contents
---------------------

1) <a href="#getting-started">Getting Started</a><br>
2) <a href="#maricutodb--features">Features</a><br>
3) <a href="#how-to-use">How to use | create data</a><br>
4) <a href="#insert-more-data-in-a-created-table">Insert data</a><br>
5) <a href="#getting-created-data">Getting created data</a><br>
6) <a href="#getting-a-common-item-from-many-tables">Getting a common item from many tables</a><br>
8) <a href="#getting-an-unknow-item-id">Getting a unknown table id</a><br>
9) <a href="#verifying-data-and-passwords">Verifying data and passwords</a><br>
10) <a href="#paginator">Paginator</a><br>
11) <a href="#search-engine">Search Engine</a><br>
12) <a href="#update-database">Update Database</a><br>
13) <a href="#backups">Backups</a><br>
14) <a href="#delete-data">Delete data</a><br>
15) <a href="#restore-a-backup">Restore a backup</a><br>
16) <a href="#license">License</a><br>

MaricutoDB it's a lightweight database manager with flexibility and easy to use. allow create, read, update and delete: database, tables, columns and rows that are saved as JSON files *(CRUD)*.

Getting Started
---------------------
To start using the Database only require:
```php
  require_once "init.php"; # in MaricutoDB folder
```
You can download the latest and clean version here:
> http://maricuto.xyz/maricutodb

MaricutoDB | Features
---------------------
*Create a Database Easily.*

- Have a strong system security for stored passwords.
- It is hard to overload the server with *MaricutoDB*.
- Read the databases dinamically and with flexibility.
- Update Content Easily: DB, Tables, Rows (ItemNames) and Colums (ItemContent).
- Update passwords Easily.
- Verify data in login panel as passwords and usernames.
- Sort the data from new to old and old to new.
- Make backups of your DBs.
- Have a paginator system to load tables dinamically.
- Can Delete Database with BackUp System.

New Feataures | added at 2018/09/30
---------------------
Now MaricutoDB has a simple search engine. 

> *This can overload the server if there are many tables*

*The paginator function eliminate the reading of all files to get contents* and only read that will appear per page. This make MaricutoDB a good database manager for many projects like blogs, portfolios, gallery images webpage and more.


## How to use
---------------------

### Creating a Database
You only need one line to create a database and insert data to it, setting four variables.


<strong>MaricutoDB::Create( $db_name, $table_id, $item_name, $item_content );</strong>

This method can create new data but it's not to update content tables.

| Variable      |  description |
|---------------|--------------|
| $db_name      | to create **DB** or if exist point to it. |
| $table_id     | to create an **table_id** or if exist point to it. |
| $item_name    | to create a item name in the **table** named above. |
| $item_content | insert content in the named **item name** above. |


```php  
  # Let's create a table with a user data, in a DB called 'UsersDB'
  MaricutoDB::Create('UsersDB', 'user_n_1', 'name', 'Yorman');  
```

### Insert more data in a created table 
you can add more data to the same table, you only need to be secure to point to the same ID. in this case (above) 'user_n_1' and in the same DB ('UsersDB').

```php
  # let's add a lastname to our firts user:
  MaricutoDB::Create('UsersDB', 'user_n_1', 'lastname', 'Maricuto');
  
  # Now let's add a NickName
  MaricutoDB::Create('UsersDB', 'user_n_1', 'nick', 'yerikmiller');
```
### Insert and secured passwords
To make it, you only need to **set a fifth argument to TRUE**

```php
  # let's add a password
  # MaricutoDB encrypt passwords with "password_hash()"
  MaricutoDB::Create('UsersDB', 'user_n_1', 'password', 'mypass1234', TRUE);
  
  # this is the most recently method for PHP to encrypt passwords.
```
Getting created data
---------------------
To simply get a table and show an item of it, just use:

**$Get = Database::Table( $db_name, $table_id );**

| Variable      |  description |
|---------------|--------------|
| $db_name      | a existing or created Database name to point |
| $table_id     | an existing table in the named database above. |

```php
	
	$Get = Database::Table('UsersDB', 'user_n_1');

  # At this point the '$Get' variable will give us a StdClass Object with the content created. We can show each one like this:

  echo 'This is my name: '.$Get->name.'<br>';
  echo 'This is my lastname: '.$Get->lastname.'<br>';

  # You can add whatever layout you want and insert data to it.

```

## Getting a common item from many tables
---------------------
This function can be useful when we try to get a common item from each DB table. If we have something like 10 products in a DB called **'books'**, each book represent a **_Database Table_** and we can get the **data tables** without calling one by one and without knowledge of each **id table**.


**This method only need one argument, the _ db_name _.**

**$GetData = Database::GetData( $existing_db_name );**

```php
  # in the example/list-books.php

  # example: if we have a DB called books
  # you can get all tables just like this:
  $GetData = Database::GetData( 'books' );

  # Now we need to Sorting the data.
  # There are two options 'new' and 'old'
  # The firts argument it's the $GetData variable above
  $GetData = Generate::SortingFiles( $GetData, 'new' );

```

Now you can give a layout and style to all data that we are getting from the DB

> **The *Database* will give us a **stdClass Object** so, we need to make a foreach to output the data**

for each cell we need to use the method _Generate::Row( $GetData, $ItemName, $error = 'N/A' );_ to create new data into a row.

| Variable      |  description |
|---------------|--------------|
| $GetData      | the variable we have obtained with the method GetData above |
| $ItemName     | an existing ItemName in the table. |
| $error        | if the item name don't exists the method will output "N/A" by default you can set whatever string you want |

**_Generate::Row_ method will works like the **$GetData->ItemName** to show specific items. But this method can verify and ouput personalized errors if the item don't exist.**

```html
  <!-- 
  in the example/list-books.php

  Let's make a HTML table.
  each tr will make a new row.
  each td will make a new cell data.

   -->
  <table>
    <thead>
      <th>Book</th>
      <th>Author</th>
    </thead>
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

If we have a Database with three books and their authors the code above will ouput:

|     Book      |    Author     |
| ------------- | ------------- |
| The Breathing Method  | Stephen King  |
| Hickory Dickory Dock  | Agatha Christie |
| The Hound of the Baskervilles  | Conan Doyle |


## Getting an unknow item id
---------------------
MaricutoDB has the method to generate 'RandomString' and use it like a **RANDOMID** to create tables. This is to make the table creations easily, also we don't need to know the *TABLE ID* to get Data.

**$RandomString = Generate::RandomString();**

Let's create a **database table** with a random id.

```php

# This will output a unique random ID for our next table to create
$RandomString = Generate::RandomString();

# Create the table
MaricutoDB::Create( 'UsersDB', $RandomString, 'nick', 'carlos_medina1995' );
MaricutoDB::Create( 'UsersDB', $RandomString, 'name', 'Carlos' );
MaricutoDB::Create( 'UsersDB', $RandomString, 'lastname', 'Medina' );
MaricutoDB::Create( 'UsersDB', $RandomString, 'password', 'medinacarlos-1234', TRUE );

```

### Getting the random ID

The code above will create a new table into the database called 'UsersDB' with a random id. We can get the id from another known unique data like a nickname (username), using the *OutputId* method.

**$id = Database::OutputId( $db_name, $item_name, $content );**


| Variable      |  description |
|---------------|--------------|
| $db_name      | An existing **DB** |
| $ItemName     | an existing **ItemName** in each table. |
| $content      | **a unique content** like username, nickname, ID, or something like that |

```php

# This will output the unknown table id generated above.
$id = Database::OutputId( "UsersDB", "nick", "carlos_medina1995" );

# Now we can use the id to get the table data.

$Get = Database::Table('UsersDB', $id);
echo 'This is my name: '.$Get->name.'<br>';

// this will print 'Carlos' because that was the name created above.

```

## Verifying data and passwords
---------------------
If we have a panel to login and we need to verify the data that a user send through form with method *POST*. MaricutoDB has a method for it. First we need to make a PHP code that will be excuted only when users submit a form.


```php
# in: http://example.com/login/panel

// $_POST["UserLogin"] is the input name for the username
// $_POST["PassLogin"] is the input name for the password


if ( isset( $_POST['UserLogin']) && isset( $_POST['PassLogin']) )
{
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


    # Now Using the next method we can get a FALSE if the user and pass don't match and TRUE if they match
    $Login = Database::Login( $User, $Pass );
    if ( $Login == TRUE )
    {
      # Start a Session 
      session_start();

      # Getting the table from the user when all it's correct
      $Get = Database::Table( "UsersDB", $id );
      # Creating a SessionID
      $_SESSION["SessionUserID"] = md5( $id );
    }
  }
# executing function
Login( $id, $User, $Pass );
} # close the "if" sentence. 

```

## Paginator
---------------------
MaricutoDB has a simple paginator to slice data by pages:

```php
# Options
#########################
$Pagination = TRUE;         # Set for Start the pagination
$sortby = "new";            # sortby new or old
$PaginatorName = "page";    # a simple name
$GLOBALS['PerPage'] = "10"; # Items for each page 
$NextText = "Next";         # text for next button
$PreviusText = "Previus";   # text for previues button
$NavigationNumbers = "5";   # Total of itemNumbers to appear
#########################

# Get paths from a DB
#######################
$GetData = Database::GetData('UsersDB'); # Write the DB you want to parse his data
$GetData = Generate::SortingFiles( $GetData, 'new' );
#######################

# Execute the paginator
# Just copy and page this
#######################
$GLOBALS['CountData'] = count($GetData);
$limit     = Database::SliceData( $GLOBALS['PerPage'], $GLOBALS['CountData'] );
$Paginator = Generate::Paginator( $PaginatorName );
$GetData   = Database::Paginate( $GetData, $GLOBALS['PerPage'], $limit, $Paginator  );
#######################


# at this point MaricutoDB will show and parse only 10 tables ( see $GLOBALS['PerPage'] )
# the foreach will process only ten JSON files.
echo '<h6>name</h6>';
foreach ($GetData as $GetData) 
{
  # at this point MaricutoDB will work like i explained before
  $GetData = Database::Output($GetData);
  $Output  = Generate::Row($GetData, 'name', 'unknown').'<br>';
  echo $Output;
}

# If the number of tables from a DB is less than '$GLOBALS['PerPage']'
# the PaginatorButtons will not appear.



# This will build the navigation buttons -> ( Previus 1 2 3 .. 10 Next ) etc...
# just copy and paste.
Write::PaginatorButtons( $limit, $PaginatorName, $NavigationNumbers, $Paginator, $PreviusText, $NextText );

```

## Search Engine
---------------------
MaricutoDB has a simple search engine that can be use to search coincidences when a input is submitted to search something. **This can overload the server if we are trying to search in many tables**, also we can search something without overload the system in **3000-6000 tables** about depending on the JSON table file size too.

> This is in development now, but also can be useful.

### How to implement the search engine.
First we need to create a new page called 'searching' or whatever you want, this is the page where MaricutoDB will make the queries and show the results. (www.example.com/searching)

We need to use the Method 'GetData'. Before you need to learn the ways you can use this method. after that you need to select one of them.

**1) If you want to search in all DBs just leave GetData method without setting any variable**

this can be usefull when we have something like a blog, and we have many topics, so if we need to get the database tables to show to the user all posts  from all topics without exclusions use this. 

```php

  # In the searching.php file
  ########
  $GetData   = Database::GetData(); # to search in all DBs
  $GetData   = Generate::SortingFiles( $GetData, 'new' );
  ########
```


**2) If you want to search in a specific DB, set the firts argument to that DB name**

```php

  # In the searching.php file
  ########
  $GetData   = Database::GetData('UsersDB'); # Search in a specific DB
  $GetData   = Generate::SortingFiles( $GetData, 'new' );
  ########
```

**3) If you want to search in two or more DBs set an array into the argument.**

```php

  # In the searching.php file
  ########
  $GetData   = Database::GetData( array('UsersDB', 'AnotherDB') ); # Search in some DBs
  $GetData   = Generate::SortingFiles( $GetData, 'new' );
  ########
```

**4) If you want to search in all DBs but excluding some of them:**

```php
  # In the searching.php file
  ########
  $db_names  = Database::names();
  $db_names  = Database::exclude( $db_names, $exclude = 'one_db, another_db' );
  ########
  $GetData   = Database::GetData( $db_names ); # search in all dbs, excluding some of them.
  $GetData   = Generate::SortingFiles( $GetData, 'new' );
  ########
```


Now we need to show the data with a foreach sentence like above codes when we were trying to show many tables with the method GetData ( [Getting a common item from many tables](https://github.com/Yerikmiller/maricutodb#getting-a-common-item-from-many-tables) ). 

The difference here is that only will appear when a *'$_GET'* variable is set, for example *'$_GET['query']'*. This variable will be set when the user request something in the search engine.

MaricutoDB will search something in each table, if there is a coincidence with the words sent, it will execute with the layout and style that you need to output to the user.


```php
      # this code will need to be in the same .php file, like above.
      # In the searching.php file

      if ( isset($_GET['query']) )
      {
          # written words by user convert as array to search in the DB
          #########################
          $QueryArray = Generate::query( $_GET['query'] );
          #########################
          $error = 'Nothing found.';
          foreach ($GetData as $Get ) 
          {                         
              # Decode and output data json.
              $Get = Database::Output( $Get );
              #########################
              # Searching for coincidences
              foreach ($Get as $search) 
              {
                  $ParseQuerie = Database::SearchingFor( $QueryArray, $search );
                  if ( $ParseQuerie == TRUE ){break;}                  
              }
              if ( $ParseQuerie == TRUE )
              {
                # Error to false and will not show.
                # because they are a coincidence
                $error = FALSE;

                # ParseQuerie is TRUE so, show this.
                # Layout: here you can set your HTML
                echo 'Hi, my name is '.Generate::Row($Get, 'name', $error = 'unknown').'and my Lastname is '.Generate::Row($Get, 'lastname', $error = 'unknown').'<br>';
              }
          }
          if ( $error !== FALSE )
          {
            # if there are not coicidences show error.
            echo $error;
          }
      }
```

Let's create the input form for the search engine. This can be place whatever you want. You need to place where the form will make the searching in the **action attr**, in this case in 'searching' page.

```html

<!-- This can be place where you want the search engine for your users. -->

<form action="http://www.example.com/searching" method="GET">
  <input type="text" name="query" placeholder="Search">
</form>


```

Update Database
---------------------

```php

# To update the DB_NAME
Database::UpdateDBName( "old_db_name", "new_db_name");

# To update the table_name (ID_TABLE)
Database::UpdateTableName( "db_name", "old_table_id", "new_table_id");

# To Update an Item_name
Database::UpdateItemName( "db_name", "table_id", "old_item_name", "new_item_name");

# To Update the content
Database::UpdateContent( "db_name", "table_id", "item_name", "New_Content_Here");


```

Backups
---------------------

Simply use this method:

```php

Backup::DB( "db_name" );

```
Delete data
---------------------

```php

# eliminate DB without backup
DELETE::DB( "db_to_eliminate" );

# eliminate DB with backup
DELETE::DB( "db_to_eliminate", TRUE );

# Eliminate table
DELETE::Table( "db_name", "Table_ID" );

# Eliminate item and his content.
# for example to eliminate a name, address or whatever you want.
DELETE::Item( "db_name","Table_ID","ItemName" );

```
Restore a backup
---------------------
```php

Restore::DB( "db_name" );

```


License
---------------------
This project is licensed under the MIT License.
https://github.com/Yerikmiller/maricutodb/blob/master/LICENSE

Latest Documentation versions visit:
---------------------
http://maricuto.xyz/maricutodb

