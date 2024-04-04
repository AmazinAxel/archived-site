<?
require('settings.php');

if (isset($_POST["password"])) { // User is trying to login
	require('data/logininfo.php');
	if ($_POST["password"] == $password && $attempts <= 3) { // User is authenticated!
		http_response_code(200);
		file_put_contents('data/logininfo.php', "<? \$attempts = 0; ?>"); // Reset counter!
		setcookie("login", $_POST["password"], time() + 86400); // Set login cookie for 1 day
		die("SUCCESS"); // Success!

	} else if ($attempts <= 3) { // Wrong password, but not locked out yet
		require($_SERVER['DOCUMENT_ROOT'] . '/apis/notifications.php');
		http_response_code(500); // Let browser know that the password is incorrect
		file_put_contents('data/logininfo.php', "<? \$attempts = " . $attempts + 1 . "; ?>"); // Increase attempts count
		addNotification('Notice', '(' . date("M jS, Y \a\\t g:i A") . ') An incorrect password has been entered on the login form!'); // Log data
		die("WRONGPASSWORD"); }

	else {
		http_response_code(429); // Send emergency login response code to let browser know to change UI 
		require($_SERVER['DOCUMENT_ROOT'] . '/apis/notifications.php');
		addNotification('Alert', '(' . date("M jS, Y \a\\t g:i A") . ') Login form locked! Someone entered the password wrong 3 times! IP: ' . $_SERVER['REMOTE_ADDR']); // Log data
		die("EMERGENCYLOGIN"); // send emergency login link to my email if 3 tries wont work
} }


if (isset($_POST["backuplink"])) {
	include($_SERVER['DOCUMENT_ROOT'] . '/apis/notifications.php');
	if (file_exists('other/data/lastEmail.php')) { // Just in case the cache was purged
		include('other/data/lastEmail.php'); 
		if (strtotime($lastEmail) > strtotime(date('m/d/Y'))) { // Email requested too early!
			http_response_code(429);
			addNotification('Alert', '(' . date("M jS, Y \a\\t g:i A") . ') An email backup was requested too early! IP: ' . $_SERVER['REMOTE_ADDR']);
			die("FAIL");
		}}
	// Continue if everything goes well
	file_put_contents('other/data/lastEmail.php', "<? \$lastEmail =\"" . date('m/d/Y', strtotime("1 day")) . "\" ?>"); 
	http_response_code(200);
	addNotification('Alert', '(' . date("M jS, Y \a\\t g:i A") . ') An email backup link was requested and has been sent! IP: ' . $_SERVER['REMOTE_ADDR']);
	die("SUCCESS");
}

if (isset($_POST["backupcode"])) {
	
}
/* if (isset($_COOKIE['login']) == $password) {
	include 'index.php';
	die();
} */

