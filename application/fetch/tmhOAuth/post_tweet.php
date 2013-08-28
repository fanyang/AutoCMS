<?php
/**
* post_tweet.php
* Example of posting a tweet with OAuth
* Latest copy of this code:
* http://140dev.com/twitter-api-programming-tutorials/hello-twitter-oauth-php/
* @author Adam Green <140dev@gmail.com>
* @license GNU Public License
*/
function post_tweet($tweet_text) {

	$tweet_text = substr($tweet_text,0,140);

  // Use Matt Harris' OAuth library to make the connection
  // This lives at: https://github.com/themattharris/tmhOAuth
  require_once('tmhOAuth.php');

  // Set the authorization values
  // In keeping with the OAuth tradition of maximum confusion,
  // the names of some of these values are different from the Twitter Dev interface
  // user_token is called Access Token on the Dev site
  // user_secret is called Access Token Secret on the Dev site
  // The values here have asterisks to hide the true contents
  // You need to use the actual values from Twitter
  $connection = new tmhOAuth(array(
    'consumer_key' => 'NaeGQWuPX1xK5pjkcGjXw',
    'consumer_secret' => 'HzluYciJ4SEuuW5AbsSzk5JChWc6TC8gJQLdo4SVR2g',
    'user_token' => '355218609-GmuM9RYu1kIucmht5s0LNxwXyo5tKA4Kko5qi3zM',
    'user_secret' => 'T3hW32ip69O1OVIE0XQi2xLZVqr7n7zMgkObp8db2c',
  ));

  // Make the API call
  $connection->request('POST',
    $connection->url('1/statuses/update'),
    array('status' => $tweet_text));

  return $connection->response['code'];
}
?>
