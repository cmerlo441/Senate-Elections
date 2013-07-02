<?php

$no_header = 1;
require_once( '../_header.inc' );
if( true /* check for admin later */ ) {
?>
      <form> <!-- class="form-horizontal" -->
        <fieldset>
          <div class="control-group">
            <label class="control-label" for="title">Election Title:</label>
            <div class="controls"><input type="text" id="title" /></div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="winners">Number of Seats to Fill:</label>
            <div class="controls"><select id="winners">
<?php
    for( $i = 1; $i <= 10; ++$i )
        print "              <option value=\"$i\">$i</option>\n";
?>
            </select></div>
          </div>

          <div class="control-group" id="start_time-group">
            <label class="control-label" for="start_time">When should this election start?</label>
            <div class="controls">
              <div id="start_time" class="datepicker input-append">
                <input data-format="yyyy-MM-dd HH:mm PP" type="text" id="start_time"></input>
                  <span class="add-on">
                    <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                  </span>
              </div>
            </div>
          </div>  <!-- div.control-group#start_time-group -->
    
          <div class="control-group" id="end_time-group">
            <label class="control-label" for="end_time">When should this election end?</label>
            <div class="controls">
              <div id="end_time" class="datepicker input-append">
                <input data-format="yyyy-MM-dd HH:mm PP" type="text" id="end_time"></input>
                <span class="add-on">
                  <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                </span>
              </div>  <!-- div.datepicker#end_time -->
              <span class="help-inline"></span>
            </div> <!-- div.controls -->
          </div> <!-- div.control-group#end_time-group -->

          <div class="form-actions">
            <button type="button" class="btn" id='clear'>Clear Fields</button>
            <button type="submit" class="btn btn-primary" id='submit'>Create Election</button>
          </div>  <!-- div.form-actions -->
        </fieldset>
      </form>

      <script type="text/javascript">
      $(function() {
          $('div#buttons button').removeClass('btn-primary');
          $('div#buttons button#create').addClass('btn-primary');

          $('.datepicker').datetimepicker({
              language: 'en',
              pick12HourFormat: true
          });

          $('input#end_time').blur(function(){
              var start_time = $('input#start_time').val();
              var end_time = $('input#end_time').val();

              if( start_time != '' && end_time != '' && end_time <= start_time ) {
                  $('div.control-group#end_time').addClass('error');
                  $('div.control-group#end_time span.help-inline').html('End time must be after start time');
              }
          })

      });
      </script>
<?php
}

?>