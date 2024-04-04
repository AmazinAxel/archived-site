<?php
require 'settings.php'; # This is the updated and fixed code. Put this on every page!
if (isset($_COOKIE['login']) != $password) {
	require('login.php');
	#header("Location: https://alecshome.com/AlecsCP/");
	die();
}

if (isset($_GET['notes'])) { include 'pages/notes.php'; die(); } # Notes
else if (isset($_GET['options']) || isset($_GET['settings'])) { include 'pages/options.php'; } # Settings
else if (isset($_GET['upload']) || isset($_GET['quickshare'])) { include 'pages/upload.php'; } # Quickshare
else if (isset($_GET['todo']) || isset($_GET['todolist'])) { include 'pages/todo.php'; } # To-do list
else if (isset($_GET['swr'])) { include 'pages/swr.php'; die(); } # SWR Blog
else if (isset($_GET['ref']) || isset($_GET['reference'])) { include 'pages/reference.php'; } # SWR Reference
else if (isset($_GET['media']) || isset($_GET['images'])) { include 'pages/media.php'; } # Media Manager
else if (isset($_GET['linkcreator']) || isset($_GET['links'])) { include 'pages/linkcreator.php'; } # Links
else if (isset($_GET['interconn']) || isset($_GET['interconnection'])) { include 'pages/interconnection.php'; } # Interconn
else if (isset($_GET['boba']) || isset($_GET['bobablog'])) { include 'pages/bobablog.php'; } # Boba Blog
else if (isset($_GET['api']) || isset($_GET['apis'])) { include 'pages/apis.php'; } # API Manager
else if (isset($_GET['blog'])) { include 'pages/blog.php'; } # Site Blogger
else if (isset($_GET['calendar'])) { include 'pages/calendar.php'; } # Personal Calendar
else if (isset($_GET['chat'])) { include 'pages/chat.php'; } # Chat Admin
else if (isset($_GET['admin'])) { include 'pages/admin.php'; } # Server Admin
else if (isset($_GET['console'])) { include 'pages/console.php'; } # Console
else if (isset($_GET['diary'])) { include 'pages/diary.php'; } # Secondary Blog System
else if (isset($_GET['news'])) { include 'pages/news.php'; } # Personal Newsfeed System
else if (isset($_GET['projects'])) { include 'pages/projects.php'; } # Project Manager
else if (isset($_GET['reminders'])) { include 'pages/reminders.php'; } # Reminders
else if (isset($_GET['voting']) || isset($_GET['vote'])) { include 'pages/vote.php'; } # Voting Dashboard
else if (isset($_GET['logout'])) { setcookie("login", "", time() - 3600); header("Location: https://alecshome.com/AlecsCP/"); } # Logout


else { include 'index.php'; } # Error, send them back to the homepage!
