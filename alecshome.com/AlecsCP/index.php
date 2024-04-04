<? require('settings.php');
if (isset($_COOKIE['login']) != $password) {
	require 'login.php';
	die(); // add feature that when on phone it collapses everything automatically and the sidebar links are collapsed too
} 
require $_SERVER['DOCUMENT_ROOT'] . '/apis/notifications.php';
include('other/header.php');
generateHeader('Home');
?>
	<link rel="newest stylesheet" href="style.css">
	<style> /* .content { padding: 0; margin-left: 135px; margin-right: 100px; } */

		.card {height: fit-content;}
		.left{ text-align: left; margin: 0; border-radius: 10px; margin-top: 10px; }
				
		.progress {
    border-radius: 10px;
    background-color: #f6f6fd;
    box-shadow: 0 1px 3px 0 #c3c3c3;
			
    margin: auto;
    width: 250px;
    	}
		
		p { line-height: 1.3em; }
  
    	.progressinner {
    color: black;
    padding: 5px;
    text-align: center;
    font-size: 20px;
    line-height: 23px;
    border-radius: 10px;
    box-shadow: 0 1px 3px 0 #c3c3c3;
    background-color: #ffffff;
    transition: width 0.5s cubic-bezier(0.35, 1.5, 0.3, 0.9);
			/* width: 5px; BASE */
	
    	}
		.qotdText { position: relative }
		.qotdbtn, .qotdText { top: 50%; transform: translateY(-50%); margin-left: 18px; }
		
		
		.large { display: block; }
		
		.headerbtn { font-weight: bold; display: block; margin-bottom: 10px; }
		.overviewgrid { display: grid; grid-template-columns: 50% 50%; } 
		
		.listText { width: calc(50% - 400px); overflow: hidden; text-overflow: ellipsis; }
		@media (max-width: 900px) {
			.listText { width: calc(50% - 340px);  }
		}
		
		@media (max-width: 1100px) {
			.overviewgrid { display: revert; }
			.qotdbtn, .qotdText { transform: translateY(20%); margin-left: 0; }
		}
		
		
		@media (max-width: 800px) {
			.listText { width: calc(100% - 160px);  }
			.buttons { margin-top: 15px; text-align: center; float: initial; margin-right: 0; }
			.listElement { text-align: center; display: block; }
		}
		
		
</style>
<script> async function getQuote() {
		document.getElementById('qotdButton').innerHTML = 'Getting Quote of the Day...'; // Saving text		
		var xmlhttp = new XMLHttpRequest(); // Initialize AJAX request
		xmlhttp.open("GET", "<? echo $domain; ?>/other/qotd.php", true); // Open AJAX request
		xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded;"); // Encode AJAX request
		xmlhttp.send(); // Send AJAX request
		xmlhttp.onreadystatechange=function() { // Give feedback if successful
			if (xmlhttp.readyState==4 && xmlhttp.status==200) { // Show Saved text
				document.getElementById('qotdButton').remove();
				document.getElementById('qotdText').innerHTML = xmlhttp.responseText
			};
		};

	}
	
	async function deleteFile(number) {
		document.getElementById('deleteFileBtn' + number).innerHTML = 'Deleting...'; // Saving text
		let formData = new FormData();
		console.log(document.getElementById('downloadLink' + number).innerHTML);
		formData.append("delete", document.getElementById('downloadLink' + number).innerHTML);
		await fetch('action?interconn', {
			method: "POST",
			body: formData
		})
		document.getElementById('deleteFileBtn' + number).innerHTML = 'Deleted!'; // Saving text
	}
	</script>
