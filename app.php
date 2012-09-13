<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Example Usage | Ninja Blocks PHP Helper Library</title>
	<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.1.1/css/bootstrap.min.css" rel="stylesheet">
	<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.1.1/js/bootstrap.min.js"></script>

	<style type="text/css">
		.code { color: #D14; }
	</style>
</head>
<body>
	<div class="container">

		<div class="hero-unit">

			<h1>PHP Helper Library</h1>
			<p>Example usage of the Ninja Blocks API with PHP</p>
		</div>

		<p><span class="label label-info">Important!</span> Make sure your ninja block is connected 
			and live with the cloud</p>


		<?php 

		/**
		 * Sample Application using the PHP Ninja Blocks helper class.
		 */
		
		// include the Ninja Blocks API library
		require_once("nbapi.php");


		// Generate your access token from OAUTH2 or your Dashboard
		// Settings->API->API Access Token
		$accessToken = "8b7c78a0-9e65-47d8-a9a3-93462c900cf9";

		// Instantiate a new Ninjablock
		$deviceAPI = new Device($accessToken);

		?>
		<h2>DeviceAPI</h2>
		<p>Set your access token and instantiate a new Device API to interact with your Ninja Block devices</p>
		<h5>Code</h5>
		<p><code>$accessToken = "YOUR TOKEN STRING"</code></p>
		<p><code>$deviceAPI = new Device($accessToken);</code></p>


<?php
		
		$devicesResponse = $deviceAPI->getDevices();

?>

		<h4>Get Devices</h4>
		<h5>Code</h5>
		<p><code>$devicesAPI->getDevices();</code></p>
		<h5>Output</h5>
		<pre class="pre-scrollable"><code><?= print_r($devicesResponse); ?></code></pre>

<?php
			// target just the data portion of the devices response payload.
			$devices = $devicesResponse->data;

?>

		<hr/>

<?php

			// Looping over each device.
			$deviceCount = 0;
			foreach($devices as $guid => $device) {
				$deviceCount ++;
?>
				<h3>Device <?= $deviceCount ?>: <?= $device->device_name ?></h3>
				<span class="label label-success">GUID:</span> <?= $guid ?><br>
				<span class="label label-warning">Type:</span> <?= $device->device_type ?><br>
				<span class="label label-info">Name:</span> <?= $device->default_name ?><br>

				<h4>Last Heartbeat</h4>
				<h5>Code</h5>
				<p><code>$deviceAPI->lastHeartbeat($guid)</code></p>
				<h5>Output</h5>
				<pre><code><?= print_r($deviceAPI->lastHeartbeat($guid)); ?></code></pre>
<?php


				switch ($device->device_type) {

					case "light":
						break;

					case "rgbled":

?>
						<h4>Actuating LED</h4>
						<h5>Code</h5>
						<pre class="code"><code>$actuateData = (object) array('DA' => "FF00FF", 'shortName' => 'Purple');
$actuateResponse = $deviceAPI->actuate($guid, $actuateData);</code></pre>
						<h5>Output</h5>
						<pre><code><?php

						$actuateData = (object) array('DA' => "FF00FF", 'shortName' => 'Purple');

						$actuateResponse = $deviceAPI->actuate($guid, $actuateData);
						echo print_r($actuateResponse);
							
						?></code></pre>

						<h4>Subscribe</h4>
						<h5>Code</h5>
						<p><code>$deviceAPI->subscribe($guid, "http://your.callback.url");</code></p>
						<h5>Output</h5>
						<pre><code><?php

						$subscribeResponse = $deviceAPI->subscribe($guid, "http://requestb.in/13ozq1w1");
						echo print_r($subscribeResponse);

						?></code></pre>

						<h4>Unsubscribe</h4>
						<h5>Code</h5>
						<p><code>$deviceAPI->unsubscribe($guid);</code></p>
						<h5>Output</h5>
						<pre><code><?php

						$unsubscribeResponse = $deviceAPI->unsubscribe($guid);
						echo print_r($unsubscribeResponse);
							
						?></code></pre>
						<?php

						break;

					case "orientation":
						break;

				}


				//break; // Only process the first one for demonstration purposes
			}

		?>
	</div>

</body>
</html>


