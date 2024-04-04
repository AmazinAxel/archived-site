<?php
    function renderMarkdown($markdown, $date_time = NULL) { // render markdown
        require_once 'Parsedown.php'; // include markdown library
        $Parsedown = new Parsedown(); // start parsedown session

		$render = $Parsedown->text($markdown); // render post
        if ($date_time != NULL){ // fix 404 page error
            $render = '<h2> Posted On: ' . $date_time->format("F jS, Y") . '</h2>' . $render; // add date
        }
        return $render; // return the markdown
    }

    function getPostSlug($fileName) { // remove the .md extension from the filename
        return substr($fileName, 0, -3); // simply remove last 3 chars from string
    }

    function getPostDateTime($fileName) { // parse date from the file name
        $parts = explode("_", $fileName); // grab first date part of file name
        return DateTime::createFromFormat("Y-m-d", join("_", array_slice($parts, 0, 1))); // create date from the format
    }

    function getPostTitle($postContent) { // get first # title from markdown and returns the text
        $titlePattern = '/^# (.*)/'; // grab the first #
        preg_match($titlePattern, $postContent, $matches);
        return $matches[1]; // give the value
    }

    function getFirstLines($string, $count) { // get a description of the post by taking the first few lines
        $lines = array_slice(explode(PHP_EOL, $string), 0, $count);
        return implode(PHP_EOL, $lines);
    }
?>