</head>
<body>
	<div class="sidebar sidebarleft navbar">
		<a onclick="window.location.reload()" href="" class="active">AlecsCP</a>
		<a href="action?options">Options</a>
		<a href="action?projects">Projects</a>
		<a href="action?media">Media</a>
		<a href="action?voting">Voting</a>
	</div>
	<? 
	function createAnnouncement($text) { return '<div class="card oneline show" id="notice" style="margin-top: 10px; position: relative;">' . $text . '</div>'; }
	$old_date = file_get_contents("data/swrtime.txt");
		$new_date = date('m-d-Y');
		if ($old_date <= $new_date) { 
			if (date('D') == "Mon") {
				echo createAnnouncement('<p><strong> SWR Day! </strong> Would you like to start writing the SWR for today? <a href="action?swr#openswr" class="large button" style="margin-top: 10px; margin-bottom: 0;"> Write Today\'s SWR </a></p>'); }
			
			else {
				echo createAnnouncement('<p><strong> SWR Past Due! </strong> It looks like SWR day has passed. <strong>Create a new SWR post ASAP!</strong> <a href="action?swr#openswr" class="large button" style="margin-top: 10px;"> Write Today\'s SWR </a></p>'); }}
	
		if (date('D') == "Fri") {
			echo createAnnouncement('<p><strong> Happy Fun Friday! </strong> It\'s Fun Friday today! Enjoy the day. 🧋</p>'); } ?>
	
<div class="content">
		<div class="card" id="overview">
			<h2 class="button" id="overviewTitle" onclick="collapse(this)">Overview</h2>
			<p> <strong><? if (date('H') >= 11 && (date('H') <= 17)) { echo 'Good Afternoon!'; } else if (date('H') <= 10) { echo 'Good Morning!'; } else { echo 'Good Evening!'; } ?> </strong> Today is <? echo date("F jS, Y \a\\n\\d \i\\t\\'\\s g:i A"); ?>.</p>
			<? $alerts = getNotification("Alert");
			$s = "";
			if ($alerts == 0) { $alerts = "no"; $s = "s"; }
			if ($alerts >= 2) { $s = "s"; }
			echo '<div class="pop">
<label class="open" for="1" style="text-decoration: none;">You have <strong>' . $alerts . ' new</strong> alert' . $s . '. Click me to see all notifications.</label> <input id="1" type="checkbox"> <div class="popupbackground"> <div class="modal">
<h1> Alerts: </h1>' . getNotificationText("Alert") . '<h1> Info Messages: </h1> ' . getNotificationText("Info") . '<h1> Notices: </h1>' . getNotificationText("Notice") . '<label class="btn-close" for="1">Close</label></div></div></div>'; ?>
			<h2 style="margin-bottom: 5px">Overall Health:</h2><div class="progress">
        		<div class="progressinner" style="width: 100%">Good!</div>
				</div>
			<br>
			<? $lines = file('data/reminders.txt');
			$totalReminders = 0;
			$doToday = 0;

