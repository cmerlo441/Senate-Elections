<?php

$no_header = 1;
require_once( '../_header.inc' );

$u = $db->real_escape_string( $_REQUEST[ 'u' ] );
$p = $db->real_escape_string( $_REQUEST[ 'p' ] );

$hash_query = 'select password '
	. 'from passwords '
	. "where faculty_id = \"$u\"";
$hash_result = $db->query( $hash_query );
if( $hash_result->num_rows == 1 ) {
	$hash = $hash_result->fetch_object( );
	print password_verify( $p, $hash->password ) == TRUE ? 1 : 0;
} else {
	print 0;
}
?>
