<?php

class NinjaBlocks {
	var $version = "v0";

	/**
	 * Url for the Ninja Blocks endpoint.
	 * @var string
	 */
	var $apiUrl;

	/**
	 * Authentication access token
	 * @var [type]
	 */
	var $accessToken;

	var $timeout = 300;

	// Constructor
	function NinjaBlocks($token) {

		// Set the access token for the session
		$this->accessToken = $token;

		// Set the API url. Embed the version number straight in.
		$this->apiUrl = "https://api.ninja.is/rest/" . $this->version . "/";
	}

/**
 * OAUTH2
 */
	function Authorize() {
		return $this->MakeRequest("GET", "oauth/authorize");
	}

/**
 * USER
 */
	function User() {

		return $this->MakeRequest("GET", "user");

	}

	function GetDevices() {
		return $this->MakeRequest("GET", "devices");

	}

	/**
	 * Forms & makes an API Request
	 */
	private function MakeRequest($method, $endpoint, $data = false) {

		//ob_start();

		// Declare the headers
		$headers = array(
			'Accepts: application/json',
			'Content-Type: application/json'
			);


		// Initialize Curl
		$curl = curl_init();

		// Set the curl options
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HEADER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		//curl_setopt($curl, CURLOPT_VERBOSE, true);
		//curl_setopt($curl, CURLOPT_MAXREDIRS, 1);
		//curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);


		// Switch out the methods for communicating with the API
		switch ($method) {
			case "GET":
				break;
			case "POST":
				curl_setopt($curl, CURLOPT_POST, 1);

				if ($data) {
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				}
				break;
			case "PUT":
				curl_setopt($curl, CURLOPT_PUT, 1);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				break;
			case "DELETE":
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
				break;
		}

		// Generate the final endpoint url to be called
		$url = "{$this->apiUrl}{$endpoint}?user_access_token={$this->accessToken}";
		echo $url;
		curl_setopt($curl, CURLOPT_URL, $url);

		//debug("Calling endpoint: {$url}", "MakeRequest");

		// Make the call
		$response = curl_exec($curl);

		//$result = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		// Close the connection
		curl_close($curl);

		//ob_end_clean();

		return $response;
	}


} 