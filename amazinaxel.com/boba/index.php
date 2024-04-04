<!DOCTYPE html>
<html lang="en_US">
<head>
    <title>The Bubble Tea Blog</title>
    <link rel="stylesheet" href="https://amazinaxel.com/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script> </script> <!-- Fix bug with animations firing on page load on browsers like Chrome -->
</head>
    <body>
        <?php include 'header.php'; // include the header
        require_once 'postRenderer.php'; // include the dependency

        $page = intval(0); // fix error
        if (isset($_GET["page"])){ $page=intval($_GET["page"]); } // get page, if not set to default

        $all_files = glob('./posts/*.md'); // grab all the posts

        arsort($all_files); // sort files from latest
        $files = array_slice($all_files, $page * 5, 5); // grab only 5 of the posts

        foreach ($files as $file) { // loop through the posts
            $md = file_get_contents($file); // get the markdown

            $file_name = basename($file); // get name of file
            $date_time = getPostDateTime($file_name); // get date & time from title

            $post_link = substr($file_name, 10, -3); // remove .md and date from link

            $md = getFirstLines($md, 3); // get summary of the post ?>

            <div class="card">
                <?php echo renderMarkdown($md, $date_time); // render the post markdown ?>
                <br>
                <a class="button" href="<?php echo $post_link // add post link button ?>" style="text-decoration: none;">View post in fullscreen</a>
            </div>
        <?php } // end the loop ?>
        <div class="navbar"> <?php // add the pagintation at the bottom
        if ($page > 1) { echo "<a href=\"https://amazinaxel.com/boba\">" . "First" . "</a>"; } // add first button
        if ($page > 0) {
            $href = "?page=" . strval($page-1);
            if ($page == 1) {
                $href = "https://amazinaxel.com/boba/";
            }
            //else {
            //    echo " | ";  // link bar
            //}
            echo "<a href=\"" . $href . "\">" . "Newer" . "</a>"; // add newer button
        }

        if (($page+1)*5 < count($all_files)) {
            echo "<a class=\"right\" href=\"?page=" . strval($page+1) . "\">" . "Older" . "</a>"; // add older button
        } ?>
        </div>
</body></html>