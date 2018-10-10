<!-- HTML input to create new shorten links -->

<div class="col_12">
	<form action="" method="POST">
		<input class="input is-radiusless col_9 is-medium is-success" type="url" name="linktoshorten" placeholder="Link to shorten" required/>
		<input class="button is-success is-radiusless col_3 is-medium" name="ShortenButton" type="submit" value="Shorten" >
	</form>
</div>

<?php
# Here is the code where we will make a shorten link.

# Only if the form have been sent
if ( isset($_POST['ShortenButton']) && isset($_POST['linktoshorten']) )
{
	# search if a link already exist:
	$table_id = Database::OutputId('shorten_links', 'original_link', $_POST['linktoshorten'] );
	# if exist will output the __id__ (string)
	# else output false
	if (  is_string($table_id) )
	# if already exist, show the existing shorten link
	{
		# get the table database of the existing shorten link
		$Get = Database::Table( 'shorten_links' , $table_id );
		# show the link shortened with a message
		require 'msg-when-is-shortened.php';	
	}
	else
	# if don't exist store the link in a new table
	{
		# Generate RandomString
		$RandomString = Generate::RandomString();

		# Now let's create a table id equal to "$RandomString"
		$table_id = $RandomString;

		# let's Create the table in a database called 'shorten_links'
		# if the database name doesn't exist, MaricutoDB will create it automatically.

		# let's create the next content into the mentioned table above:
		# itemName-> "original_link";
		# itemContent-> $_POST['linktoshorten'];

		MaricutoDB::Create( 'shorten_links', $table_id, 'original_link', $_POST['linktoshorten'] );

		# MaricutoDB will create a table with the "id" related to the the shorten link you want to share.
		# and will save his original link in that table note the original_link content variable.
		# MaricutoDB will save automatically the ID.

		# so, when the user try to find a shorten link MaricutoDB will search if a table exist with the requested ID and the user will be redirect to the "original_link".

		# get the table created to show a msg with a button to copy the link
		$Get = Database::Table( 'shorten_links' , $table_id );
		# show the link shortened with a message
		require 'msg-when-is-shortened.php';	
	}
}





?>