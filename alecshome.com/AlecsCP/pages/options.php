<?
require 'settings.php'; # This is the updated and fixed code. Put this on every page!
if (isset($_COOKIE['login']) != $password) {
	require('login.php');
	die();
}
if (isset($_POST['disableDev'])) { //
	if(chmod("../dev/",600)){ die("SUCCESS"); //
	} else { die("FAIL"); }} // 
else if (isset($_POST['enableDev'])) { //  Might need to change this to 771
	if(chmod("../dev/",363)){ die("SUCCESS"); 
	} else { die("FAIL"); }} 
else if (isset($_POST['wipeNotifications'])) { // 
	if(file_put_contents('data/alerts.txt', '')) { die("SUCCESS"); 
	} else { die("FAIL"); }} 
else if (isset($_POST['wipeTemp'])) { // 
	$files = glob('other/data/*'); // get all file names
		foreach($files as $file){ if(is_file($file)) { unlink($file); }} die('SUCCESS'); }
else if (isset($_POST['toggleLock'])) {
	require('data/logininfo.php'); 
	if ($attempts >= 3) { file_put_contents('data/logininfo.php', "<? \$attempts = 0; ?>"); }
	else { file_put_contents('data/logininfo.php', "<? \$attempts = 4; ?>"); }
	die('SUCCESS');
} else if (isset($_POST['download'])) {
	$action = strtolower($_POST['download']);
	if ($action == "all") { $folder = "../../../"; }
	else if ($action == "cp") { $folder = "/"; }
	else if ($action == "dev") { $folder = "../dev"; }
	else if ($action == "amazinaxel") { $folder = "../../../amazinaxel.com/public_html/"; }
	else if ($action == "alecshome") { $folder = "../"; }
	else if ($action == "") { die("DOWNLOADING LAST BACKUP..."); }
		// Get real path for our folder
		$rootPath = realpath($folder);
		$zip = new ZipArchive();
		$zip->open('other/data/backup.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);
		$files = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator($rootPath),
			RecursiveIteratorIterator::LEAVES_ONLY
		);

		foreach ($files as $name => $file) {
			if (!$file->isDir()) {
				$filePath = $file->getRealPath();
				$relativePath = substr($filePath, strlen($rootPath) + 1);
				$zip->addFile($filePath, $relativePath); } }
		$zip->close();
		
	die('SUCCESS');
} else if (isset($_POST['deltemp'])) {
	$files = glob('other/data/*'); // get all file names
	foreach($files as $file) { // iterate files
		if(is_file($file) && $file != ".htaccess")
			unlink($file); // delete file
		} die('SUCCESS'); }

if (isset($_POST['aboutMe'])) { 
	$lines = implode(file("../../../../domains/amazinaxel.com/public_html/about-me.html")); 
	$file = fopen("../../../../domains/amazinaxel.com/public_html/about-me.html", "w");
	$lines1 = explode('<div class="leftcolumn">', $lines);
	$endpoint = explode('<div class="navbar">', $lines);
	$lines2 = explode('<div class="card">', $endpoint[1]);
	$data = $lines1[0] . '<div class="leftcolumn"> <div class="card"><h1>About Me</h1><p>' . $_POST['aboutMe'] . '</p></div>' . "\n"; 
	for ($i = 1; $i < count($lines2); $i++) { if (!str_contains($lines2[$i], "<h1>About Me</h1>")) { $data = $data . '<div class="card">' . $lines2[$i]; }}
	$data = $data . '<div class="navbar">' . $endpoint[2];
	fwrite($file, $data);
	fclose($file); die('ABOUTMESUCCESS'); } 

