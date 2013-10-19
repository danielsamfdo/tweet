<?php
require 'tmhOAuth.php'; // Get it from: https://github.com/themattharris/tmhOAuth
 
// Use the data from http://dev.twitter.com/apps to fill out this info
// notice the slight name difference in the last two items)
 
$connection = new tmhOAuth(array(
  'consumer_key' => 'Twt0Fz9zpE9HpIjB8Ky3xQ',
	'consumer_secret' => '8rZlSDW7uOsBdtJAEjvbph3Oxy2UhJd9G43EpmsIU94',
	'user_token' => '143451652-hj6g5ehLyZEBJgi5IlBro7vYnNXvqIqGdUupxua2', //access token
	'user_secret' => '1Gl0DkiZ93h4BsQ3xjQjJdhArBPInkbxJN3dZHsAxg' //access token secret
));
 
// set up parameters to pass
$parameters = array();
 
if ($_GET['count']) {
	$parameters['count'] = strip_tags($_GET['count']);
}
 
if ($_GET['screen_name']) {
	$parameters['screen_name'] = strip_tags($_GET['screen_name']);
}
 
if ($_GET['twitter_path']) { $twitter_path = $_GET['twitter_path']; }  else {
	$twitter_path = '1.1/statuses/user_timeline.json';
}
 
$http_code = $connection->request('GET', $connection->url($twitter_path), $parameters );
 
if ($http_code === 200) { // if everything's good
	$response = strip_tags($connection->response['response']);
 
	if ($_GET['callback']) { // if we ask for a jsonp callback function
		echo $_GET['callback'],'(', $response,');';
	} else {
		echo $response;	
	}
} else {
	echo "Error ID: ",$http_code, "<br>\n";
	echo "Error: ",$connection->response['error'], "<br>\n";
}
 
