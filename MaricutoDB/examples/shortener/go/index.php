<?php 


# init database.
require_once dirname(__DIR__).'/MaricutoDB/init.php';
$ACTUAL_LINK = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
# the $_GET['url'] variable it's the IDFROMTABLE after go action.
# that is possible to the .htaccess in "go folder"
# 


if(isset($_GET['url'])){

	$id = $_GET['url'];
	// search the table id into the database
	$Get = Database::Table('shorten_links', $id );

	# if the table don't exist
	if ( $Get == FALSE )
	{
		header('HTTP/1.1 404 Not Found');
		echo "Error 404. this links don't exist.";
		exit();
	} else{
		# if there is an existing table in the database
		// Permanent 301 redirection
	    header("HTTP/1.1 301 Moved Permanently");
	    header('Location: ' . $Get->original_link );
	    exit();
	}
} else
{
	# if is not set $_GET['url']
	# redirect to previus page (main)
	header('Location: http://'.dirname($ACTUAL_LINK));
	exit();
}

?>