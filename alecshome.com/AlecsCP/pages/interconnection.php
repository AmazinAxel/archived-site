<?php 
error_reporting(E_ALL);
ini_set('display_errors', true);
require('settings.php');
if (isset($_COOKIE['login']) != $password) {
	require 'login.php';
	die();
}

if (isset($_POST["delete"])) {
	if (!unlink("data/interconnection/" . $_POST["delete"])) {
		http_response_code(500);
		exit;
	} else {exit;}}

if (isset($_FILES["file"])) {
	if(!empty($_FILES["file"]["name"])) {
		if (!isset($_POST["name"])) { $name = basename($_FILES["file"]["name"]); } else { $name = $_POST["name"]; }
		$tmp = explode('.', $_FILES["file"]["name"]);
		$extension = end($tmp);

		if (move_uploaded_file($_FILES["file"]["tmp_name"], "data/interconnection/" . $name . '.' . $extension)){

			#function human_filesize($bytes, $decimals = 2) {
			#	$size   = array('Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
			#	$factor = floor((strlen($bytes) - 1) / 3);
			#	return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
			#}

			// Grab sent information
			#$size = human_filesize(filesize("../../downloads/" . $name . '.' . $extension));
			#$date = date("M jS, Y \a\\t g:i A");

			#$file = fopen('../data/uploads/' . $name . '.' . $extension . ".txt", 'w'); // Change which folder data is stored in
			#fwrite($file, $size . '~' . $date); // Add content
			#fclose($file); // Close

			exit;
		} else { http_response_code(501); /* Couldn't move file */ exit; }
	} else { http_response_code(501); /* No file uploaded */ exit; }
	http_response_code(501); exit; } 

include('other/header.php');
generateHeader('Interconnection'); ?>
		<style>
			.fixbuttons { position: relative; top: -18px; } 
			@media (max-width: 800px) {
.listText {
    width: 100%;
    display: block;
    text-align: center;
				}	.fixbuttons { top: unset; }}
</style>
		<script>
			function showUpload() {
				document.getElementById('uploadForm').style.display = 'revert';
				document.getElementById('newUploadBtn').setAttribute("onclick", "cancelUpload()");
				document.getElementById('newUploadBtn').innerHTML = 'Cancel Upload';
				document.getElementById('header').style.height = '173px';
			}
			function cancelUpload() {
				document.getElementById('uploadForm').style.display = 'none';
				document.getElementById('newUploadBtn').setAttribute("onclick", "showUpload()");
				document.getElementById('newUploadBtn').innerHTML = 'Upload File';
				document.getElementById('header').style.height = '84px';
			}

			async function uploadFile() {
				event.preventDefault(); // Prevent auto reload of page
				let formData = new FormData();
				formData.append("file", fileupload.files[0]);
				formData.append("name", document.getElementById('fileName').value);
				document.getElementById('uploadFileBtn').value = 'Uploading...'; // Saving text
				await fetch('#', {
					method: "POST",
					body: formData
				})
				document.getElementById('uploadFileBtn').value = 'Uploaded!'; // Saving text
				setTimeout(function() {
					document.getElementById('uploadFileBtn').value = 'Copy';
					document.getElementById('uploadFileBtn').setAttribute("onclick", "copyNewLink()");
				}, 1000);
			}

			async function copyLink(number) {
				navigator.clipboard.writeText(document.getElementById('downloadLink' + number).getAttribute("href"))
				document.getElementById('copyLinkBtn' + number).innerHTML = 'Copied!';
				setTimeout(function() {
					document.getElementById('copyLinkBtn' + number).innerHTML = 'Copy';
				}, 2000);
			}

			async function copyNewLink() {
				event.preventDefault(); // Prevent auto reload of page
				let fileName = document.getElementById('fileupload').value;
				let extension = fileName.split('.')[1];
				navigator.clipboard.writeText("<? echo $domain ?>/data/interconnection/" + document.getElementById('fileName').value + "." + extension);
				document.getElementById('uploadFileBtn').value = 'Copied!';
				setTimeout(function() {
					document.getElementById('uploadFileBtn').value = 'Copy';
				}, 2000);
			}

			async function deleteFile(number) {
				document.getElementById('deleteFileBtn' + number).innerHTML = 'Deleting...'; // Saving text
				let formData = new FormData();
				console.log(document.getElementById('downloadLink' + number).innerHTML);
				formData.append("delete", document.getElementById('downloadLink' + number).innerHTML);
				await fetch('#', {
					method: "POST",
					body: formData
				})
				document.getElementById('deleteFileBtn' + number).innerHTML = 'Deleted!'; // Saving text
			}
		</script>
	</head>
	<body>
		<div class="card" id="header" style="margin: 0; height: 84px; transition: height 0.4s cubic-bezier(0, 1.3, 0.4, 1) 0s;">
			<a class="button headerbtn" href="<? echo $domain ?>"> Interconnection </a>
			<a id="newUploadBtn" class="large button margin-top" onclick="showUpload()"> Upload New File </a>
			<div id="uploadForm" style="display: none;">
				<form method="POST" enctype="multipart/form-data">
					<input type="file" name="fileupload" id="fileupload" style="margin-top: 10px;">
					<h2 style="margin: 0; margin-top: 5px;"> File Name: <input type="text" name="title" value="filename" id="fileName"> <input type="submit" name="submit" value="Upload" onclick="uploadFile()" id="uploadFileBtn" class="button"></h2>
				</form>
			</div>
		</div>
		<?php 
		$arrFiles = scandir('data/interconnection/');

		for ($i = 2; $i < count($arrFiles); $i++) { // CHANGE THE VALUE IF THERE ARE ISSUES WITH PERIODS / .htaccess
			echo '<div class="card left">
					<p class="listText"><a id="downloadLink' . $i . '" href="' . $data .'/data/interconnection/' . $arrFiles[$i] . '">'. $arrFiles[$i] .'</a> ('. date("M jS, Y \a\\t g:i A", filemtime('data/interconnection/' . $arrFiles[$i])) .')</p>
					<div class="buttons fixbuttons">
						<a id="copyLinkBtn'. $i .'" class="button" onclick="copyLink(' . $i . ')">Copy</a>
						<a href="'. $data . '/data/interconnection/' . $arrFiles[$i] . '" class="button" download>Download</a>
						<a id="deleteFileBtn'. $i .'" class="button" onclick=deleteFile(' . $i . ')>Delete</a>
					</div>
				</div>';} ?>
		<div class="card left">
			<? $fileCount = new FilesystemIterator("data/interconnection/", FilesystemIterator::SKIP_DOTS);
			echo "<a class='listText'><strong>" . iterator_count($fileCount) . "</strong> total file(s) in the interconn directory</a>";
			// using 'a' instead of p will fix the button glitch but makes the code not w3 certified anymore, fix in future update ?>
			<div class="buttons"> <a class="button"> View in File Explorer </a> </div>
		</div>
	</body>
</html>