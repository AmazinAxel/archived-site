<?php 
require('settings.php'); # This is the updated and fixed code. Put this on every page!
if (isset($_COOKIE['login']) != $password) {
	require('login.php');
	die();
}

if (isset($_POST['note'])) {
	$data = explode('~', $_POST['note']);
	
	$Handle = fopen("data/" . $data[0] . ".txt", 'w'); // Change which folder data is stored in
	fwrite($Handle, $data[1]); // Write data
	fclose($Handle); // Close
	die("SUCCESS"); // Exit & don't send / process any extra data / wrap up all PHP processes
}

if (isset($_POST['newnote'])) {	
	file_put_contents("data/" . $_POST['newnote'] . ".txt", "Notes go here!");
	die("SUCCESS"); // Exit & don't send / process any extra data / wrap up all PHP processes
}



if (isset($_GET['get'])) { die(file_get_contents("data/" . $_GET['get'] . '.txt')); }

include('other/header.php');
generateHeader('Notes'); ?>
	<script>
		function loadNote(type) {
			document.getElementById('header').innerHTML = 'Loading Note...';
			var xmlhttp = new XMLHttpRequest(); // Initialize AJAX request
			xmlhttp.open("GET", "action?notes&get=" + type, true); // Open AJAX request
			xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded;"); // Encode AJAX request
			xmlhttp.send(); // Send AJAX request
			xmlhttp.onreadystatechange=function() { // Give feedback if successful
				if (xmlhttp.readyState==4 && xmlhttp.status==200) { // Show Saved text
					document.getElementById('header').innerHTML = 'Notes';
					document.getElementById('submit').setAttribute('onclick', 'saveNote(\'' + type + '\')');
					document.getElementById('body').innerHTML = xmlhttp.responseText
				};
			};			
		}
		
		async function saveNote(name) {
	document.getElementById("submit").innerHTML = "Saving..."
	let formData = new FormData();
	formData.append("note", name + '~' + document.getElementById("body").value);
	await fetch('#', {
		method: "POST",
		body: formData
	})
	document.getElementById("submit").innerHTML = "Saved!"
	setTimeout(function() {
		document.getElementById("submit").innerHTML = 'Save';
		}, 2000); }

</script>
	</head>
	<body>
		<div class="content row">
			<div class="card">
				<a class="button headerbtn" id="header" href="<? echo $domain ?>"> Notes </a>
				<textarea cols="40" id="body" name="data" rows="20" style="height: -webkit-fill-available;"><? echo file_get_contents("data/stickynote.txt"); ?></textarea>
				<a class="large button" id="submit" onclick="saveNote('stickynote');">Save</a>
			</div>
			<div class="card">
				<a class="write button" style="display: block; margin-bottom: 5px;" onclick="loadNote('diary')"> Notes: </a>
				<a class="write button" style="display: block; margin-bottom: 5px;" onclick="loadNote('stickynote')"> Sticky Note </a>
				<a class="write button" style="display: block; margin-bottom: 5px;" onclick="loadNote('projectnotes')"> Project Notes </a>
				<a class="write button" style="display: block; margin-bottom: 5px;" onclick="loadNote('miscnotes')"> Misc Notes </a>
				<a class="write button" style="display: block; margin-bottom: 5px;" onclick="loadNote('loggingnote')"> Logging </a>
				<a class="write button" style="display: block; margin-bottom: 5px;" onclick="loadNote('uberspace')"> Uberspace </a>
				<!-- TO ADD A NEW NOTE: It's very simple! Just copy one of the things above and change the onclick to the the note in the /data/ folder (ending in .txt) That's it!! -->
			</div>
			
		</div>
	</body>
</html>
