<? 
function generateHeader($pageTitle) {
	require('settings.php');
	echo '<!DOCTYPE html>
	<html lang="en-US">
	<head>
		<title>' . $pageTitle . ' - AlecsCP</title>
		<meta charset="UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="' . $domain . '/scripts.js?v=' . $version . '"></script>
		<link rel="stylesheet" type="text/css" href="' . $domain . '/style.css?v=' . $version . '"/>
		<link rel="stylesheet" href="https://amazinaxel.com/style.css?v=' . $version . '"/>
		<link rel="stylesheet" href="' . $domain . '/AlecsCP.css?v=' . $version . '"/>
		<meta name="description" content="AlecsCP is my custom webmaster panel for administering my websites & more!"/>
		<link rel="canonical" href="https://amazinaxel.com/"/>
		<meta name="author" content="AmazinAxel (Alec)"/>
		<meta name="copyright" content="AmazinAxel (Alec)"/>
		<meta property="og:locale" content="en, en_US"/>
		<meta property="og:type" content="website"/>
		<meta property="og:title" content="AlecsCP"/>
		<meta property="og:description" content="AlecsCP is my custom webmaster panel for administering my websites & more!"/>
		<meta property="og:url" content="' . $domain . '"/>
		<meta property="og:site_name" content="AlecsCP"/>
		<link rel="manifest" href="manifest.json">
		<link rel="apple-touch-icon" href="other/icons/apple-icon-180x180.png">
		<meta name="theme-color" content="#eaeafa"/>' ; }
?>