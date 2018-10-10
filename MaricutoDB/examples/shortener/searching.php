<?php
# This one require the database too.
# see header file.
require 'src/header.php'; 
########
$GetData   = Database::GetData('shorten_links'); 
$GetData   = Generate::SortingFiles( $GetData, 'new' );
########
?>


<body>
  <article class="grid article-full">
    <div class="col_12 article-full article-center">
      <br><br>
      <h1 class="title has-text-info josefin normal">Search shortened links</h1>
      <br>
      <h2 class="subtitle has-text-primary josefin lighter">MaricutoDB Manager</h2>
      <p>This is an example made by <a href="http://maricuto.xyz/maricutodb">MaricutoDB</a></p>
    </div>
    <div class="col_6 offset-3 offset-3-r article-center">
      <form action="" method="GET">
        <input class="input is-rounded is-success is-medium" type="text" name="query" placeholder="search something shortened">
      </form>
    </div>
    <div class="col_12"><hr></div>
    <section class="col_10 offset-1 offset-1-r article-center">
      <h2 class="subtitle has-text-info">Results</h2>
      <?php  

      # if there are queries through html-search-input show data...
      if ( isset($_GET['query']) )
      {
          # written words by user convert as array to search in the DB
          #########################
          $QueryArray = Generate::query( $_GET['query'] );
          #########################
          $error = 'Nothing found. Please use another words.';
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

        # the visual link that will be print (only the firsts 45 characters)
        $link_text = substr($Get->original_link, 0, 45);
        # link for "<a>" HTML tag
        $original_link = $Get->original_link;

        # extract table id
        $table_id = $Get->__id__;

        # for each table from database apply this layout
        include 'layout-each-item.php';
              }
          }
          if ( $error !== FALSE )
          {
            # if there are not coicidences show error.
            echo $error;
          }
      }
      else
      {
        # if is not set "$_GET['query']"
        echo '<h6 class="article-center josefin normal">Type something above and search</h6>';
      }

      ?>
    </section>
  </article>
</body>
<?php require 'src/footer.php'; ?>
</html>