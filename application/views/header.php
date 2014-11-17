<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to Salt Kettle Guest House</title>
	<!-- JS -->
	<script type="text/javascript" src="//code.jquery.com/jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <script src="assets/js/ckeditor/ckeditor.js"></script>
    <!-- CSS --> 
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/ink.min.css" rel="stylesheet">
</head>
<body>
   	<div id="topbar">
		<nav class="ink-navigation">
			<ul class="menu horizontal black">
				<li class="heading"><a href="<?=$_SERVER['PHP_SELF']?>">Home</a></li>
				<li><a href="<?= $_SERVER['PHP_SELF'] ?>?/roomrates">Our Rooms and Rates</a></li>
				<li><a href="<?= $_SERVER['PHP_SELF'] ?>?/reservations">Reservations</a></li>
				<li><a href="<?= $_SERVER['PHP_SELF'] ?>?/contact">Contact</a></li>
			</ul>
		</nav>
	</div>