<?
///////////////////////////////////////////////////////////////////////////////
// How to setup PayPal in your website using PHP + MYSQL
// Author: Ideal Kamerolli
// Check out our website for more tutorials like this: https://dopehacker.com
///////////////////////////////////////////////////////////////////////////////

//Database credentials
define("HOST", "localhost");     // The host you want to connect to.
define("USER", "root");    // The database username. 
define("PASSWORD", "");    // The database password. 
define("DATABASE", "ipn");    // The database name.

//Connect with database
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);

$system_mode = 'test'; // set 'test' for sandbox and 'live' for real payments.
$paypal_seller = 'sb-xgis2645680@business.example.com'; //Your PayPal account email address

$payment_return_success = 'https://demo.dopehacker.com/paypal_integration/payment_success.php'; //after payment, user will be redirected in this page, change with your own url
$payment_return_cancel = 'https://demo.dopehacker.com/paypal_integration/payment_cancel.php'; //if payment cancelled, user will be redirected in this page, change with your own url

if ($system_mode == 'test') {$paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; $enable_sandbox = true; } else {$paypal_url = 'https://www.paypal.com/cgi-bin/webscr';}
?>