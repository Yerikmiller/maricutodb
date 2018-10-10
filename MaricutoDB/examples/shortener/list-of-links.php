<?php

# Paginator Options
#########################
$sortby = "new";
$Pagination = TRUE;
$PaginatorName = "links";
$GLOBALS['PerPage'] = "10";
$NextText = "Next";
$PreviusText = "Previus";
$NavigationNumbers = "7";
#########################

# Get the tables from "shorten_links" database name.
#######################
$GetData = Database::GetData( 'shorten_links' );
# Sorting New To Old
$GetData = Generate::SortingFiles( $GetData, 'new' );
#######################

# Excute the paginator
# Just copy and page
#######################
$GLOBALS['CountData'] = count($GetData);
$limit     = Database::SliceData( $GLOBALS['PerPage'], $GLOBALS['CountData'] );
$Paginator = Generate::Paginator( $PaginatorName );
$GetData   = Database::Paginate( $GetData, $GLOBALS['PerPage'], $limit, $Paginator  );
#######################

# write how you want to show the data

# let's make the foreach sentence in a section HTML tag 
echo '<section class="col_12">'; 
#######################
foreach ($GetData as $GetData) 
{
	# Ouput the data for each table
	$GetData = Database::Output($GetData);
	# the visual link that will be print (only the firsts 45 characters)
	$link_text = substr($GetData->original_link, 0, 45);
	# link to the <a> "href attr"
	$original_link = $GetData->original_link; 

	# extract table id
	$table_id = $GetData->__id__;

	# for each table from database apply this layout
	include 'layout-each-item.php';
}
#######################
echo '</section>';


?>

<!-- paginator buttons -->


<div class="col_12">
	<?php
	# output paginator buttons
		Write::PaginatorButtons( $limit, $PaginatorName, $NavigationNumbers, $Paginator, $PreviusText, $NextText );
	?>
</div>


<!-- 

you can add style to the buttons adding style to .MDBNumbers, .MDBCurrent and .MDBButtons (next and previus)

In this case i'll add to them, some class from "bulma css framework"... with jquery.

-->

<script>
	$(document).ready(function(){
		$('.MDBNumbers, .MDBButtons').addClass('button is-radiusless');
		$('.MDBCurrent').addClass('is-info is-radiusless');
	});
</script>