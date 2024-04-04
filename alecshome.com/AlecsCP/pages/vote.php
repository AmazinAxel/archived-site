<? include 'settings.php'; # This is the updated and fixed code. Put this on every page!
if (isset($_COOKIE['login']) != $password) {
	require('login.php');
	die();
}
require('other/header.php');
generateHeader('Vote'); ?>	</head>
	<body>
		<div class="card header">
			<h2 class="button" style="margin: 0;">Voting</h2>
		</div>
		<div class="row">
			<div class="leftcolumn">
				<div class="card left">
					<h2 class="button" style="text-align: center"> Do you like school? </h2>
					<h2> Answer 1: <input type="text" name="title" value="I do"> </h2>
					<h2 style="float: right; bottom: 45px; position: relative;"> Answer 2: <input type="text" name="title" value="No!!!"> </h2>
					<h2> Answer 3: <input type="text" name="title" value="I don't go to school"> </h2>
					<h2 style="float: right; bottom: 45px; position: relative;"> Answer 4: <input type="text" name="title" value="Yes and no"> </h2>
					<div class="card" style="background-color: #f2f2fc; text-align: left;">
						<h2 class="button">Poll Results:</h2>
						<h2>I do: 10 votes</h2>
						<h2 style="float: right; bottom: 32px; position: relative;">I don't: 14 votes</h2>
						<h2>I don't go to school: 22 votes</h2>
						<h2 style="float: right; bottom: 32px; position: relative;">Yes and no: 55 votes</h2>
					</div>
					<br><br>
					<div class="buttons">
						<a href="#" class="button">Wipe Poll Results</a>
						<a href="#" class="button">Delete Poll</a>
						<a href="#" class="button">Archive Poll</a>
					</div>
				</div>
			</div>
			<aside>
				<div class="card right">
					<h2 style="margin-top: 5px; display: block;" class="button"> Add Voting Poll: </h2>
					<h2> Title: <input type="text" name="date" value="" placeholder="Poll title goes here"> </h2>
					<a href="#" class="button" style="display: block; width: -webkit-fill-available;">Add</a>
				</div>
				<div class="card right">
					<h2 style="margin-top: 5px; display: block;" class="button"> Settings: </h2>
					<h2> Text: <input type="text" name="date" value="" placeholder="Banner Text goes here"> </h2>
					<h2 style="margin: 8px 0px 15px 0px;"> Accuracy Mode: <input type="checkbox" id="privateEntry" title="Hide entry on Publish" placeholder="Hide entry on Publish"> </h2>
					<a href="#" class="button" style="display: block;">Save</a>
				</div>
			</aside>
		</div>
	</body>
</html>