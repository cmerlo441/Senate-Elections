<?php

$title_stub = 'Faculty Home';
require_once( '../_header.inc' );

print "<div id=\"the_page\">\n";

if( $_SESSION[ 'faculty' ] > 0 ) {
?>
      <script type="text/javascript">
	  	  $.post('faculty_index.php',
	  	  	  function(data){
	  	  	  	$('div#the_page').html(data);
	  	  	  }
	  	  )
      </script>
<?php
} else {
?>
      <script type="text/javascript">
	  	  $.post('login_form.php',
	  	  	  function(data){
	  	  	  	$('div#the_page').html(data);
	  	  	  }
	  	  )
      </script>
<?php
}

require_once( '../_footer.inc' );
?>
