<script>
$(document).ready(function(){
	  var btns = document.querySelectorAll('button');
	  var clipboard = new ClipboardJS(btns);
	  clipboard.on('copied', function(e) {
	      console.log(e);
	  });
	  clipboard.on('error', function(e) {
	      console.log(e);
	  });
 });
</script>