<!DOCTYPE HTML>
<html>
    <head>
        <link rel="stylesheet" href="https://amazinaxel.com/contact-form.css"/>
        <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    </head>
<?php
define('EMAIL_TO', 'your email here'); // Set this to the email you want the form to send to

//define('CAPTCHA1', rand(1,10));
//define('CAPTCHA2', rand(1,10));

$old_date = file_get_contents("contact-form.txt");
$new_date = date('m-d-Y_H:i:s');
if ($old_date > $new_date) { echo "<div class=\"card\"><h3> Someone has already sent a message recently, please try sending your message later. </h3> </div> <br>"; }

if ($_POST) {
	$title = htmlspecialchars(stripslashes(trim($_POST['title'])));
	$name = htmlspecialchars(stripslashes(trim($_POST['name'])));
	$email = htmlspecialchars(stripslashes(trim($_POST['email'])));
	$message = htmlspecialchars(stripslashes(trim($_POST['message'])));
	$captcha= $_POST['cf-turnstile-response'];
	#$captcha = htmlspecialchars(stripslashes(trim($_POST['captcha'])));
	#$captcha1 = htmlspecialchars(stripslashes(trim($_POST['captcha1'])));
	#$captcha2 = htmlspecialchars(stripslashes(trim($_POST['captcha2'])));
	if ((isset($_POST['website'])) || (isset($_POST['state'])) || (isset($_POST['country']))) { $robot = true; } // honeypot
	// check IP using stopforumspam.org:
    $inrbl = true;
    $subnets = explode('.',$_SERVER['REMOTE_ADDR']);
    $rev_ip = implode('.', array_reverse($subnets));
    $query = $rev_ip.'.i.rbl.stopforumspam.org';
    $res = gethostbyname($query);
    $rbl_res = explode('.',$res);
    if ($query != $res && $rbl_res[0] == 127 && $rbl_res[1] >= 2 && $rbl_res[2] < 7) { $inrbl = false; }
    
    // use the Cloudflare Turnstile API:
    $secretKey = "0x4AAAAAAAEGFUPmqoCKgFRbVnt4YhZZfts";
    $ip = $_SERVER['REMOTE_ADDR'];

    $url_path = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';
    $data = array('secret' => $secretKey, 'response' => $captcha, 'remoteip' => $ip);
	
	$options = array(
		'http' => array(
		'method' => 'POST',
		'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
		'content' => http_build_query($data))
	);
	
	$stream = stream_context_create($options);
	
	$result = file_get_contents($url_path, false, $stream);
	
	$response =  $result;
   
   $responseKeys = json_decode($response,true);
    
// if the last mail was sent recently:
$old_date = file_get_contents("contact-form.txt");
$new_date = date('m-d-Y_H:i:s');
//$timer = 0;

//if ($old_date > $new_date) { echo "<br> The code will not run!"; $timer = 1; }


// the user can continue:

// Errors
	if (empty($title) || empty($message)) { $msg = ' Your title or message is blank! '; }
	//else if ($old_date > $new_date) { $msg = ' Someone else has already sent a message recently. Please try resending your message later. '; }
	else if ($old_date > $new_date) {}
	else if (!$email == '' && (!strstr($email,'@') || !strstr($email,'.'))) { $msg = ' Your Email address is not formatted correctly! '; }
	//else if (($captcha1 + $captcha2) != $captcha) { $msg = ' The captcha is incorrect! Please try again. '; }
	else if (!$captcha) { $msg = ' There was an issue with the captcha. Please try again. '; }
	else if (intval($responseKeys["success"]) !== 1) { $msg = ' The captcha was entered incorrectly. Please try again. '; }
	else if (!(empty($website)) || !(empty($state)) || !(empty($country))) { $msg = ' My spam detect has detected you as a robot! Please try again. '; }
	else if (!($inrbl)) { $msg = ' Your IP adress was blocked due to being listed on the <a href="stopforumspam.com">StopForumSpam</a> database! Please try contacting me through other means or use a different IP. '; }
	
// Create Email headers
	else {
	    
	    $file_date = date('m-d-Y_H:i:s', strtotime("10 minutes"));
        file_put_contents('contact-form.txt', $file_date);
	    
        if (empty($email)){
            $email = "No Email Entered";
        }
        if (empty($name)){
            $name = "No Name Entered";
        }
        
		$headers = "Title: ".$title." <".$email.">\r\n";
		$headers .= "Reply-To: ".$title." <".$email.">\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

// Create Email body
		$body = '
		<html><body>
		You recieved a new message from the contact form on AmazinAxel.com! <br>
		Email Subject: <b>'.$title.'</b> <br>
		Email Address: <b>'.$email.'</b> <br>
		Name: <b> '.$name.'</b> <br><hr><br>
		Message: <br>'.$message.' 
		</body></html>
		';

// Send the email and reset form
		mail(EMAIL_TO, 'New Message: ' .$title, $body, $headers);
		$title = '';
		$name = '';
		$email = '';
		$message = '';
		$msg = ' Your message has been successfully sent! ';
	}
}

?>

<body>
<?php if (isset($msg)) { echo "<h2>" . $msg . "</h2>"; } 
/* NOTE: WHEN STYLING THIS PAGE FOR LIGHT AND DARK MODE:
USE THIS! https://developers.cloudflare.com/turnstile/get-started/client-side-rendering/ AND THEN GO DOWN TO THEME AND USE THAT!! */
?>


<form method="POST">
<p>* Subject: <input type="text" name="title" value="<?php if (isset($title)){ echo $title; } ?>"/></p>
<p>Email: <input type="text" name="email" value="<?php if (isset($email)){ echo $email; } ?>"/></p>
<p>Name: <input type="text" name="name" value="<?php if (isset($name)){ echo $name; } ?>"/></p>
<input type="text" name="state" value=""/>
<input type="text" name="website" value=""/>
<p>* Message: <br><textarea name="message" rows="5" cols="40"/><?php if (isset($message)){ echo $message; } ?></textarea></p>
<!-- <p>* <?php //echo CAPTCHA1; ?> + <?php //echo CAPTCHA2; ?> = <input type="text" name="captcha" class="numInput"/></p>
<input type="hidden" name="captcha1" value="<?php //echo CAPTCHA1; ?>"/>
<input type="hidden" name="captcha2" value="<?php //echo CAPTCHA2; ?>"/> -->
<div class="cf-turnstile" data-sitekey="0x4AAAAAAAEGFTl2ESubJ-n9"></div>
<p><input type="submit" class="button" value="Submit"/></p>
<p>* = required</p>
</form>

</body>
</html>