<?php 
error_reporting(E_ALL);
ini_set('display_errors', true);
require('settings.php');
if (isset($_COOKIE['login']) != $password) {
	require 'login.php';
	die();
}

if (isset($_POST['data'])) { // If submitting data, write data to file
	$data = explode("~", $_POST["data"]); // Get & parse the data
	$longURL = $data[0]; # Get long URL
	$shortURL = $data[1]; # Get short URL

	if ($longURL == "delete") {
		if (!unlink("../go/" . $shortURL . ".php")) {
			http_response_code(500);
			exit;
		} else { exit; }
	}

	$file = fopen('../go/' . $shortURL . '.php','w'); // Create file in /go/ dir
	fwrite($file, '<?php header("Location: ' . $longURL . '"); exit; ?>'); // Add content
	fclose($file); // Close
	exit; // Exit & don't send / process any extra data / wrap up all PHP processes
}  else if (isset($_POST['axeldata'])) {
	$data = explode("~", $_POST["axeldata"]); // Get & parse the data
	$longURL = $data[0]; # Get long URL
	$shortURL = $data[1]; # Get short URL

	if ($longURL == "delete") {
		if (!unlink("../../../amazinaxel.com/public_html/go/" . $shortURL . ".php")) {
			http_response_code(500);
			exit;
		} else { exit; }
	}

	$file = fopen('../../../amazinaxel.com/public_html/go/' . $shortURL . '.php','w'); // Create file in /go/ dir
	fwrite($file, '<?php header("Location: ' . $longURL . '"); exit; ?>'); // Add content
	fclose($file); // Close
	exit; // Exit & don't send / process any extra data / wrap up all PHP processes
}

