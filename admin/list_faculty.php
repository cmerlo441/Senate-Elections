<?php

$no_header = 1;
require_once( '../_header.inc' );

if( true /* an admin is logged in */ ) {
    
    $sort = $db->real_escape_string( $_REQUEST[ 'sort' ] );
    $search = $db->real_escape_string( $_REQUEST[ 'search' ] );
    
    $fac_query = 'select fac.id, fac.first_name as f, fac.last_name as l, '
        . 'dept.name as d, dept.prefix as p, ranks.rank as r, ranks.abbr as ra '
        . 'from faculty as fac, departments as dept, ranks '
        . 'where fac.department = dept.id '
        . 'and fac.rank = ranks.id ';
    if( $search != '' )
        $fac_query .= "and ( fac.first_name like \"%$search%\" "
            . "or fac.last_name like \"%$search%\" "
            . "or dept.name like \"%$search%\" "
            . "or fac.id like \"%$search%\" ) ";
    if( $sort == 'dept' or $sort == 'deptaz' ) {
        $fac_query .= 'order by d, l, f';
    } else if( $sort == 'deptza' ) {
        $fac_query .= 'order by d desc, l, f';
    } else if( $sort == 'rank' or $sort == 'rankaz') {
        $fac_query .= 'order by r, l, f';
    } else if( $sort == 'rankza') {
        $fac_query .= 'order by r desc, l, f';
    } else if( $sort == 'name' or $sort == 'namelastaz' or $sort == '' ) {
        $fac_query .= 'order by l, f';
    } else if( $sort == 'namelastza' ) {
        $fac_query .= 'order by l desc, f';
    } else if( $sort == 'namefirstaz' ) {
        $fac_query .= 'order by f, l';
    } else if( $sort == 'namefirstza' ) {
        $fac_query .= 'order by f desc, l';
    }
    
    $fac_result = $db->query( $fac_query );
    
?>
<p class="<?php print $fac_result->num_rows == 0 ? 'text-error' : 'text-info';?>">Displaying <?php echo $fac_result->num_rows;?> faculty member<?php print $fac_result->num_rows == 1 ? '' : 's';?>.</p>
<table class="table table-striped table-condensed" id="faculty_table">
  <thead>
    <tr>
      <td>
        <div class="btn-toolbar" style="margin: 0;">
          <div class="btn-group" id="name">
            <button class="btn<?php if( $sort == '' or substr( $sort, 0, 4 ) == 'name' ) print ' btn-success';?>" id="name">Name</button>
            <button class="btn dropdown-toggle<?php if( $sort == '' or substr( $sort, 0, 4 ) == 'name' ) print ' btn-success';?>" data-toggle="dropdown"><span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li><a href="#javascript:void(0)" id="namelastaz">Sort by Last Name A-Z</a></li>
              <li><a href="#javascript:void(0)" id="namelastza">Sort by Last Name Z-A</a></li>
              <li><a href="#javascript:void(0)" id="namefirstaz">Sort by First Name A-Z</a></li>
              <li><a href="#javascript:void(0)" id="namefirstza">Sort by First Name Z-A</a></li>
            </ul>
          </div><!-- /btn-group -->
        </div>
      </td>
      
      <td>
        <div class="btn-toolbar" style="margin: 0;">
          <div class="btn-group" id="dept">
            <button class="btn<?php if( substr( $sort, 0, 4 ) == 'dept' ) print ' btn-success';?>" id="dept"><span class="visible-desktop">Department</span><span class="hidden-desktop">Dept.</span></button>
            <button class="btn dropdown-toggle<?php if( substr( $sort, 0, 4 ) == 'dept' ) print ' btn-success';?>" data-toggle="dropdown"><span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li><a href="#javascript:void(0)" id="deptaz">Sort A-Z</a></li>
              <li><a href="#javascript:void(0)" id="deptza">Sort Z-A</a></li>
            </ul>
          </div><!-- /btn-group -->
        </div>
      </td>
      
      <td>
        <div class="btn-toolbar" style="margin: 0;">
          <div class="btn-group" id="rank">
            <button class="btn<?php if( substr( $sort, 0, 4 ) == 'rank' ) print ' btn-success';?>" id="rank">Rank</button>
            <button class="btn dropdown-toggle<?php if( substr( $sort, 0, 4 ) == 'rank' ) print ' btn-success';?>" data-toggle="dropdown"><span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li><a href="#javascript:void(0)" id="rankaz">Sort A-Z</a></li>
              <li><a href="#javascript:void(0)" id="rankza">Sort Z-A</a></li>
            </ul>
          </div><!-- /btn-group -->
        </div>
      </td>
    </tr>
  </thead>
  
  <tbody>
<?php

    while( $fac = $fac_result->fetch_object( ) ) {

?>
    <tr id="<?php echo $fac->id;?>">
      <td>
        <button class="btn btn-mini facultycog"><i class="icon-cog"></i></button>
        <span class="name"><?php echo "$fac->f $fac->l";?></span>
      </td>
      <td>
        <span class="visible-desktop"><?php echo $fac->d;?></span>
        <span class="hidden-desktop"><?php echo $fac->p;?></span>
      </td>
      <td>
        <span class="visible-desktop"><?php echo $fac->r;?></span>
        <span class="hidden-desktop"><?php echo $fac->ra;?></span>
      </td>
    </tr>
    
<?php

    }

?>
  </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function(){

        $('[autofocus]:first').focus();
        
        $('div#buttons button').removeClass('btn-primary');
        $('div#buttons button#faculty_list').addClass('btn-primary');
        
        $('table#faculty_table a').click(function(){
            var key = $(this).attr('id');
            $.post('list_faculty.php',
                { sort: key },
                function(data){
                    $('div#lists > div#list').html(data);
                }
            )
        })

        $('table#faculty_table button:not(.dropdown-toggle)').click(function(){
            var key = $(this).attr('id');
            var search = $('input#search').val();
                        
            $.post('list_faculty.php',
                { sort: key, search: search },
                function(data){
                    $('div#lists > div#list').html(data);
                    $('span#loading').html('');
                }
            )
        })
        
        $('button.facultycog').click(function(){
            var id = $(this).parent().parent().attr('id');
            console.log( id );
        })
    })
</script>
<?php

}

?>