<?php

$no_header = 1;
require_once( '../_header.inc' );

if( true /* check for admin later */ ) {
    $pw = $db->real_escape_string( $_REQUEST[ 'pw' ] );
    $id = $db->real_escape_string( $_REQUEST[ 'id' ] );
    
    $password = password_hash( $pw, PASSWORD_DEFAULT );
    
    $select_query = 'select * from passwords '
        . "where faculty_id = \"$id\"";
    $select_result = $db->query( $select_query );
    
    $new_pw_query = '';
    if( $select_result->num_rows == 1 ) {
        $new_pw_query = 'update passwords '
            . "set password = \"$password\" "
            . "where id = \"$id\"";
    } else {
        $new_pw_query = 'insert into passwords ( faculty_id, password  ) '
            . "values( \"$id\", \"$password\" )";
    }
    
    print $new_pw_query;
    //$new_pw_result = $db->query( $new_pw_query );
    print $new_pw_result->affected_rows;
}
