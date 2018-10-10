<?php 

# This one require the database too.
# see header file.
require 'src/header.php'; 

?>
<body>
	<article class="grid article-full">
		<div class="col_12 article-full article-center">
			<br><br>
			<h1 class="title has-text-info josefin normal">Shorten your links and store them in a Flat file Database</h1>
			<br>
			<h2 class="subtitle has-text-primary josefin lighter">MaricutoDB Manager</h2>
			<p>This is an example made by <a href="http://maricuto.xyz/maricutodb">MaricutoDB</a></p>
		</div>
		<div class="col_12"><hr></div>
		<section class="col_6 offset-3 offset-3-r article-center">
			<h3 class="subtitle josefin normal">Search Engine</h3>
			<form action="searching.php" method="GET">
				<input class="input is-rounded is-success is-medium" type="text" name="query" placeholder="search something shortened">
			</form>
		</section>
		<div class="col_12"><hr></div>
		<section class="col_8 offset-2 offset-2-r article-center">
			<br>
			<?php 
			# Here is the code to create new shorten links
			require 'shorten.php'; 
			?>

		</section>
		<div class="col_12"><hr></div>
		<section class="col_10 offset-1 offset-1-r article-center">
			<h2 class="subtitle has-text-info">List of shortened links</h2>
			<?php  
			# Here is the code to output all links created
			# Here is the code to paginate the data too.
			require 'list-of-links.php';

			?>
		</section>
	</article>
</body>
<?php require 'src/footer.php'; ?>
</html>