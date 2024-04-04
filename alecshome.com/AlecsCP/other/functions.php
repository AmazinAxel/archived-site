<?
# Prepending a line on a file:
function file_prepend($filename, $string) {
	$fileContent = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/AlecsCP' . $filename);
	file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/AlecsCP' . $filename, $string . "\n" . $fileContent);
}
