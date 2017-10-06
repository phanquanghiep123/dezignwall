<?php
session_start();

//include google api library
require_once 'src/Google/autoload.php';// or wherever autoload.php is located

$google_client_id = '311891690528-3hrpete7kkkc9gm7iesnbta7mliu0bsg.apps.googleusercontent.com';
$google_client_secret = 'eJSTWpe0gYHUhYfDxtDxCqHw';
$google_redirect_uri = 'http://betadev.dezignwalldev.com/social/google_api/callback.php';

//setup new google client
$client = new Google_Client();
$client->setApplicationName('DezignWall');
$client->setClientid($google_client_id);
$client->setClientSecret($google_client_secret);
$client->setRedirectUri($google_redirect_uri);
$client->setAccessType('offline');
$client->setScopes('https://www.google.com/m8/feeds');

$googleImportUrl = $client->createAuthUrl();

function curl($url, $post = "") {
	$curl = curl_init();
	$userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';
	curl_setopt($curl, CURLOPT_URL, $url);
	//The URL to fetch. This can also be set when initializing a session with curl_init().
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	//TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
	//The number of seconds to wait while trying to connect.
	if ($post != "") {
		curl_setopt($curl, CURLOPT_POST, 5);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
	}
	curl_setopt($curl, CURLOPT_USERAGENT, $userAgent);
	//The contents of the "User-Agent: " header to be used in a HTTP request.
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
	//To follow any "Location: " header that the server sends as part of the HTTP header.
	curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE);
	//To automatically set the Referer: field in requests where it follows a Location: redirect.
	curl_setopt($curl, CURLOPT_TIMEOUT, 10);
	//The maximum number of seconds to allow cURL functions to execute.
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	//To stop cURL from verifying the peer's certificate.
	$contents = curl_exec($curl);
	curl_close($curl);
	return $contents;
}

if(isset($_SESSION['google_code'])) {
	$auth_code = $_SESSION['google_code'];
	$max_results = 200;
    $fields=array(
        'code'=>  urlencode($auth_code),
        'client_id'=>  urlencode($google_client_id),
        'client_secret'=>  urlencode($google_client_secret),
        'redirect_uri'=>  urlencode($google_redirect_uri),
        'grant_type'=>  urlencode('authorization_code')
    );
    $post = '';
    foreach($fields as $key=>$value)
    {
        $post .= $key.'='.$value.'&';
    }
    $post = rtrim($post,'&');
    $result = curl('https://accounts.google.com/o/oauth2/token',$post);
    $response =  json_decode($result);
    $accesstoken = $response->access_token;
    $url = 'https://www.google.com/m8/feeds/contacts/default/full?max-results='.$max_results.'&alt=json&v=3.0&oauth_token='.$accesstoken;
    $xmlresponse =  curl($url);
    $contacts = json_decode($xmlresponse,true);

	$return = array();
	if (!empty($contacts['feed']['entry'])) {
		foreach($contacts['feed']['entry'] as $contact) {
            //retrieve Name and email address  
			$object_item = array (
				'name'=> $contact['title']['$t'],
				'email' => $contact['gd$email'][0]['address'],
				'image' => ''
			);

            //retrieve user photo
			if (isset($contact['link'][0]['href'])) {
				$url = $contact['link'][0]['href'] . '&access_token=' . urlencode($accesstoken);
				$curl = curl_init($url);
		        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		        curl_setopt($curl, CURLOPT_TIMEOUT, 15);
				curl_setopt($curl, CURLOPT_VERBOSE, true);
		        $image = curl_exec($curl);
		        curl_close($curl);
			}
			$imgData = base64_encode($image);
    		$pro_image = 'data:image/jpeg;base64,'.$imgData .'';
			$object_item['image'] = $pro_image;

			$return[] = $object_item;
		}	
	}

	echo '<pre>';
	print_r($return);
	echo '<pre>';

	$google_contacts = $return;

	echo '<table>';
	foreach ($google_contacts as $contact_item) {
		echo '<tr>
				<td>'.@$contact_item['name'].'</td>
				<td>'.@$contact_item['email'].'</td>
				<td>';
				if ($contact_item['image'] != 'data:image/jpeg;base64,UGhvdG8gbm90IGZvdW5k') {
					echo '<img src="'.@$contact_item['image'].'" />';
				}
		echo '	</td>
			</tr>';
	}
	echo '</table>';

	if (isset($_SESSION['google_contact'])) {
		unset($_SESSION['google_contact']);
	}
	$_SESSION['google_contact'] = $google_contacts;
	unset($_SESSION['google_code']);

	header('Location: http://betadev.dezignwalldev.com/profile/edit/google');
}

?>

<a href="<?php echo $googleImportUrl; ?>"> Import google contacts </a>