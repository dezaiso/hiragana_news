<?php
function getURL( $pURL ) {
   $_data = null;
   if( $_http = fopen( $pURL, "r" ) ) {
      while( !feof( $_http ) ) {
         $_data .= fgets( $_http, 1024 );
      }
      fclose( $_http );
   }
   return( $_data );
}



/*

$_rawData = getURL( "http://www.example.com/" );

*/



function cleanString( $pString ) {
   $_data = str_replace( array( chr(10), chr(13), chr(9) ), chr(32), $pString );
      while( strpos( $_data, str_repeat( chr(32), 2 ), 0 ) != false ) {
         $_data = str_replace( str_repeat( chr(32), 2 ), chr(32), $_data );
      }
      return( trim( $_data ) );
}



/*

$_rawData = cleanString( $_rawData );

*/



function getBlock( $pStart, $pStop, $pSource, $pPrefix = true ) {
   $_data = null;
   $_start = strpos( strtolower( $pSource ), strtolower( $pStart ), 0 );
   $_start = ( $pPrefix == false ) ? $_start + strlen( $pStart ) : $_start;
   $_stop = strpos( strtolower( $pSource ), strtolower( $pStop ), $_start );
   if( $_start > strlen( $pElement ) && $_stop > $_start ) {
      $_data = trim( substr( $pSource, $_start, $_stop - $_start ) );
   }
   return( $_data );
}

function getElement( $pElement, $pSource ) {
   $_data = null;
   $pElement = strtolower( $pElement );
   $_start = strpos( strtolower( $pSource ), chr(60) . $pElement, 0 );
   $_start = strpos( $pSource, chr(62), $_start ) + 1;
   $_stop = strpos( strtolower( $pSource ), "</" . $pElement .    chr(62), $_start );
   if( $_start > strlen( $pElement ) && $_stop > $_start ) {
      $_data = trim( substr( $pSource, $_start, $_stop - $_start ) );
   }
   return( $_data );
}



/*

$_rawData = getBlock( start_string, end_string, raw_source, include_start_string );
$_rawData = getElement( html_tag, raw_source );

*/



/*

$_count = getBlock( "Total of", "results", $_rawData, false );

*/



/*

$_count = getElement( "b", $_rawData );

*/



?>
