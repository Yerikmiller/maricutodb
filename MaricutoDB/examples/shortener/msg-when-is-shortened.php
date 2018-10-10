<?php

$shortened_link = $ACTUAL_LINK.'go/'.$Get->__id__;

?>

<div class="col_12">
	<h6 class="article-center josefin bold has-text-warning is-size-4">
		This is your shortened link:
	</h6>
	<div class="col_9">
		<p class="josefin normal is-size-5 has-text-primary">
			<?= $ACTUAL_LINK.'go/'.$Get->__id__; ?>
		</p>
	</div>
	<div class="col_3">
		<!-- see "layout-each-item.php" to see how work "data-clipboard-text" -->
		<button class="col_12 button is-radiusless is-info 9 is-size-7 copy" data-clipboard-text="<?= $shortened_link; ?>">
			Copy
		</button>
	</div>
</div>
