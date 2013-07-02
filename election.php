<?php

$title_stub = 'Election for';
require_once( './_header.inc' );

$election_id = $db->real_escape_string( $_REQUEST[ 'election' ] );

$election_query = 'select * from elections '
    . "where id = $election_id";
$election_result = $db->query( $election_query );
$election = $election_result->fetch_object( );
$people = ( $election->winners == 1 ? '1 person' : $election->winners . ' people' );s

// dialog box

?>
    
<?php

// top matter

?>
      <div class="row-fluid">
        <div class="span12">
          <h1><?php echo $election->title; ?> <small>Ends <?php echo date( 'F j, Y', strtotime( $election->end_time ) ); ?></small></h1>
          <p>This election will choose <?php echo $people; ?> for the position of <?php echo $election->title; ?>.</p>          
        </div>
      </div>

<?php

// list of candidates

$candidates_query = 'select f.id, f.first_name as f, f.last_name as l, f.rank, '
    . 'c.bio, d.prefix as prefix, d.name as dept '
    . 'from candidates as c, departments as d, elections as e, faculty as f '
    . "where e.id = $election_id "
    . 'and c.election = e.id '
    . 'and c.candidate = f.id '
    . 'and d.id = f.department '
    . 'order by f.last_name, f.first_name';
$candidates_result = $db->query( $candidates_query );

?>
      <div class="row-fluid">
        <div class="span4" id="candidates">
          <h3>Candidates</h3>
            <p>Click on each candidate to read his/her candidacy statement for the position of <?php echo $election->title;?>.</p>
<?php
while( $candidate = $candidates_result->fetch_object( ) ) {
    $id   = $candidate->id;
    $name = "$candidate->f $candidate->l";
    $d    = $candidate->dept;
    $p    = $candidate->prefix;
    $bio  = $candidate->bio;
?>
          <div class="row-fluid">
            <div class="span12">
              <button class="btn btn-default btn-block" data-toggle="button"
                      name="<?php echo $name;?>" id="<?php echo $id;?>" d="<?php echo $d;?>" p="<?php echo $p;?>"
                      bio="<?php echo $bio;?>"><span style="font-size: large; font-weight: bold;"><?php echo $name;?></span><br /><?php echo $p;?></button>
            </div>
          </div>
<?php
}
?>
        </div>
        
        <div class="span8 well" id="bio" style="display: none;">
          <h3>Candidacy Statement</h3>
          <p>Blah blah blah.</p>
        </div>
      </div>
<?php

// Vote button

?>
      <div class="row-fluid" style="padding-top: 2em;">
        <div class="span12 well">
          <p>When you are ready, click this button to vote for the candidates you've turned blue.</p>
          <button class='btn btn-success btn-large btn-block' id='vote'>Vote</button>
        </div>
      </div>
      
      <script type="text/javascript">
          $(document).ready(function() {
              
              document.title = document.title + " <?php echo $election->title; ?>";
              $('div.masthead h3').html( $('div.masthead h3').html() + " <?php echo $election->title; ?>" );
              
              $('div#candidates button').click(function(){
                  
                  var id   = $(this).attr('id');
                  var name = $(this).attr('name');
                  var bio  = $(this).attr('bio');
                  var d    = $(this).attr('d');
                  var p    = $(this).attr('p');
                  
                  /*
                   * OK, so this is really bizarre.
                   * 
                   * It appears, after some experimentation, that Bootstrap
                   * adds/removes the active class *after* running the click
                   * function.  The only way I can successfully test whether
                   * the button was active before clicking is to ask if it's
                   * active now -- in other words, the question that the code
                   * below is asking is actually "What state was the button in
                   * before it got clicked?".  Read this code that way, and
                   * it might make sense.
                   * 
                   * If, after you click the button, you ask Firebug whether
                   * the button is active or not, it will tell you the "right"
                   * thing -- the post-click state.  But this click function
                   * needs to work with the pre-click state.
                   */

                  // If this click will make the button active
                  if( ! $(this).hasClass('active') ) {
                      $('div#bio').slideUp( 500, function(){
                          $('div#bio > h3').html( name + ' <small><span class="visible-desktop">' + d + '</span><span class="hidden-desktop">' + p + '</span></small>' );
                          $('div#bio > p').html( bio );
                      })
                      $('div#bio').slideDown();
                      $(this).removeClass('btn-default').addClass('btn-primary');
                  }
                  
                  // Else if this click will make the button inactive
                  else {
                      $('div#bio').slideUp();
                      $(this).removeClass('btn-primary').addClass('btn-default');
                  }
              })
              
              $('button#vote').click(function(){
                  var size = $('div#candidates button.active').length;
                  var winners = <?php echo $election->winners; ?>;
                  
                  var choices = '';
                  $.each( $('div#candidates button.active'), function(){
                      if( choices != '' )
                        choices += "<br />";
                      choices += $(this).attr('name');
                  })

                  var too_few = '<p>This election will result in ' + winners +
                      ' winners, but you have only chosen ' + size +
                      ".  This is OK, but we thought you should know.</p>\n";
                  
                  var just_right = "<p>To cast your ballot for "
                      + ( size == 1 ? 'this candidate' : 'these candidates' ) + ": </p>\n" +
                      "<p style='padding-left: 1em;'>" +
                      choices + "</p>\n<p>Press OK.  Press Cancel if you would like to change your selections.</p>\n";
                  
                  if( size == 0 ) {
                      bootbox.alert( 'You have not selected any candidates!' );
                  } else if( size > winners ) {
                      bootbox.alert( 'You have selected too many candidates.  You may only choose ' + winners + '.' );
                  } else if( size < winners ) {
                    bootbox.confirm( too_few + just_right );
                  } else {
                      bootbox.confirm( just_right, function(result) {
                          //alert(result);
                      })
                  }
              })
          })
      </script>

<?php
require_once( './_footer.inc' );
?>
