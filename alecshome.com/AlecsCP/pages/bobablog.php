<?php 
error_reporting(E_ALL); // add error reporting for the backend page
ini_set('display_errors', true); // error reporting
include('../../../../domains/amazinaxel.com/public_html/boba/postRenderer.php'); // include library
require 'settings.php'; # This is the updated and fixed code. Put this on every page!
if (isset($_COOKIE['login']) != $password) {
	require('login.php');
	die();
}
# ADD HTTP HEADERS FOR ERRORS / NON ERRORS!
if (isset($_FILES['media'])) { // HANDLE UPLOADED MEDIA
	if (isset($_POST['post'])) {
		if(!empty($_FILES["media"]["name"])) {
			#$allowTypes = array('jpg','png','jpeg','gif','pdf');
			#if(in_array($fileType, $allowTypes)){
			$tmp = explode('.', $_FILES["media"]["name"]);
			$extension = end($tmp);
			if (!is_dir('../../../../domains/amazinaxel.com/public_html/media/' . $_POST["post"])) { mkdir('../../../../domains/amazinaxel.com/public_html/boba/media/' . $_POST["post"]); } // Make directory
			if (move_uploaded_file($_FILES["media"]["tmp_name"], "../../../../domains/amazinaxel.com/public_html/boba/media/" . $_POST["post"] . '/' . $_FILES["media"]["name"])){
				die('SUCCESS');
			} else { http_response_code(501); /* Couldn't move file */ exit; }
		} else { http_response_code(501); /* No file uploaded */ exit; }
		http_response_code(501); exit; }

} else if (isset($_FILES['postImg'])) { // HANDLE POST MEDIA
	if (isset($_POST['post'])) {
		if(!empty($_FILES["postImg"]["name"])) {
			#$allowTypes = array('jpg','png','jpeg','gif','pdf');
			#if(in_array($fileType, $allowTypes)){
			$file = glob('../../../../domains/amazinaxel.com/public_html/boba/media/' . $_POST['post'] . '*');

			foreach ($file as $postImg) { unlink($postImg); } // Delete previous post image
			$tmp = explode('.', $_FILES["postImg"]["name"]);
			$extension = end($tmp);
			if (move_uploaded_file($_FILES["postImg"]["tmp_name"], "../../../../domains/amazinaxel.com/public_html/boba/media/" . $_POST["post"] . '.' . $extension)){
				die('SUCCESS');
			} else { http_response_code(501); /* Couldn't move file */ exit; }
		} else { http_response_code(501); /* No file uploaded */ exit; }
		http_response_code(501); exit; }

} else if (isset($_GET['edit'])) { // HANDLE POST EDITING
	if (isset($_POST['post'])) {
		$possible_files = glob('../../../../domains/amazinaxel.com/public_html/boba/posts/*' . $_GET['edit'] . '.md');
		if (count($possible_files) > 0) {
			$file = fopen($possible_files[0], "w");
			fwrite($file, $_POST['post']);
			fclose($file);
			die("SUCCESS"); // Exit & don't send / process any extra data / wrap up all PHP processes
	}}

} else if (isset($_POST['title'])) { // HANDLE POST CREATION
	if (isset($_POST['post']) && isset($_POST['slug']) && isset($_POST['author'])) {
		if ($_POST['author'] == 'None') { $author = "  \n"; }
		else { $author = "\nAuthor: " . $_POST['author'] . "  \n"; }
		$file = fopen('../../../../domains/amazinaxel.com/public_html/boba/posts/' . date('Y-n-j') . '_'. $_POST['slug'] . '.md', "w");
		fwrite($file, "# " . $_POST['title'].$author . $_POST['post']);
		fclose($file);
		die("SUCCESS"); // Exit & don't send / process any extra data / wrap up all PHP processes
	}

} else if (isset($_POST['delete'])) { // HANDLE POST DELETION
	$possible_files = glob('../../../../domains/amazinaxel.com/public_html/boba/posts/*' . $_POST['delete'] . '.md');
	if (count($possible_files) > 0) {
		if (unlink($possible_files[0])) {
			die("SUCCESS"); // Exit & don't send / process any extra data / wrap up all PHP processes
		} else {
			die("ERROR");
		}}
} else if (isset($_POST['bio'])) {
	if (isset($_POST['author'])) {
		$file = fopen('../../../../domains/amazinaxel.com/public_html/boba/data/' . $_POST['author'] . '.html', "w");
		fwrite($file, $_POST['bio']);
		fclose($file);
		die("SUCCESS");
}} include('other/header.php');
generateHeader('Boba Blog'); ?>
		<style>
			.buttons { position: relative; top: -20px; margin-right: -9px; } 
			

			@media (max-width: 800px) {
.listText {
    width: 100%;
    display: block;
    text-align: center;
				}	.buttons { top: unset; }}
