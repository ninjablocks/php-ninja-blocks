<?php

/**
 * Ninja Blocks API Helper Classes.
 *
 * This is a Ninja Blocks Helper class to assist php developers with
 * interacting with the Ninja Blocks REST service
 *
 * @author  Jeremy Manoto <jeremy@ninjablocks.com>
 *
 * @since 0.1
 *
 * @copyright 2012 Ninja Blocks Pty Ltd
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * 
 */
class NBAPI {
	var $version = "v0";

	/**
	 * Url for the Ninja Blocks endpoint.
	 * @var string
	 */
	var $apiUrl;

	/**
	 * Authentication access token
	 * @var string
	 */
	var $accessToken;

	var $timeout = 300;

	// Constructor
	public function __construct($token) {

		// Set the access token for the session
		$this->accessToken = $token;

		// Set the API url. Embed the version number straight in.
		$this->apiUrl = "https://api.ninja.is/rest/" . $this->version . "/";
	}

	/**
	 * USER
	 */
	public function User() {

		return $this->MakeRequest("GET", "user");

	}

	public function GetDevices() {
		return $this->MakeRequest("GET", "devices");

	}

	/**
	 * Forms & makes an API Request
	 */
	public function MakeRequest($method, $endpoint, $data = false) {
		// Declare the headers
		$headers = array();
		array_push($headers, 'Accepts: application/json');
		array_push($headers, 'Content-Type: application/json');

		// Initialize Curl
		$curl = curl_init();

		// Switch out the methods for communicating with the API
		switch ($method) {
			case "GET":
				if ($data) {
					$urlData = "&".http_build_query($data);
				}
				break;
			case "POST":
				curl_setopt($curl, CURLOPT_POST, 1);

				if ($data) {
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
					array_push($headers, 'Content-Length: ' . strlen($data));
				}
				break;
			case "PUT":
				curl_setopt($curl, CURLOPT_PUT, 1);
				if ($data) {
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
					array_push($headers, 'Content-Length: ' . strlen($data));
				}
				break;
			case "DELETE":
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
				if ($data) {
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
					array_push($headers, 'Content-Length: ' . strlen($data));
				}

				break;
		}

		// Generate the final endpoint url to be called
		$url = "{$this->apiUrl}{$endpoint}?user_access_token={$this->accessToken}{$urlData}";
		
		// Set the curl options
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HEADER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_VERBOSE, false);

		// Make the call
		$response = curl_exec($curl);
		//echo print_r(curl_getinfo($curl));

		$headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
		$header = substr($response, 0, $headerSize);
		$body = substr($response, $headerSize);
	
		$curlInfo = curl_getinfo($curl);
		//echo print_r($curlInfo);

		// Close the connection
		curl_close($curl);

		// Convert to JSON object
		$responseJSON = json_decode($body);

		return $responseJSON;
	}


}

class User {

	public function __construct($accessToken) {
		$this->nbapi = new NBAPI($accessToken);
	}

	public function GetUser() {

	}

}



class Device {

	var $nbapi;

	function __construct($accessToken) {

		$this->nbapi = new NBAPI($accessToken);

	}

	/**
	 * Lists the devices associated with the authenticating user
	 * @return object 
	 */
	public function getDevices() {
		return $this->nbapi->MakeRequest("GET", "devices");
	}


	/**
	 * Actuates a device
	 * @param  string $guid The GUID of the device to actuate
	 * @param  object $da   The data object to pass to the device
	 * @return object       
	 */
	public function actuate($guid, $da) {
		return $this->nbapi->MakeRequest("PUT", "device/{$guid}", json_encode($da));
	}

	/**
	 * Subscribes a callback to the specified device
	 * @param  string $guid the GUID of the device to subscribe to
	 * @param  string $url  The url that will be called as a callback
	 * @return object       
	 */
	public function subscribe($guid, $url) {

		$urlObject = (object) array('url' => $url);
		return $this->nbapi->MakeRequest("POST", "device/{$guid}/callback", json_encode($urlObject));
	}

	/**
	 * Unsubscribes a callback from the specified device
	 * @param  string $guid The GUID of the device to subscribe to
	 * @return object       
	 */
	public function unsubscribe($guid) {
		return $this->nbapi->MakeRequest("DELETE", "device/{$guid}/callback");
	}

	public function data($guid, $from, $to) {

		$dataScope = (object) array('from' => $from, 'to' => $to);
		return $this->nbapi->MakeRequest("GET", "device/{$guid}/data", $dataScope);
	}

	public function lastHeartbeat($guid) {
		return $this->nbapi->MakeRequest("GET", "device/{$guid}/heartbeat");
	}
}