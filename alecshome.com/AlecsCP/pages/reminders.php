<?
# parse todo file by line
# put a - before to mark that its done
# allow deletion and creation (creating appends it to top)
# when saving just loop through all items and if it is finished then add a slash & send as big data file
# and maybe add thing where you make it go up and down

# add a scan reminders button that just runs the reminder cronjob to resend any notifications due today
# ALL INEED TO DOI TO FINISH REMINDERS 

# !!! WHAT I NEED TO DO!!
# Fix the creating function and the metadata so when you save it, it all works!
# some metadata things arent being changed???
error_reporting(E_ALL);
ini_set('display_errors', true);
require 'settings.php'; # This is the updated and fixed code. Put this on every page!
if (isset($_COOKIE['login']) != $password) {
	require('login.php');
	die();
}
if (isset($_POST["new"])) {
	# APPEND THE DATA FROM NEW TO THE REMINDERS FILE!! ADD IT TO THE TOP
	# THEN USE THIS SAME CODE TO MAKE THE APPEND FUNCTIONS FOR THE ALERTS / NOTIFICATIONS!
	# THEN ADD ALL OF THIS CODE TO THE OTHER TODO AND NOTES PAGES (ALLOW CHANGING OF DATE BEFORE SAVING)
	# TO MAKE ALL OF THE PAGES INTERCONNECT, FINISH THE CODE FOR THE scripts.js fiLE!!!
	function file_prepend ($string, $filename) {
		$fileContent = file_get_contents ($filename);
		file_put_contents ($filename, $string . "\n" . $fileContent);
}
	file_prepend($_POST["new"], 'data/reminders.txt');
}


if (isset($_POST["item1"]) && isset($_POST["count"])) {
    $Handle = fopen("data/reminders.txt", 'w'); // Change which folder data is stored in
    for ($i = 1; $i < $_POST["count"] + 1; $i++) {
        #$_POST["item" . $i] = str_replace(array("\n"), '', $_POST["item" . $i]);
	    #echo $_POST["item" . $i] . "\n";
	    #$Handle = fopen("../data/todo.txt", 'w'); // Change which folder data is stored in
    	fwrite($Handle, str_replace(array("\n"), '', $_POST["item" . $i]) . "\n"); // Add line
    }
    fclose($Handle); // Close
	die('SUCCESS'); // Exit script
} 

