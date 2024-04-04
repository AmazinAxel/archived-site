<?
if (isset ($_GET['get'])){
	#echo getNotificationText("Alert");
	if(!isset($_COOKIE['apipass'])) { exit('Auth Fail (403) | Authkey not set'); }
	if(!isset($_COOKIE['apipass']) == "CookiePasswordKey(@(%KMKG(#AlecsCP9!*%/!#48") { exit('Auth fail (403) | Authkey invalid'); }
	$lines = file('../data/alerts.txt');
    $service = $_GET['get']; // alecshome.com/AlecsCP/apis/notifications?get=info
    
    if ($service == "info" || $service == "information"){
        $infoCount = getNotification("Info");
		echo $infoCount;
		die();
    }
    
    else if ($service == "notice" || $service == "notices"){ // alecshome.com/AlecsCP/apis/misc?get=todo
        $noticeCount = getNotification("Notice");
		echo $noticeCount;
		die();
    }
		
	else if ($service == "alert" || $service == "alerts"){ // alecshome.com/AlecsCP/apis/misc?get=todo
        $alertCount = getNotification("Alert");
		echo $alertCount;
		die();
    }
    
    exit('Service not found (404) | Service deleted or moved'); // service not found or is offline
}

function getNotification($type) { 
	$lines = file($_SERVER['DOCUMENT_ROOT'] . '/data/alerts.txt');

	if ($type == "Alert") {
		$alertCount = 0;
		foreach ( $lines as $line ) { # strtolower($title) if needed
			$message = explode(' > ', $line); # $level[0]
			if ($message[0] == "ALERT") { $alertCount++; }
		} return $alertCount;
		
	} else if ($type == "Info") {
		$infoCount = 0;
		foreach ( $lines as $line ) { # strtolower($title) if needed
			$message = explode(' > ', $line); # $level[0]
			if ($message[0] == "INFO") { $infoCount++; }
		} return $infoCount;
		
	} else if ($type == "Notice") {
		$noticeCount = 0;
		foreach ( $lines as $line ) { # strtolower($title) if needed
			$message = explode(' > ', $line); # $level[0]
			if ($message[0] == "NOTICE") { $noticeCount++; }
		} return $noticeCount; }} 

function getNotificationText($type) { 
	$lines = file($_SERVER['DOCUMENT_ROOT'] . '/data/alerts.txt');

	if ($type == "Alert") {
		$alertMessage = "";
		foreach ( $lines as $line ) { # strtolower($title) if needed
			$message = explode(' > ', $line); # $level[0]
			if ($message[0] == "ALERT") { $alertMessage = $alertMessage . $message[1] . "\n <br>"; }
		} 
		if ($alertMessage == NULL) { $alertMessage = "No alert messages."; }
		return $alertMessage;
		
	} else if ($type == "Info") {
		$infoMessage = "";
		foreach ( $lines as $line ) { # strtolower($title) if needed
			$message = explode(' > ', $line); # $level[0]
			if ($message[0] == "INFO") { $infoMessage = $infoMessage . $message[1] . "\n <br>"; }
		} 
		if ($infoMessage == NULL) { $infoMessage = "No info messages."; }
		return $infoMessage;
		
	} else if ($type == "Notice") {	
		$noticeMessage = "";
		foreach ( $lines as $line ) { # strtolower($title) if needed
			$message = explode(' > ', $line); # $level[0]
			if ($message[0] == "NOTICE") { $noticeMessage = $noticeMessage . $message[1] . "\n <br>"; }
		} 
		if ($noticeMessage == NULL) { $noticeMessage = "No notices."; }
		return $noticeMessage; }} 

function addNotification($type, $message) {
	include($_SERVER['DOCUMENT_ROOT'] . '/other/functions.php');

	if ($type == "Alert") {
		file_prepend('/data/alerts.txt', 'ALERT > ' . $message);
	} else if ($type == "Info") {
		file_prepend('/data/alerts.txt', 'INFO > ' . $message);
	} else if ($type == "Notice") {	
		file_prepend('/data/alerts.txt', 'NOTICE > ' . $message);
	}} 
?>

