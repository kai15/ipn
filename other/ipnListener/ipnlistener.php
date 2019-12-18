<?php
$raw_post_data = file_get_contents('php://input');
$raw_post_array = explode('&', $raw_post_data);
$myPost = array();
foreach ($raw_post_array as $keyval) {
  $keyval = explode('=', $keyval);
  if (count($keyval) == 2)
    $myPost[$keyval[0]] = urldecode($keyval[1]);
}
$req = 'cmd=_notify-validate';
if (function_exists('get_magic_quotes_gpc')) {
  $get_magic_quotes_exists = true;
}
/* Sample PHP PayPal IPN Listener - http://www.richosoft2.co.uk - Steve Riches - info@richosoft2.co.uk */
foreach ($myPost as $key => $value) {
  if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
    $value = urlencode(stripslashes($value));
  } else {
    $value = urlencode($value);
  }
  $req .= "&$key=$value";
}

$ch = curl_init("https://ipnpb.paypal.com/cgi-bin/webscr");
if ($ch == FALSE) {
  return FALSE;
}
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
$res = curl_exec($ch);
if (curl_errno($ch) != 0) // cURL error
  curl_close($ch);
exit;
curl_close($ch);

if (strcmp($res, "VERIFIED") == 0) {
  echo "sipsip";
  /* 	ADD YOUR DATA PROCESSING FUNCTIONS HERE
	TO Access your database and update it and activate any membership access or process orders etc.
	and to send emails etc
*/
} else {
  echo "coba lagi";
}
