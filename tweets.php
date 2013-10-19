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
$parameters['count'] = 10;
$parameters['q']='sachin';
if ($_GET['twitter_path']) { $twitter_path = $_GET['twitter_path']; }  else {
	$twitter_path = '1.1/search/tweets.json';
}
echo $connection->url($twitter_path);
$http_code = $connection->request('GET', $connection->url($twitter_path), $parameters );

if ($http_code === 200) { // if everything's good
	$response = strip_tags($connection->response['response']);

	if ($_GET['callback']) { // if we ask for a jsonp callback function
		echo $_GET['callback'],'(', $response,');';
	} else {
                echo "hi guys  <br/> ";
		$n="d1";
		$myFile = $n .".txt";
		$fh = fopen($myFile, 'w') or die("can't open file");
		fwrite($fh, $response);
		fclose($fh);
		$arr=json_decode($response);
                $n="d2";
		$myFile = $n .".txt";
                $fh = fopen($myFile, 'w') or die("can't open file");
                foreach($arr->statuses as $tweet)
                {
                 echo "{$tweet->user->screen_name} {$tweet->text}\n <br/>";
                 $dat="{$tweet->user->screen_name} {$tweet->text}\n";
                 fwrite($fh, $dat);
                }
                
		fclose($fh);


		//print_r($arr);
		/*
		echo $arr[0]['text'];
		foreach($arr as &$value)
		{echo $value['text'].'\n';}
		*/
	}
} else {
	echo "Error ID: ",$http_code, "<br>\n";
	echo "Error: ",$connection->response['error'], "<br>\n";
}

// You may have to download and copy http://curl.haxx.se/ca/cacert.pem							