else if (isset($_POST['socials'])) { 
	$lines = implode(file("../../../../domains/amazinaxel.com/public_html/about-me.html")); 
	$file = fopen("../../../../domains/amazinaxel.com/public_html/about-me.html", "w");
	$lines1 = explode('<div class="leftcolumn">', $lines);
	$endpoint = explode('<div class="navbar">', $lines);
	$lines2 = explode('<div class="card">', $endpoint[1]);
	$data = $lines1[0] . '<div class="leftcolumn">'; 
	for ($i = 1; $i < count($lines2); $i++) { if (str_contains($lines2[$i], "<h1>Social</h1>")) { $data = $data . '<div class="card"><h1>Social</h1><p>' . $_POST['socials'] . '</p></div>'; } else { $data = $data . '<div class="card">' . $lines2[$i]; }}
	$data = $data . '<div class="navbar">' . $endpoint[2]; # add echo before it to make it msg u
	fwrite($file, $data);
	fclose($file); die('SOCIALSSUCESS'); } 

else if (isset($_POST['privacyPolicy'])) { 
	$lines = implode(file("../../../../domains/amazinaxel.com/public_html/privacy-policy.html")); 
	$file = fopen("../../../../domains/amazinaxel.com/public_html/privacy-policy.html", "w");
	$lines1 = explode('<!-- main content -->', $lines); 
	$lines3 = explode('<!-- bottom navigation -->', $lines1[1]);
	$data = $lines1[0] . '<!-- main content --> <div class="card"><h1>Privacy Policy</h1>' . $_POST['privacyPolicy'] . '</div><!-- bottom navigation -->' . $lines3[1];
	fwrite($file, $data);
	fclose($file); 
	die('PRIVACYPOLICYSUCCESS'); }
include('other/header.php');
generateHeader('Options');
 ?><script>
	async function sendData(requestName, eleID) { // ONLY WORKS WITH OPTIONS PAGE AS OF NOW, FIX BEFORE USING!!!
		document.getElementById(eleID.id).innerHTML = "Saving..." // ^^^
		let formData = new FormData();// ^^^
		formData.append(requestName, document.getElementById(requestName).value);
	await fetch('action?options', {
		method: "POST",
		body: formData
	})
	document.getElementById(eleID.id).innerHTML = "Saved!"
	setTimeout(function() {
		document.getElementById(eleID.id).innerHTML = 'Save';
		}, 2000); }
</script>
<style>
	textarea { 
		overflow: hidden; } 
