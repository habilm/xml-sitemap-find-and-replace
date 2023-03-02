<?php

error_reporting( E_ALL );
ini_set( "display_errors", 1 );


$file_contents = file_get_contents( __DIR__ . '/remove_url.txt');
$site_map_text = file_get_contents( __DIR__ . '/sitemap.xml');

$array_of_url = preg_split('/\n|\r/', $file_contents);

// var_dump( $array_of_url );

if( ! is_array( $array_of_url ) ){
    die( "not well formatted url list" ) ;
}

$array_of_url_html_encoded = array_map( function( $v ){
    return htmlspecialchars_decode( trim($v ) );
}, $array_of_url );

$not_found_count = 0;

for( $i = 0; $i < count( $array_of_url ); $i++ ){

    if( strpos( $site_map_text, trim( $array_of_url[ $i ] ) ) === false && strpos( $site_map_text, trim( $array_of_url_html_encoded[ $i ] ) ) === false ){
        echo " NOT FOUND: " . $array_of_url[ $i ];
        echo "<br>";
        $not_found_count ++;
    }
}

$XML = simplexml_load_file( "sitemap.xml" );

$toDelete = array();

$not_removed = [];

foreach ($XML->url as $url) {

    $loc = $url->loc[0];
    if (in_array($loc, $array_of_url) || in_array($loc, $array_of_url_html_encoded) ) {
        
        echo "REMOVED - ";
        echo $loc[0];
        echo "<br>";
        $toDelete[] = $url;
    }else {
        $not_removed[] =  $loc;
    }
}

echo "<br><br><b>Given : " . ( count($array_of_url ) ) .  " </b><br>";
echo "<br><br><b>Not Found : " . ( $not_found_count )  .  " </b><br>";
echo "<b>Total Removed: " . ( count($toDelete) ) .  " </b>";

foreach ($toDelete as $item) {
    $dom = dom_import_simplexml($item);
    $dom->parentNode->removeChild($dom);
}

// echo "<br>";
// array_map( function($v){
// echo $v . "<br>";
// },$not_removed );

$XML->asXML("new_sitemap.xml");

?>
