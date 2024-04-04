<?php 
error_reporting(E_ALL);
ini_set('display_errors', true);
require('settings.php');
if (isset($_COOKIE['login']) != $password) {
	require 'login.php';
	die();
}


if (isset($_POST["delete"])) {
	if (!unlink("../downloads/" . $_POST["delete"])) {
		http_response_code(500);
		exit;
		}
	if (!unlink("data/uploads/" . $_POST["delete"] . ".txt")) {
		http_response_code(500);
		exit;
	} else { exit; }
} else if (isset($_POST["axeldelete"])) {
	if (!unlink("../../../amazinaxel.com/public_html/downloads/" . $_POST["axeldelete"])) {
		http_response_code(500);
		exit;
		}
	if (!unlink("data/amazinaxel/uploads/" . $_POST["axeldelete"] . ".txt")) {
		http_response_code(500);
		exit;
	} else { exit; }
}


if (isset($_FILES["alecfile"])) {
	if(!empty($_FILES["alecfile"]["name"])) {
		#$allowTypes = array('jpg','png','jpeg','gif','pdf');
		#if(in_array($fileType, $allowTypes)){
		if (!isset($_POST["name"])) { $name = basename($_FILES["alecfile"]["name"]); } else { $name = $_POST["name"]; }
		$tmp = explode('.', $_FILES["alecfile"]["name"]);
		$extension = end($tmp);

		if (move_uploaded_file($_FILES["alecfile"]["tmp_name"], "../downloads/" . $name . '.' . $extension)){

			function human_filesize($bytes, $decimals = 2) {
				$size   = array('Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
				$factor = floor((strlen($bytes) - 1) / 3);
				return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
			}

			// Grab sent information
			$size = human_filesize(filesize("../downloads/" . $name . '.' . $extension));
			$description = $_POST["description"];
			$date = date("M jS, Y \a\\t g:i A");

			$file = fopen('data/uploads/' . $name . '.' . $extension . ".txt", 'w'); // Change which folder data is stored in
			fwrite($file, $size . '~' . $description . '~' . $date); // Add content
			fclose($file); // Close

			exit;
		} else { http_response_code(501); /* Couldn't move file */ exit; }
	} else { http_response_code(501); /* No file uploaded */ exit; }
http_response_code(501); exit; } else if (isset($_FILES["axelfile"])) {
	if(!empty($_FILES["axelfile"]["name"])) {
		#$allowTypes = array('jpg','png','jpeg','gif','pdf');
		#if(in_array($fileType, $allowTypes)){
		if (!isset($_POST["name"])) { $name = basename($_FILES["axelfile"]["name"]); } else { $name = $_POST["name"]; }
		$tmp = explode('.', $_FILES["axelfile"]["name"]);
		$extension = end($tmp);

		if (move_uploaded_file($_FILES["axelfile"]["tmp_name"], "../../../amazinaxel.com/public_html/downloads/" . $name . '.' . $extension)){

			function human_filesize($bytes, $decimals = 2) {
				$size   = array('Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
				$factor = floor((strlen($bytes) - 1) / 3);
				return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
			}

			// Grab sent information
			$size = human_filesize(filesize("../../../amazinaxel.com/public_html/downloads/" . $name . '.' . $extension));
			$description = $_POST["description"];
			$date = date("M jS, Y \a\\t g:i A");

			$file = fopen('data/amazinaxel/uploads/' . $name . '.' . $extension . ".txt", 'w'); // Change which folder data is stored in
			fwrite($file, $size . '~' . $description . '~' . $date); // Add content
			fclose($file); // Close

			exit;
		} else { http_response_code(501); /* Couldn't move file */ exit; }
	} else { http_response_code(501); /* No file uploaded */ exit; }
http_response_code(501); exit; } 
include('other/header.php');
generateHeader('Quickshare'); ?>
		<style>
			.buttons { position: relative; top: -24px; margin-right: -7px; } 
			@media (max-width: 800px) {
.listText {
    width: 100%;
    display: block;
    text-align: center;
			} .buttons { top: unset; }	}
			
			
			
			
			.show { position: relative; } /* MIGHT WANT TO ADD THIS PIECE OF CODE TO ALL OF THE CSS FILES IF IT WORKS!!!!! */
</style>
		<script>
			function showUpload() {
				cancelAxelUpload();
				document.getElementById('alecuploadForm').style.display = 'revert';
				document.getElementById('alecUpload').setAttribute("onclick", "cancelUpload()");
				document.getElementById('alecUpload').innerHTML = 'Cancel Upload';
				document.getElementById('header').style.height = '335px';
				document.getElementById('alecuploadForm').classList.add('show');
			}
			function cancelUpload() {
				document.getElementById('alecuploadForm').style.display = 'none';
				document.getElementById('alecUpload').setAttribute("onclick", "showUpload()");
				document.getElementById('alecUpload').innerHTML = 'AlecsHome.com';
				document.getElementById('header').style.height = '135px';
				document.getElementById('alecuploadForm').classList.remove('show'); 
			}
			
			function showAxelUpload() {
				cancelUpload();
				document.getElementById('axeluploadForm').style.display = 'revert';
				document.getElementById('axelUpload').setAttribute("onclick", "cancelAxelUpload()");
				document.getElementById('axelUpload').innerHTML = 'Cancel Upload';
				document.getElementById('header').style.height = '335px';
				document.getElementById('axeluploadForm').classList.add('show');
			}
			function cancelAxelUpload() {
				document.getElementById('axeluploadForm').style.display = 'none';
				document.getElementById('axelUpload').setAttribute("onclick", "showAxelUpload()");
				document.getElementById('axelUpload').innerHTML = 'AmazinAxel.com';
				document.getElementById('header').style.height = '135px';
				document.getElementById('axeluploadForm').classList.remove('show');
			}

			async function uploadFile(type) {
				event.preventDefault(); // Prevent auto reload of page
				let formData = new FormData();
				formData.append(type + "file", document.getElementById(type + 'fileupload').files[0]);
				formData.append("description", document.getElementById(type + 'fileDescription').value);
				formData.append("name", document.getElementById(type + 'fileName').value);
				document.getElementById(type + 'uploadFileBtn').value = 'Uploading...'; // Saving text
				await fetch('#', {
					method: "POST",
					body: formData
				})
				document.getElementById(type + 'uploadFileBtn').value = 'Uploaded!'; // Saving text
				setTimeout(function() {
					document.getElementById(type + 'uploadFileBtn').value = 'Copy';
					if (type == "axel") { document.getElementById(type + 'uploadFileBtn').setAttribute("onclick", "copyNewAxelLink('" + type + "')"); }
					else if (type == "alec") { document.getElementById(type + 'uploadFileBtn').setAttribute("onclick", "copyNewLink('" + type + "')"); }
				}, 1000);
			}

			async function copyLink(number) {
				navigator.clipboard.writeText(document.getElementById('downloadLink' + number).getAttribute("href"))
				document.getElementById('copyLinkBtn' + number).innerHTML = 'Copied!';
				setTimeout(function() {
					document.getElementById('copyLinkBtn' + number).innerHTML = 'Copy';
				}, 2000);
			}
			
			async function copyAxelLink(number) {
				navigator.clipboard.writeText(document.getElementById('downloadAxelLink' + number).getAttribute("href"))
				document.getElementById('axelcopyLinkBtn' + number).innerHTML = 'Copied!';
				setTimeout(function() {
					document.getElementById('axelcopyLinkBtn' + number).innerHTML = 'Copy';
				}, 2000);
			}

			async function copyNewLink() {
				event.preventDefault(); // Prevent auto reload of page
				let fileName = document.getElementById('alecfileupload').value;
				let extension = fileName.split('.')[1];
				navigator.clipboard.writeText("https://alecshome.com/download?file=" + document.getElementById('fileName').value + "." + extension);
				document.getElementById('alecuploadFileBtn').value = 'Copied!';
				setTimeout(function() {
					document.getElementById('alecuploadFileBtn').value = 'Copy';
				}, 2000);
			}
			
			async function copyNewAxelLink() {
				event.preventDefault(); // Prevent auto reload of page
				let fileName = document.getElementById('axelfileupload').value;
				let extension = fileName.split('.')[1];
				navigator.clipboard.writeText("https://amazinaxel.com.com/download?file=" + document.getElementById('axelfileName').value + "." + extension);
				document.getElementById('axeluploadFileBtn').value = 'Copied!';
				setTimeout(function() {
					document.getElementById('axeluploadFileBtn').value = 'Copy';
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
			
			async function deleteAxelFile(number) {
				document.getElementById('axeldeleteFileBtn' + number).innerHTML = 'Deleting...'; // Saving text
				let formData = new FormData();
				console.log(document.getElementById('downloadAxelLink' + number).innerHTML);
				formData.append("axeldelete", document.getElementById('downloadAxelLink' + number).innerHTML);
				await fetch('#', {
					method: "POST",
					body: formData
				})
				document.getElementById('axeldeleteFileBtn' + number).innerHTML = 'Deleted!'; // Saving text
			}
			
			window.onload = function() { if (window.location.toString().includes("openupload")) { setTimeout(function(){ showUpload(); }, 250); } else if (window.location.toString().includes("axelupload")) { setTimeout(function(){ showAxelUpload(); }, 250); } }
		</script>
	</head>
	<body>
			<? #include("settings.php"); if ($headless == true) { die('<br><h2 style="margin: 0;">Headless Mode is enabled, so this feature is disabled.</h2>'); } ?>
			<div class="card header" id="header" style="transition: height 0.4s cubic-bezier(0, 1.3, 0.4, 1) 0s; height: 135px;">
				<a class="button headerbtn" href="<? echo $domain ?>"> File Sharing </a>
				<div style="display: grid; grid-template-columns: 50% 50%; justify-content: center; margin-top: 10px;">
					<a id="alecUpload" class="button" style="margin-right: 5px;" onclick="showUpload()">AlecsHome.com</a> 
					<a class="button" id="axelUpload" style="margin-left: 5px;" onclick="showAxelUpload()">AmazinAxel.com</a>
				</div>
			<div id="alecuploadForm" style="display: none;">
				<form method="POST" enctype="multipart/form-data">
				<input type="file" name="fileupload" id="alecfileupload" style="margin-top: 10px;">
				<textarea id="alecfileDescription" name="description" style="height: 100px; resize: none;">This is some description that I have created</textarea>
				<h2 style="margin: 0; margin-top: 5px;"> File Name: <input type="text" name="title" value="filename" id="alecfileName"> <input type="submit" name="submit" value="Upload" onclick="uploadFile('alec')" id="alecuploadFileBtn" class="button"></h2></form></div>
			<div id="axeluploadForm" style="display: none;">
				<form method="POST" enctype="multipart/form-data">
				<input type="file" name="fileupload" id="axelfileupload" style="margin-top: 10px;">
				<textarea id="axelfileDescription" name="description" style="height: 100px; resize: none;">This is some description that I have created</textarea>
				<h2 style="margin: 0; margin-top: 5px;"> File Name: <input type="text" name="title" value="filename" id="axelfileName"> <input type="submit" name="submit" value="Upload" onclick="uploadFile('axel')" id="axeluploadFileBtn" class="button"></h2>
				</form></div>
		</div>
		<?php 
		$arrFiles = scandir('data/uploads/');
		function get_string_between($string, $start, $end){
			$string = ' ' . $string;
			$ini = strpos($string, $start);
			if ($ini == 0) return '';
			$ini += strlen($start);
			$len = strpos($string, $end, $ini) - $ini;
			return substr(substr($string, $ini, $len), 0, -6);
		}

		for ($i = 2; $i < count($arrFiles); $i++) { // CHANGE THE VALUE IF THERE ARE ISSUES WITH PERIODS / .htaccess
			$data = explode("~", file_get_contents('data/uploads/' . pathinfo($arrFiles[$i], PATHINFO_FILENAME) . ".txt"));
				$size = $data[0];
				$description = $data[1];
				$date = $data[2];

				echo '<div class="card left">
					<p class="listText"><a id="downloadLink' . $i . '" href="https://alecshome.com/download?file=' . substr($arrFiles[$i], 0, -4) . '">'. pathinfo($arrFiles[$i], PATHINFO_FILENAME) .'</a> ('. $date .') | AlecsHome.com</p>
					<div class="buttons">
						<a id="copyLinkBtn'. $i .'" class="button" onclick="copyLink(' . $i . ')">Copy</a>
						<a href="https://alecshome.com/downloads/' . substr($arrFiles[$i], 0, -4) . '" class="button" download>Download</a>
						<a id="deleteFileBtn'. $i .'" class="button" onclick=deleteFile(' . $i . ')>Delete</a>
					</div>
				</div>';} 
		
		$arrFiles = scandir('data/amazinaxel/uploads/');
		for ($i = 2; $i < count($arrFiles); $i++) { // CHANGE THE VALUE IF THERE ARE ISSUES WITH PERIODS / .htaccess
			$data = explode("~", file_get_contents('data/amazinaxel/uploads/' . pathinfo($arrFiles[$i], PATHINFO_FILENAME) . ".txt"));
				$size = $data[0];
				$description = $data[1];
				$date = $data[2];

				echo '<div class="card left">
					<p class="listText"><a id="downloadAxelLink' . $i . '" href="https://amazinaxel.com/download?file=' . substr($arrFiles[$i], 0, -4) . '">'. pathinfo($arrFiles[$i], PATHINFO_FILENAME) .'</a> ('. $date .') | AmazinAxel.com</p>
					<div class="buttons">
						<a id="axelcopyLinkBtn'. $i .'" class="button" onclick="copyAxelLink(' . $i . ')">Copy</a>
						<a href="https://amazinaxel.com/downloads/' . substr($arrFiles[$i], 0, -4) . '" class="button" download>Download</a>
						<a id="axeldeleteFileBtn'. $i .'" class="button" onclick=deleteAxelFile(' . $i . ')>Delete</a>
					</div>
				</div>';
		
		} ?>

		<!-- ADD SOME MORE POLISH!
		Make this show that there are no files and hide this when headless mode is enabled!
		Dynamically update this number so that 1 is removed from it when a file is deleted and 1 is added when a file is added!
		Make above code sort through the things by date to give newest ones on top, and have EXTRA VERIFICATION SECURITY here!!!
		Add total file size statistic for the uploaded files!
		Add some SEO stuff for when you put the link in discord, including the name, description, filesize and stuff!
		makes things into a list or array instead of my current method and maybe use a database?!?!??
		add fileicons so that there are really cool small icons for different file types, includes on both the backend and frontent
		PHP HTML CSS ZIP SWF TXT OTHER NONE DOCX PNG JPG SVG GIF PPTX MP4 MP3 EXE RTF WEBP CSV JAR PDF
		INCLUDE FOR A FUTURE UPDATE! -->
		<div class="card left">
			<? $fileCount = new FilesystemIterator("../downloads/", FilesystemIterator::SKIP_DOTS);
			$registerCount = new FilesystemIterator("data/uploads/", FilesystemIterator::SKIP_DOTS);
			$axelfileCount = new FilesystemIterator("../../../amazinaxel.com/public_html/downloads/", FilesystemIterator::SKIP_DOTS);
			$axelregisterCount = new FilesystemIterator("data/amazinaxel/uploads/", FilesystemIterator::SKIP_DOTS);
			echo "<a class='listText'><strong>" . iterator_count($fileCount) - 1 + iterator_count($axelfileCount) - 1 . "</strong> total file(s) in the download directory | <strong>" . iterator_count($registerCount) + iterator_count($axelregisterCount) . "</strong> file(s) registered in the database</a>"; 
			// using 'a' instead of p will fix the button glitch but makes the code not w3 certified anymore, fix in future update ?>
			<div class="buttons" style="top: 0"> <a class="button">Modify Registry Values</a> </div>
		</div>
	</body>
</html>