?>
<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://amazinaxel.com/style.css"/>
		<script>

			async function readMe() {
				document.getElementById('loginBtn').innerHTML = 'Back to Login'; // Saving text
				document.getElementById('loginBtn').setAttribute("onclick", "hideReadMe()");
				document.getElementById('readme').style.display = 'unset';

				document.getElementById('login').style.display = 'none';
				document.getElementById('loginInput').style.display = 'none';

				document.getElementById('main').classList.add('animateHeight'); // anim
				document.getElementById('main').classList.remove('unanimateHeight');
				document.getElementById('main').style.height = '270px';

				document.getElementById('readme').classList.add('show');
				document.getElementById('readme').classList.remove('hide');

				document.getElementById('login').classList.add('hide');
				document.getElementById('login').classList.remove('show');
				var tempHeight = window.getComputedStyle(document.getElementById('arrow')).top;
				document.getElementById('arrow').style.top = tempHeight;

				document.getElementById('arrow').classList.add('hidearrow');
				setTimeout(function() {
					document.getElementById('arrow').style.display = 'none';
				}, 260);
			}
			async function hideReadMe() {
				document.getElementById('loginBtn').innerHTML = 'Login:'; // Saving text
				document.getElementById('readme').style.display = 'none';
				document.getElementById('loginBtn').setAttribute("onclick", "readMe()");

				document.getElementById('login').style.display = 'unset';
				document.getElementById('loginInput').style.display = 'unset';

				document.getElementById('main').classList.remove('animateHeight'); // anim
				document.getElementById('main').classList.add('unanimateHeight');
				document.getElementById('main').style.height = '118px';

				document.getElementById('readme').classList.add('hide');
				document.getElementById('readme').classList.remove('show');

				document.getElementById('login').classList.remove('hide');
				document.getElementById('login').classList.add('show');
			}

			async function login() {
				document.getElementById('loginBtn').innerHTML = 'Logging In...'; // Saving text
				let formData = new FormData();
				formData.append("password", document.getElementById('loginInput').value);
				let response = await fetch('login.php', {
					method: "POST",
					body: formData
				})
				console.log(response.status);
				console.log(response);
				if (response.status == 429) { 
					document.getElementById('loginBtn').innerHTML = 'No attemps left.';
					document.getElementById('submitLogin').classList.add('hide');
					document.getElementById('loginInput').classList.add('hide');
					document.getElementById('readMe').classList.add('show');
					document.getElementById('readMe').classList.remove('hide');
					document.getElementById('readMe').innerHTML = '<strong>NOTE: </strong>Your IP has been logged.';
					document.getElementById('readMe').setAttribute('onclick', '');
					document.getElementById('arrow').style.display = 'unset';
					document.getElementById('arrow').classList.remove('hidearrow');
					setTimeout(function() {
						document.getElementById('submitLogin').style.display = 'none';
						document.getElementById('loginInput').style.visibility = 'hidden';
						document.getElementById('loginInput').style.position = 'absolute';
						document.getElementById('backupBtn').classList.add('show');
						document.getElementById('backupBtn').style.display = 'block';
					}, 250);
				}
				else if (response.status < 200 || response.status > 300) {
					document.getElementById('loginBtn').innerHTML = 'Wrong Password! Try again.'; } // Saving text
				else {
					document.getElementById('loginBtn').innerHTML = 'Logged in! Redirecting...'; // Saving text
					// document.getElementById('main').classList.add('hide'); // fade out, doesnt work very well?
					location.reload();
				}
			}
			
			async function backup() {
				document.getElementById('loginBtn').innerHTML = 'Generating Link...'; // Saving text
				let formData = new FormData();
				formData.append("backuplink", true);
				let response = await fetch('login.php', {
					method: "POST",
					body: formData
				})
				console.log(response.status);
				console.log(response);
				if (response.status == 429) { 
					document.getElementById('loginBtn').innerHTML = 'A link was sent recently.';
					document.getElementById('submitLogin').classList.add('hide');
					document.getElementById('loginInput').classList.add('hide');
					setTimeout(function() {
						document.getElementById('submitLogin').style.display = 'none';
						document.getElementById('loginInput').style.visibility = 'hidden';
						document.getElementById('loginInput').style.position = 'absolute';
						document.getElementById('backupBtn').classList.add('show');
						document.getElementById('backupBtn').style.display = 'block';
					}, 250);
				}
				else { document.getElementById('loginBtn').innerHTML = 'Backup link sent!'; // Saving text
				}
			}

			document.onkeyup = enter; // enter key pressed bug fix
			function enter(e) { if (e.which == 13) login(); }
		</script>
		<style>
			h2 {margin-top: 0;}
			input {
				padding: 8px;
				border-radius: 10px;
				background-color: #f1f1fc;
				box-shadow: 0 1px 3px 0 #c3c3c3;
				border: 0px;
				background-color: #f6f6fd;
				box-shadow: 0 0 6px 0 #ddd;
				transition: box-shadow 0.3s;
				text-indent: 5px;
				width: 169px;
			}

			input:focus-visible {
				outline: 0;
				transition: background-color 0.3s, box-shadow 0.3s;
				box-shadow: rgb(221 221 221) 0px 0px 11px 1px;
			}

			.animateHeight {
				animation: animateHeight 0.3s cubic-bezier(0, 1.3, 0.4, 1);
			}

			.unanimateHeight {
				animation: unanimateHeight 0.3s cubic-bezier(0, 1.3, 0.4, 1);
			}

			.hidearrow { animation: hidearrow 0.4s cubic-bezier(0, 1.3, 0.4, 1)!important; }
			
			@keyframes hidearrow {
				0% { opacity: 1; }
				100% { opacity: -0.6; top: 75px; }
			}
			
			@keyframes float {
				0% { top: -85px; }
				50% { top: -100px; }
				100% { top: -85px; }
			}

			
			*, *::before, *::after { box-sizing: border-box; }

			* { margin: 0; }
		body { line-height: 1; -webkit-font-smoothing: antialiased; }

		img, picture, video, canvas, svg { display: block; max-width: 100%; }

		p, h2 { overflow-wrap: break-word; }

		</style>
	</head>
	<body>
		<noscript>
			<div class="card" style="width: 282px; margin: 0; position: absolute; left: 50%; margin-top: 50px; transform: translate(-50%, -50%);">
			<p> <strong>Please enable JavaScript.</strong> JavaScript is required to use the control panel properly. </p>
			</div></noscript>
		<div id="main" class="card" style="width: 282px; margin: 0; position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); height: 118px; transition: height 0.5s cubic-bezier(0, 1.3, 0.4, 1);">
			<h2 class="button" id="loginBtn" style="margin-bottom: 11px;" onclick="readMe()">Login:</h2>
			<div>
				<p style="padding: 15px;
						  border-radius: 15px;
						  background-color: #f1f1fc;
						  box-shadow: 0 1px 3px 0 #c3c3c3;
						  width: 282px;
						  position: absolute;
						  left: 5px;
						  animation: float 4s cubic-bezier(0.5, 0, 0.5, 1) infinite;" class="arrow" id="arrow"> <a class="button" onclick="readMe()" style="display: block; border-radius: 7px;" id="readMe">Read me before logging in.</a> </p>
				<div id="login">
					<input id="loginInput" for="1" style="display: unset;" type="password" name="date" value="" placeholder="Enter Password">
					<a id="submitLogin" class="button" onclick="login()">Login</a>
					<a id="backupBtn" class="button" onclick="backup()" style="display: none; margin-top: -5px;">Email Backup Link</a>
				</div>
				<div id="readme" style="display: none">
					<br><p> Cookies will be saved, and <strong>your IP will be logged</strong> when you click the "Login" button. </p>
					<br><p> No privacy will be guaranteed when logged into the control panel. </p>
					<a href="https://amazinaxel.com/privacy-policy"> <h2 class="button" style="margin-bottom: 0; margin-top: 20px;"> Read my Privacy Policy.</h2> </a>
				</div>
			</div>
		</div>
	</body>
</html>