include('other/header.php');
generateHeader('Linkcreator'); ?>
		<script>
			function showCreateLink() { cancelAxelLink(); document.getElementById('createLink').style.display = 'revert'; 
									   document.getElementById('createLink').classList.add('show');
										document.getElementById('createLink').classList.remove('hide'); 
									   document.getElementById('createLinkBtn').setAttribute('onclick', 'cancelLink();');
									  document.getElementById('header').style.height = '320px'
									  document.getElementById('createLinkBtn').innerHTML = 'Cancel'; }
			function cancelLink() { document.getElementById('createLink').style.display = 'none'; 
								   document.getElementById('createLink').classList.add('hide');
									document.getElementById('createLink').classList.remove('show'); 
								   document.getElementById('createLinkBtn').setAttribute('onclick', 'showCreateLink();');
								  document.getElementById('header').style.height = '140px' 
								  document.getElementById('createLinkBtn').innerHTML = 'AlecsHome.com'; }
			function showCreateAxelLink() { cancelLink(); document.getElementById('createAxelLink').style.display = 'revert'; 
									   document.getElementById('createAxelLink').classList.add('show');
										document.getElementById('createAxelLink').classList.remove('hide'); 
									   document.getElementById('axelLink').setAttribute('onclick', 'cancelAxelLink();');
									  document.getElementById('header').style.height = '320px'
									  document.getElementById('axelLink').innerHTML = 'Cancel'; }
			function cancelAxelLink() { document.getElementById('createAxelLink').style.display = 'none'; 
								   document.getElementById('createAxelLink').classList.add('hide');
									document.getElementById('createAxelLink').classList.remove('show'); 
								   document.getElementById('axelLink').setAttribute('onclick', 'showCreateAxelLink();');
								  document.getElementById('header').style.height = '140px' 
								  document.getElementById('axelLink').innerHTML = 'AmazinAxel.com'; }
			
			/* async function createAxelLink() {
				document.getElementById('axelLink').innerHTML = 'Code Copied!';
				navigator.clipboard.writeText("<\?php header(\"Location: https://place.go/url.html\"); exit; ?>")
				setTimeout(function() {
					document.getElementById('axelLink').innerHTML = 'Paste & modify it in the /go/ dir.';
				}, 1500);
				setTimeout(function() {
					document.getElementById('axelLink').innerHTML = 'Create New AmazinAxel.com Link';
				}, 4000);
			} */

			async function createLink() {
				document.getElementById('createLinkBtn').innerHTML = 'Saving...'; // Saving text
				var xmlhttp = new XMLHttpRequest(); // Initialize AJAX request
				var longURL = document.getElementById('longURL').value; // Gather form data
				var shortURL = document.getElementById('shortURL').value; // Gather form data
				var data = longURL + '~' + shortURL
				xmlhttp.open("POST", "#", true); // Open AJAX request
				xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded;"); // Encode AJAX request
				xmlhttp.send('data=' + encodeURIComponent(data)); // Send AJAX request
				xmlhttp.onreadystatechange=function() { // Give feedback if successful
					if (xmlhttp.readyState==4 && xmlhttp.status==200) { // Show Saved text
						document.getElementById('createLinkBtn').innerHTML = 'Saved!';
						setTimeout(function() {
							document.getElementById('createLinkBtn').innerHTML = 'Copy';
							document.getElementById('createLinkBtn').setAttribute("onclick", "copyNewLink()");
						}, 1000);
					};
				};
			}
			
			async function createAxelLink() {
				document.getElementById('createAxelLinkBtn').innerHTML = 'Saving...'; // Saving text
				var xmlhttp = new XMLHttpRequest(); // Initialize AJAX request
				var longURL = document.getElementById('AxellongURL').value; // Gather form data
				var shortURL = document.getElementById('AxelshortURL').value; // Gather form data
				var data = longURL + '~' + shortURL
				xmlhttp.open("POST", "#", true); // Open AJAX request
				xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded;"); // Encode AJAX request
				xmlhttp.send('axeldata=' + encodeURIComponent(data)); // Send AJAX request
				xmlhttp.onreadystatechange=function() { // Give feedback if successful
					if (xmlhttp.readyState==4 && xmlhttp.status==200) { // Show Saved text
						document.getElementById('createAxelLinkBtn').innerHTML = 'Saved!';
						setTimeout(function() {
							document.getElementById('createAxelLinkBtn').innerHTML = 'Copy';
							document.getElementById('createAxelLinkBtn').setAttribute("onclick", "copyNewAxelLink()");
						}, 1000);
					};
				};
			}

			async function copyNewLink() {
				navigator.clipboard.writeText("AlecsHome.com/go/" + document.getElementById('shortURL').value)
				document.getElementById('createLinkBtn').innerHTML = 'Copied!';
				setTimeout(function() {
					document.getElementById('createLinkBtn').innerHTML = 'Copy';
				}, 2000);
			}
			
			async function copyNewAxelLink() {
				navigator.clipboard.writeText("AmazinAxel.com/go/" + document.getElementById('AxelshortURL').value)
				document.getElementById('createAxelLinkBtn').innerHTML = 'Copied!';
				setTimeout(function() {
					document.getElementById('createAxelLinkBtn').innerHTML = 'Copy';
				}, 2000);
			}

			async function deleteLink(number) {
				document.getElementById('deleteLinkBtn' + number).innerHTML = 'Deleting...'; // Saving text
				var xmlhttp = new XMLHttpRequest(); // Initialize AJAX request
				var shortURL = document.getElementById('shortURL' + number).innerHTML; // Gather form data
				var data = "delete~" + shortURL
				xmlhttp.open("POST", "#", true); // Open AJAX request
				xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded;"); // Encode AJAX request
				xmlhttp.send('data=' + encodeURIComponent(data)); // Send AJAX request
				xmlhttp.onreadystatechange=function() { // Give feedback if successful
					if (xmlhttp.readyState==4 && xmlhttp.status==200) { // Show Saved text
						document.getElementById('deleteLinkBtn' + number).innerHTML = 'Deleted!';
					};
				};
			}
			
			async function deleteAxelLink(number) {
				document.getElementById('deleteAxelLinkBtn' + number).innerHTML = 'Deleting...'; // Saving text
				var xmlhttp = new XMLHttpRequest(); // Initialize AJAX request
				var shortURL = document.getElementById('AxelshortURL' + number).innerHTML; // Gather form data
				var data = "delete~" + shortURL
				xmlhttp.open("POST", "#", true); // Open AJAX request
				xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded;"); // Encode AJAX request
				xmlhttp.send('axeldata=' + encodeURIComponent(data)); // Send AJAX request
				xmlhttp.onreadystatechange=function() { // Give feedback if successful
					if (xmlhttp.readyState==4 && xmlhttp.status==200) { // Show Saved text
						document.getElementById('deleteAxelLinkBtn' + number).innerHTML = 'Deleted!';
					};
				};
			}


			async function updateLink(number) {
				document.getElementById('saveLinkBtn' + number).innerHTML = 'Saving...'; // Saving text
				var xmlhttp = new XMLHttpRequest(); // Initialize AJAX request
				var longURL = document.getElementById('longURL' + number).value; // Gather form data
				var shortURL = document.getElementById('shortURL' + number).innerHTML; // Gather form data
				var data = longURL + '~' + shortURL
				xmlhttp.open("POST", "#", true); // Open AJAX request
				xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded;"); // Encode AJAX request
				xmlhttp.send('data=' + encodeURIComponent(data)); // Send AJAX request
				xmlhttp.onreadystatechange=function() { // Give feedback if successful
					if (xmlhttp.readyState==4 && xmlhttp.status==200) { // Show Saved text
						document.getElementById('saveLinkBtn' + number).innerHTML = 'Saved!';
						setTimeout(function() {
							document.getElementById('saveLinkBtn' + number).innerHTML = 'Save';
						}, 2000);
					};
				};
			}
			
			async function updateAxelLink(number) {
				document.getElementById('saveAxelLinkBtn' + number).innerHTML = 'Saving...'; // Saving text
				var xmlhttp = new XMLHttpRequest(); // Initialize AJAX request
				var longURL = document.getElementById('AxellongURL' + number).value; // Gather form data
				var shortURL = document.getElementById('AxelshortURL' + number).innerHTML; // Gather form data
				var data = longURL + '~' + shortURL
				xmlhttp.open("POST", "#", true); // Open AJAX request
				xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded;"); // Encode AJAX request
				xmlhttp.send('axeldata=' + encodeURIComponent(data)); // Send AJAX request
				xmlhttp.onreadystatechange=function() { // Give feedback if successful
					if (xmlhttp.readyState==4 && xmlhttp.status==200) { // Show Saved text
						document.getElementById('saveAxelLinkBtn' + number).innerHTML = 'Saved!';
						setTimeout(function() {
							document.getElementById('saveAxelLinkBtn' + number).innerHTML = 'Save';
						}, 2000);
					};
				};
			}
			
			window.onload = function() { if (window.location.toString().includes("openlink")) { setTimeout(function(){ showCreateLink(); }, 250); }
									     else if (window.location.toString().includes("axellink")) { setTimeout(function(){ showCreateAxelLink(); }, 250); }}
		</script>
	</head>
	<body>
		<div class="card header" id="header" style="transition: height 0.4s cubic-bezier(0, 1.3, 0.4, 1) 0s; height: 140px;">
			<a class="button headerbtn" href="<? echo $domain ?>"> Link Creator </a>
		<div style="display: grid; grid-template-columns: 50% 50%; justify-content: center; margin-top: 10px;">
			<a id="createLinkBtn" class="button" style="margin-right: 5px;" onclick="showCreateLink()">AlecsHome.com</a> <a href="#" class="button" id="axelLink" style="margin-left: 5px;" onclick="showCreateAxelLink()">AmazinAxel.com</a>
			<div id="createLink" style="display: none; width: 200%; margin-top: 10px; position: relative;">
				<h2 class="button" style="text-align: center;"> Create AlecsHome.com Link</h2>
				<h2> Long URL: <input type="text" name="title" value="https://longURL.here/" id="longURL"> </h2>
				<h2> Short URL: <input type="text" name="title" value="shortURL" id="shortURL"> </h2>
				<a href="#" class="button" onclick="cancelLink()">Cancel</a>  <a href="#" class="button" id="createLinkBtn" onclick="createLink()">Save</a>
			</div>
			<div id="createAxelLink" style="display: none; width: 200%; margin-top: 10px; position: relative;">
				<h2 class="button" style="text-align: center;"> Create AmazinAxel.com Link</h2>
				<h2> Long URL: <input type="text" name="title" value="https://longURL.here/" id="AxellongURL"> </h2>
				<h2> Short URL: <input type="text" name="title" value="shortURL" id="AxelshortURL"> </h2>
				<a href="#" class="button" onclick="cancelAxelLink()">Cancel</a>  <a href="#" class="button" id="createAxelLinkBtn" onclick="createAxelLink()">Save</a>
		</div>
        </div>
		</div>
		<?php 
		$arrFiles = scandir('../go/');
		function get_string_between($string, $start, $end){
			$string = ' ' . $string;
			$ini = strpos($string, $start);
			if ($ini == 0) return '';
			$ini += strlen($start);
			$len = strpos($string, $end, $ini) - $ini;
			return substr(substr($string, $ini, $len), 0, -6);
		}

		for ($i = 3; $i < count($arrFiles); $i++) { // CHANGE THE VALUE IF THERE ARE ISSUES WITH PERIODS / .htaccess
			echo '<div class="card">
			<h2 class="button" style="text-align: center;" id="fullURL'. $i .'" onclick="copyLink(this.id, \'AlecsHome.com/go/' . substr($arrFiles[$i], 0, -4) . '\')"> AlecsHome.com/go/' . substr($arrFiles[$i], 0, -4) . '</h2>
			<p style="display: none;" id="shortURL'. $i .'">' . substr($arrFiles[$i], 0, -4) . '</p>
			<h2> URL: <input type="text" name="title" id="longURL'. $i .'" value="' . get_string_between(htmlspecialchars(file_get_contents('../go/' . $arrFiles[$i])), 'Location: ', ');') . '"> </h2>
					<a href="#" class="button" onclick="deleteLink('. $i .')" id="deleteLinkBtn'. $i .'" >Delete</a>  <a href="#" class="button" onclick="updateLink('. $i .')" id="saveLinkBtn'. $i .'">Save</a>
					<a href="#" class="button" onclick="copyLink(this.id, \'AlecsHome.com/go/' . substr($arrFiles[$i], 0, -4) . '\')" id="copyLinkBtn'. $i .'">Copy</a>
			</div>' ;} 
		
		$arrFiles = scandir('../../../amazinaxel.com/public_html/go/'); // AmazinAxel.com

		for ($i = 3; $i < count($arrFiles); $i++) { // CHANGE THE VALUE IF THERE ARE ISSUES WITH PERIODS / .htaccess
			echo '<div class="card">
			<h2 class="button" style="text-align: center;" id="AxelfullURL'. $i .'" onclick="copyLink(this.id, \'AmazinAxel.com/go/' . substr($arrFiles[$i], 0, -4) . '\'"> AmazinAxel.com/go/' . substr($arrFiles[$i], 0, -4) . '</h2>
			<p style="display: none;" id="AxelshortURL'. $i .'">' . substr($arrFiles[$i], 0, -4) . '</p>
			<h2> URL: <input type="text" name="title" id="AxellongURL'. $i .'" value="' . get_string_between(htmlspecialchars(file_get_contents('../../../amazinaxel.com/public_html/go/' . $arrFiles[$i])), 'Location: ', ');') . '"> </h2>
					<a href="#" class="button" onclick="deleteAxelLink('. $i .')" id="deleteAxelLinkBtn'. $i .'" >Delete</a>  <a href="#" class="button" onclick="updateAxelLink('. $i .')" id="saveAxelLinkBtn'. $i .'">Save</a>
					<a href="#" class="button" onclick="copyLink(this.id, \'AmazinAxel.com/go/' . substr($arrFiles[$i], 0, -4) . '\')" id="copyAxelLinkBtn'. $i .'">Copy</a>
			</div>' ;}
		?>

		<div class="card">
			<? $fileCount = new FilesystemIterator("../go/", FilesystemIterator::SKIP_DOTS);
			$axelfileCount = new FilesystemIterator("../../../amazinaxel.com/public_html/go/", FilesystemIterator::SKIP_DOTS);
			echo "<p><strong>" . iterator_count($fileCount) - 1 + iterator_count($axelfileCount) - 1 . "</strong> total redirect(s)</p>" ?>
		</div>
	</body>
</html>