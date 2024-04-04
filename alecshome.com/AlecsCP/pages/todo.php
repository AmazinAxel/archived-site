<?
# parse todo file by line
# put a - before to mark that its done
# allow deletion and creation (creating appends it to top)
# when saving just loop through all items and if it is finished then add a slash & send as big data file
# and maybe add thing where you make it go up and down

# !!!!!!!!!!
# FIX THE DELETING FUNCTION!!!!!!!!!!!!!
error_reporting(E_ALL);
ini_set('display_errors', true);
require 'settings.php'; # This is the updated and fixed code. Put this on every page!
if (isset($_COOKIE['login']) != $password) {
	require('login.php');
	die();
}


if (isset($_POST["item1"]) && isset($_POST["count"])) {
    $Handle = fopen("data/todo.txt", 'w'); // Change which folder data is stored in
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
generateHeader('To Do');
?>
	<style>
					p { line-height: 18px; }


		h3 {
			    display: unset;
    position: absolute;
    font-weight: normal;
    font-size: 1.2em;
    margin: -2px 0 0 5px;
    /* white-space: nowrap; */
    /* word-wrap: break-word; */
    /* text-align: left; */
    /* white-space: nowrap; */
    /* word-wrap: break-word; */
    overflow: hidden;
    /* overflow-wrap: break-word; */
    text-overflow: ellipsis;
		} .card.left {
			white-space: nowrap; }
		
		.showDesc { animation: showDesc 1s cubic-bezier(0, 1.3, 0.4, 1); }

			.hideDesc { animation: hideDesc 1s cubic-bezier(0, 1.3, 0.4, 1); }

		@keyframes hideDesc { 0% { opacity: 1; line-height: 18px; margin-top: 20px; } 25% { opacity: 0 } 45% { line-height: 0px; margin-top: 0; } 100% { opacity: 0; height: 0} }

			@keyframes showDesc { 0% { opacity: 0; line-height: 0px; margin-top: 0; } 45% { line-height: 18px; margin-top: 20px; } 100% { opacity: 1; } }
		
		@media (min-width: 1050px) { .listText { width: 560px; }}
		@media (max-width: 1050px) and (min-width: 800px) { .listText { width: calc(100% - 440px); }}
		
		.default { text-align: center; }
		
		.animateBottom { animation: animateBottom 0.4s cubic-bezier(0, 1.3, 0.4, 1) 0s; }
		@keyframes animateBottom { 0% { top: -40px; } 100% { top: 0 } }
		.revanimateBottom { animation: revanimateBottom 0.4s cubic-bezier(0, 1.3, 0.4, 1) 0s; }
		@keyframes revanimateBottom { 0% { top: 40px; } 100% { top: 0 } }
		
		.show { animation: show 0.7s cubic-bezier(0, 1.3, 0.4, 1) 0s; }

</style>
		<script>
			async function save() {
				event.preventDefault(); // Prevent auto reload of page
				let formData = new FormData();
				formData.append("count", totalItems)
				
// 				formData.append("description", document.getElementById('fileDescription').value);
// 				formData.append("name", document.getElementById('fileName').value);
			    for (i = totalItems; i > 0; i--) {
                    if (document.getElementById('completed' + i).checked == true){
                        formData.append("item" + i, '- ' + document.getElementById('item' + i).innerHTML)
                    } else {
                        formData.append("item" + i, document.getElementById('item' + i).innerHTML)
                    }
                    
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
				document.getElementById('addItemMenu').style.display = 'none';
				document.getElementById('header').style.height = "185px"
				document.getElementById('saveBtn').classList.remove('animateBottom');
				document.getElementById('saveBtn').classList.add('revanimateBottom');
				setTimeout(function() {
					document.getElementById('saveBtn').classList.remove('revanimateBottom');
				}, 500);
			}
			
			async function addItem() {
				document.getElementById('addItemBtn').innerHTML = 'Cancel'; // Saving text
				document.getElementById('addItemBtn').setAttribute("onclick", "cancelAddItem()");
				document.getElementById('addItemMenu').style.display = 'revert';
				document.getElementById('header').style.height = "235px";
				document.getElementById('addItemMenu').classList.add('show');
				document.getElementById('saveBtn').classList.remove('revanimateBottom');
				document.getElementById('saveBtn').classList.add('animateBottom');
				setTimeout(function() {
					document.getElementById('saveBtn').classList.remove('animateBottom');
				}, 500);
			}

			async function setReminder(number) {
				// Add code for adding a reminder!
				document.getElementById('reminderBtn' + number).innerHTML = 'Reminder Added!';
				setTimeout(function() {
					document.getElementById('reminderBtn' + number).innerHTML = 'Add Reminder';
				}, 2000);
			}

			async function deleteItem(number) {
				//document.getElementById('deleteBtn' + number).innerHTML = 'Deleting...'; // Saving text
				document.getElementById('item' + number).innerHTML = document.getElementById('item' + number).innerHTML + '(Deleted)'; // Saving text
				document.getElementById('deleteBtn' + number).setAttribute('onclick', ''); // Saving text
				document.getElementById('deleteBtn' + number).innerHTML = 'Deleted!';
				
				document.getElementById('item' + number).style.color = '#b1b1b1';
				document.getElementById('item' + number).style.textDecoration = 'line-through';
				document.getElementById('item' + number).id = 'deleted';
				document.getElementById(number).id = 'deleted';
				document.getElementById('completed' + number).id = 'deleted';
				document.getElementById('reminderBtn' + number).id = 'deleted';
				document.getElementById('deleteBtn' + number).id = 'deleted';
// now i need to loop through all of the items that are greater than the deleted items and then remove 1 from them and set this to nothing
                for (i = totalItems; i > number; i--) {
                    //console.log('test' + i);
                    let temp = i - 1;
                    console.log('test' + i);
					document.getElementById('completed' + i).id = 'completed' + temp;
					document.getElementById('item' + i).id = 'item' + temp;
					//document.getElementById('completeBtn' + i).id = 'completeBtn' + temp;
					document.getElementById('reminderBtn' + i).id = 'reminderBtn' + temp;
					document.getElementById('deleteBtn' + i).setAttribute('onclick', 'deleteItem(' + temp + ')');
					//document.getElementById('reminderBtn' + i).setAttribute('onclick', 'setReminder(' + temp + ')');
					document.getElementById('deleteBtn' + i).id = 'deleteBtn' + temp;
					document.getElementById(i).id = temp;
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
					document.getElementById('completed' + i).id = 'completed' + temp;
					document.getElementById('showDescriptionBtn' + i).setAttribute('onclick', 'showDescription(' + temp + ')');
					document.getElementById('showDescriptionBtn' + i).id = 'showDescriptionBtn' + temp;
					document.getElementById('description' + i).id = 'description' + temp;
					document.getElementById(i).id = i + 1;
					document.getElementById('item' + i).id = 'item' + temp;
					//document.getElementById('completeBtn' + i).id = 'completeBtn' + temp;
					document.getElementById('reminderBtn' + i).id = 'reminderBtn' + temp;
					console.log("finished: " + i);
				};
				document.getElementById("main").prepend(clone);
				document.getElementById("main").children[0].id = 1;
				
				document.getElementById("item1").innerHTML = document.getElementById("item").value;
				document.getElementById("description1").innerHTML = document.getElementById("item").value;
				totalItems++
				//var wrapper = this.parentElement;

		    	//if (wrapper.previousElementSibling)
			 //       wrapper.parentNode.insertBefore(wrapper, wrapper.previousElementSibling);
				// now loop through all of the other ones and make sure they get increased by 1 and increase the total var as well
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
	<body onload="totalItems = <? $lines = file("data/todo.txt"); $totalNotes = 0; foreach ( $lines as $line) { $totalNotes++; } echo $totalNotes ?>;">
	<div class="card" id="header" style="margin: 0; height: 185px; transition: height 0.4s cubic-bezier(0, 1.3, 0.4, 1) 0s;">
		<a class="button headerbtn" href="<? echo $domain ?>" style="margin-bottom: 10px;"> To Do List </a>
		<h2 style="margin: 0;"><a id="addItemBtn" class="button" onclick="addItem()" style="display: block;">Add Item</a></h2>
		<h2 style="display: none; position: relative; margin-top: 5px; margin-bottom: 10px;" id="addItemMenu"> Item: <input type="text" name="title" value="item" id="item" style="margin-top: 8px;"> <input type="submit" name="submit" value="Add Item" onclick="createItem()" id="uploadFileBtn" class="button"></h2>
			<a id="saveBtn" class="button" style="display: block; margin-top: 5px;" onclick="save()">Save All Items</a>
		</div>
		<div id="main"></div>
		<?php 
		$lines = file("data/todo.txt");

		$i = 0;
		foreach ( $lines as $line) {
			$i++;
			//do something here.
			#echo(nl2br($line . "\r"));

			echo '<div class="card left" id="'. $i .'">
				<label class="container">';
				if (str_contains($line, '- ')){
				    echo '<input type="checkbox" checked="checked" id="completed' . $i .'">';
				    $line = str_replace('- ', '', $line);
				} else {
				    echo '<input type="checkbox" id="completed' . $i .'">';
				}
				echo '<span class="checkmark"></span>
				</label>
				<h3 id="item' . $i . '" class="listText">' . $line . '</h3>
				<div class="buttons">
					<!-- <a id="completeBtn'. $i .'" class="button" onclick="markCompleted(' . $i . ')">Mark Completed</a> -->
					<a style="margin-right: 5px;" id="showDescriptionBtn'. $i .'" class="button" onclick="showDescription(' . $i . ')"> Show All </a>
					<a id="reminderBtn'. $i .'" class="button" onclick="setReminder(' . $i . ')">Set Reminder</a>
					<a class="button" id="deleteBtn' . $i . '" onclick="deleteItem(' . $i . ')">Delete</a>
				</div>
				<div id="description' . $i . '" class="hide" style="display: none; white-space: normal; margin-top: 20px;"><p class="default"> '. $line .' </p></div>
			</div>'; } ?>

		<div class="card left">
			<? echo "<a><strong>" . $totalNotes . "</strong> total notes</a>"; 
			// using 'a' instead of p will fix the button glitch but makes the code not w3 certified anymore, fix in future update ?>
			<div class="buttons"> <a class="button" id="saveBtn" onclick="save()">Edit Array Index</a> </div>
		</div>
	</body>
</html>