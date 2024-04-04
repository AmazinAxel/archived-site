<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://amazinaxel.com/style.css"/>
		<style>
			.left{ text-align: left; }
			h2 {margin-top: 0;}
			.upload {position: relative; top: 12px;}
			input{
				padding: 8px;
				border-radius: 10px;
				background-color: #f1f1fc;
				box-shadow: 0 1px 3px 0 #c3c3c3;
				border: 0px;
				background-color: #f6f6fd;
				box-shadow: 0 0 6px 0 #ddd;
				transition: box-shadow 0.3s;
				text-indent: 5px;
			}
			textarea:focus-visible {
				outline: 0;
				transition: background-color 0.3s, box-shadow 0.3s;
				box-shadow: rgb(221 221 221) 0px 0px 11px 1px;
			}

			input:focus-visible {
				outline: 0;
				transition: background-color 0.3s, box-shadow 0.3s;
				box-shadow: rgb(221 221 221) 0px 0px 11px 1px;
			}
			textarea {
				padding: 8px;
				margin-top: 5px;
				border-radius: 10px;
				border: 0px;
				background-color: rgb(246, 246, 253);
				box-shadow: 0 1px 3px 0 #c3c3c3;
				height: 113px;
				width: 331px;
				transition: box-shadow 0.3s;
				resize: vertical;
				width: -webkit-fill-available;
			}
			aside a:hover { text-decoration: none; }
			input[type="checkbox"] {
				cursor: pointer;
				margin-left: 5px;
				box-shadow: 0 1px 3px 0 #c3c3c3;
			}
			.buttons {
				text-align: center;
				margin-bottom: 10px;
				margin-top: -10px;
			}
		</style>
	</head>
	<body>
		<div class="card header" style="margin-top: 0;">
			<h1 style="margin: 0;">Voting</h1>
			<h4 style="margin-bottom: 0;"> Submit your vote & have your voice heard! </h4>
		</div>
		<div class="card text-align: left;">
			<h2 class="button" style="text-align: center"> Do you like school? </h2>
			<h2>I do: 10 votes</h2>
			<h2 style="float: right; bottom: 32px; position: relative;">I don't: 14 votes</h2>
			<h2>I don't go to school: 22 votes</h2>
			<h2 style="float: right; bottom: 32px; position: relative;">Yes and no: 55 votes</h2>

		</div>
		<div class="card">
			<h2 class="button" id="submit" style="margin: 0; text-align: center; font-size: 20px;">Submit</h2>
		</div>
	</body>
</html>