<? if (isset($_POST["wipenotifications"]) == true) { file_put_contents('notification.txt', ' None set '); die('SUCCESS'); } ?>
<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://amazinaxel.com/style.css"/>
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
		</style>
		<script>
			async function wipeNotifications() {
				document.getElementById('wipenotifications').innerHTML = "Wiping Notifications..."
				let formData = new FormData();
				formData.append('wipenotifications', true);
				await fetch('index.php', {
					method: "POST",
					body: formData
				})
				document.getElementById('wipenotifications').innerHTML = "Notifications Wiped!"
			}
		</script>
	</head>
	<body>
		<div class="card header">
			<h2 class="button" style="margin: 0;"> Notifications </h2>
		</div>
		<div class="row">
			<div class="leftcolumn">
				<div class="card left" style="text-align: center;">
					<h2 class="button"> Transferring Servers </h2>
					<p> Transferring servers and need to get notifications working again? Here are some basic steps: <br> 1: First, install Composer <br> 2: Run command: composer require minishlink/web-push <br> 3: Make sure the plugin OpenSSL is enabled <br> 4: Generate VAPID Keys: <? require "../../../../../vendor/autoload.php"; use Minishlink\WebPush\VAPID;
$keyset = VAPID::createVapidKeys();
// public key - this needs to be accessible via an API endpoint
echo $keyset["publicKey"];
// private key - never expose this!
#echo $keyset["privateKey"]; # UNCOMMENT THIS!
#file_put_contents("vapid.json", json_encode($keyset)); ?> <br> Step 5: Add yourself below</p>
				</div>
				<div class="card left">
					<h2 class="button" style="margin-bottom: 5px;"> Add Yourself! </h2>
					<p> This writes all your notification details to a file that is used in reference to send you notifications. By clicking the link below, you agree that your data will be saved in a file to send notifications. This could expose personal details and if you used this before, any device that clicked the link below will no longer recieve notifications as the text file is overwritten. </p>
					<p> Add yourself to the list of notified users by clicking the button below.</p> <a href="setup.php" class="button" style="display: block;"> Set Notification User </a>
				</div>
				<div class="card">
					<h2 class="button"> Test Notifications </h2>
					<p> Send a test notification by clicking below! </p>
				    <a href="push-server.php" class="button" style="display: block;"> Send a Server PUSH! </a>
				</div>
				<div class="card">
					<h3 style="margin-top: 5px;"> Security: </h3>
					<a class="button" id="wipenotifications" onclick="wipeNotifications()" style="display: block; width: -webkit-fill-available;">Wipe Notification File</a>
				</div>
			</div>
		</div>
	</body>
</html>
