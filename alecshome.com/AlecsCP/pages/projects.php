<?php 
error_reporting(E_ALL); // add error reporting for the backend page
ini_set('display_errors', true); // error reporting
#header('Access-Control-Allow-Origin: no-cors'); // fix bug
#include('../../boba/postRenderer.php'); // include library

// HERE IS A WAY TO OPTIMIZE THE CODE OF THIS PAGE:
/* technically i dont really need the "project" tag because it's already contained within the URL! every time a request is sent with this page, it includes the title in its url (CHECK THE QUERY STRING PARAMS IN DEVTOOLS TO CONFIRM) which helps to better the code */
// TIP; to include more stuff in the metadata, keep the project description, links, link title and other data in the metadata folder so whenever the projecct becomes hidden, that data isnt removed!!
require 'settings.php'; # This is the updated and fixed code. Put this on every page!
if (isset($_COOKIE['login']) != $password) {
	require('login.php');
	die();
}

function hideProject() {
		$lines = implode(file("../../../../domains/amazinaxel.com/public_html/projects.html")); 
		$lines1 = explode('<div class="card" id="' . $_POST['project'] . '">', $lines);
		$lines2 = explode('</div>', $lines1[1], 2)[1];
		$data = $lines1[0] . $lines2; 
		file_put_contents('../../../../domains/amazinaxel.com/public_html/projects.html', $data);
} function showProject () {
		#true~Enter a subtitle here!~Enter a description here!~Project URL goes here!~Project URL text goes here!~placeholder.png
		$lines = implode(file("../../../../domains/amazinaxel.com/public_html/projects.html")); 
		$lines1 = explode('<div class="grid-container">', $lines);
		$metadata = explode('~', file_get_contents('data/projects/' . $_POST['project'] . '/metadata.txt'));
		if ($metadata[5] != '') { $isImgAvailable = '<img src="media/' . $metadata[5] . '">'; } else { $isImgAvailable = ''; }
		if ($metadata[3] != '' && $metadata[4] != '') { $button = '<a href="' . $metadata[3] . '" class="button">' . $metadata[4] . '</a>'; } else { $button = ''; }
		$data = $lines1[0] . '<div class="grid-container"> <div class="card" id="' . $_POST['project'] . '">' . $isImgAvailable . '
		<h1>' . $_POST['project'] . '</h1>
		<h2>' . $metadata[1] . '</h2>
		' . $button . '
		<p>' . $metadata[2] . '</p>
	</div>' . $lines1[1];
	file_put_contents('../../../../domains/amazinaxel.com/public_html/projects.html', $data);
}

if(isset($_POST['toggleVisible']) && isset($_POST['project'])) {
	$isVisible = explode( '~', file_get_contents('data/projects/' . $_GET['option'] . '/metadata.txt'));
	if ($isVisible[0] == 'true'){
		$data = str_replace("true", "false", file_get_contents('data/projects/' . $_GET['option'] . '/metadata.txt'));
		file_put_contents('data/projects/' . $_GET['option'] . '/metadata.txt', str_replace("true", "false", $data));
		hideProject();
		die('SUCCESS');
	
	} else if ($isVisible[0] == 'false') {
		$data = file_put_contents('data/projects/' . $_GET['option'] . '/metadata.txt', str_replace("false", "true", file_get_contents('data/projects/' . $_GET['option'] . '/metadata.txt')));
		showProject();
		die('SUCCESS');
	}
}

if (isset($_POST['projectURLText']) && isset($_POST['projectURL']) && isset($_POST['projectText']) && isset($_POST['project']) && isset($_POST['projectSubtitle']) && isset($_POST['projectImage'])) {
	$data = explode('~', file_get_contents('data/projects/' . $_GET['edit'] . '/metadata.txt'));
	$visibility = $data[0];
	file_put_contents('data/projects/' . $_GET['edit'] . '/metadata.txt', $data[0] . '~' . $_POST['projectSubtitle'] . '~' . $_POST['projectText'] . '~' . $_POST['projectURL'] . '~' . $_POST['projectURLText'] . '~' . $_POST['projectImage']);
	if ($visibility == 'true'){
		hideProject();
		showProject();
		die('SUCCESS');
	}
	#true~Enter a subtitle here!~Enter a description here!~Project URL goes here!~Project URL text goes here!~placeholder.png
}

