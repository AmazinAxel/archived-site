<? # This file contains APIs used for the following:
# Sticky Notes, To-Do list, etc...

# ADD FEATURE TO DETECT LOCKDOWN MODE!! 
if(!isset($_COOKIE['apipass'])) { exit('Auth Fail (403) | Authkey not set'); }
if(!isset($_COOKIE['apipass']) == "CookiePasswordKey(@(%KMKG(#AlecsCP9!*%/!#48") { exit('Auth fail (403) | Authkey invalid'); }

if (isset ($_GET['get'])){
    $service = $_GET['get']; // alecshome.com/AlecsCP/apis/misc?get=notes
    
    if ($service == "notes" || $service == "stickynotes"){
        exit(file_get_contents('../data/stickynote.txt'));
    }
    
    if ($service == "todo" || $service == "todolist"){ // alecshome.com/AlecsCP/apis/misc?get=todo
        exit(file_get_contents('../data/todo.txt')); 
    }
    
    exit('Service not found (404) | Service deleted or moved'); // service not found or is offline
}

exit('Service not found (404) | Service deleted or moved'); // server was pinged, return online status