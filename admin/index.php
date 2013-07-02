<?php

$title_stub = 'Administrative Panel';
require_once( '../_header.inc' );

?>
      <div id="logged_in" style="display: none;">
        <div class="row-fluid">
          <div class="span12">
            <h1 class="warning">Administrative Panel <small>You are logged in as J. Random Human</small></h1>
            <p>Use this panel to view the list of faculty, create elections, and view their results.</p>          
          </div>
        </div>

        <div class="row-fluid">
          <div class="span3" id="buttons">

            <div class="row-fluid">
              <div class="span12">
                <button class="btn btn-default btn-block" id="faculty_list">
                  <span style="font-size: large;">Faculty List</span>
                </button>
              </div>
            </div>

            <div class="row-fluid">
              <div class="span12 btn-group">
                <button class="btn btn-block dropdown-toggle" data-toggle="dropdown" id="e">
                  <span style="font-size: large;">Elections List <span class="caret"></span></span>
                </button>
                <ul class="dropdown-menu">
                  <li><a href="javascript:void(0)" class="elections" id="All">All Elections</a></li>
                  <li><a href="javascript:void(0)" class="elections" id="Past">Past Elections</a></li>
                  <li><a href="javascript:void(0)" class="elections" id="Current">Current Elections</a></li>
                  <li><a href="javascript:void(0)" class="elections" id="Future">Future Elections</a></li>
                </ul>
              </div>
            </div>

            <div class="row-fluid">
              <div class="span12">
                <button class="btn btn-default btn-block" id="create">
                  <span style="font-size: large;">Create an Election</span>
                </button>
              </div>
            </div>

            <div class="row-fluid">
              <div class="span12">
                <button class="btn btn-default btn-block" id="logout">
                  <span style="font-size: large;">Log Out</span>
                </button>
              </div>
            </div>

          </div>

          <div class="span9 well" style="display: none;" id="lists">
            <h3>Loading...</h3>
              <form class="form-search" id="list_search">
                <input type="text" class="span4 input-medium search-query"
                  placeholder="Search" value="<?php echo $search;?>"
                  id="search" autofocus="autofocus"></input>
                <span class="alert" id="loading" style="display: none;">Loading...</span>
              </form>
            <div id="list" style="height: 20em !important; overflow: scroll;"></div>
          </div>
        </div>
      </div>  <!-- div#logged_in -->
      
      <div id="not_logged_in" style="display: none;">
        You are not logged in.
      </div>  <!-- div#not_logged_in -->

      <script type="text/javascript">
          $(document).ready(function(){
              var current_button;
              
              if( /* "<?php echo $_SESSION[ 'admin' ]; ?>" == 1 */ true )
                  $('div#logged_in').show();
              else
                  $('div#not_logged_in').show();
              
              $('button#faculty_list').click(function(){
                  $('input#search').val('');
                  current_button = 'faculty_list';
                  $.post('list_faculty.php',
                      function(data){
                          $('div#lists > h3').html('Faculty List').show();
                          $('div#lists > form#list_search').show();
                          $('div#lists > div#list').html(data);
                          $('div#lists').slideDown();
                      }
                  )
              })
              
              $('button#logout').click(function(){
                  $('div#logged_in').slideUp(function(){
                      $('div#not_logged_in').slideDown();
                  })
              })
              
              $('button#create').click(function(){
                  $.post('create_election.php',
                    function(data){
                        $('div#lists > h3').html('Create a New Election').show();
                        $('div#lists > form#list_search').hide();
                        $('div#lists > div#list').html(data);
                        $('div#lists').slideDown();
                    }
                  )
              })
              
              $('a.elections').click(function(){
                  $('input#search').val('');
                  current_button = 'e';
                  var when = $(this).attr('id');
                  $.post('list_elections.php',
                      { when: when.toLowerCase() },
                      function(data){
                          $('div#lists > h3').html(when + ' Elections').show();
                          $('div#lists > form#list_search').show();
                          $('div#lists > div#list').html(data);
                          $('div#lists').slideDown();
                          $('button#e').parent().children('ul').toggle();
                      }
                  )
                  return false;
              })
              
              $('button#e').click(function(){
                  $(this).parent().children('ul').toggle();
              })

              $('input#search').keyup(function(){
                  
                  var when = $('div#lists > h3').html().substring(0, $('div#lists > h3').html().indexOf(' ') ).toLowerCase( );

                  $('span#loading').show();
                  
                  if( $(this).val().length > 0 ) {
                      var sort = "<?php echo $sort;?>";
                      
                      $.post( current_button == 'e' ? 'list_elections.php' : 'list_faculty.php',
                          { sort: sort, search: $(this).val(), when: when },
                          function(data){
                              $('div#lists > div#list').html(data);
                              $('span#loading').hide();
                          }
                      )
                  } else {
                      $.post( current_button == 'e' ? 'list_elections.php' : 'list_faculty.php',
                          { sort: sort, when: when },
                          function(data){
                              $('div#lists div#list').html(data);
                              $('span#loading').hide();
                          }
                      )
                  }
              })
          })
      </script>
<?php

require_once( '../_footer.inc' );
?>
