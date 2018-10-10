<div class="col_8 has-text-left">
	<a class="josefin normal has-text-info" target="_blank" href="<?= $original_link; ?>">
		<?= $link_text; ?> ...
	</a>
</div>

<!-- 
	# you will need to create a "copy button" to make easy to "share links"

	To copy links, you need to use "clipboard.js" making this task easy. 
	# go to the header and see the linked "clipboard.min.js".
	# go to the footer see the clipboard initialization.

	we need to build the "shortened link" just like this:
	$ACTUAL_LINK.'/go/' . $table_id

	# $ACTUAL_LINK can be found in "header.php"
	# it output the actual link.

	let's create it!
-->

<?php

$shortened_link = $ACTUAL_LINK.'go/'.$table_id;

# $shortened_link place into the data-clipboard-text 'attr' "copy shortened" <button> tag

# output: http://example.com/go/IDFromDatabase

?>

<!-- 
	For original link only set the data-clipboard-text 'attr' with 
	$original_link variable
-->



<button class="col_2 button is-radiusless is-info 9 is-size-7 copy" data-clipboard-text="<?= $shortened_link; ?>">
	Copy Shortened
</button>
<button class="col_2 button is-radiusless is-primary 9 is-size-7 copy" data-clipboard-text="<?= $original_link; ?>">
	Copy Original
</button>
<hr>