</style>
</head>
	<body>
		<div class="card header">
			<a class="button headerbtn" href="<? echo $domain ?>"> Site Options </a>
		</div>
		<div class="row">
			<div class="leftcolumn">
				<div class="card left" style="text-align: center;">
					<h2 class="button"> AmazinAxel.com Settings </h2>
					<h2> About Me Introduction Text: </h2>
					<?php 
					$postCount = 0;
					$lines = implode(file("../../../../domains/amazinaxel.com/public_html/about-me.html"));
					$lines1 = explode('<div class="leftcolumn">', $lines); // this line may not be needed, check??
					$lines3 = explode('<div class="navbar">', $lines);
					$posts = explode('<div class="card">', $lines);

					for ($i = 1; $i < count($posts); $i++) { // CHANGE THE VALUE IF THERE ARE ISSUES WITH CUTTING OFF POSTS, GLITCHY WHEN ITS 0??
						if (str_contains($posts[$i], "<h1>About Me</h1>")) {
							$getFirstCard = explode('</div>', $posts[$i]);
							$aboutMe = str_replace("<h1>About Me</h1>", "", $getFirstCard[0]);
							$aboutMe = str_replace("<p>", "", $aboutMe);
							$aboutMe = str_replace("</p>", "", $aboutMe);
						} else if (str_contains($posts[$i], "<h1>Social</h1>")) {
							$getFirstCard = explode('</div>', $posts[$i]);
							$socials = str_replace("<h1>Social</h1>", "", $getFirstCard[0]);
							$socials = str_replace("<p>", "", $socials);
							$socials = str_replace("</p>", "", $socials);
						if (isset($aboutMe) && isset($socials)) { break; }
						} }
					
					$lines = implode(file("../../../../domains/amazinaxel.com/public_html/privacy-policy.html")); 
					$lines1 = explode('<!-- main content -->', $lines); 
					$lines3 = explode('<!-- bottom navigation -->', $lines1[1]);
					$privacyPolicy = str_replace('<div class="card"><h1>Privacy Policy</h1>', '', $lines3[0]);
					# $privacyPolicy = str_replace('</div>', '', $privacyPolicy); // SOMETHING TO WORK ON, MIGHT TAKE A WHILE: MAKE IT SO WHEN THE PRIVACY POLICY IS SAVED, IT WILL AUTOMAGICALLY UPDATE THE TIMESTAMP (My privacy policy was lasted updated on...) AND WILL NOT SHOW UP IN THE TEXTAREA WHEN UPDATING THE PRIVACY POLICY
					$privacyPolicy = substr($privacyPolicy, 0, -7);
					
					// add a feature where on the about me page it shows age and stuff but you can edit it in here but its in its own section and it parses <p class="age"> </p> tags to get the data
					?>
					<textarea name="message" rows="5" cols="40" placeholder="Enter About Me text here (in HTML)" id="aboutMe"><? echo $aboutMe; ?></textarea>
					<a onclick="sendData('aboutMe', this)" class="large button" id="aboutMeSaveBtn"> Save </a>
					<h2 style="margin: revert;"> About Me Social Links: </h2>
					<textarea name="message" rows="5" cols="40" placeholder="Enter Social Links here (in HTML)" id="socials"><? echo $socials; ?></textarea>
					<a onclick="sendData('socials', this)" class="large button" id="socialsSaveBtn"> Save </a>
					
					<h2 style="margin: revert;"> Privacy Policy: </h2>
					<textarea name="message" rows="5" cols="40" placeholder="Enter Privacy Policy here (in HTML)" id="privacyPolicy"><? echo $privacyPolicy; ?></textarea>
					<a onclick="sendData('privacyPolicy', this)" class="large button" id="privacyPolicySaveBtn"> Save </a>
				</div>
				<div class="card left" style="text-align: center;">
					<h2 class="button"> AlecsHome.com Settings </h2>
					<h2> Homepage Text: </h2>
					<textarea name="message" rows="5" cols="40" placeholder="Enter About Me text here (in HTML)"> This feature will be added when the homepage for Alecshome is finished, maybe switch to a card style? ALSO MAKE A FEATURE THAT WILL ALLOW ME TO UPDATE THE NAVBAR YEAR FOR ALL PAGES (that are not the SWR years) AND ALLOW ME TO UPDATE THE SIDEBAR LINKS FOR EVERY SINGLE PAGE AND ALLOW UPDATING OF THE NAVIGATION HEADER BAR!!! this pretty much makes the static site dynamic AND ALSO ADD A FEATURE THAT ALLOWS ME TO CHANGE THE CACHE BUSTING VERSION FOR ALL CSS FILES EASILY so you enter in a version and it will add ?v=(NUM) to it so i can push css updates easily to the users. also when this is updated send a reminder to myself to clear the cache on Cloudflare. </textarea>
					<a onclick="sendData('aboutMe', this)" class="large button" id="aboutMeSaveBtn"> Save </a>
				</div>
				<div class="card left">
					<h2 class="button" style="margin-bottom: 5px;"> Control Panel Options</h2>
					<? #$isLock = file_get_contents('data/lock.txt');
					   require('data/logininfo.php');
	if ($attempts >= 3) { echo ' <a class="button" style="line-height: 50px;" id="toggleLock" onclick="toggleOption(this, \'toggleLock\', \'Disabling Control Panel Lock...\', \'Disabled Control Panel Lock!\')"> Disable Control Panel Lock </a>'; }
	else { echo '<a class="button" style="line-height: 50px;" id="toggleLock" onclick="toggleOption(this, \'toggleLock\', \'Locking Control Panel...\', \'Locked Control Panel!\')"> Lock Control Panel </a>'; } ?>
					<p> Locks the login page and stops users from getting CP access. </p>
					<a class="button" style="line-height: 50px;" id="downloadDataBtn" onclick="downloadData()"> Download Data </a>
					<p> Download selected control panel data to back up and save. </p> 
					<a class="button" style="line-height: 50px;" id="clearNotifications" onclick="toggleOption(this, 'wipeNotifications', 'Clearing Notifications', 'Cleared All Notifications!')"> Clear All Notifications </a>
					<p> Clears the notifications file. </p> <br>
					<? function human_filesize($bytes, $decimals = 2) {
						$size   = array('Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
						$factor = floor((strlen($bytes) - 1) / 3);
						return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
					}
					function folderSize($directory) {
						$total = 0;
						foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file) { if (!str_contains($file->getFilename(), 'htaccess')) { $total += $file->getSize(); }} return $total;
					} ?>
					<p> There are <strong><? echo human_filesize(folderSize("../AlecsCP/")); ?></strong> currently used by AlecsCP. Of this, </p>
					<p style="text-indent: 20px;"> <strong><? $count = intval(folderSize("pages/")) + intval(folderSize("friend/")); echo human_filesize($count); ?></strong> are being used by AlecsCP core files </p>
					<p style="text-indent: 20px;"> <strong><? echo human_filesize(folderSize("data/")); ?></strong> are being used by AlecsCP data files </p>
					<p style="text-indent: 20px;"> <strong><? echo human_filesize(folderSize("friend/")); ?></strong> are being used by the friends management feature </p>
					<p style="text-indent: 20px;"> <strong><? $temp = human_filesize(folderSize("other/data/")); if ($temp != "8.00KB") { echo human_filesize(folderSize("other/data/")); } else { echo "0KB"; } ?></strong> are being used by temporary system files </p>
					<a id="clearTempDataBtn" class="button" style="line-height: 50px;" onclick="toggleOption(this, 'deltemp', 'Clearing Temporary Data...', 'Cleared Temporary Data!')"> Clear Temporary Data (Saves <strong><? $temp = human_filesize(folderSize("other/data/")); if ($temp != "8.00KB") { echo human_filesize(folderSize("other/data/")); } else { echo "0KB"; } ?></strong>)</a>
				</div>
			</div>
			<aside>
				<div class="card right">
					<h2 style="margin-top: 5px; display: block;" class="button"> Development </h2>
					<?
					if (fileperms("../dev/") == 16984) { echo '<a class="large button" onclick="toggleOption(this, \'enableDev\', \'Enabling...\', \'Enabled!\')" id="toggleDev"> Enable </a><br>'; 
					} else if (fileperms("../dev/") == 16747) {
						echo "<a class='large button' onclick='toggleOption(this, \"disableDev\", \"Disabling...\", \"Disabled!\")' id='toggleDev'> Disable </a><br>";
					}
					if(strpos(file_get_contents("../dev/.htaccess"),'AuthType') !== false) {
					echo '<input type="text" id="httpPassword" value="" style="width: 100%;" placeholder="Enter a password here">'; } # No password set
					else { echo '<input type="text" id="httpPassword" value="" style="width: 100%;" placeholder="Update password here">'; } # Password is set ?>
					</div>
				<div class="card right" style="padding-bottom: 8px;">
					<h2 class="large button"> Integration: </h2>
					<? if (file_exists('apis/.htaccess')) { echo '<a class="large button margin-top xlarge-margin-bottom" onclick="toggleOption(this, \'enableDev\', \'Disabling...\', \'Disabled!\')" id="toggleDev"> Disable ACPManager </a>';
					} else { echo '<a class="large button margin-top xlarge-margin-bottom" onclick="toggleOption(this, \'enableDev\', \'Enabling...\', \'Enabled!\')" id="toggleDev"> Enable ACPManager </a>'; }?>
				</div>
				<div class="card right">
					<h2 class="large button"> Other: </h2>
					<a href="https://alecshome.com/AlecsCP/other/notifications" class="button margin-top" style="display: block;"> Open Notification Manager </a>
					<a href="https://alecshome.com/AlecsCP/other/download" class="button margin-top" style="display: block;"> Download Last Backup </a>
				</div>

			</aside>
		</div>
	</body>
</html>