include('other/header.php');
generateHeader('Reminders'); ?>
<style>
			p { line-height: 18px; }

			.hide { animation: hide 1s cubic-bezier(0, 1.3, 0.4, 1) }

			@keyframes hide { 0% { opacity: 1; line-height: 18px; margin-top: 20px; } 25% { opacity: 0 } 45% { line-height: 0px; margin-top: 0; } 100% { opacity: 0; height: 0} }

			@keyframes show { 0% { opacity: 0; line-height: 0px; margin-top: 0; } 45% { line-height: 18px; margin-top: 20px; } 100% { opacity: 1; } }
			
			.default p { line-height: 18px; text-align: center; }
			
			
			.show1 { animation: show1 1s cubic-bezier(0, 1.3, 0.4, 1) }

			.hide1 { animation: hide1 1.5s cubic-bezier(0, 1.3, 0.4, 1); }


			@keyframes hide1 { 0% { opacity: 1; top: 0; } 45% { top: -50px; opacity: 0; } 100% { } }

			@keyframes show1 { 0% { opacity: 0; top: -50px; } 45% { top: 0; } 100% { opacity: 1; } }
	
	.animateBottom { animation: animateBottom 0.4s cubic-bezier(0, 1.3, 0.4, 1) 0s }
		@keyframes animateBottom { 0% { top: -163px; } 100% { top: 0 } }
		.revanimateBottom { animation: revanimateBottom 0.4s cubic-bezier(0, 1.3, 0.4, 1) 0s }
		@keyframes revanimateBottom { 0% { top: 163px; } 100% { top: 0 } }
		
		.show { animation: show 1s cubic-bezier(0, 1.3, 0.4, 1) }


		</style>
		<script>
			async function save() {
				event.preventDefault(); // Prevent auto reload of page
				let formData = new FormData();
				formData.append("count", totalItems)
				
// 				formData.append("description", document.getElementById('fileDescription').value);
// 				formData.append("name", document.getElementById('fileName').value);
			    for (i = totalItems; i > 0; i--) {
                    formData.append("item" + i, 'TITLE: ' + document.getElementById('metatitle' + i).innerHTML + ' MESSAGE: ' + document.getElementById('metadesc' + i).innerHTML + ' DATE: ' + document.getElementById('metadate' + i).innerHTML)
                    
					console.log("finished: " + i);
				};

				//for (i = 1; i < totalItems + 1; i++) {
				//	console.log(document.getElementById('completed' + i).checked);
				//}
				document.getElementById('saveBtn').innerHTML = 'Saving...'; // Saving text
 				await fetch('#', {
 					method: "POST",
 					body: formData
 				})
				document.getElementById('saveBtn').innerHTML = 'Saved!'; // Saving text
				setTimeout(function() {
					document.getElementById('saveBtn').innerHTML = 'Save All Items';
				}, 1000);
			}

			async function cancelAddItem() {
				document.getElementById('addItemBtn').innerHTML = 'Create New Item'; // Saving text
				document.getElementById('addItemBtn').setAttribute("onclick", "addItem()");
				document.getElementById('addDescription').style.display = 'none';
				document.getElementById('addItem').style.display = 'none';
				document.getElementById('mainaddNewItemBtn').style.display = 'none';
				document.getElementById('mainDate').style.display = 'none';
				document.getElementById('header').style.height = "190px"
				document.getElementById('createnew').classList.remove('show1');
				document.getElementById('saveBtn').classList.remove('animateBottom');
				document.getElementById('saveBtn').classList.add('revanimateBottom');
				setTimeout(function() {
					document.getElementById('saveBtn').classList.remove('revanimateBottom');
				}, 500);
			}
			
			async function addItem() {
				document.getElementById('addItemBtn').innerHTML = 'Cancel'; // Saving text
				document.getElementById('addItemBtn').setAttribute("onclick", "cancelAddItem()");
				document.getElementById('addDescription').style.display = 'revert';
				document.getElementById('addItem').style.display = 'revert';
				document.getElementById('mainaddNewItemBtn').style.display = 'revert';
				document.getElementById('mainDate').style.display = 'revert';
				document.getElementById('header').style.height = "365px"
				document.getElementById('createnew').classList.add('show1');
				document.getElementById('saveBtn').classList.remove('revanimateBottom');
				document.getElementById('saveBtn').classList.add('animateBottom');
				setTimeout(function() {
					document.getElementById('saveBtn').classList.remove('animateBottom');
				}, 500);
			}

			async function deleteItem(number) {
				//document.getElementById('deleteBtn' + number).innerHTML = 'Deleting...'; // Saving text
				document.getElementById('item' + number).innerHTML = document.getElementById('item' + number).innerHTML + '(Deleted)'; // Saving text
				document.getElementById('deleteBtn' + number).setAttribute('onclick', ''); // Saving text
				document.getElementById('deleteBtn' + number).innerHTML = 'Deleted!';
				document.getElementById('metadesc' + number).id = 'deleted';
				document.getElementById('metatitle' + number).id = 'deleted';
				document.getElementById('metadate' + number).id = 'deleted';
				
				document.getElementById('item' + number).style.color = '#b1b1b1';
				document.getElementById('item' + number).style.textDecoration = 'line-through';
				document.getElementById('item' + number).id = 'deleted';
				document.getElementById(number).id = 'deleted';
				document.getElementById('description' + number).id = 'deleted';
				document.getElementById('showDescriptionBtn' + number).setAttribute('onclick', ''); // Saving text
				document.getElementById('showDescriptionBtn' + number).id = 'deleted';
				document.getElementById('deleteBtn' + number).id = 'deleted';
// now i need to loop through all of the items that are greater than the deleted items and then remove 1 from them and set this to nothing
                for (i = totalItems; i > number; i--) {
                    //console.log('test' + i);
                    let temp = i - 1;
                    console.log('test' + i);
					document.getElementById('item' + i).id = 'item' + temp;
					//document.getElementById('completeBtn' + i).id = 'completeBtn' + temp;
					document.getElementById('showDescriptionBtn' + i).setAttribute('onclick', 'showDescription(' + temp + ')');
					document.getElementById('showDescriptionBtn' + i).id = 'showDescriptionBtn' + temp;
					document.getElementById('deleteBtn' + i).setAttribute('onclick', 'deleteItem(' + temp + ')');
					//document.getElementById('reminderBtn' + i).setAttribute('onclick', 'setReminder(' + temp + ')');
					document.getElementById('deleteBtn' + i).id = 'deleteBtn' + temp;
					document.getElementById('description' + i).id = 'description' + temp;
					document.getElementById(i).id = temp;
					
					document.getElementById('metadesc' + i).id = 'metadesc' + temp;
					document.getElementById('metatitle' + i).id = 'metatitle' + temp;
					document.getElementById('metadate' + i).id = 'metadate' + temp;
                }
				totalItems--
			}

			async function createItem() {
			    let clone = document.getElementById("1").cloneNode(true);
			    for (i = totalItems; i > 0; i--) {
			        let temp = i + 1
			        console.log("doing: " + i);
					document.getElementById('deleteBtn' + i).setAttribute('onclick', 'deleteItem(' + temp + ')');
					document.getElementById('deleteBtn' + i).id = 'deleteBtn' + temp;
					document.getElementById('description' + i).id = 'description' + temp;
					document.getElementById('metadesc' + i).id = 'metadesc' + temp;
					document.getElementById('metatitle' + i).id = 'metatitle' + temp;
					document.getElementById('metadate' + i).id = 'metadate' + temp;
					document.getElementById(i).id = i + 1;
					document.getElementById('item' + i).id = 'item' + temp;
					//document.getElementById('completeBtn' + i).id = 'completeBtn' + temp;
					document.getElementById('showDescriptionBtn' + i).setAttribute('onclick', 'showDescription(' + temp + ')');;
					document.getElementById('showDescriptionBtn' + i).id = 'showDescriptionBtn' + temp;
					console.log("finished: " + i);
				};
				document.getElementById("main").prepend(clone);
				document.getElementById("main").children[0].id = 1;
				
				document.getElementById("item1").innerHTML = document.getElementById("item").value + ' (' + document.getElementById("date").value + ')';
				document.getElementById('description1').innerHTML = document.getElementById("description").value;
				document.getElementById('metatitle1').innerHTML = document.getElementById("item").value;
				document.getElementById('metadesc1').innerHTML = document.getElementById("description").value;
				document.getElementById('metadate1').innerHTML = document.getElementById("date").value;
				
				totalItems++
			}
			
			function showDescription(number) {
				document.getElementById("showDescriptionBtn" + number).innerHTML = "Hide Description"
				document.getElementById("showDescriptionBtn" + number).setAttribute('onclick', 'hideDescription(' + number + ')') 
				document.getElementById("description" + number).style.display = "revert"
				document.getElementById("description" + number).classList.add('show');
				document.getElementById("description" + number).classList.remove('hide');
			}
			async function hideDescription(number) {
				document.getElementById("showDescriptionBtn" + number).innerHTML = "View Description"
				document.getElementById("showDescriptionBtn" + number).setAttribute('onclick', 'showDescription(' + number + ')') 
				document.getElementById("description" + number).classList.add('hide');
				document.getElementById("description" + number).classList.remove('show');
				setTimeout(function() {
					document.getElementById("description" + number).style.display = "none"
				}, 400);
			}

			/* async function markCompleted(number) {
				document.getElementById('completeBtn' + number).innerHTML = 'Marked as Completed!';
				document.getElementById('item' + number).style.color = '#b1b1b1';
				document.getElementById('item' + number).style.textDecoration = 'line-through';
				document.getElementById('completeBtn' + number).setAttribute('onclick', 'markIncomplete(' + number + ')')
				document.getElementById('item' + number).innerHTML = document.getElementById('item' + number).innerHTML + '(Completed)'; // Saving text
				setTimeout(function() {
					document.getElementById('completeBtn' + number).innerHTML = 'Mark Incomplete';
				}, 1000);
			}

			async function markIncomplete(number) {
				document.getElementById('completeBtn' + number).innerHTML = 'Marked as Incomplete!';
				document.getElementById('item' + number).style.color = '#000';
				document.getElementById('item' + number).style.textDecoration = 'unset';
				document.getElementById('completeBtn' + number).setAttribute('onclick', 'markCompleted(' + number + ')')
				document.getElementById('item' + number).innerHTML = document.getElementById('item' + number).innerHTML.replace('(Completed)', ''); // Saving text
				setTimeout(function() {
					document.getElementById('completeBtn' + number).innerHTML = 'Mark Completed';
				}, 1000);
			} */

			async function moveItem(number) {} // maybe make item draggable up and down if you get the position of the item and then increase it by 1 and decrease the one above it by 1, but it may be
			// difficult when trying to move the item up and down dynamically
		</script>
	</head>
	<body onload="totalItems = <? $lines = file("data/reminders.txt"); $totalReminders = 0; foreach ( $lines as $line) { $totalReminders++; } echo $totalReminders ?>;">
	<div class="card" id="header" style="margin: 0; transition: height 0.4s cubic-bezier(0, 1.3, 0.4, 1) 0s; height: 190px;">
		<a class="button headerbtn" href="<? echo $domain ?>"> Reminders </a>
		<h2 style="margin: 0; margin-top: 10px;"><a id="addItemBtn" class="button" onclick="addItem()" style="display: block;">Add Item</a></h2>
		<div id="createnew" style=" display: revert; position: relative; margin-top: 5px; margin-bottom: 10px;">
		<h2 style="margin: 0; display: none;" id="addItem"> Item: <input type="text" name="title" value="item" id="item" style="margin-top: 8px;"></h2>
		<h2 style="margin: 0; display: none;" id="addDescription"> Description: <input type="text" name="title" value="description" id="description" style="margin-top: 8px;"></h2>
		<h2 style="margin: 7px; display: none;" id="mainDate">Date: <input type="text" id="date" placeholder="3/17/2022" value="<? echo date("n/j/y"); ?>"></h2>
		<h2 style="margin-top: 10px; display: none; margin-bottom: 0px;" id="mainaddNewItemBtn"><a class="button" style="display: block" onclick="createItem()" id="addNewItemBtn"> Add Item </a></h2>
		</div>
		<a id="saveBtn" class="button" style="display: block; margin-top: 5px;" onclick="save()">Save All Items</a>
		</div>
		<div id="main"></div>
		<? $lines = file("data/reminders.txt");
		  
		  function get_string_between($string, $start, $end){
			$string = ' ' . $string;
			$ini = strpos($string, $start);
			if ($ini == 0) return '';
				$ini += strlen($start);
				$len = strpos($string, $end, $ini) - $ini;
				return substr($string, $ini, $len);
			}


		$i = 0;
		foreach ( $lines as $line) {
			$i++;
			$title = get_string_between($line, 'TITLE: ', 'MESSAGE: ');
			$message = get_string_between($line, 'MESSAGE: ', 'DATE: ');
			$date = explode('DATE: ', $line); # $date[1]
			

			echo '<div class="card left" id="'. $i .'">
				<p style="display: none" id="metadate' . $i . '">' . $date[1] . '</p>
				<p style="display: none" id="metatitle' . $i . '">' . $title . '</p>
				<p style="display: none" id="metadesc' . $i . '">' . $message . '</p>

				<a id="item' . $i . '">' . $title . '('. str_replace(array("\n","\r"), '', $date[1]) .')</a>
				<div class="buttons">
					<a style="margin-right: 5px;" id="showDescriptionBtn'. $i .'" class="button" onclick="showDescription(' . $i . ')"> View Description </a>
					<a class="button" id="deleteBtn' . $i . '" onclick="deleteItem(' . $i . ')">Delete</a>
				</div>
				<div id="description' . $i . '" class="hide" style="display: none; white-space: normal; margin-top: 20px;"><p class="default"> '. $message .' </p></div>
			</div>'; } ?>

		<div class="card left">
			<? echo "<a><strong>" . $totalReminders . "</strong> total reminders</a>"; 
			// using 'a' instead of p will fix the button glitch but makes the code not w3 certified anymore, fix in future update ?>
			<div class="buttons"> <a class="button" id="saveBtn" onclick="save()">Edit Array Index</a> </div>
		</div>
	</body>
</html>