if (isset($_POST['noteData']) && isset($_POST['note']) && isset($_POST['project'])) {
	file_put_contents('data/projects/' . $_POST['project'] . '/' . $_POST['note'] . '.txt', $_POST['noteData']);
}

if (isset($_POST['media'])) {
	file_put_contents('data/projects/' . $_POST['project'] . '/' . $_POST['note'] . '.txt', $_POST['noteData']);
}

if (isset($_POST['delProject']) && isset($_POST['project'])) {
	$data = explode('~', file_get_contents('data/projects/' . $_POST['project'] . '/metadata.txt'));
	if ($data[0] == 'true'){
		hideProject();
	}
	$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator('data/projects/' . $_POST['project'] . '/', RecursiveDirectoryIterator::SKIP_DOTS),
    RecursiveIteratorIterator::CHILD_FIRST
	);

	foreach ($files as $fileinfo) {
	    $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
	    $todo($fileinfo->getRealPath());
	}

	rmdir('data/projects/' . $_POST['project'] . '/');
	die('SUCCESS!');
}

if (isset($_POST["item1"]) && isset($_POST["count"]) && isset($_POST['project'])) {
	echo $_POST['project'];
    $Handle = fopen('data/projects/' . $_POST['project'] . '/todo.txt', 'w'); // Change which folder data is stored in
    for ($i = 1; $i < $_POST["count"] + 1; $i++) {
		if (isset($_POST["item" . $i])) {
    		fwrite($Handle, str_replace(array("\n"), '', $_POST["item" . $i]) . "\n"); // Add line
	}}
    fclose($Handle); // Close
	die('SUCCESS'); // Exit script
} 

if (isset($_POST['updateProject'])){ // ../../../../domains/amazinaxel.com/public_html/index.html
	die("\nSUCCESS"); // Exit & don't send / process any extra data / wrap up all PHP processes
	
	
} else if (isset($_POST['newProject'])){
	/* when creating a new project, create a new folder in the /data/projects folder
	then add all of the metadata like a file named "notes" and "todo"
	then allow the user to instantly copy the link to it 2
	
	*/
	 mkdir("data/projects/" . $_POST['newProject']);
	
	file_put_contents('data/projects/' . $_POST['newProject'] . '/notes.txt', 'Your project notes go here!');
	file_put_contents('data/projects/' . $_POST['newProject'] . '/metadata.txt', 'false~Enter a subtitle here!~Enter a description here!~Project URL goes here!~Project URL text goes here!~placeholder.png');
	file_put_contents('data/projects/' . $_POST['newProject'] . '/updatenotes.txt', 'Your reminders and notes for the project update process go here!');
	file_put_contents('data/projects/' . $_POST['newProject'] . '/todo.txt', 'Enter your to-do list items here!');
	file_put_contents('data/projects/' . $_POST['newProject'] . '/updatelog.txt', 'Put info to go in the update log here!');

	die('NEWYEARSUCCESS'); 
	} else if (isset($_FILES['media'])) { // HANDLE UPLOADED MEDIA
		if(!empty($_FILES["media"]["name"])) {
			if (isset($_POST["name"])) { $name = $_POST["name"]; } else { $name = $_FILES["media"]["name"]; }
			#$allowTypes = array('jpg','png','jpeg','gif','pdf');
			#if(in_array($fileType, $allowTypes)){
			if (move_uploaded_file($_FILES["media"]["tmp_name"], "../../../../domains/amazinaxel.com/public_html/media/" . $name)){
				die('SUCCESS');
			} else { http_response_code(501); /* Couldn't move file */ exit; }
		} else { http_response_code(501); /* No file uploaded */ exit; }}

