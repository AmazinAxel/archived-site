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
if (isset($_POST['post']) && isset($_POST['title'])){ // ../../../../domains/amazinaxel.com/public_html/index.html
	$lines = implode(file("../../../../domains/amazinaxel.com/public_html/archives/" . $year .".html")); // WRITE DATA TO THE ARCHIVES FIRST!!
	$file = fopen('../../../../domains/amazinaxel.com/public_html/archives/' . $year . '.html', "w");
	$lines1 = explode('<div class="leftcolumn">', $lines);
	$lines2 = explode('<div class="card">', $lines);
	$data = $lines1[0] . '<div class="leftcolumn"> <div class="card"><h2>' . $_POST['title'] . ' ('. date('n/j/Y', time()) . ') </h2><p>' . $_POST['post'] . '</p></div>' . "\n" . $lines1[1];
	fwrite($file, $data); 
	fclose($file);
	
	
	// WRITE THE DATA TO THE HOMEPAGE AND DELETE THE LAST POST!
	
	$lines = implode(file("../../../../domains/amazinaxel.com/public_html/index.html")); 
	$file = fopen("../../../../domains/amazinaxel.com/public_html/index.html", "w");
	$lines1 = explode('<div class="leftcolumn">', $lines);
	$lines2 = explode('<div class="card">', $lines);
	$endpoint = explode('<div class="navbar">', $lines);
	$data = $lines1[0] . '<div class="leftcolumn"> <div class="card"><h1>' . $_POST['title'] . ' ('. date('n/j/Y', time()) . ') </h1><p>' . $_POST['post'] . '</p></div>' . "\n"; 
	for ($i = 1; $i < 3; $i++) { $data = $data . '<div class="card">' . $lines2[$i]; }
	echo $data = $data . '<div class="navbar">' . $endpoint[2];
	fwrite($file, $data);
	fclose($file);
	die("\nSUCCESS"); // Exit & don't send / process any extra data / wrap up all PHP processes
	
	
} else if (isset($_POST['newyear'])){
	$newyear = (int)file_get_contents('data/blogyear.txt') + 1;
	file_put_contents('data/blogyear.txt', $newyear);
	$data = '<!-- HTML for my website at https://amazinaxel.com -->
<!DOCTYPE html>
<html lang="en-US">
	<!-- meta for SEO and normal boring web stuff -->
	<head>
		<meta charset="UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<title>AmazinAxel&#039;s Stuff - Homepage</title>
		<meta name="description" content="Welcome to my home on the web! I post updates, games and whatever I feel like here!"/>
		<link rel="stylesheet" type="text/css" href="https://amazinaxel.com/style.css"/>
		<link rel="canonical" href="https://amazinaxel.com/"/>
		<meta property="og:locale" content="en, en_US"/>
		<meta property="og:type" content="website"/>
		<meta property="og:title" content="AmazinAxel&#039;s Stuff"/>
		<meta property="og:description" content="AmazinAxel&#039;s Stuff is my personal home on the web to share my ideas, thoughts, updates and whatever I feel like posting!"/>
		<meta property="og:url" content="https://amazinaxel.com"/>
		<meta property="og:site_name" content="AmazinAxel&#039;s Stuff"/>
		<meta property="og:image" content="https://amazinaxel.com/favicon.png"/>
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
	file_put_contents('../../../../domains/amazinaxel.com/public_html/archives/' . $newyear .'.html', $data);
	
	$lines = implode(file("../../../../domains/amazinaxel.com/public_html/archives/index.html"));
	$file = fopen('../../../../domains/amazinaxel.com/public_html/archives/index.html', "w");

	$lines1 = explode('<!-- Start Index: -->', $lines);
	$data = $lines1[0] . '<!-- Start Index: --> <div class="card"><h1><a href=' . $newyear . '>' . $newyear . "</a></h1></div>\n" . $lines1[1];
	fwrite($file, $data);

	die('NEWYEARSUCCESS'); } else if (isset($_FILES['media'])) { // HANDLE UPLOADED MEDIA
		if(!empty($_FILES["media"]["name"])) {
			if (isset($_POST["name"])) { $name = $_POST["name"]; } else { $name = $_FILES["media"]["name"]; }
			#$allowTypes = array('jpg','png','jpeg','gif','pdf');
			#if(in_array($fileType, $allowTypes)){
			if (move_uploaded_file($_FILES["media"]["tmp_name"], "../../../../domains/amazinaxel.com/public_html/media/" . $name)){
				die('SUCCESS');
			} else { http_response_code(501); /* Couldn't move file */ exit; }
		} else { http_response_code(501); /* No file uploaded */ exit; }}

