<?php
require_once 'postRenderer.php'; // include dependency
$post = $_GET['post']; // get post
$possible_files = glob('./posts/*'.$post); // grab the post(s)

if (count($possible_files) > 0) {
    $post = $possible_files[0]; // get post
    $postSlug = basename($post); // get post slug
    $date_time = getPostDateTime($postSlug); // get post date from filename
    $markdown = file_get_contents($post); // get post data
	$postTitle = getPostTitle($markdown); // get post title from inside the markdown
	$isImgSet = false; // if media not set then skip it in the future

} else if (str_contains($post, 'about')){ // ABOUT PAGE
    $markdown = "# About My Boba Blog \nThis place is where I share my experiences with different bubble tea stores all around the PNW! I have reviews in different states, like Oregon, Idaho, and Washington. I rate each one with a 1-10 (10 being the best) Boba Pearl rating. Bubble tea is a type of milk tea mixed with tapioca pearls or different topings, and it originated in Taiwan.";
    $postTitle = 'About My Boba Blog'; // set page title
	$date_time = NULL; // fix glitch
	$postSlug = NULL; // fix glitch and show that its not a post
	$isImgSet = "skip"; // fix glitch with image appearing
} else { // ERROR 404 PAGE
	$markdown = "# Error 404 | Boba Not Found! <br/> \n The boba that you were looking for could not be found on this blog. [You may want to head back to the homepage.](https://amazinaxel.com/boba/ 'Go to homepage')";
    $postTitle = 'Blog post not found!'; // set page title
	$date_time = NULL; // fix glitch
    $postSlug = NULL; // fix glitch and show that its not a post
    $isImgSet = "skip"; // fix glitch with image appearing
} 
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <link rel="stylesheet" href="https://amazinaxel.com/style.css">
    <title><?php echo $postTitle; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<style> img { width: 100%; }</style>
	<script> </script> <!-- Fix bug with animations firing on page load on browsers like Chrome -->
    <?php 
        $post_link = implode('', array_slice(explode('_', $postSlug), 1, 2)); // remove date and time from link
        $post_link = "https://amazinaxel.com/boba/". $post_link; // generate link
		$title = implode('', array_slice(explode('_', $postSlug), 1, 2)); // remove date and time from link
		$title = substr($title, 0, -3); // get post title
		if (!$postSlug == NULL){ $post_link = substr($post_link, 0, -3); } // remove .md extension from link, only if not 404 or other page

		$file = glob('media/' . $title . '*'); // grab the post media file if applicable

		if (!$isImgSet == "skip") { foreach ($file as $postImg) { // get the post media file and grab the data but only if it's not a page
			$tmp = explode('.', $postImg); // grab extension part 1
			$extension = end($tmp); // grab extension part 2
			$isImgSet = true; // media is set
		 } }

		$newMarkdown = str_replace("\nAuthor: AmazinAxel  ","", $markdown); // take out author when getting description
		$newMarkdown = str_replace("\nAuthor: Eaglelistic  ","", $newMarkdown); // take out author when getting description
		$lines = explode(PHP_EOL, $newMarkdown); // get all post data
		$description = NULL; // fix error
		foreach ($lines as $line) { // attempt to get description
			if (strlen($line) > 0) {
				if ($line[0] == '#') {} // If this post has an empty title, then forget about it.
				else if ($description == NULL) {
					$description = strip_tags(implode('.', array_slice(explode('.', $line), 0, 3)) . "... (Read more by visiting the post!)"); // set the description to the first couple words
				}
			}
		}
		echo('<meta property="og:title" content="'.$postTitle.'"/>'); // print post title
		if (!$postSlug == NULL) { echo('<meta property="og:description" content="'.$description.'"/>'); } // print description if not 404 or about page
		echo('<meta property="og:url" content="'. $post_link .'"/>'); // print post link
		echo('<meta property="og:type" content="article"/>'); // print content type
		if ($isImgSet === true) { echo('<meta property="og:image" content="https://amazinaxel.com/boba/media/' . $title . '.' . $extension . '"/>'); } // print post media (if applicable)
    ?>
</head>
<body>
    <div class="blog">
        <?php include 'header.php'; // include the header for all pages! ?>
    <div class='card'>
        <?php
		if ($isImgSet === true) { echo('<img src="https://amazinaxel.com/boba/media/' . $title . '.' . $extension . '" src="Banner image"/>'); } // if post image is set, show it!
		echo renderMarkdown($markdown, $date_time); // finally, print the markdown for the post! ?>
    </div><?
			if (str_contains($markdown, "Author:")){
				echo '<div class="card">';
				if (str_contains($markdown, "Author: AmazinAxel")){ include 'data/AmazinAxel.html'; }
				else if (str_contains($markdown, "Author: Eaglelistic")){ include 'data/Eaglelistic.html'; }
				echo '</div>'; } ?>
    </div>
</body>
</html>
