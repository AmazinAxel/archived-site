<? error_reporting(E_ALL);
ini_set('display_errors', true);
require('settings.php');
if (isset($_COOKIE['login']) != $password) {
	require 'login.php';
	die();
}
// WORK ON THE MEDIA PAGE!!!!! 

if (isset($_POST["alecdelete"])) {
	if (!unlink("../media/" . $_POST["alecdelete"])) {
		http_response_code(500);
		exit;
	} else { die('FAIL!'); }}
else if (isset($_POST["axeldelete"])) {
	if (!unlink("../../../../domains/amazinaxel.com/public_html/media/" . $_POST["axeldelete"])) {
		http_response_code(500);
		exit;
	} else { die('FAIL!'); }}
else if (isset($_POST["axelhotlinkdelete"])) {
	if (!unlink("../../../../domains/amazinaxel.com/public_html/media/hotlink-ok/" . $_POST["axelhotlinkdelete"])) {
		http_response_code(500);
		exit;
	} else { die('FAIL!'); }}


else if (isset($_FILES["alecfile"])) {
	if(!empty($_FILES["alecfile"]["name"])) {
		#$allowTypes = array('jpg','png','jpeg','gif','pdf');
		#if(in_array($fileType, $allowTypes)){
		if (!isset($_POST["alectitle"])) { $name = basename($_FILES["alecfile"]["name"]); } else { $name = $_POST["alectitle"]; }
		$tmp = explode('.', $_FILES["alecfile"]["name"]);
		$extension = end($tmp);

		if (move_uploaded_file($_FILES["alecfile"]["tmp_name"], "../media/" . $name . '.' . $extension)){
			die('SUCCESS');
		} else { http_response_code(501); /* Couldn't move file */ exit; }
	} else { http_response_code(501); /* No file uploaded */ exit; }
http_response_code(501); exit; } 

else if (isset($_FILES["axelfile"]) && isset($_POST['hotlink'])) {
	if(!empty($_FILES["axelfile"]["name"])) {
		#$allowTypes = array('jpg','png','jpeg','gif','pdf');
		#if(in_array($fileType, $allowTypes)){
		if (!isset($_POST["axeltitle"])) { $name = basename($_FILES["axelfile"]["name"]); } else { $name = $_POST["axeltitle"]; }
		$tmp = explode('.', $_FILES["axelfile"]["name"]);
		$extension = end($tmp);
		if ($_POST['hotlink'] == "true") { 
			if (move_uploaded_file($_FILES["axelfile"]["tmp_name"], "../../../../domains/amazinaxel.com/public_html/media/hotlink-ok/" . $name . '.' . $extension)){ die('SUCCESS'); } else { http_response_code(501); die(); }}
		else if ($_POST['hotlink'] == "false") { 
			if (move_uploaded_file($_FILES["axelfile"]["tmp_name"], "../../../../domains/amazinaxel.com/public_html/media/" . $name . '.' . $extension)){ die('SUCCESS'); } else { http_response_code(501); die(); }}
			
	} else { http_response_code(501); /* No file uploaded */ exit; }
http_response_code(501); exit; } 

