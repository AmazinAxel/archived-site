<?php
require_once 'postRenderer.php'; // get dependency

header("Content-type: text/xml"); // set RSS header

echo "<?xml version='1.0' encoding='UTF-8'?>
 <rss version='2.0'>
 <channel>
 <title> The Boba Blog </title>
 <link> https://" . $_SERVER['HTTP_HOST'] . substr($_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], '/') + 1) . "</link>
 <description> My Boba Blog is a place where I blog about different boba shops all around the PNW! </description>
 <copyright> Copyright AmazinAxel (Alec) @ AmazinAxel.com | All Rights Reserved. </copyright>
 <language>en-US</language>"; // print all the RSS header specific data

$all_files = glob('./posts/*.md'); // grab all the posts

arsort($all_files); // sort the posts
$files = array_slice($all_files, 0, 5); // just take the 5 newest posts

foreach ($files as $file) { // loop thru all the posts
	$md = file_get_contents($file); // get the markdown

	$title = explode("_", substr(basename($file), 0, -3)); // get the title and remove extension
	$date_time = getPostDateTime(basename($file)); // get date & time from title
	$postTitle = getPostTitle($md); // get the post title from inside the markdown

	$post_link = substr(basename($file), 10, -3); // remove .md and date from link

	$md = getFirstLines($md, 3); // get only the first couple lines, not the entire post!
	$description = explode("\n", renderMarkdown($md, $date_time), 2); // get the partial description
	echo "<item>
   <title> $postTitle </title>
   <link> https://amazinaxel.com/boba/$post_link </link>
   <description> " . strip_tags($description[1]) . "</description>
   <pubDate> " . $date_time->format('r') . " </pubDate>
   </item>"; // print all the data
} echo "</channel></rss>"; // wrap it all up!