include('other/header.php');
generateHeader('Project Manager'); ?>
		<style>
			p { line-height: 1.3em; }
			h1 { margin-block-start: 0.6em; margin-block-end: 0.6em; }
			a.button {
    display: block;
    margin-bottom: 13px;
}
			#main { margin-top: 50px; }
			/* TODO LIST STYLE!!! */
			h3 {
			    display: unset;
    position: absolute;
    font-weight: normal;
    font-size: 1.2em;
    margin: -2px 0 0 5px;
    /* white-space: nowrap; */
    /* word-wrap: break-word; */
    /* text-align: left; */
    /* white-space: nowrap; */
    /* word-wrap: break-word; */
    overflow: hidden;
    /* overflow-wrap: break-word; */
    text-overflow: ellipsis;
		} .card.left {
			white-space: nowrap; }
		
		.showDesc { animation: showDesc 1s cubic-bezier(0, 1.3, 0.4, 1) } 

			.hideDesc { animation: hideDesc 1s cubic-bezier(0, 1.3, 0.4, 1) }

		@keyframes hideDesc { 0% { opacity: 1; line-height: 18px; margin-top: 20px; } 25% { opacity: 0 } 45% { line-height: 0px; margin-top: 0; } 100% { opacity: 0; } }

			@keyframes showDesc { 0% { opacity: 0; line-height: 0px; margin-top: 0; } 45% { line-height: 18px; margin-top: 20px; } 100% { opacity: 1; } }
		
		@media (min-width: 1050px) { .listText { width: 600px; }}
		@media (max-width: 1050px) and (min-width: 800px) { .listText { width: calc(100% - 425px); }}
		
		.default { text-align: center; }
		
		.animateBottom { animation: animateBottom 0.4s cubic-bezier(0, 1.3, 0.4, 1) 0s; }
		@keyframes animateBottom { 0% { top: -40px; } 100% { top: 0 } }
		.revanimateBottom { animation: revanimateBottom 0.4s cubic-bezier(0, 1.3, 0.4, 1) 0s; }
		@keyframes revanimateBottom { 0% { top: 40px; } 100% { top: 0 } }
		
		.show { animation: show 0.8s cubic-bezier(0, 1.3, 0.4, 1) 0s }
			
			@media (max-width: 800px) {
.listText {
    right: 62px;
			} }
