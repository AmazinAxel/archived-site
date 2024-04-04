<? #how its gonna work:
#its simply gonna scan the reminders text file and compare the dates of it to see if it matches todays date
#if it does, send a PUSH notification using the push notification api
require '../notifications/notifications.php';
# require '../../../../AlecsCP/other/notifications/notifications.php';
$lines = file('../../data/reminders.txt');
#echo date("n/j/y");
function get_string_between($string, $start, $end){
			$string = ' ' . $string;
			$ini = strpos($string, $start);
			if ($ini == 0) return '';
				$ini += strlen($start);
				$len = strpos($string, $end, $ini) - $ini;
				return substr($string, $ini, $len);
			}


foreach ( $lines as $line) { # strtolower($title) if needed
	$date = explode('DATE: ', $line); # $date[1]
	$date = strtotime($date[1]);
	if (strtotime(date("n/j/y")) >= $date) { 
		# get title description
		$title = get_string_between($line, 'TITLE: ', 'MESSAGE: ');
		$message = get_string_between($line, 'MESSAGE: ', 'DATE: ');
		sendNotification('REMINDER: ' . $title, $message, $domain . '/action?reminders');
	} } ?>