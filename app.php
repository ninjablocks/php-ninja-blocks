<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title></title>
</head>
<body>
	<h1>Ninja Blocks - PHP Helper Library</h1>


	<?php 


	/**
	 * Sample Application using the PHP Ninja Blocks helper class.
	 */

	require_once("ninjablocks.php");
	require_once("PhpConsole.php");
	PhpConsole::start();


	$accessToken = "8b7c78a0-9e65-47d8-a9a3-93462c900cf9";


	$ninjablocks = new NinjaBlocks($accessToken);

	//echo "<h2>Authorize</h2>";
	//echo $ninjablocks->Authorize();

	echo "<h2>User</h2>";
	echo $ninjablocks->User();

	echo "<h2>Devices</h2>";
	echo $ninjablocks->GetDevices();

	?>

</body>
</html>