</style>
		<script>
			async function addProject(name) {
				document.getElementById('addProjectBtn').innerHTML = "Saving..."
				let formData = new FormData();
				formData.append('newProject', document.getElementById('projectName').value);
				await fetch('#', {
					method: "POST",
					body: formData
				})
				document.getElementById('addProjectBtn').innerHTML = "Saved!"
				setTimeout(function() {
					document.getElementById('addProjectBtn').innerHTML = 'Edit ' + document.getElementById('projectName').value;
					document.getElementById('addProjectBtn').href = '?projects&edit=' + document.getElementById('projectName').value;
					document.getElementById('addProjectBtn').setAttribute('onclick', '');
				}, 500);
			}

			function showCreatePost() {
				document.getElementById('showCreatePostBtn').innerHTML = 'Cancel';
				document.getElementById('showCreatePostBtn').setAttribute('onclick','cancelCreatePost()');
				document.getElementById('createPost').style.display = "unset"
				document.getElementById('header').style.height = "240px"
				document.getElementById('createPost').classList.add('show');
				document.getElementById('createPost').classList.remove('hide');
				
			} function cancelCreatePost() {
				document.getElementById('showCreatePostBtn').innerHTML = 'Create New Project';
				document.getElementById('showCreatePostBtn').setAttribute('onclick','showCreatePost()');
				document.getElementById('header').style.height = "140px"
				document.getElementById('createPost').classList.add('hide');
				document.getElementById('createPost').classList.remove('show');
				document.getElementById('createPost').style.display = "none";
				//setTimeout(function(){ document.getElementById('createPost').style.display = "none"; }, 500);
			}
			
			async function refreshProject() {
				document.getElementById('refreshBtn').innerHTML = "Saving..."
				let formData = new FormData();
				formData.append('project', '<? if (isset($_GET['edit'])) { echo $_GET['edit']; } ?>');
				formData.append('projectText', document.getElementById('projectText').value);
				formData.append('projectURL', document.getElementById('projectURL').value);
				formData.append('projectURLText', document.getElementById('projectURLText').value);
				formData.append("projectSubtitle", document.getElementById('projectSubtitle').value)
				formData.append("projectImage", document.getElementById('projectImage').value)
				await fetch('#', {
					method: "POST",
					body: formData
				})
				document.getElementById('refreshBtn').innerHTML = "Saved!"
			}

			async function SaveNote(theID, noteType, noteData) {
				document.getElementById(theID.id).innerHTML = "Saving..."
				let formData = new FormData();
				formData.append('project', '<? if (isset($_GET['edit'])) { echo $_GET['edit']; } ?>');
				formData.append('note', noteType);
				formData.append('noteData', document.getElementById(noteData).value);
				await fetch('#', {
					method: "POST",
					body: formData
				})
				document.getElementById(theID.id).innerHTML = "Saved!"
				setTimeout(function() {
					document.getElementById(theID.id).value = 'Save';
				}, 2000);
			}
			
			async function toggleProjectOption(id, option, toggletext, finishedtext, url) {
				document.getElementById(id.id).innerHTML = toggletext
				let formData = new FormData();
				formData.append(option, true);
				formData.append('project', '<? if (isset($_GET['edit'])) { echo $_GET['edit']; } ?>');
				await fetch(url, {
					method: "POST",
					body: formData
				})
				document.getElementById(id.id).innerHTML = finishedtext
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
			
			// CODE FOR THE TO DO LIST;
			
			
			async function save() {
				event.preventDefault(); // Prevent auto reload of page
				let formData = new FormData();
				formData.append("count", totalItems)
				formData.append('project', '<? if (isset($_GET['edit'])) { echo $_GET['edit']; } ?>');
			    for (i = totalItems; i > 0; i--) {
                    if (document.getElementById('completed' + i).checked == false){
                        formData.append("item" + i, document.getElementById('item' + i).innerHTML)
                    }
                    
					console.log("finished: " + i);
				};
				document.getElementById('saveBtn').innerHTML = 'Saving...'; // Saving text
 				await fetch('#', {
 					method: "POST",
 					body: formData
 				})
				document.getElementById('saveBtn').innerHTML = 'Saved!'; // Saving text
				setTimeout(function() {
					document.getElementById('saveBtn').innerHTML = 'Save All Items';
				}, 1000);
			}

			async function cancelAddItem() {
				document.getElementById('addItemBtn').innerHTML = 'Create New Item'; // Saving text
				document.getElementById('addItemBtn').setAttribute("onclick", "addItem()");
				document.getElementById('addItemMenu').style.display = 'none';
				document.getElementById('todoheader').style.height = "125px"
				document.getElementById('saveBtn').classList.remove('animateBottom');
				document.getElementById('saveBtn').classList.add('revanimateBottom');
				setTimeout(function() {
					document.getElementById('saveBtn').classList.remove('revanimateBottom');
				}, 500);
			}
			
			async function addItem() {
				document.getElementById('addItemBtn').innerHTML = 'Cancel'; // Saving text
				document.getElementById('addItemBtn').setAttribute("onclick", "cancelAddItem()");
				document.getElementById('addItemMenu').style.display = 'revert';
				document.getElementById('todoheader').style.height = "180px"
				document.getElementById('addItemMenu').classList.add('show');
				document.getElementById('saveBtn').classList.remove('revanimateBottom');
				document.getElementById('saveBtn').classList.add('animateBottom');
				setTimeout(function() {
					document.getElementById('saveBtn').classList.remove('animateBottom');
				}, 500);
			}
			
			async function createItem() {
			    let clone = document.getElementById("1").cloneNode(true);
			    for (i = totalItems; i > 0; i--) {
			        let temp = i + 1
			        console.log("doing: " + i);
					document.getElementById('completed' + i).id = 'completed' + temp;
					document.getElementById('showDescriptionBtn' + i).setAttribute('onclick', 'showDescription(' + temp + ')');
					document.getElementById('showDescriptionBtn' + i).id = 'showDescriptionBtn' + temp;
					document.getElementById('description' + i).id = 'description' + temp;
					document.getElementById(i).id = i + 1;
					document.getElementById('item' + i).id = 'item' + temp;
					console.log("finished: " + i);
				};
				document.getElementById("main").prepend(clone);
				document.getElementById("main").children[0].id = 1;
				
				document.getElementById("item1").innerHTML = document.getElementById("item").value;
				document.getElementById("description1").innerHTML = document.getElementById("item").value;
				totalItems++
			}
		</script>
	</head>
	<body onload="totalItems = <? if (isset($_GET['edit'])) { $lines = file('data/projects/' . $_GET['edit'] . '/todo.txt'); $totalItems = 0; foreach ( $lines as $line) { $totalItems++; } echo $totalItems; } else { echo '0'; } ?>;">
		<?php if (isset($_GET['edit'])) { 
			echo '<div class="card header" id="header" style="margin: 0; transition: height 0.4s cubic-bezier(0, 1.3, 0.4, 1) 0s;" id="header"> <a class="button headerbtn" style="margin: 0" href="' . $domain . '">Managing Project: ' . $_GET['edit'] . '</a> </div>
			<div class="card">
			<h2 class="header button"> Project Page Options </h2>
			<h2> Project Information: </h2>
			'; 
			$data = explode('~', file_get_contents('data/projects/' . $_GET['edit'] . '/metadata.txt'));
			echo '<h2 style="margin-top: 10px;"> Project Subtitle: <input type="text" name="date" value="' . $data[1] . '" placeholder="Project subtitle text goes here" id="projectSubtitle"></h2>
			<textarea name="message" rows="5" cols="40" placeholder="Enter Project Text" id="projectText">' . $data[2] . '</textarea>
			<h2 style="margin-top: 10px;"> Project URL: <input type="text" name="date" value="' . $data[3] . '" placeholder="Project URL goes here" id="projectURL"></h2>
			<h2 style="margin-top: 10px;"> Project URL text: <input type="text" name="date" value="' . $data[4] . '" placeholder="Project URL text goes here" id="projectURLText"></h2>
			<h2 style="margin-top: 10px;"> Image URL: <input type="text" name="date" value="' . $data[5] . '" placeholder="Enter a URL for the project image" id="projectImage"></h2>
			';
			$isVisible = explode( '~', file_get_contents('data/projects/' . $_GET['edit'] . '/metadata.txt'));
			if ($isVisible[0] == "true") { echo ' <a class="large button" id="toggleVisible" onclick="toggleProjectOption(this, \'toggleVisible\', \'Disabling Visiblity...\', \'Disabled Visibility!\', \'?projects&option=' . $_GET['edit'] .'\')"> Disable Visibility </a>'; }
			else if ($isVisible[0] == "false") { echo '<a class="large button" id="toggleLock" onclick="toggleProjectOption(this, \'toggleVisible\', \'Enabling Visibility...\', \'Enabled Visibility!\', \'?projects&option=' . $_GET['edit'] .'\')"> Enable Visibility </a>'; }
			echo '
			<a onclick="refreshProject()" class="large button margin-top margin-bottom" id="refreshBtn"><strong>Save</strong></a>
			<p ckass="margin-top"> The save button will use the data from the form above and will refresh the project page with the updated information as long as visibility is enabled. </p>
			</div>
			
			<div class="card">
			<h2 class="header button"> Notes </h2>
			<textarea name="message" rows="5" cols="40" placeholder="Enter Project Notes" id="noteData">' . file_get_contents('data/projects/' . $_GET['edit'] . '/notes.txt') . '</textarea>
			<a id="noteSave" class="large button" onclick="SaveNote(this, \'notes\', \'noteData\')"> Save </a>
			<h2> Releasing Updates Notes: </h2>
			<textarea name="message" rows="5" cols="40" placeholder="Enter Project Text" id="updatenoteData">' . file_get_contents('data/projects/' . $_GET['edit'] . '/updatenotes.txt') . '</textarea>
			<a id="updatenoteSave" class="large button" onclick="SaveNote(this, \'updatenotes\', \'updatenoteData\')"> Save </a>
			<h2> Update Log: </h2>
			<textarea name="message" rows="5" cols="40" placeholder="Enter text to go into the update log here!" id="lognoteData">' . file_get_contents('data/projects/' . $_GET['edit'] . '/updatelog.txt') . '</textarea>
			<a id="updatelognoteSave" class="large button" onclick="SaveNote(this, \'updatelog\', \'lognoteData\')"> Save </a>
			</div>
			
			<div class="card">
			<div id="todoheader" style="margin: 0; height: 125px; transition: height 0.4s cubic-bezier(0, 1.3, 0.4, 1) 0s;">
		<a class="button headerbtn" href="' . $domain . '"> To Do List </a>
		<h2 style="margin: 0;"><a id="addItemBtn" class="button" onclick="addItem()" style="display: block;">Add Item</a></h2>
		<h2 style="display: none; position: relative; margin-top: 5px; margin-bottom: 10px;" id="addItemMenu"> Item: <input type="text" name="title" value="item" id="item" style="margin-bottom: 6px;"> <input type="submit" name="submit" value="Add Item" onclick="createItem()" id="uploadFileBtn" class="button"></h2>
			<a id="saveBtn" class="button" onclick="save()">Save All Items</a>
		</div>
		<div id="main"></div>
		';
		$lines = file('data/projects/' . $_GET['edit'] . '/todo.txt');

		$i = 0;
		foreach ( $lines as $line) {
			$i++;
			//do something here.
			#echo(nl2br($line . "\r"));

			echo '<div class="card left" id="'. $i .'">
				<label class="container">';
				if (str_contains($line, '- ')){
				    echo '<input type="checkbox" checked="checked" id="completed' . $i .'">';
				    $line = str_replace('- ', '', $line);
				} else {
				    echo '<input type="checkbox" id="completed' . $i .'">';
				}
				echo '<span class="checkmark"></span>
				</label>
				<h3 id="item' . $i . '" class="listText">' . $line . '</h3>
				<div class="buttons">
					<a style="margin-right: 5px; display: unset;" id="showDescriptionBtn'. $i .'" class="button" onclick="showDescription(' . $i . ')"> Show All </a>
				</div>
				<div id="description' . $i . '" class="hide" style="display: none; white-space: normal; margin-top: 20px;"><p class="default"> '. $line .' </p></div>
			</div>'; }
			echo '</div>
			
			<div class="card">
			<h2 class="header button"> APIs </h2>
			<textarea name="message" rows="5" cols="40" placeholder="Enter Project Text">Changelog</textarea>
			<h2 style="margin-top: 10px;"> Version: <input type="text" name="date" value="" placeholder="Project title goes here" id="projectName"> </h2>			</div>
			
			<div class="card">
			<h2 class="header button"> Project Management </h2>
			<a onclick="toggleProjectOption(this, \'delProject\', \'Deleting Project...\', \'Deleted Project!\', \'?projects&option=' . $_GET['edit'] .'\')" id="delProjectBtn" class="large button">Delete Project</a>
			<a onclick="" class="large button margin-top">Disable APIs</a> <!-- The way this works is that the APIs used by the projects are stored in the /apis/projectName.php file, and when they are disabled, they are moved to a spot in AlecsCP -->
			</div>
			'; }
	
		else { echo '
		<div class="card header" id="header" style="margin-top: 0; transition: height 0.4s cubic-bezier(0, 1.3, 0.4, 1) 0s; height: 140px;" id="header">
			<a class="button headerbtn" href="' . $domain .'"> Projects </a>
			<h2 class="button" style="display: block; margin: 0;" id="showCreatePostBtn" onclick="showCreatePost()"> Create New Project </h2>
			<div id="createPost" style="display: none; position: relative;" class="hide">
				<h2 style="margin-top: 10px;"> Project Name: <input type="text" name="date" value="" placeholder="Project title goes here" id="projectName"> </h2>
				<a id="addProjectBtn" class="button" style="display: block; margin: 0;" onclick="addProject()"> Save </a>
			</div>
		</div>
		<div class="row">
			<div class="leftcolumn">
			<div class="card"> 
			<h1>All Projects:</h1>';
					$arrFiles = scandir('data/projects', SCANDIR_SORT_DESCENDING);
					$totalProjects = 0;

					for ($i = 0; $i < count($arrFiles); $i++) { // CHANGE THE VALUE IF THERE ARE ISSUES WITH PERIODS / .htaccess
						if ($arrFiles[$i] != '.' && $arrFiles[$i] != '..' ){
							$totalProjects++;
							echo '<a class="button" href="?projects&edit=' . $arrFiles[$i] . '">
					<h1>' . $arrFiles[$i] . '</h1>
				</a>'; }}
			
			/* how this works:
				go to the data/projects folder and every folder in there is a project
				then get the project name and allow you to edit the project by creating a URL to action?projects&edit=NAME
				*/
			echo '</div><div class="card"> <h1>Visible Projects:</h1> </div>';
				
					$projectCount = 0;
					$lines = implode(file("../../../../domains/amazinaxel.com/public_html/projects.html"));
					$lines1 = explode('<div class="grid-container">', $lines);
					$lines2 = '<div class="grid-container">' . $lines1[1];
					$lines3 = explode('<div class="navbar">', $lines2);
			  		#echo $lines4 = str_replace('<img src="media/freepvp-thumbnail-web.png">', '', $lines3[0]);
			  		$lines4 = $lines3[0]; 
			  		$projects = explode('<div class="card" id="', $lines4);
					#echo $lines[0];
					#$posts = explode('<div class="rightside card">', $lines4);

					for ($i = 1; $i < count($projects); $i++) { // CHANGE THE VALUE IF THERE ARE ISSUES WITH CUTTING OFF POSTS, GLITCHY WHEN ITS 0??
							$project = explode('</div>', $projects[$i]);
							$title = explode('">', $project[0])[0];
							$project = str_replace($title . '">', '', $project[0]);
							$project = preg_replace("/<img[^>]+>/", "", $project);
							#echo $posts[$i] . "\n";
							# to get file title, check for any H1 tags inside of it and parse the data inside
							$projectCount++;
							echo '<div class="card">
					' . $project . '</div>'; }
			  echo '
			<div class="card left">
				<p> <strong>' . $projectCount . '</strong> total visible projects | <strong>' . $totalProjects . '</strong> total projects </p>
			</div> 
		</div>
		<aside>
			<div class="card right">
				<a href="https://amazinaxel.com/projects"><h2 class="large button margin-bottom"> View Projects Page </h2></a>
				<h2 class="large button margin-bottom">Edit Projects Folder</h2>
				<h2 class="large button" id="newBlogyear" onclick="newBlogYear()">Update Copyright Year</h2>
			</div>
			<div class="card right">
				<h2 class="large button margin-bottom" id="newBlogyear" onclick="newBlogYear()">Edit Project Page HTML</h2>
				<h2 class="large button" id="newBlogyear" onclick="newBlogYear()">View All Project Media</h2>
			</div>
		</aside>
		</div> '; } ?>
	</body>
</html>