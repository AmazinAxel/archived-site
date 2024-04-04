<? include '../settings.php'; # This is the updated and fixed code. Put this on every page!
if (isset($_COOKIE['login']) != $password) {
	require('../login.php');
	die();
}
header('Content-Disposition: attachment; filename="AlecsCP-backup.zip"');
readfile('data/backup.zip');