<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://amazinaxel.com/style.css"/>
		<link rel="stylesheet" href="https://alecshome.com/AlecsCP/style.css"/>
		<style> .content { margin: 0; padding: 0; }
			textarea:focus-visible {
				outline: 0;
				transition: background-color 0.3s, box-shadow 0.3s;
				box-shadow: rgb(221 221 221) 0px 0px 11px 1px;
			}

			input:focus-visible {
				outline: 0;
				transition: background-color 0.3s, box-shadow 0.3s;
				box-shadow: rgb(221 221 221) 0px 0px 11px 1px;
			}
			textarea {
				padding: 8px;
				margin-top: 5px;
				border-radius: 10px;
				border: 0px;
				background-color: rgb(246, 246, 253);
				box-shadow: 0 1px 3px 0 #c3c3c3;
				height: 113px;
				width: 331px;
				transition: box-shadow 0.3s;
				width: -webkit-fill-available;
				resize: none;
			}
			
			.sidebar a {
				margin: 5px;
			}
		</style>
		<script>
			async function getQuote() {
				document.getElementById('qotdButton').innerHTML = 'Getting Quote of the Day...'; // Saving text
				var xmlhttp = new XMLHttpRequest(); // Initialize AJAX request
				xmlhttp.open("GET", "https://alecshome.com/AlecsCP/other/qotd.php", true); // Open AJAX request
				xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded;"); // Encode AJAX request
				xmlhttp.send(); // Send AJAX request
				xmlhttp.onreadystatechange=function() { // Give feedback if successful
					if (xmlhttp.readyState==4 && xmlhttp.status==200) { // Show Saved text
						document.getElementById('qotdButton').innerHTML = 'Hide Quote of the Day';
						document.getElementById('qotdButton').setAttribute("onclick", "hideQuote()");
						document.getElementById('qotdText').style.marginTop = '20px';
						document.getElementById('qotdText').innerHTML = xmlhttp.responseText
					};
				};
			}
			function hideQuote() {
				document.getElementById('qotdText').style.display = 'none';
				document.getElementById('qotdButton').innerHTML = 'Show Quote of the Day';
				document.getElementById('qotdButton').setAttribute("onclick", "showQuote()");
			}

			function showQuote() {
				document.getElementById('qotdText').style.display = 'block'
				document.getElementById('qotdText').style.marginTop = '20px';
				document.getElementById('qotdButton').innerHTML = 'Hide Quote of the Day';
				document.getElementById('qotdButton').setAttribute("onclick", "hideQuote()");
			}

			async function overview() {
				document.getElementById('overview').innerHTML = 'Getting Alert...';
			}

			async function submitNote() {
				event.preventDefault(); // Prevent auto reload of page
				document.getElementById('dataSubmit').value = 'Saving...'; // Saving text
				var xmlhttp = new XMLHttpRequest(); // Initialize AJAX request
				var data = document.getElementById('data').value; // Gather form data
				xmlhttp.open("POST", "homepage.php", true); // Open AJAX request
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

			function mediaOpen(){
				document.getElementById('mediaText').innerHTML = 'Media';
				document.getElementById('media').style.display = 'unset';
				document.getElementById('mediaText').style.marginBottom = '15px';
				document.getElementById('mediaText').setAttribute("onclick", "mediaClose()");
			}

			function mediaClose(){
				document.getElementById('mediaText').innerHTML = 'Media (Collapsed)';
				document.getElementById('media').style.display = 'none';
				document.getElementById('mediaText').style.marginBottom = '0';
				document.getElementById('mediaText').setAttribute("onclick", "mediaOpen()");
			}
		</script>
	</head>
	<div class="sidebar sidebarleft navbar" style="top: 0; left: 0; margin: 0; height: 100%; border-radius: 0 10px 10px 0; display: grid; align-content: center;">
		<a href="#">Projects</a>
		<a href="#">Blog</a>
		<a href="#">APIs</a>
		<a href="#" style=" background-color: #f6f6fd; box-shadow: 0 0 6px 0 #ddd;">Homepage</a>
		<a href="#">To do</a>
		<a href="#">Changelogs</a>
		<a href="#">Notes</a>
	</div>
	<body>
		<div class="content" style="margin-left: 135px;">
			<div class="card">
				<h2 class="button" id="overview" onclick="overview()"><p>Overview</h2>
				<p> <strong>Good Afternoon!</strong>  It's Monday, Jan 32, at 5:23 PM.</p>
			</div>
			<div class="card">
				<h2 class="button"> Notes </h2>
				<textarea cols="40" id="data" name="data" rows="20"> Stufffffff </textarea>
				<br><br>
				<input class="button" id="dataSubmit" name="submit" type="submit" value="Save" onclick="submitNote()">
				<a href="#" class="button">All Notes</a>
			</div>
			<div class="card">
				<h2 class="button"> Projects </h2>
				<p> Manage Projects </p>
			</div>
			<div class="card">
				<h2 class="button"> Blog </h2>
				<p> Create a developer blogpost for a project. </p>
			</div>
			<div class="card">
				<h2 class="button"> APIs </h2>
				<p> Access the APIs and modify them. </p>
			</div>
			<div class="card">
				<h2 class="button"> To Do </h2>
				<p> Create a to-do list for yourself. </p>
			</div>
			<div class="card">
				<h2 class="button"> Changelogs </h2>
				<p> Create changelogs for projects. </p>
			</div>
			<div class="card">
				<h2 class="button">Other</h2>
				<a href="#" class="button">View Dashboard information</a>
				<a href="#" class="button">Logout</a>
				<a href="#" class="button">Send Message</a>
				<a href="#" class="button">Disclaimers</a>
			</div>
		</div>
	</body>
</html>