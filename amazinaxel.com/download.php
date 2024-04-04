<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://amazinaxel.com/style.css"/>
		<script>
			window.onload = function() {
				tempHeight = document.getElementById('main').clientHeight - 40; // remove 40px from padding
				document.documentElement.style.setProperty('--height', tempHeight + 'px');
			};

			async function readMe() {
				document.getElementById('login').innerHTML = 'Back to Download'; // Saving text
				document.getElementById('login').setAttribute("onclick", "hideReadMe()"); // set text
				document.getElementById('readme').style.display = 'unset'; // show readme
				document.getElementById('info').style.display = 'none'; // hide info

				document.getElementById('main').classList.add('animateHeight'); // anim
				document.getElementById('main').classList.remove('unanimateHeight');

				document.getElementById('main').style.height = '338px';
				document.getElementById('main').style.minHeight = '338px';

				document.getElementById('readme').classList.add('show');
				document.getElementById('readme').classList.remove('hide');

				document.getElementById('info').classList.remove('show');
				document.getElementById('info').classList.add('hide');
			}

			async function hideReadMe() {
				document.getElementById('login').innerHTML = 'Download:'; // Saving text
				document.getElementById('login').setAttribute("onclick", "readMe()"); // set text
				document.getElementById('info').style.display = 'unset'; // show info
				document.getElementById('readme').style.display = 'none'; // hide readme

				document.getElementById('main').classList.remove('animateHeight'); // anim
				document.getElementById('main').classList.add('unanimateHeight');

				document.getElementById('main').style.height = tempHeight + 'px';
				document.getElementById('main').style.minHeight = tempHeight + 'px';

				document.getElementById('readme').classList.add('hide');
				document.getElementById('readme').classList.remove('show');

				document.getElementById('info').classList.remove('hide');
				document.getElementById('info').classList.add('show');
			}

			async function copyLink() {
				document.getElementById('copyBtn').innerHTML = 'Download Link Copied!'; // Saving text
				navigator.clipboard.writeText(document.getElementById('copyLinkBtn').getAttribute("href"));
				// get link from the other button and then copy it to clipboard
				setTimeout(function() {
					document.getElementById('copyBtn').innerHTML = 'Copy Download Link';
				}, 2000);
			}

			async function downloading() {
				document.getElementById('downloadBtn').innerHTML = 'Download Started!'; // Saving text
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
			.pop input:checked + .popupbackground {background: rgb(241 241 252); }

			.animateHeight {
				animation: animateHeight 0.35s cubic-bezier(0, 0.7, 0, 1);
			}

			.unanimateHeight {
				/* animation: unanimateHeight 0.35s cubic-bezier(0.5, 0, 0, 1.2); BOUNCE */
				animation: unanimateHeight 0.35s cubic-bezier(0, 0.7, 0, 1);
			}

			.show { animation-duration: 0.6s; animation-name: show; }

			.hide { animation-duration: 0.6s; animation-name: hide; }

			@keyframes animateHeight {
				0% {
					height: var(--height); /* SIZE  */
					min-height: var(--height); /* SIZE  */
				}
				100% {
					height: 338px; /* 338px */
					min-height: 338px; /* 338px */
				}
			}

			@keyframes unanimateHeight {
				0% {
					height: 338px; /* 338px */
					min-height: 338px; /* 338px */
				}
				100% {
					height: var(--height); /* SIZE  */
					min-height: var(--height);  /* SIZE  */
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

		</style>
	</head>
	<body id="body">
		<div id="main" class="card" style="width: 257px; margin: 0; position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%);">
			<h2 class="button" id="login" style="margin-bottom: 11px;" onclick="readMe()">Download:</h2>
			<div id="info">
				<br>
				<? if (!isset ($_GET['file'])){
				echo '<p><strong> Error getting file: </strong><br> No file selected! <br> The link may be malformed. </p><br><h2 class="button" style="margin: 0;" onclick="readMe()"> <a>View More Information</a> </h2>'; } 
				else if (!file_exists('../../alecshome.com/public_html/AlecsCP/data/amazinaxel/uploads/' . $_GET['file'] . ".txt")) { echo '<p><strong> Error getting file: </strong><br> File not found! <br> The file may have been deleted. </p><br><h2 class="button" style="margin: 0;" onclick="readMe()"> <a>View More Information</a> </h2>'; }
				else {

				$data = explode("~", file_get_contents('../../alecshome.com/public_html/AlecsCP/data/amazinaxel/uploads/' . $_GET['file'] . ".txt"));
				$size = $data[0];
				$description = $data[1];
				$date = $data[2];
				echo '<p><strong>File name: </strong>' . $_GET['file'] . '</p>
				<p><strong>Date: </strong>' . $data[2] . '</p>
				<p><strong>Size: </strong>' . $data[0] . '</p>
				<br>
				<p><strong>Description: </strong>' . $data[1] . '</p>
				<br>
				<a id="copyBtn" class="button" onclick="copyLink()" style="display: block; margin-bottom: 10px;">Copy Download Link</a>
				<a href="https://amazinaxel.com/downloads/' . $_GET['file'] . '" onclick="downloading()" id="copyLinkBtn" download> <h2 id="downloadBtn" class="button" style="margin: 0;"> Download File</h2> </a>';

				} ?>
			</div>
			<div id="readme" style="display: none;">
				<h3> What is this?</h3>
				<p> This is my custom file hosting service used to temporarily allow downloading for a certain file. </p>
				<h3> Security Notes: </h3>
				<p> I always recommend running a virus scan after downloading a file to make sure it isn't malicious. The download server is in the US. </p>
				<a href="https://amazinaxel.com/privacy-policy"><h2 class="button" style="margin-bottom: 0; margin-top: 20px;"> Read my privacy policy. </h2></a>
			</div>
		</div>
	</body>
</html>