include('other/header.php');
generateHeader('Media');
?>
<style>

			img {     margin-top: 10px;
				margin-bottom: 15px; }
			
			.card { height: fit-content; }
		</style>
		<script> 
			async function deleteMedia(string, number, type) {
				let formData = new FormData();
				document.getElementById(type + 'deleteFileBtn' + number).innerHTML = 'Deleting...';
				formData.append(type + "delete", string);
				await fetch('#', {
					method: "POST",
					body: formData
				})				
				document.getElementById(type + 'deleteFileBtn' + number).innerHTML = 'Deleted!';
			}
			
			function showUpload() {
				axelhideUpload();
				document.getElementById('alecnewUploadBtn').innerHTML = 'Cancel';
				document.getElementById('alecnewUploadBtn').setAttribute('onclick','hideUpload()');
				document.getElementById('alecnewMedia').style.display = "unset"
				document.getElementById('header').style.height = "280px"
				document.getElementById('alecnewMedia').classList.add('show');
				
			} function hideUpload() {
				document.getElementById('alecnewUploadBtn').innerHTML = 'AlecsHome.com';
				document.getElementById('alecnewUploadBtn').setAttribute('onclick','showUpload()');
				document.getElementById('header').style.height = "140px"
				document.getElementById('alecnewMedia').classList.remove('show');
				document.getElementById('alecnewMedia').style.display = "none";
				//setTimeout(function(){ document.getElementById('createPost').style.display = "none"; }, 500);
			}
			
			function axelshowUpload() {
				hideUpload();
				document.getElementById('axelnewUploadBtn').innerHTML = 'Cancel';
				document.getElementById('axelnewUploadBtn').setAttribute('onclick','axelhideUpload()');
				document.getElementById('axelnewMedia').style.display = "unset"
				document.getElementById('header').style.height = "330px"
				document.getElementById('axelnewMedia').classList.add('show');
				
			} function axelhideUpload() {
				document.getElementById('axelnewUploadBtn').innerHTML = 'AmazinAxel.com';
				document.getElementById('axelnewUploadBtn').setAttribute('onclick','axelshowUpload()');
				document.getElementById('header').style.height = "140px"
				document.getElementById('axelnewMedia').classList.remove('show');
				document.getElementById('axelnewMedia').style.display = "none";
				//setTimeout(function(){ document.getElementById('createPost').style.display = "none"; }, 500);
			}
			
			async function uploadMedia(type) {
				let formData = new FormData();
				formData.append(type + "file", document.getElementById(type + 'fileupload').files[0]);
				formData.append(type + "title", document.getElementById(type + 'mediaTitle').value);
				if (type == "axel") { formData.append("hotlink", document.getElementById('hotlink').checked); }
				document.getElementById(type + 'mediaSubmit').innerHTML = 'Uploading...'; // Saving text
				await fetch('#', {
					method: "POST",
					body: formData
				})
				console.log(document.getElementById('hotlink').checked);
				document.getElementById(type + 'mediaSubmit').innerHTML = 'Uploaded!'; // Saving text
				setTimeout(function() {
					let fileName = document.getElementById(type + 'fileupload').value;
					let extension = fileName.split('.')[1];
					document.getElementById(type + 'mediaSubmit').innerHTML = 'Copy';
					if (type == "alec") { document.getElementById(type + 'mediaSubmit').setAttribute("onclick", "copyLink(\'" + type + 'copyLinkBtn0\', \'https://alecshome.com/media/' + document.getElementById(type + 'mediaTitle').value + '.' + extension + "')"); }
					else if (type == "axel") { 
						if (document.getElementById('hotlink').checked == false) { document.getElementById(type + 'mediaSubmit').setAttribute("onclick", "copyLink(\'" + type + 'copyLinkBtn0\', \'https://amazinaxel.com/media/' + document.getElementById(type + 'mediaTitle').value + '.' + extension + "')"); }
						else if (document.getElementById('hotlink').checked == true) { document.getElementById(type + 'mediaSubmit').setAttribute("onclick", "copyLink(\'" + type + 'copyLinkBtn0\', \'https://amazinaxel.com/media/hotlink-ok/' + document.getElementById(type + 'mediaTitle').value + '.' + extension + "')"); }}
					document.getElementById(type + 'mediaSubmit').id = type + 'copyLinkBtn0';
				}, 1000);
			}
			
			window.onload = function() { if (window.location.toString().includes("amazinaxel")) { setTimeout(function(){ axelshowUpload(); }, 250); }
			else if (window.location.toString().includes("alecshome")) { setTimeout(function(){ showUpload(); }, 250); } }
		</script>
	</head>
	<body>
		<div class="card header" id="header" style="transition: height 0.4s cubic-bezier(0, 1.3, 0.4, 1) 0s; height: 140px;">
			<a class="button headerbtn" href="<? echo $domain ?>"> Media Manager </a>
		<div style="display: grid; grid-template-columns: 50% 50%; justify-content: center; margin-top: 10px;">
			<a id="alecnewUploadBtn" class="button" style="margin-right: 5px;" onclick="showUpload()"> AlecsHome.com </a> <a href="#" class="button" id="axelnewUploadBtn" style="margin-left: 5px;" onclick="axelshowUpload()"> AmazinAxel.com </a></div>
			<div id="alecnewMedia" style="display: none; position: relative;">
				<h2 style="margin-top: 10px;"> Title: <input type="text" name="date" value="" placeholder="Media filename goes here" id="alecmediaTitle"> </h2>
				<input type="file" name="fileupload" id="alecfileupload">
				<a id="alecmediaSubmit" class="large button margin-top" onclick="uploadMedia('alec')"> Save & Upload </a>
			</div>
			<div id="axelnewMedia" style="display: none; position: relative;">
				<h2 style="margin-top: 10px;"> Title: <input type="text" name="date" value="" placeholder="Media filename goes here" id="axelmediaTitle"> </h2>
				<input type="file" name="fileupload" id="axelfileupload">
				<br>
				<div style="margin-top: 15px; margin-bottom: 20px;"><label class="container" style="right: 60px;"><input type="checkbox" id="hotlink"><span class="checkmark"></span><h2 style="display: unset; position: absolute; width: 130px; margin: 0;"> Allow Hotlinking </h2></label></div>
				<a id="axelmediaSubmit" class="large button margin-top"onclick="uploadMedia('axel')"> Save & Upload </a>
			</div>
			<div id="uploadForm" style="display: none;">
				<form method="POST" enctype="multipart/form-data">
					<input type="file" name="fileupload" id="fileupload" style="margin-top: 10px;">
					<h2 style="margin: 0; margin-top: 5px;"> File Name: <input type="text" name="title" value="filename" id="fileName"> 
					<input type="submit" name="submit" value="Upload" onclick="uploadFile()" id="uploadFileBtn" class="button"></h2>
				</form>
			</div>
		</div>
		<? 
		# lets loop through all files in the /media directory and show the name of the item and allow them to delete it, copy link or open it. also ofc allow them to upload a file and change its name too
		?>
		<div class="row" style="grid-template-columns: auto auto; align-items: center;">
			<?php 
		$arrFiles = scandir('../media/');
		for ($i = 2; $i < count($arrFiles); $i++) { // CHANGE THE VALUE IF THERE ARE ISSUES WITH PERIODS / .htaccess
			#$data = explode("~", file_get_contents('../data/uploads/' . pathinfo($arrFiles[$i], PATHINFO_FILENAME) . ".txt"));
				#$size = $data[0];
				#$description = $data[1];
				#$date = $data[2];

				echo '<div class="card">
					<a id="downloadLink" href="https://alecshome.com/media/' . $arrFiles[$i] . '" class="large button" style="margin-bottom: 15px;">' . $arrFiles[$i] . '</a>
					<a href="https://alecshome.com/media/' . $arrFiles[$i] . '"> <img src="https://alecshome.com/media/' . $arrFiles[$i] . '" width="100%"></a>
					<a id="copyLinkBtn'. $i .'" onclick="copyLink(\'copyLinkBtn' . $i . '\', \'https://alecshome.com/media/' . $arrFiles[$i] . '\', ' . $i . ');" class="button">Copy Media Link</a>
					<a href="https://alecshome.com/media/' . $arrFiles[$i] . '" class="button" download>Download</a>
					<a id="alecdeleteFileBtn'. $i .'" class="button" onclick="deleteMedia(\'' . $arrFiles[$i] . '\', ' . $i . ', \'alec\');">Delete</a>
				</div>';}
			
		$arrFiles = scandir('../../../../domains/amazinaxel.com/public_html/media/');
		for ($i = 2; $i < count($arrFiles); $i++) { // CHANGE THE VALUE IF THERE ARE ISSUES WITH PERIODS / .htaccess
			if (!str_contains($arrFiles[$i], "htaccess") && !str_contains($arrFiles[$i], "hotlink-ok")) {
			#$data = explode("~", file_get_contents('../data/uploads/' . pathinfo($arrFiles[$i], PATHINFO_FILENAME) . ".txt"));
				#$size = $data[0];
				#$description = $data[1];
				#$date = $data[2];

				echo '<div class="card">
					<a id="downloadLink" href="https://amazinaxel.com/media/' . $arrFiles[$i] . '" class="large button" style="margin-bottom: 15px;">' . $arrFiles[$i] . ' (AmazinAxel.com)</a>
					
					<a id="axelcopyLinkBtn'. $i .'" onclick="copyLink(\'axelcopyLinkBtn' . $i . '\', \'https://amazinaxel.com/media/' . $arrFiles[$i] . '\', ' . $i . ');" class="button">Copy Media Link</a>
					<a href="https://amazinaxel.com/media/' . $arrFiles[$i] . '" class="button" download>Download</a>
					<a id="axeldeleteFileBtn'. $i .'" class="button" onclick="deleteMedia(\'' . $arrFiles[$i] . '\', ' . $i . ', \'axel\');">Delete</a>
				</div>';}}
			
		$arrFiles = scandir('../../../../domains/amazinaxel.com/public_html/media/hotlink-ok/');
		for ($i = 2; $i < count($arrFiles); $i++) { // CHANGE THE VALUE IF THERE ARE ISSUES WITH PERIODS / .htaccess
			if (!str_contains($arrFiles[$i], "htaccess")) {
				echo '<div class="card">
					<a id="downloadLink" href="https://amazinaxel.com/media/hotlink-ok/' . $arrFiles[$i] . '" class="large button" style="margin-bottom: 15px;">' . $arrFiles[$i] . ' (AmazinAxel.com, No Hotlink)</a>
					<a href="https://amazinaxel.com/media/hotlink-ok/' . $arrFiles[$i] . '"> <img src="https://amazinaxel.com/media/hotlink-ok/' . $arrFiles[$i] . '" width="100%"></a>
					<a id="copyHotlinkedBtn'. $i .'" onclick="copyLink(\'copyHotlinkedBtn' . $i . '\', \'https://amazinaxel.com/media/hotlink-ok/' . $arrFiles[$i] . '\', ' . $i . ');" class="button">Copy Media Link</a>
					<a href="https://amazinaxel.com/media/hotlink-ok/' . $arrFiles[$i] . '" class="button" download>Download</a>
					<a id="axelhotlinkdeleteFileBtn'. $i .'" class="button" onclick="deleteMedia(\'' . $arrFiles[$i] . '\', ' . $i . ', \'axelhotlink\');">Delete</a>
				</div>';}}
			?>

		<!-- ADD SOME MORE POLISH!
		Make this show that there are no files and hide this when headless mode is enabled!
		Dynamically update this number so that 1 is removed from it when a file is deleted and 1 is added when a file is added!
		Make above code sort through the things by date to give newest ones on top, and have EXTRA VERIFICATION SECURITY here!!!
		Add total file size statistic for the uploaded files!
		Add some SEO stuff for when you put the link in discord, including the name, description, filesize and stuff!
		makes things into a list or array instead of my current method and maybe use a database?!?!??
		add fileicons so that there are really cool small icons for different file types, includes on both the backend and frontent
		PHP HTML CSS ZIP SWF TXT OTHER NONE DOCX PNG JPG SVG GIF PPTX MP4 MP3 EXE RTF WEBP CSV JAR PDF
		INCLUDE FOR A FUTURE UPDATE! 


EXTRA NOTE JUST FOR MEDIA!!!! Turn the copy link function into using "this.id" instead of giving the name, it makes it more efficient. For example, instead of 
<a id="copyHotlinkedBtn1" onclick="copyLink('copyHotlinkedBtn1, 'https://amazinaxel.com/media/hotlink-ok/eggdog', 3');" class="button">Copy Media Link</a> 
it becomes
<a id="copyHotlinkedBtn1" onclick="copyLink('this.id, 'https://amazinaxel.com/media/hotlink-ok/eggdog', 3');" class="button">Copy Media Link</a> 
fix the copyLink function to be able to do this!!!
-->
		<!-- <div class="card left">
			<? $fileCount = new FilesystemIterator("../media/", FilesystemIterator::SKIP_DOTS);
			echo "<a><strong>" . iterator_count($fileCount) . "</strong> total files in the Media directory"; 
			// using 'a' instead of p will fix the button glitch but makes the code not w3 certified anymore, fix in future update ?>
			<div class="buttons"> <a class="button">Modify Registry Values</a> </div>
		</div> -->
		</div> 
	</body>
</html>