</style>
		<script>
			async function uploadPost(name) {
				document.getElementById('postSubmit').innerHTML = "Saving..."
				let formData = new FormData();
				formData.append('post', document.getElementById('data').value);
				if (window.location.toString().includes("edit")) { // If not editing a post, add the post title
					formData.append('edit', document.getElementById('editID').innerHTML);
				} else {
					formData.append('title', document.getElementById('postTitle').value);
					formData.append('slug', document.getElementById('postSlug').value);
					if (window.author == undefined){ window.author = 'None'; }
					formData.append('author', window.author);
				}
				await fetch('#', {
					method: "POST",
					body: formData
				})
				document.getElementById('postSubmit').innerHTML = "Saved!"
				setTimeout(function() {
					document.getElementById('postSubmit').innerHTML = 'Save';
				}, 2000);
			}

			async function deletePost(btnId, postID) {
				console.log("DeletePostBtn" + btnId)
				document.getElementById("deletePostBtn" + btnId).innerHTML = "Deleting..."
				let formData = new FormData();
				formData.append('delete', postID);
				await fetch('#', {
					method: "POST",
					body: formData
				})
				document.getElementById("deletePostBtn" + btnId).innerHTML = "Deleted!"
			}

			async function uploadMedia() {
				document.getElementById('mediaUpload').innerHTML = 'Uploading...'; // Saving text
				let formData = new FormData();
				formData.append("media", fileupload.files[0]);
				if (window.location.toString().includes("edit")) { // If not editing a post, add the post title
					formData.append('post', document.getElementById('editID').innerHTML);
					var postName = document.getElementById('editID').innerHTML;
				} else { // creating a post
					formData.append('post', document.getElementById('postSlug').value);
					var postName = document.getElementById('postSlug').value;
				}
				await fetch('#', {
					method: "POST",
					body: formData
				})
				document.getElementById('mediaUpload').innerHTML = 'Uploaded!'; // Saving text
				navigator.clipboard.writeText("![Alt Text goes here](https://amazinaxel.com/boba/media/" + postName + "/" + fileupload.files[0].name + ' "Title goes here")');
				setTimeout(function() {
					document.getElementById('mediaUpload').innerHTML = 'Text copied!';
				}, 500);
				setTimeout(function() {
					document.getElementById('mediaUpload').innerHTML = 'Upload another file';
				}, 1000);
			}

			async function uploadPostImg() {
				document.getElementById('postimgUpload').innerHTML = 'Uploading...'; // Saving text
				let formData = new FormData();
				formData.append("postImg", postimgupload.files[0]);
				if (window.location.toString().includes("edit")) { // If not editing a post, add the post title
					formData.append('post', document.getElementById('editID').innerHTML);
				} else { // creating a post
					formData.append('post', document.getElementById('postSlug').value);
				}
				await fetch('#', {
					method: "POST",
					body: formData
				})
				document.getElementById('postimgUpload').innerHTML = 'Post Image Uploaded!'; // Saving text
				setTimeout(function() {
					document.getElementById('postimgUpload').innerHTML = 'Upload new Post Image';
				}, 2000);
			} // if editing, then get the post ID, if not, get the post name through the SLUG!

			function showCreatePost() {
				hideBio();
				document.getElementById('showCreatePostBtn').innerHTML = 'Cancel Post';
				document.getElementById('showCreatePostBtn').setAttribute('onclick','cancelCreatePost()');
				document.getElementById('createPost').style.display = "unset"
				document.getElementById('header').style.height = "565px"
				document.getElementById('createPost').classList.add('show');
			} function cancelCreatePost() {
				document.getElementById('showCreatePostBtn').innerHTML = 'Create New Post';
				document.getElementById('showCreatePostBtn').setAttribute('onclick','showCreatePost()');
				document.getElementById('createPost').style.display = "none"
				document.getElementById('header').style.height = "135px"
				document.getElementById('createPost').classList.remove('show');
			}

			function showBio() {
				cancelCreatePost();
				document.getElementById('showBioBtn').innerHTML = 'Cancel Bio';
				document.getElementById('showBioBtn').setAttribute('onclick','hideBio()');
				document.getElementById('editBio').style.display = "unset";
				document.getElementById('header').style.height = "340px"
				document.getElementById('editBio').classList.add('show');
			} function hideBio() {
				document.getElementById('showBioBtn').innerHTML = 'Manage Bio';
				document.getElementById('showBioBtn').setAttribute('onclick','showBio()');
				document.getElementById('editBio').style.display = "none";
				document.getElementById('header').style.height = "135px"
				document.getElementById('editBio').classList.remove('show');
			}

			async function saveBio(id) {
				document.getElementById(id + 'Save').innerHTML = "Saving...";
				let formData = new FormData();
				formData.append("author", id);
				formData.append("bio", document.getElementById(id).value);
				await fetch('#', {
					method: "POST",
					body: formData
				})
				document.getElementById(id + 'Save').innerHTML = "Saved!";
				setTimeout(function() {
					document.getElementById(id + 'Save').innerHTML = "Save";
				}, 1000);
			}

			async function selectAuthor(id) {
				window.author = id;
				document.getElementById('authorMesage').innerHTML = "Author set to: " + window.author;
				if (window.author == "None") { document.getElementById('authorMesage').innerHTML = "No author selected!"; }
			}
			window.onload = function() { if (window.location.toString().includes("openblog")) { setTimeout(function(){ showCreatePost(); }, 250); } }
		</script>
	</head>
	<body>
		<?  if (isset($_GET['edit'])){ $possible_files = 0; $possible_files = glob('../../../../domains/amazinaxel.com/public_html/boba/posts/*' . $_GET['edit'] . '.md'); // ADD A TITLE SYSTEM SO YOU CAN EDIT THE TITLE WITHOUT HAVING TO ADD THE # BEFORE IT!
			if (count($possible_files) > 0) {
				$date_time = getPostDateTime(basename($possible_files[0]));
				$markdown = file_get_contents($possible_files[0]);
				$postTitle = getPostTitle($markdown);
				$fileName = explode("_", substr($possible_files[0], 0, -3));
				$fileName = $fileName[1];
				echo '<div class="card">
				<a class="button headerbtn" href="?boba" id="editingPostBtn"> Boba Blog | Editing: ' . $postTitle . '</a>
				<p id="editID" style="display: none;">'. $fileName .'</p>
				<textarea cols="40" id="data" name="data" rows="20">'. $markdown .'</textarea>
				<input type="file" name="fileupload" id="fileupload" style="margin-top: 10px;">
				<a id="mediaUpload" class="button" style="margin-top: 10px;" onclick="uploadMedia()"> Upload Media </a>
				<br><input type="file" name="postimgupload" id="postimgupload" style="margin-top: 10px;">
				<a id="postimgUpload" class="button" style="margin-top: 10px;" onclick="uploadPostImg()"> Upload Post Image </a>
				<a id="postSubmit" class="button" style="display: block; margin-top: 10px;" onclick="uploadPost()"> Save & Update </a>
				<a id="postSubmit" class="button" style="display: block; margin-top: 10px;" href="?bobablog"> Cancel & Exit </a>
			</div>';
				die('</div></body></html>');
			} else { echo '<div class="card"><a href="' . $domain . '/pages/bobablog.php"><h1>This post could not be found! Click me to hide this message.</h1></a></div>'; }} ?>
			<div class="card" style="margin-top: 0; transition: height 0.4s cubic-bezier(0, 1.3, 0.4, 1) 0s; height: 135px;" id="header">
				<a class="button headerbtn" href="<? echo $domain ?>"> Boba Blog </a>
				<div style="display: grid; grid-template-columns: 50% 50%; justify-content: center; margin-top: 10px;">
					<a id="showCreatePostBtn" class="button" style="margin-right: 5px;" onclick="showCreatePost()">Create New Post</a> <a href="#" class="button" id="showBioBtn" style="margin-left: 5px;" onclick="showBio()">Settings</a></div>
				<div id="createPost" style="display: none; position: relative; ">
					<textarea cols="40" id="data" name="data" rows="20">Enter post text here</textarea>
					<h2 style="margin-top: 10px;"> Filename / Slug: <input type="text" name="date" value="" placeholder="PostTitle" id="postSlug"> </h2>
					<h2 style="margin-top: 10px;"> Title: <input type="text" name="date" value="" placeholder="A Boba Shop (City, State)" id="postTitle"> </h2>
					<input type="file" name="fileupload" id="fileupload">
					<a id="mediaUpload" class="button" style="margin-top: 10px;" onclick="uploadMedia()"> Upload Media </a>
					<br><input type="file" name="postimgupload" id="postimgupload" style="margin-top: 10px;">
					<a id="postimgUpload" class="button" style="margin-top: 10px;" onclick="uploadPostImg()"> Upload Post Image </a>
					<br><br>
					<a onclick="selectAuthor('None')" class="button" style="margin-right: 5px;" id="authorMesage">Select an author:</a>
					<a onclick="selectAuthor('AmazinAxel')" class="button">AmazinAxel</a>
					<br><br>
					<a id="postSubmit" class="button" style="display: block; margin-top: 10px;" onclick="uploadPost()"> Save & Publish </a>
				</div>
				<div id="editBio" style="display: none; position: relative;">
					<h1> AmazinAxel </h1>
					<textarea cols="40" id="AmazinAxel" name="data" rows="20"><? echo file_get_contents("../../../../domains/amazinaxel.com/public_html/boba/data/AmazinAxel.html"); ?></textarea>
					<a id="AmazinAxelSave" class="button" style="margin-top: 10px; display: block; margin: 0;" onclick="saveBio('AmazinAxel')"> Save </a>
				</div>
			</div>
				<?php 
					$arrFiles = scandir('../../../../domains/amazinaxel.com/public_html/boba/posts/', SCANDIR_SORT_DESCENDING);
					$postCount = 0;

					for ($i = 0; $i < count($arrFiles); $i++) { // CHANGE THE VALUE IF THERE ARE ISSUES WITH PERIODS / .htaccess
						if ($arrFiles[$i] != '.' && $arrFiles[$i] != '..' ){
						$title = explode("_", substr($arrFiles[$i], 0, -3));
						$title = $title[1];
						$postCount++;
						echo '<div class="card left">
					<p class="listText"><a href="?bobablog&edit=' . $title . '">'. $title . '</a> | ' . getPostDateTime(basename($arrFiles[$i]))->format('F jS, Y') . '</p>
					<div class="buttons">
						<a href="?boba&edit='. $title .'" class="button">Edit</a>
						<a id="deletePostBtn' . $i . '" class="button" onclick=deletePost('.$i.',"'.$title.'")>Delete</a>
					</div>
				</div>'; }}?>
			<div class="card left">
				<a><strong><? echo $postCount; ?> </strong> total posts</a>
				<div class="buttons" style="top: 0"> <a class="button" id="manageMedia" onclick="mediaError()">Manage Media</a> </div> <!-- add href="https://alecshome.com/boba/media/ once finished -->
		</div>
	</body>
</html>