include('other/header.php');
generateHeader('Blog'); ?>
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


			function showCreatePost() {
				document.getElementById('showCreatePostBtn').innerHTML = 'Cancel Post';
				document.getElementById('showCreatePostBtn').setAttribute('onclick','cancelCreatePost()');
				document.getElementById('createPost').style.display = "unset"
				document.getElementById('header').style.height = "410px"
				document.getElementById('createPost').classList.add('show');
				document.getElementById('createPost').classList.remove('hide');
				
			} function cancelCreatePost() {
				document.getElementById('showCreatePostBtn').innerHTML = 'Create New Blog Post';
				document.getElementById('showCreatePostBtn').setAttribute('onclick','showCreatePost()');
				document.getElementById('header').style.height = "130px"
				document.getElementById('createPost').classList.add('hide');
				document.getElementById('createPost').classList.remove('show');
				document.getElementById('createPost').style.display = "none";
				//setTimeout(function(){ document.getElementById('createPost').style.display = "none"; }, 500);
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
			
			async function newBlogYear() {
				document.getElementById('newBlogyear').innerHTML = "Creating new year..."
				let formData = new FormData();
				formData.append('newyear', 'true');
				await fetch('#', {
					method: "POST",
					body: formData
				})
				document.getElementById('newBlogyear').innerHTML = "New year created!"
				document.getElementById('newBlogyear').setAttribute('onclick', '');
			}
			
			async function uploadMedia() {
				document.getElementById('mediaUpload').innerHTML = 'Uploading...'; // Saving text
				let formData = new FormData();
				formData.append("media", fileupload.files[0]);
				let response = window.prompt("Please enter the filename for the selected file. <strong>Remember to add the extension!</strong><br>Leave this blank to use the uploaded files filename.")
				if (response != null && response != "") { formData.append("name", response); } else { response = fileupload.files[0].name; }
				await fetch('#', {
					method: "POST",
					body: formData
				})
				document.getElementById('mediaUpload').innerHTML = 'Uploaded!'; // Saving text
				navigator.clipboard.writeText('<img src="https://amazinaxel.com/media/' + response + '">');
				setTimeout(function() {
					document.getElementById('mediaUpload').innerHTML = 'Text copied!';
				}, 500);
				setTimeout(function() {
					document.getElementById('mediaUpload').innerHTML = 'Upload another file';
				}, 1000);
			}
			
			window.onload = function() { if (window.location.toString().includes("openblog")) { setTimeout(function(){ showCreatePost(); }, 250); } }
		</script>
	</head>
	<body>
		<div class="card header" id="header" style="margin-top: 0; transition: height 0.4s cubic-bezier(0, 1.3, 0.4, 1) 0s; height: 130px;" id="header">
			<a class="button headerbtn" href="<? echo $domain ?>"> Blog </a>
			<h2 class="large button margin-top" id="showCreatePostBtn" onclick="showCreatePost()"> Create New Blog Post </h2>
			<div id="createPost" style="display: none; position: relative;" class="hide">
				<h2 style="margin-top: 10px;"> Title: <input type="text" name="date" value="" placeholder="Post title goes here" id="postTitle"> </h2>
				<textarea cols="40" id="data" name="data" rows="20" placeholder="Enter post text here" style="margin-bottom: 10px;"></textarea>
				<input type="file" name="fileupload" id="fileupload"><a id="mediaUpload" class="button" style="margin-left: 10px;" onclick="uploadMedia()">Upload Media</a>
				<a id="postSubmit" class="button" style="display: block; margin-top: 10px;" onclick="uploadPost()"> Save & Publish </a>
			</div>
		</div>
		<div class="row">
			<div class="leftcolumn">
			<div class="card"> <h1>Previous Blog Posts:</h1> </div>
				<?php 
					$postCount = 0;
				$lines = implode(file("../../../../domains/amazinaxel.com/public_html/index.html"));
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
				<a class="button" id="manageHTML" style="right: 8px;" href="https://amazinaxel.com/archives/"> View Archives </a>
				<div class="buttons"> <a class="button" id="manageHTML"> Edit Page HTML </a> </div> <!-- add href="https://alecshome.com/boba/media/ once finished -->
				</div>
			</div>
		<aside>
			<div class="card right">
				<a href="https://amazinaxel.com"><h2 class="large button margin-bottom"> View Blog Page </h2></a>
				<h2 class="large button margin-top">Edit Previous Posts</h2>
				<h2 class="large button margin-top" style="margin: 0" id="newBlogyear" onclick="newBlogYear()">Create New Blog Year</h2>
			</div>
			<div class="card right">
				<h2 class="button" style="margin: 0;"> Blogging Reference </h2>
				<textarea id="blogreference" name="data"><? echo file_get_contents("data/blogreference.txt"); ?></textarea>
				<a class="large button" onclick="saveNote('blogreference')" id="blogreferenceSubmit">Save</a>
			</div>
		</aside>
		</div>
	</body>
</html>