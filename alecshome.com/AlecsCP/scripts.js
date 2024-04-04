if('serviceWorker' in navigator) {
	navigator.serviceWorker.register('sw.js')
	.then(function() { console.log('Service Worker Registered'); });
	}

async function saveNote(name) {
	document.getElementById(name + "Submit").innerHTML = "Saving..."
	let formData = new FormData();
	console.log(document.getElementById(name).value)
	formData.append("note", name + '~' + document.getElementById(name).value);
	await fetch('action?notes&save', {
		method: "POST",
		body: formData
	})
	document.getElementById(name + "Submit").innerHTML = "Saved!"
	setTimeout(function() {
		document.getElementById(name + "Submit").innerHTML = 'Save';
		}, 2000); }

function collapse(ele){
	document.getElementById(ele.id).innerHTML = document.getElementById(ele.id).innerHTML + ' (Collapsed)';
	children = document.getElementById(ele.id).parentNode.children;
	for (var i=0; i < children.length; i++) {
		children[i].style.display = 'none';
	}
	document.getElementById(ele.id).style.display = 'block';
	document.getElementById(ele.id).style.margin = '0';
	document.getElementById(ele.id).setAttribute("onclick", "reopen(this)");
}

function reopen(ele){
	document.getElementById(ele.id).innerHTML = document.getElementById(ele.id).innerHTML.replace(' (Collapsed)', '');
	children = document.getElementById(ele.id).parentNode.children;
	for (var i=0; i < children.length; i++) {
		children[i].style.removeProperty('display');
	}
	document.getElementById(ele.id).style.display = 'block';
	document.getElementById(ele.id).style.margin = '0 0 15px';
	document.getElementById(ele.id).setAttribute("onclick", "collapse(this)");
}

async function toggleOption(id, option, toggletext, finishedtext) {
				document.getElementById(id.id).innerHTML = toggletext
				let formData = new FormData();
				formData.append(option, true);
				await fetch('action?options', {
					method: "POST",
					body: formData
				})
				document.getElementById(id.id).innerHTML = finishedtext
				setTimeout(function() {
					if (id.id == "toggleDev") {
						if (option == "enableDev") {
					document.getElementById('toggleDev').setAttribute('onclick','toggleOption(this, "disableDev", "Disabling Development Mode...", "Disabled Development Mode!")');
					document.getElementById('toggleDev').innerHTML = 'Disable Development Mode'; 
						} else {
							document.getElementById('toggleDev').setAttribute('onclick','toggleOption(this, "enableDev", "Enabling Development Mode...", "Enabled Development Mode!")');
							document.getElementById('toggleDev').innerHTML = 'Enable Development Mode'; 
						}}
				}, 1000);
			}

async function togglePageOption(id, option, toggletext, finishedtext, url) {
				document.getElementById(id.id).innerHTML = toggletext
				let formData = new FormData();
				formData.append(option, true);
				await fetch(url, {
					method: "POST",
					body: formData
				})
				document.getElementById(id.id).innerHTML = finishedtext
			}

async function saveReminder() {
	document.getElementById('saveReminderBtn').innerHTML = 'Saving Reminder...'
	let formData = new FormData();
	formData.append("new", 'TITLE: ' + document.getElementById('remindertitle').value + ' MESSAGE: ' + document.getElementById('reminderdesc').value + ' DATE: ' + document.getElementById('reminderdate').value)
	await fetch('action?reminders', {
					method: "POST",
					body: formData
				})
	document.getElementById('saveReminderBtn').innerHTML = 'Reminder Saved!'
	setTimeout(function() { 
	document.getElementById('saveReminderBtn').innerHTML = 'Save Reminder'
	}, 1000);
}

onlineShown = false;
loginShown = false;

async function headerNotifications() {
	if (!navigator.onLine) { if (onlineShown == false) { console.log("NOT ONLINE!"); onlineShown = true; document.body.insertAdjacentHTML('afterbegin', '<div class="card oneline show" id="notice" style="margin-top: 10px; position: relative; margin-bottom: 10px;"> <p><strong> No Internet! </strong> You are not connected to the internet!</p></div>');}}
	if(document.cookie.indexOf('login') == -1) { if (loginShown == false) { console.log("NOT LOGGED IN!"); loginShown = true; document.body.insertAdjacentHTML('afterbegin', '<div class="card oneline show" id="notice" style="margin-top: 10px; position: relative; margin-bottom: 10px;"> <p><strong> Not Logged In! </strong> You were logged out! </p></div>');}}
}

function loopFunction(delay, callback){
    var loop = function(){
        callback();
        setTimeout(loop, delay);
    }; loop();
}
loopFunction(1000, function(){ headerNotifications(); });

async function downloadData() {
			let formData = new FormData();
			formData.append('download', prompt("Please type what you would like to download. \nOptions: All / CP / AmazinAxel / AlecsHome / Dev\nEnter nothing to download the last backup.", "All"));
			document.getElementById("downloadDataBtn").innerHTML = "Server Processing Data..."
				await fetch('action?options', {
					method: "POST",
					body: formData
				})
			document.getElementById("downloadDataBtn").innerHTML = "Finished, just a moment..."
			await new Promise(resolve => setTimeout(resolve, 2000)); // wait so that the server has time to cache the file instead of downloading the old backup file
			document.getElementById("downloadDataBtn").innerHTML = "Downloading..."
				window.open('other/download.php', '_blank');
				setTimeout(function() {
					document.getElementById("downloadDataBtn").innerHTML = 'Download Data';
				}, 6000);
			}

async function copyLink(eleID, text) {
				navigator.clipboard.writeText(text)
				document.getElementById(eleID).innerHTML = 'Copied!';
				setTimeout(function() {
					document.getElementById(eleID).innerHTML = 'Copy';
				}, 2000);
			}

async function sendData(requestName, eleID) { // ONLY WORKS WITH OPTIONS PAGE AS OF NOW, FIX BEFORE USING!!!
		document.getElementById(eleID.id).innerHTML = "Saving..." // ^^^
		let formData = new FormData();// ^^^
		formData.append(requestName, document.getElementById(requestName).value);
	await fetch('action?options', {
		method: "POST",
		body: formData
	})
	document.getElementById(eleID.id).innerHTML = "Saved!"
	setTimeout(function() {
		document.getElementById(eleID.id).innerHTML = 'Save';
		}, 2000); }

// TODO LIST CODE:
function showDescription(number) {
				document.getElementById("showDescriptionBtn" + number).innerHTML = "Hide"
				document.getElementById("showDescriptionBtn" + number).setAttribute('onclick', 'hideDescription(' + number + ')') 
				document.getElementById("description" + number).style.display = "revert"
				document.getElementById("description" + number).classList.add('showDesc');
				document.getElementById("description" + number).classList.remove('hideDesc');
			}
			async function hideDescription(number) {
				document.getElementById("showDescriptionBtn" + number).innerHTML = "Show All"
				document.getElementById("showDescriptionBtn" + number).setAttribute('onclick', 'showDescription(' + number + ')') 
				document.getElementById("description" + number).classList.add('hideDesc');
				document.getElementById("description" + number).classList.remove('showDesc');
				setTimeout(function() {
					document.getElementById("description" + number).style.display = "none"
				}, 400);
			}
