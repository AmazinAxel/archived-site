<? # add the reminders stuff here 
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
		sendNotification('REMINDER: ' . $title, $message, 'https://alecshome.com/AlecsCP/action?reminders');
	} } ?>