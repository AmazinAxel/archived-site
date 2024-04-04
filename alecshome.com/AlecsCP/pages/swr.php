<?php 
error_reporting(E_ALL); // add error reporting for the backend page
ini_set('display_errors', true); // error reporting
#header('Access-Control-Allow-Origin: no-cors'); // fix bug
#include('../../boba/postRenderer.php'); // include library
require 'settings.php'; # This is the updated and fixed code. Put this on every page!
if (isset($_COOKIE['login']) != $password) {
	require('login.php');
	die();
}

$year = file_get_contents('data/blogyear.txt');
# ADD HTTP HEADERS FOR ERRORS / NON ERRORS!
/* if (isset($_POST['title'])) { // HANDLE POST CREATION
	if (isset($_POST['post'])) {
		#$file = fopen('../../2023.html', "w");
		#fwrite($file, "# " . $_POST['title'].$author . $_POST['post']);
		#fclose($file);
		echo 'title: ' . $_POST['title'] . "\n data: " . $_POST['post'];
		die(" \n SUCCESS"); // Exit & don't send / process any extra data / wrap up all PHP processes
	}} */

if (isset($_POST['post'])){ // ../../../../../domains/amazinaxel.com/public_html/SWR/2023.html
	$lines = implode(file("../../../../domains/amazinaxel.com/public_html/swr/" . $year .".html"));
	$file = fopen('../../../../domains/amazinaxel.com/public_html/swr/' . $year . '.html', "w");

	$lines1 = explode('<div class="leftcolumn">', $lines);
	$lines2 = explode('<div class="card">', $lines);
	if (isset($_POST['title'])) { $data = $lines1[0] . '<div class="leftcolumn"> <div class="card"><h2>' . $_POST['title'] . ' ('. date('n/j/Y', time()) . ') </h2><p>' . $_POST['post'] . '</p></div>' . "\n"; }
	else { $data = $lines1[0] . '<div class="leftcolumn"> <div class="card"><h2>' . date('n/j/Y', time()) . '</h2><p>' . $_POST['post'] . '</p></div>' . "\n"; }
	for ($i = 1; $i < count($lines2); $i++) { $data = $data . '<div class="card">' . $lines2[$i]; }
	fwrite($file, $data);
	$file_date = date('m-d-Y', strtotime("7 days"));
    file_put_contents('data/swrtime.txt', $file_date);
	fclose($file);
	die("\nSUCCESS"); // Exit & don't send / process any extra data / wrap up all PHP processes
} else if (isset($_POST['mini'])){
	$lines = implode(file("../../../../domains/amazinaxel.com/public_html/swr/" . $year . ".html"));
	$file = fopen('../../../../domains/amazinaxel.com/public_html/swr/' . $year . '.html', "w");
	#echo 'title: ' . $_POST['title'] . "\n data: " . $_POST['post'];

	$lines1 = explode('<div class="leftcolumn">', $lines);
	#$lines1a = $lines1[0];
	$lines2 = explode('<div class="card">', $lines);
	#$lines2a = $lines2[0];
	#echo $lines1[0] . '<div class="card"><p>' . $_POST['post'] . '</p></div>' . "\n";
	#fwrite($file, $lines1[0] . '<div class="card"><p>' . $_POST['post'] . '</p></div>' . "\n");
	if (isset($_POST['title'])) { $data = $lines1[0] . '<div class="leftcolumn"> <div class="card"><h2> SWR Mini - ' . $_POST['title'] . ' ('. date('n/j/Y', time()) . ') </h2><p>' . $_POST['mini'] . '</p></div>' . "\n"; }
	else { $data = $lines1[0] . '<div class="leftcolumn"> <div class="card"><h2> SWR Mini ' . date('n/j/Y', time()) . '</h2><p>' . $_POST['mini'] . '</p></div>' . "\n"; }
	for ($i = 1; $i < count($lines2); $i++) { $data = $data . '<div class="card">' . $lines2[$i]; }
	#echo $data;
	fwrite($file, $data);
	#echo $lines[0];
	#$posts = explode('<div class="card">', $lines4);
	fclose($file);
	die("\nSWRMINISUCCESS"); // Exit & don't send / process any extra data / wrap up all PHP processes
} else if (isset($_POST['newyear'])){
	$newyear = (int)file_get_contents('data/swryear.txt') + 1;
	file_put_contents('data/swryear.txt', $newyear);
	$data = '<!-- HTML for my website at https://amazinaxel.com -->
<!DOCTYPE html>
<html lang="en-US">
	<!-- meta for SEO and normal boring web stuff -->
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<title>AmazinAxel&#039;s Stuff - SWR ' . $newyear . '</title>
		<meta name="description" content="Welcome to my home on the web! I post updates, games and whatever I feel like here!" />
		<link rel="stylesheet" type="text/css" href="https://amazinaxel.com/style.css" />
		<link rel="canonical" href="https://amazinaxel.com/" />
		<meta property="og:locale" content="en, en_US" />
		<meta property="og:type" content="website" />
		<meta property="og:title" content="AmazinAxel&#039;s Stuff" />
		<meta property="og:description" content="AmazinAxel&#039;s Stuff is my personal home on the web to share my ideas, thoughts, updates and whatever I feel like posting!" />
		<meta property="og:url" content="https://amazinaxel.com" />
		<meta property="og:site_name" content="AmazinAxel&#039;s Stuff" />
		<meta property="og:image" content="https://amazinaxel.com/favicon.png" />
		<script> </script> <!-- Fix bug with animations firing on page load on browsers like Chrome -->
		</head>
		<!-- main website content -->
		<body>
		<header>
		<!-- header -->
		<h1><a class="headtxt" href="https://amazinaxel.com">AmazinAxel&#039;s Stuff</a></h1>
			<h2><a class="infotxt" href="https://amazinaxel.com">My personal home on the web to share stuff!</a></h2>
			<!-- navigation bar -->
			<div class="navbar"><p><a href="https://amazinaxel.com/index.html">Home</a> <a href="https://amazinaxel.com/swr.html">SWR</a> <a href="https://amazinaxel.com/projects.html">Projects</a> <a class="right" href="https://amazinaxel.com/about-me.html">About Me</a></p></div>
		</header>
		<!-- content and sidebar -->
		<div class="row">
			<!-- main content -->
			<div class="leftcolumn">
				<div class="card"><p> This is the start of my SWR' . $newyear . ' cluster.</p></div>
				<div class="navbar"><p><a href="https://amazinaxel.com/swr.html">SWR Posts</a> <a class="right" href="https://amazinaxel.com/">Latest Posts</a></p></div>
			</div>
			<!-- sidebar -->
			<aside>
				<div class="card"><h3>Featured Stuff</h3>
					<ul>
						<li><a href="https://amazinaxel.com/projects.html">My Projects!</a></li>
						<li><a href="https://www.roblox.com/games/5589862413/FreePvP-New-cave?">FreePvP (Roblox)</a></li>
						<li><a href="https://amazinaxel.com/about-me.html">About Me</a></li>
					</ul></div>
				<div class="card"><h3>Social</h3>
					<ul>
						<li><a href="https://github.com/amazinaxel">Github repos</a></li>
						<li><a href="https://www.youtube.com/channel/UC2rR60IXOH_ExzPAYS1CPcA">YouTube channel</a></li>
					</ul></div>
			</aside>
		</div>
		<!-- footer copyright -->
		<footer>
			<p>Copyright © AmazinAxel ' . $newyear .' • <a href="https://amazinaxel.com/privacy-policy.html">Privacy / Cookies</a></p>
		</footer>
	</body>
</html>';
	file_put_contents('../../../../domains/amazinaxel.com/public_html/swr/' . $newyear .'.html', $data);

	#$swrIndexCount = 0;
	$lines = implode(file("../../../../domains/amazinaxel.com/public_html/swr/index.html"));
	$file = fopen('../../../../domains/amazinaxel.com/public_html/swr/index.html', "w");

	$lines1 = explode('<!-- Start Index: -->', $lines);
	#$lines1a = $lines1[0];
	#$lines2 = explode('<div class="card">', $lines);
	#$lines2a = $lines2[0];
	#echo $lines1[0] . '<div class="card"><p>' . $_POST['post'] . '</p></div>' . "\n";
	#fwrite($file, $lines1[0] . '<div class="card"><p>' . $_POST['post'] . '</p></div>' . "\n");
	$data = $lines1[0] . '<!-- Start Index: --> <div class="card"><h1><a href=' . $newyear . '>SWR' . $newyear . "</a></h1></div>\n" . $lines1[1];
	#for ($i = 1; $i < count($lines2); $i++) { $data = $data . '<div class="card">' . $lines2[$i]; }
	#echo $data;
	fwrite($file, $data);

	#file_put_contents('../../../../../domains/amazinaxel.com/public_html/SWR/index.html', $data);
	die('NEWYEARSUCCESS');
# first parse out the data from the leftcolumn and explode the index, and add the item 2nd from the top, and then paste in everything else 
}
include('other/header.php');
generateHeader('SWR');
?>
		<style>
			h1 { margin-block-start: 0.6em; margin-block-end: 0.6em; }
		</style>
		<script>
			async function uploadPost(name) {
				document.getElementById('postSubmit').innerHTML = "Saving..."
				let formData = new FormData();
				formData.append('post', document.getElementById('data').value);
				if (document.getElementById('postTitle').value != ''){ formData.append('title', document.getElementById('postTitle').value); }
				await fetch('#', {
					method: "POST",
					body: formData
				})
				document.getElementById('postSubmit').innerHTML = "Saved!"
			}

			async function uploadMiniPost(name) {
				document.getElementById('miniSubmit').innerHTML = "Saving..."
				let formData = new FormData();
				formData.append('mini', document.getElementById('miniData').value);
				formData.append('title', document.getElementById('miniTitle').value);
				await fetch('#', {
					method: "POST",
					body: formData
				})
				document.getElementById('miniSubmit').innerHTML = "Saved!"
				document.getElementById('miniSubmit').setAttribute('onclick', '');
			}

			function showCreatePost() {
				cancelMiniPost();
				document.getElementById('showCreatePostBtn').innerHTML = 'Cancel';
				document.getElementById('showCreatePostBtn').setAttribute('onclick','cancelCreatePost()');
				document.getElementById('createPost').style.display = "unset"
				document.getElementById('header').style.height = "370px"
				document.getElementById('createPost').classList.add('show');
				document.getElementById('createPost').classList.remove('hide');
				
			} function cancelCreatePost() {
				document.getElementById('showCreatePostBtn').innerHTML = 'SWR';
				document.getElementById('showCreatePostBtn').setAttribute('onclick','showCreatePost()');
				document.getElementById('header').style.height = "140px"
				document.getElementById('createPost').classList.add('hide');
				document.getElementById('createPost').classList.remove('show');
				document.getElementById('createPost').style.display = "none";
				//setTimeout(function(){ document.getElementById('createPost').style.display = "none"; }, 500);
			}

			function showMiniPost() {
				cancelCreatePost();
				document.getElementById('showMiniPostBtn').innerHTML = 'Cancel';
				document.getElementById('showMiniPostBtn').setAttribute('onclick','cancelMiniPost()');
				document.getElementById('createMiniPost').style.display = "unset"
				document.getElementById('header').style.height = "370px"
				document.getElementById('createMiniPost').classList.add('show');
				document.getElementById('createMiniPost').classList.remove('hide');
			} function cancelMiniPost() {
				document.getElementById('showMiniPostBtn').innerHTML = 'SWR Mini';
				document.getElementById('showMiniPostBtn').setAttribute('onclick','showMiniPost()');
				document.getElementById('createMiniPost').style.display = "none"
				document.getElementById('header').style.height = "140px"
				document.getElementById('createMiniPost').classList.add('hide');
				document.getElementById('createMiniPost').classList.remove('show');
			}

			async function submitData() {
				event.preventDefault(); // Prevent auto reload of page
				document.getElementById('dataSubmit').value = 'Saving...'; // Saving text
				var xmlhttp = new XMLHttpRequest(); // Initialize AJAX request
				var data = document.getElementById('referenceData').value; // Gather form data
				xmlhttp.open("POST", "action?ref", true); // Open AJAX request
				xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded;"); // Encode AJAX request
				xmlhttp.send('data=' + encodeURIComponent(data)); // Send AJAX request
				xmlhttp.onreadystatechange=function() { // Give feedback if successful
					if (xmlhttp.readyState==4 && xmlhttp.status==200) { // Show Saved text
						document.getElementById('dataSubmit').value = 'Saved!';
						setTimeout(function() {
							document.getElementById('dataSubmit').value = 'Save';
						}, 2000);
					};
				};
			}
			
			async function newSWRYear() {
				document.getElementById('newSWRyear').innerHTML = "Creating new year..."
				let formData = new FormData();
				formData.append('newyear', 'true');
				await fetch('#', {
					method: "POST",
					body: formData
				})
				document.getElementById('newSWRyear').innerHTML = "New year created!"
				document.getElementById('newSWRyear').setAttribute('onclick', '');
			}
			
			window.onload = function() { if (window.location.toString().includes("openswr")) { setTimeout(function(){ showCreatePost(); }, 250); } }
		</script>
	</head>
	<body>
		<div class="card header" id="header" style="transition: height 0.4s cubic-bezier(0, 1.3, 0.4, 1) 0s; height: 140px;">
			<a class="button headerbtn" href="<? echo $domain ?>"> SWR Creator </a>
		<div style="display: grid; grid-template-columns: 50% 50%; justify-content: center; margin-top: 10px;">
			<a id="showCreatePostBtn" class="button" style="margin-right: 5px;" onclick="showCreatePost()"> SWR </a> <a href="#" class="button" id="showMiniPostBtn" style="margin-left: 5px;" onclick="showMiniPost()"> SWR Mini </a></div>
		<!--<div class="card header" id="header" style="margin-top: 0; transition: height 0.4s cubic-bezier(0.2, 1.3, 0.7, 1); height: 135px;" id="header">
			<a class="button headerbtn" href="https://alecshome.com/AlecsCP/"> SWR Editor </a>
			<h2 class="button" style="display: block; margin: 0;" id="showCreatePostBtn" onclick="showCreatePost()"> Create New SWR Post </h2> -->
			<div id="createPost" style="display: none; position: relative;" class="hide">
				<h2 style="margin-top: 10px;"> Title: <input type="text" name="date" value="" placeholder="Optional title goes here" id="postTitle"> </h2>
				<textarea cols="40" id="data" name="data" rows="20" placeholder="Enter post text here"></textarea>
				<a id="postSubmit" class="button" style="display: block; margin-top: 10px;" onclick="uploadPost()"> Save & Publish </a>
			</div>
			<!--<h2 class="button" style="display: block; margin: 0; margin-top: 10px;" id="showMiniPostBtn" onclick="showMiniPost()"> Create New SWR Mini Post </h2>-->
			<div id="createMiniPost" style="display: none; position: relative;">
				<h2 style="margin-top: 10px;"> Title: <input type="text" name="date" value="" placeholder="Post title goes here" id="miniTitle"> </h2>
				<textarea cols="40" id="miniData" name="data" rows="20" placeholder="Enter post text here"></textarea>
				<a id="miniSubmit" class="button" style="display: block; margin-top: 10px;" onclick="uploadMiniPost()"> Save & Publish </a>
			</div>
			</div>
		<div class="row">
			<div class="leftcolumn">
				<? #include('../../../../../domains/amazinaxel.com/public_html/SWR/2023.html')  ?>
			<div class="card"> <h1>Previous SWR Posts:</h1> </div>
				<?php 
					# just get the latest SWR html file
					# also make sure to show that swr referbnce added
		# Also add the SWR post year selection picker and allow for creation of new SWR post
					#$arrFiles = scandir('../../boba/posts/', SCANDIR_SORT_DESCENDING);
					$postCount = 0;
				$lines = implode(file("../../../../domains/amazinaxel.com/public_html/swr/" . $year .".html"));
					$lines1 = explode('<div class="leftcolumn">', $lines);
					$lines2 = $lines1[1];
					$lines3 = explode('<div class="navbar">', $lines2);
					$lines4 = $lines3[0];
					#echo $lines[0];
					$posts = explode('<div class="card">', $lines4);

					$i = 0;
					for ($i = 1; $i < count($posts); $i++) { // CHANGE THE VALUE IF THERE ARE ISSUES WITH CUTTING OFF POSTS, GLITCHY WHEN ITS 0??
							#echo $posts[$i] . "\n";
							# to get file title, check for any H1 tags inside of it and parse the data inside
							$postCount++;
							echo '<div class="card">
					<p> ' . $posts[$i]; }?>
			<div class="card left">
				<a><strong><? echo $postCount; ?> </strong> SWR Posts </a>
				<div class="buttons"> <a class="button" id="manageHTML"> Edit Page HTML </a> </div> <!-- add href="https://alecshome.com/boba/media/ once finished -->
				</div>
			</div>
		<aside>
			<div class="card right">
				<h2 class="large button">Options:</h2>
				<a class="button headerbtn large-margin-top margin-bottom" href="https://amazinaxel.com/swr/<? echo $year; ?>"> View SWR Page </a>
				<h2 class="large button margin-bottom">Edit Previous SWRs</h2>
				<h2 class="large button" id="newSWRyear" onclick="newSWRYear()">Create New SWR Year</h2>
			</div>
			<div class="card right">
				<h2 class="button" style="margin: 0;"> SWR Reference </h2>
				<textarea id="reference" name="data"><? echo file_get_contents("data/reference.txt"); ?></textarea>
				<a class="large button" onclick="saveNote('reference')" id="referenceSubmit">Save</a>
			</div>
		</aside>
		</div>
	</body>
</html>