<?php

$title_stub = 'Faculty Home';
require_once( '../_header.inc' );

if( $_SESSION[ 'faculty' ] > 0 ) {
    // foo
} else {
?>
      <div class="container" id="not_logged_in">
        <form class="form-signin">
          <h2 class="form-signin-heading">Faculty Login</h2>
          <input type="text" class="input-block-level" placeholder="Banner ID">
          <input type="password" class="input-block-level" placeholder="Password">
          <label class="checkbox">
            <input type="checkbox" value="remember-me"> Remember me
          </label>
          <button class="btn btn-large btn-primary" type="submit">Sign in</button>
        </form>
      </div>  <!-- div.container -->
<?php
}

require_once( '../_footer.inc' );
?>