foreach ( $lines as $line) { # strtolower($title) if needed # NOTE!!!!! Update this to get it from the reminder API instead of this!!! ALSO FIX THE (s) PROBLEM BY SHOWING EITHER Reminder or Reminders depending on if it is 1 or 2+!!!!
	$date = explode('DATE: ', $line); # $date[1] SHOW REMINDERS PAST DUE AND REMNIDERS DUE TOADY BUT SEPERATE THEM! THIS IS SHWON HERE ON THE OVERVIEW!!
	$date = strtotime($date[1]);
	if (strtotime(date("n/j/y")) >= $date) { 
		$totalReminders++;
	}
	if (strtotime(date("n/j/y")) == $date) { 
		$doToday++;
	} } ?>
			<div class="overviewgrid">
				<div>
					<p>You have <strong><? echo $totalReminders; ?> reminder(s) past due.</strong></p>
					<p>You have <strong><? echo $doToday; ?> item(s)</strong> to do today.</p>
				</div>
				<div>
					<a id="qotdButton" class="large button qotdbtn" onclick="getQuote()">View Quote of the Day</a>
					<p id="qotdText" class="qotdText"></p>
				</div>
			</div>
			<br>
			<div id="showMore">
				<h2 class="button" id="showMoreTitle" onclick="reopen(this)" style="margin: 0"> Show More Links (Collapsed)</h2>
				<div id="showMore" style="display: none;">
					<a href="action?chat" class="button">Live Chat</a>
					<a href="action?media" class="button">Media</a>
					<a href="action?admin" class="button">Server Admin</a>
				</div>
			</div>
		</div>
	<div class="card">
		<a href="action?options" class="headerbtn button"> Options </a>
		<?
					if (fileperms("../dev/") == 16984) { echo '<a class="button" style="display: block;" onclick="toggleOption(this, \'enableDev\', \'Enabling Development Mode...\', \'Enabled Development Mode!\')" id="toggleDev"> Enable Development Mode </a>'; 
					} else if (fileperms("../dev/") == 16747) {
						echo "<a class='button' style='display: block;' onclick='toggleOption(this, \"disableDev\", \"Disabling Development Mode...\", \"Disabled Development Mode!\")' id='toggleDev'> Disable Development Mode </a>";
					}
					?>
		<a onclick="downloadData()" id="downloadDataBtn" class="large margin-top button"> Select Data To Download </a>
		<? require('data/logininfo.php');
	if ($attempts >= 3) { echo ' <a class="large margin-top button" id="toggleLock" onclick="toggleOption(this, \'toggleLock\', \'Disabling Control Panel Lock...\', \'Disabled Control Panel Lock!\')"> Disable Control Panel Lock </a>'; }
	else { echo '<a class="large margin-top button" id="toggleLock" onclick="toggleOption(this, \'toggleLock\', \'Locking Control Panel...\', \'Locked Control Panel!\')"> Lock Control Panel </a>'; } ?>
	</div>
		<div class="card">
			<a href="action?notes" class="headerbtn button"> Sticky Notes </a>
			<textarea cols="40" id="stickynote" name="data" rows="5" style="height: unset; resize: vertical;"><? echo file_get_contents("data/stickynote.txt"); ?></textarea>
			<a class="large button" id="stickynoteSubmit" onclick="saveNote('stickynote')">Save</a>
		</div>
		<div class="card">
			<a href="action?quickshare" class="headerbtn button"> File Sharing </a>
			<a href="action?quickshare#openupload" class="button large"> Upload AlecsHome.com File </a>
			<a href="action?quickshare#axelupload" class="button large margin-top"> Upload AmazinAxel.com File </a>
			<p style="margin-top: 15px"><? $fileCount = new FilesystemIterator("../downloads/", FilesystemIterator::SKIP_DOTS);
			$registerCount = new FilesystemIterator("data/uploads/", FilesystemIterator::SKIP_DOTS);
			$axelfileCount = new FilesystemIterator("../../../amazinaxel.com/public_html/downloads/", FilesystemIterator::SKIP_DOTS);
			$axelregisterCount = new FilesystemIterator("data/amazinaxel/uploads/", FilesystemIterator::SKIP_DOTS);
			echo "<a class='listText'><strong>" . iterator_count($fileCount) - 1 + iterator_count($axelfileCount) - 1 . "</strong> total file(s) in the download directory | <strong>" . iterator_count($registerCount) + iterator_count($axelregisterCount) . "</strong> file(s) registered in the database</a>"; ?></p>
		</div>
		<!--<iframe src="https://alecshome.com/AlecsCP/action?upload" width="100%" style="height: 235px;"></iframe>-->
		<div class="card">
			<a href="action?todo" class="headerbtn button"> To Do </a>
			<?php 
		$lines = file("data/todo.txt");
		$totalNotes = 0; foreach ( $lines as $line) { $totalNotes++; }

		$i = 0;
		foreach ( $lines as $line) {
			$i++;
			if ($i > 3) { break; } // exit
			echo '<div class="card left" id="'. $i .'" style="white-space: nowrap;">
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
					<a id="reminderBtn'. $i .'" class="button" onclick="setReminder(' . $i . ')">Set Reminder</a>
				</div>
			</div>'; } 
			echo "<br><p><strong>" . $totalNotes . "</strong> total notes</p>"; ?>
		</div>
		<div class="card">
			<a href="action?reminders" class="headerbtn button"> Reminders </a>
			<h2 style="margin: 0;"> Reminder Title: <input type="text" name="title" value="" id="remindertitle" placeholder="Input a short title here"></h2><br>
			<h2 style="margin: 0; margin-top: -8px;" class="large-margin-bottom"> Reminder Description: <input type="text" name="reminderdesc" value="" id="reminderdesc" placeholder="Input reminder description here"></h2>
			<input type="date" id="reminderdate" style="margin: 7px;">
			<a onclick="saveReminder()" id="saveReminderBtn" class="button"> Save Reminder </a>
		</div>
	<div class="card">
			<a href="action?blog" class="headerbtn button"> Blogging </a>
			<a href="action?blog#openblog" class="large margin-top button"> Create New Blog Post </a>
			<a href="action?boba#openblog" class="large margin-top button"> Create New Boba Blog Post </a>
		<a href="action?swr#openswr" class="large margin-top button"> Create New SWR Post </a>
	</div>
		<div class="card">
			<a href="action?links" class="headerbtn button"> Link Creator </a>
			<a href="action?links#openlink" class="large button"> Create New AlecsHome.com Link </a>
			<a href="action?links#axellink" class="large margin-top xlarge-margin-bottom button"> Create AmazinAxel.com (Public) Link </a>
			<? $fileCount = new FilesystemIterator("../go/", FilesystemIterator::SKIP_DOTS);
			echo "<p><strong>" . iterator_count($fileCount) - 1 . "</strong> total redirect(s)</p>" ?>
		</div>
		<div class="card">
			<a href="action?projects" class="headerbtn button"> Project Manager </a>
				<? $arrFiles = scandir('data/projects', SCANDIR_SORT_DESCENDING);
					$totalProjects = 0;

					for ($i = 0; $i < count($arrFiles); $i++) { // CHANGE THE VALUE IF THERE ARE ISSUES WITH PERIODS / .htaccess
						if ($arrFiles[$i] != '.' && $arrFiles[$i] != '..' ){
							$totalProjects++;
							echo '<a class="large button margin-top" href="action?projects&edit=' . $arrFiles[$i] . '">' . $arrFiles[$i] . '</a>'; }} ?>
		</div>
		<div class="card">
			<a href="action?vote" class="headerbtn button"> Voting </a>
			<p>Create, view, and edit voting polls!</p>
		</div>
		<div class="card">
			<a href="action?apis" class="headerbtn button"> API Manager </a>
			<p>View and edit APIs!</p>
		</div>
		<div class="card">
			<a href="action?media" class="headerbtn button"> Media Manager </a>
			<div class="buttongrid">
				<a href="action?media#alecshome" class="large button">AlecsHome.com</a>
				<a href="action?media#amazinaxel" class="large button">AmazinAxel.com</a>
			</div>
			<? $arrFiles = glob('../../../../domains/amazinaxel.com/public_html/media/*');
			usort($arrFiles, function($a, $b) {
    		return filemtime($b) - filemtime($a);
			});
			for ($i = 0; $i < 4; $i++) { // CHANGE THE VALUE IF THERE ARE ISSUES WITH PERIODS / .htaccess
				if (!str_contains($arrFiles[$i], "htaccess") && !str_contains($arrFiles[$i], "hotlink-ok")) {
				echo '<div class="card left" style="white-space: nowrap; height: 66px;">
				<h3 class="listText" style="position: relative;text-align: center"><a href="https://amazinaxel.com/media/' .basename($arrFiles[$i]) .'">' . basename($arrFiles[$i]) . '</a></h3>
				<div class="buttons"><a id="axelcopyLinkBtn'. $i .'" onclick="copyLink(\'axelcopyLinkBtn' . $i . '\', \'https://amazinaxel.com/media/' . basename($arrFiles[$i]) . '\', ' . $i . ');" class="button">Copy Link</a></div>
			</div>'; }} ?>
		</div>
	</div>

<div class="sidebar sidebarright navbar">
	<a href="action?api">APIs</a>
	<a href="action?upload">Upload</a>
	<a href="action?links">Links</a>
	<a href="action?swr">SWR</a>
	<a href="action?logout">Logout</a>
</div>
	</body>
</html>
