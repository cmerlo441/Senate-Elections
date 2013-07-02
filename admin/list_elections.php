<?php

$no_header = 1;
require_once( '../_header.inc' );

if( true /* check for admin later */ ) {
    
    $sort = $db->real_escape_string( $_REQUEST[ 'sort' ] );
    $search = $db->real_escape_string( $_REQUEST[ 'search' ] );
    $when = $db->real_escape_string( $_REQUEST[ 'when' ] );

    $now = date( 'Y-m-d H:i:s' );
    
    $query = 'select * from elections ';
    if( $when == 'past' )
        $query .= "where end_time < \"$now\" ";
    else if( $when == 'current' )
        $query .= "where start_time < \"$now\" and end_time > \"$now\" ";
    else if( $when == 'future' )
        $query .= "where start_time > \"$now\" ";
    else {
        $when = 'all';
    }
    
    if( $search != '' ) {
        $query .= ( $when == 'all' ? 'where ' : 'and ' ) . "title like \"%$search%\" "
            . "or start_time like \"%$search%\" or end_time like \"%$search%\" ";
    }
    
    $query .= "order by start_time, end_time";
    
    $result = $db->query( $query );
    if( $result->num_rows == 0 ) {
        print "<p>There are no $when elections to display.</p>\n";
    } else {

?>
<p class="<?php print $result->num_rows == 0 ? 'text-error' : 'text-info';?>">Displaying <?php echo $result->num_rows;?> election<?php print $result->num_rows == 1 ? '' : 's';?>.</p>
<table class="table table-striped table-condensed" id="past_elections">
  <thead>
    <tr>
      <td>
        <div class="btn-toolbar" style="margin: 0;">
          <div class="btn-group" id="name">
            <button class="btn<?php if( substr( $sort, 0, 8 ) == 'election' ) print ' btn-success';?>" id="name">Election</button>
            <button class="btn dropdown-toggle<?php if( substr( $sort, 0, 8 ) == 'election' ) print ' btn-success';?>" data-toggle="dropdown"><span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li><a href="#javascript:void(0)" id="electionaz">Sort A-Z</a></li>
              <li><a href="#javascript:void(0)" id="electionza">Sort Z-A</a></li>
              <li class="divider"></li>
              <li><a href="#">Search By Election Title</a></li>
            </ul>
          </div><!-- /btn-group -->
        </div>
      </td>

      <td>
        <div class="btn-toolbar" style="margin: 0;">
          <div class="btn-group" id="start">
            <button class="btn<?php if( $sort == '' or substr( $sort, 0, 6 ) == 'starts' ) print ' btn-success';?>" id="name">Start<?php print $when == 'future' ? 's' : 'ed';?></button>
            <button class="btn dropdown-toggle<?php if( $sort == '' or substr( $sort, 0, 6 ) == 'starts' ) print ' btn-success';?>" data-toggle="dropdown"><span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li><a href="#javascript:void(0)" id="startsoldnew">Oldest to Newest</a></li>
              <li><a href="#javascript:void(0)" id="startsnewold">Newest to Oldest</a></li>
              <li class="divider"></li>
              <li><a href="#">Search By Start Date</a></li>
            </ul>
          </div><!-- /btn-group -->
        </div>
      </td>

      <td>
        <div class="btn-toolbar" style="margin: 0;">
          <div class="btn-group" id="end">
            <button class="btn<?php if( substr( $sort, 0, 4 ) == 'ends' ) print ' btn-success';?>" id="name">End<?php print $when == 'past' ? 'ed' : 's';?></button>
            <button class="btn dropdown-toggle<?php if( substr( $sort, 0, 4 ) == 'ends' ) print ' btn-success';?>" data-toggle="dropdown"><span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li><a href="#javascript:void(0)" id="startsoldnew">Oldest to Newest</a></li>
              <li><a href="#javascript:void(0)" id="startsnewold">Newest to Oldest</a></li>
              <li class="divider"></li>
              <li><a href="#">Search By End Date</a></li>
            </ul>
          </div><!-- /btn-group -->
        </div>
      </td>
<?php
        if( $when != 'future' )
            print "      <td>Results</td>\n";
        if( $when != 'past' )
            print "      <td>Active</td>\n";
?>
    </tr>
  </thead>
  
  <tbody>
<?php
        while( $election = $result->fetch_object( ) ) {
            print "    <tr";
            if( $election->start_time < date( 'Y-m-d H:i:s' ) and $election->end_time > date( 'Y-m-d H:i:s' ) )
                print ' class="info"';
            print ">\n";
            print "      <td>$election->title</td>\n";
            print "      <td>" . date( 'Y-m-d', strtotime( $election->start_time ) ) . "</td>\n";
            print "      <td>" . date( 'Y-m-d', strtotime( $election->end_time ) ) . "</td>\n";
            if( $when == 'past' or $when == 'current' or $when == 'all' )
                print "      <td>";
                if( $election->start_time < date( 'Y-m-d H:i:s' ) ) {
                    print "<a href=\"javascript:void(0)\" id=\"$election->id\">View Results</a>";
                }
                print "</td>\n";
            if( $when == 'current' or $when == 'future' or $when == 'all' ) {
                print "      <td>";
                if( $election->end_time > date( 'Y-m-d H:i:s') ) {
                    print "<button id=\"$election->id\" class=\"active btn ";
                    if( $election->active == 1 ) {
                        print 'btn-success">Active';
                    } else {
                        print 'btn-danger">Not Active';
                    }
                }
                print "</button></td>\n";
            }
            print "    </tr>\n";
        }
?>
  </tbody>
</table>

<?php
    } // else there are elections to display
?>
<script type="text/javascript">
    $(document).ready(function(){

        $('[autofocus]:first').focus();
        
        $('div#buttons button').removeClass('btn-primary');
        $('div#buttons button#e').addClass('btn-primary');
        
        $('button.active').click(function(){
            var button = $(this);
            var id = $(this).attr('id');
            $.post( 'active_election_toggle.php',
                { id: id },
                function(data) {
                    if( data == 0 )
                        $(button).removeClass( 'btn-success' ).addClass( 'btn-danger' ).html( 'Not Active' );
                    else
                        $(button).removeClass( 'btn-danger' ).addClass( 'btn-success' ).html( 'Active' );
                }
            )
        })
    })
</script>
<?php
}
?>

