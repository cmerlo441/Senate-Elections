<?php

$no_header = 1;
require_once( '../_header.inc' );

if( true /* test for admin later */ ) {
    $id = $db->real_escape_string( $_REQUEST[ 'id' ] );

    $current_query = 'select active from elections '
        . "where id = $id";
    $current_result = $db->query( $current_query );
    $election = $current_result->fetch_object( );
    
    $db->query( "update elections set active = " . ( $election->active == 1 ? '0' : '1' )
        . " where id = $id" );

    $current_query = 'select active from elections '
        . "where id = $id";
    $current_result = $db->query( $current_query );
    $election = $current_result->fetch_object( );
    print $election->active;
}

?>