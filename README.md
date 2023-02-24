# xml-sitemap-find-and-replace
Find url and remove it from a XML sitemap

In this example, we define an array of URLs to remove and load the sitemap file using simplexml_load_file(). We then loop through each URL in the sitemap and check if its loc element matches any of the URLs in the urls_to_remove array. If it does, we use unset() to remove the URL from the sitemap. Finally, we save the updated sitemap file using the asXML() method.

Note that this code assumes that your sitemap file follows the XML schema specified by the sitemap protocol, with each URL represented by a <url> element and the URL itself stored within a <loc> element. If your sitemap file has a different structure, you may need to modify the code accordingly.
