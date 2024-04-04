<? require('../../settings.php'); # This is the updated and fixed code. Put this on every page!
if (isset($_COOKIE['login']) != $password) {
	die('Please login before trying to set notifications!');
}

if (isset($_POST['sub'])) {
	$Handle = fopen("notification.txt", 'w'); // Change which folder data is stored in
	fwrite($Handle, $_POST['sub']); // Write data
	fclose($Handle); // Close
	die('successfully wrote data to file'); // Exit & don't send / process any extra data / wrap up all PHP processes
} ?>
<!DOCTYPE html>
<html>
  <head>
    <title> Push Notification Register </title>
  </head>
  <body>
    <script>
    // (A) OBTAIN USER PERMISSION TO SHOW NOTIFICATION
    window.onload = () => {
      // (A1) ASK FOR PERMISSION
      if (Notification.permission === "default") {
        Notification.requestPermission().then(perm => {
          if (Notification.permission === "granted") {
            regWorker().catch(err => console.error(err));
          } else {
            alert("Allow notifications in your browser to continue.");
          }
        });
      }

      // (A2) GRANTED
      else if (Notification.permission === "granted") {
        regWorker().catch(err => console.error(err));
      }
  
      // (A3) DENIED
      else { alert("Please allow notifications."); }
    };

    // (B) REGISTER SERVICE WORKER
    async function regWorker () {
		alert("ServiceWorker Registered Successfully, sending data to server...");
      // (B1) YOUR PUBLIC KEY - CHANGE TO YOUR OWN!
      const publicKey = "BJJTbkKjGZ1HApfLtod5Yq5Qh7U5at1sevUvcTVzW5EYeTY4I6juy9_vFqrJR_pUJFMyfaScq78TGQnXWesoPbY";

      // (B2) REGISTER SERVICE WORKER
      navigator.serviceWorker.register("sw.js", { scope: "/AlecsCP/other/notifications/" });

      // (B3) SUBSCRIBE TO PUSH SERVER
      navigator.serviceWorker.ready
      .then(reg => {
        reg.pushManager.subscribe({
          userVisibleOnly: true,
          applicationServerKey: publicKey
        }).then(
          // (B3-1) OK - TEST PUSH NOTIFICATION
          sub => {
            let data = new FormData();
            data.append("sub", JSON.stringify(sub));
            fetch("setup.php", { method: "POST", body : data })
            .then(res => res.text())
            .then(txt => console.log(txt))
            .catch(err => console.error(err));
          },
          err => console.error(err)
        );
      });
      alert("All done! Please go back and test a PUSH message!");
    }
    </script>
  </body>
</html>
