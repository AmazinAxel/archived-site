<?php
// (A) LOAD WEB PUSH LIBRARY
require "../../../../../vendor/autoload.php";
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

function sendNotification($title, $text, $url) {
	$url = $domain;
	$sub = Subscription::create(json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/AlecsCP/other/notifications/notification.txt'), true));

	$push = new WebPush(["VAPID" => [
		"subject" => "your email here",
		"publicKey" => "BJJTbkKjGZ1HApfLtod5Yq5Qh7U5at1sevUvcTVzW5EYeTY4I6juy9_vFqrJR_pUJFMyfaScq78TGQnXWesoPbY",
		"privateKey" => "cm5NwzKsr9-r9upWmLpQ6xIGmWX_1pFS8s3Tzk_F6ec"
	]]);
	$result = $push->sendOneNotification($sub, json_encode([
		"title" => $title,
		"body" => $text,
		"url" => $url,
		"urgency" => 'high',
		"icon" => "/favicon.png"
		//"image" => "/favicon.png"
		
  //"icon" => "PUSH-php-A.webp",
  //"image" => "PUSH-php-B.webp" # you can also look up how to add a badge and sound effect to this!! "icon" => "PUSH-php-A.webp"
]));
}