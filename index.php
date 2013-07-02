<?php

$home = 1;
require_once( './_header.inc' );
?>
      <!-- Jumbotron -->
      <div class="jumbotron visible-desktop">
        <h1>Academic Senate Elections</h1>
        <p class="lead">Welcome to the Nassau Community College Academic Senate Election Server.  Please log in to get started with nominating and voting.</p>
        <!-- <a class="btn btn-large btn-success" href="#">Get started today</a> -->
      </div>
      <div class="well text-center hidden-desktop">
        <h1>Academic Senate Elections</h1>
        <p class="lead">Welcome to the Nassau Community College Academic Senate Election Server.  Please log in to get started with nominating and voting.</p>
        <!-- <a class="btn btn-large btn-success" href="#">Get started today</a> -->
      </div>

      <!-- Example row of columns -->
      <div class="row-fluid visible-desktop">
        <div class="span4 offset2 text-right">
          <h2>Faculty</h2>
          <p>Log in here to vote, choose to run in an election, or sign someone's nominating petition.</p>
          <p><a class="btn btn-primary" href="<?php echo $docroot;?>/faculty/">Log In As Faculty &raquo;</a></p>
        </div>
        <div class="span4">
          <h2>Behind The Scenes</h2>
          <p>If you help manage the elections, use the button below to log in.</p>
          <p><a class="btn btn-danger" href="admin">Log In As Administrator &raquo;</a></p>
        </div>
      </div>
      <div class="row-fluid hidden-desktop">
        <div class="span6 text-center">
          <h2>Faculty</h2>
          <p>Log in here to vote, choose to run in an election, or sign someone's nominating petition.</p>
          <p><a class="btn btn-primary" href="<?php echo $docroot;?>/faculty/">Log In As Faculty &raquo;</a></p>
        </div>
        <div class="span6 text-center">
          <h2>Behind The Scenes</h2>
          <p>If you help manage the elections, use the button below to log in.</p>
          <p><a class="btn btn-danger" href="admin">Log In As Administrator &raquo;</a></p>
        </div>
      </div>

<?php
require_once( './_footer.inc' );
?>
