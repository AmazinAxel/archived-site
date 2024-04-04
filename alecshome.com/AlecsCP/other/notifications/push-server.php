<?php
require('../../settings.php'); # This is the updated and fixed code. Put this on every page!
if (isset($_COOKIE['login']) != $password) {
	die('Please login before trying to test notifications!');
}

require ('notifications.php');
sendNotification('Server PUSH Method Test', 'If you\'re recieving this message, the notification system works!', $domain);