<?php

// Define the list of URLs to remove
$urls_to_remove = array(
    'http://example.com/page1',
    'http://example.com/page2',
    'http://example.com/page3',
);

// Load the sitemap file
$sitemap_file = 'sitemap.xml';
$sitemap = simplexml_load_file($sitemap_file);

// Remove URLs from sitemap
foreach ($sitemap->url as $url) {
    $loc = (string) $url->loc;
    if (in_array($loc, $urls_to_remove)) {
        unset($url[0]);
    }
}

// Save the updated sitemap file
$sitemap->asXML($sitemap_file);
