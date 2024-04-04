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
				document.getElementById('input').style.display = 'none';

				document.getElementById('main').classList.add('animateHeight'); // anim
				document.getElementById('main').classList.remove('unanimateHeight');

				document.getElementById('readme').classList.add('show');
				document.getElementById('readme').classList.remove('hide');

				document.getElementById('login').classList.add('hide');
				document.getElementById('login').classList.remove('show');


			}
			async function hideReadMe() {
				document.getElementById('loginBtn').innerHTML = 'Alternative Login:'; // Saving text
				document.getElementById('loginBtn').setAttribute("onclick", "readMe()");
				document.getElementById('readme').style.display = 'none';

				document.getElementById('login').style.display = 'unset';
				document.getElementById('input').style.display = 'unset';

				document.getElementById('main').classList.remove('animateHeight'); // anim
				document.getElementById('main').classList.add('unanimateHeight');

				document.getElementById('readme').classList.add('hide');
				document.getElementById('readme').classList.remove('show');

				document.getElementById('login').classList.remove('hide');
				document.getElementById('login').classList.add('show');


			}
		</script>
		<style>
			.left{ text-align: left; }
			h2 {margin-top: 0;}
			.upload {position: relative; top: 12px;}
			.buttons {float: right; margin-right: -10px;}
			input{
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
				resize: vertical;
				width: -webkit-fill-available;
			}
			aside a:hover { text-decoration: none; }
			input[type="checkbox"] {
				cursor: pointer;
				margin-left: 5px;
				box-shadow: 0 1px 3px 0 #c3c3c3;
			}
			::-webkit-scrollbar { display: none; }

			.animateHeight {
				animation: animateHeight 0.3s ease;
			}

			.unanimateHeight {
				animation: unanimateHeight 0.3s ease;
			}

			.show { animation-duration: 0.5s; animation-name: show; }

			.hide { animation-duration: 0.5s; animation-name: hide; }


			@keyframes animateHeight {
				0% {
					height: 79px; /* 79px */
					min-height: 79px; /* 79px */
				}
				100% {
					height: 231px; /* 231px */
					min-height: 231px; /* 231px */
				}
			}

			@keyframes unanimateHeight {
				0% {
					height: 231px; /* 231px */
					min-height: 231px; /* 231px */
				}
				100% {
					height: 79px; /* 79px */
					min-height: 79px; /* 79px */
				}
			}

			@keyframes hide {
				0% { opacity: 1; }
				100% { opacity: 0; }
			}

			@keyframes show {
				0% { opacity: 0; }
				100% { opacity: 1; }
			}
			
			body {
				background-image: url(bg.svg);
				background-position: center;
				background-size: cover;
				background-attachment: fixed;
			}
			
			.button {
				box-shadow: inset 0 1px 20px 6px rgb(255 255 255 / 15%), inset 0 -1px 0 rgb(255 255 255 / 10%), 0 1px 0 rgb(0 0 0 / 10%);
    background: rgb(255 255 255 / 38%);
				transition: background-color .3s,box-shadow .3s, transform .3s;
			}
			
			.button:hover {
				box-shadow: none;
    cursor: pointer;
    transform: scale(1.05, 1.1);
				box-shadow: inset 0 1px 20px 6px rgb(255 255 255 / 15%), inset 0 -1px 0 rgb(255 255 255 / 10%), 0 1px 0 rgb(0 0 0 / 10%);
			}
			
			.button:active {
				    box-shadow: inset 0 1px 20px 6px rgb(255 255 255 / 15%), inset 0 -1px 0 rgb(255 255 255 / 10%), 0 1px 0 rgb(0 0 0 / 10%);
				background-color: rgb(255 255 255 / 38%);
				transform: scale(0.85, 0.9);
			}
		</style>
	</head>
	<body>
		<!--<div class="card" style="width: 257px; margin: 0; position: absolute; left: 50%; margin-top: 50px; transform: translate(-50%, -50%);">
<p> JavaScript is required to login. </p>
<br>
<p> Lockdown mode is enabled. </p>
<br>
<p> Development mode is enabled. </p>
</div>-->
		<div id="main" class="card" style="width: 257px; margin: 0; position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); 
										   box-shadow: inset 0 1px 20px 6px rgb(255 255 255 / 15%), inset 0 -1px 0 rgb(255 255 255 / 10%), 0 1px 0 rgb(0 0 0 / 10%);
										   background: rgb(255 255 255 / 40%); backdrop-filter: blur( 5px );">
			<h2 class="button" id="loginBtn" style="margin-bottom: 11px;" onclick="readMe()">Alternative Login:</h2>
			<div>
				<div id="login">
					<input id="input" for="1" style="display: unset;" type="text" name="date" value="" placeholder="Enter Password Here">
					<a id="loginBtn" href="#" class="button">Login</a>
				</div>
				<div id="readme" style="display: none">
					<br><p> Cookies will be saved, and <strong>your IP will be logged</strong> when you click on the "Login" button. </p>
					<br><p> No privacy will be guaranteed when logged into the admin panel. </p>
					<h2 class="button" style="margin-bottom: 0; margin-top: 20px;"><a href="https://amazinaxel.com/privacy-policy"> Read this before logging in. </a></h2>
				</div>
			</div>
		</div>
	</body>
</html>