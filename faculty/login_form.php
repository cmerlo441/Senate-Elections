<?php

$no_header = 1;
require_once( '../_header.inc' );

?>
      <div class="container" id="not_logged_in">
          <h2 class="form-signin-heading">Faculty Login</h2>
          <input id="u" type="text" class="input-block-level" placeholder="Banner ID">
          <input id="p" type="password" class="input-block-level" placeholder="Password">
          <button class="btn btn-large btn-primary" id="login">Sign in</button>
      </div>  <!-- div.container -->
      
      <script type="text/javascript">
          $('document').ready(function(){
          	  $('button#login').click(function(){
          	  	  var u = $('input#u').val();
          	  	  var p = $('input#p').val();
          	  	  $.post('validate_login.php',
          	  	  	  { u: u, p: p },
          	  	  	  function(data){
          	  	  	  	  if( data == 1 ) {
          	  	  	  	      $.post('faculty_index.php',
          	  	  	  	      	  function(data){
          	  	  	  	      	  	  // Set a cookie and stuff
          	  	  	  	      	  	  $('div#the_page').html(data);
          	  	  	  	      	  }
          	  	  	  	      )
          	  	  	  	  }
          	  	  	  }
          	  	  )
          	  })
          })
      </script>

