<? require 'settings.php'; # This is the updated and fixed code. Put this on every page!
if (isset($_COOKIE['login']) != $password) {
	require('login.php');
	die();
}
include('other/header.php');
generateHeader('API Manager');?>	
<script>
	async function saveAPI(api, dataID) {
		// get the dataID element and then send it to the server using the "api" variable data, and then the server handles it and sends it back
	}
</script>
</head>
	
	<body>
		<div class="card header">
			<h2 class="button" style="margin: 0;">API Editor</h2>
		</div>
		<div class="row">
			<div class="leftcolumn">
				<div class="card">
					<h2 class="button" style="text-align: center;"> Escaprs APIs </h2>
					<h2> Version: <input type="text" name="title" value="" id='escaprsVer'> </h2><a class="large button" onclick="saveAPI('escaprsVer', 'escaprsVer')" id="apiSaveBtn"> Save </a>
					<h2> Changelog: </h2>
					<textarea name="message" rows="5" cols="40" placeholder="Enter changelog here" id='escaprsData'></textarea>
					<a class="large button" onclick="saveAPI('escaprs', 'escaprsData')" id="apiSaveBtn"> Save </a>
				</div>
				<div class="card">
					<h2 class="button" style="text-align: center;"> Another API </h2>
					<h2> API Value: <input type="text" name="title" value=""> </h2>
					<h2> More API Text: </h2>
					<textarea name="message" rows="5" cols="40" placeholder="Enter text here" id="apiData"></textarea>
					<a class="large button" onclick="saveAPI('api', 'apiData')" id="apiSaveBtn"> Save </a>
				</div>
			</div>
		</div>
	</body>
</html>