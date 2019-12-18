<?php 
///////////////////////////////////////////////////////////////////////////////
// How to setup PayPal in your website using PHP + MYSQL
// Author: Ideal Kamerolli
// Check out our website for more tutorials like this: https://dopehacker.com
///////////////////////////////////////////////////////////////////////////////


namespace Listener;

//include PayPal IPN Class file (https://github.com/paypal/ipn-code-samples/blob/master/php/PaypalIPN.php)
require('PaypalIPN.php');

//include configuration file
// require('core_config.php');

use PaypalIPN;
$ipn = new PaypalIPN();
if ($enable_sandbox) {$ipn->useSandbox();}
$verified = true;

$ipn->verifyIPN();

//reading $_POST data from PayPal
$data_text = "";
foreach ($_POST as $key => $value) {
    $data_text .= $key . " = " . $value . "\r\n";
}

// Checking if our paypal email address was changed during payment.
$receiver_email_found = false;
if (strtolower($_POST["receiver_email"]) == strtolower($paypal_seller)) {
        $receiver_email_found = true;
}

// Checking if price was changed during payment.
// Get product price from database and compare with posted price from PayPal
$correct_price_found = false;
// $prep_stmt = "SELECT price FROM paypal_products WHERE id = ?";
// $stmt = $mysqli->prepare($prep_stmt);
// $item_number = $_POST["item_number"];
// if ($stmt) {
// 	$stmt->bind_param('s', $item_number);
//     $stmt->execute();
//     $stmt->store_result();
// 	$stmt->bind_result($price);
	
// 	if ($stmt->num_rows >= 1) { 
// 		while ($stmt->fetch()) {			 
// 		if ($_POST["mc_gross"] == $price) {
// 			$correct_price_found = true;
// 			break;
// 		}
// 		}
// 	}
// 	$stmt->close();
// }

//Checking Payment Verification
$paypal_ipn_status = "PAYMENT VERIFICATION FAILED";
if ($verified) {
    $paypal_ipn_status = "Email address or price mismatch";
    if ($receiver_email_found || $correct_price_found) {
        $paypal_ipn_status = "Payment has been verified";
		
        // Check if payment has been completed and insert payment data to database
        // if ($_POST["payment_status"] == "Completed") {
		// uncomment upper line to exit sandbox mode	
			
			// Insert payment data to database
			// if ($insert_stmt = $mysqli->prepare("INSERT INTO paypal_payments (item_no, transaction_id, payment_amount, payment_status) VALUES (?, ?, ?, ?)")) {
            // $item_number = $_POST["item_number"];
            // $transaction_id = $_POST["txn_id"];
			// $payment_amount = $_POST["mc_gross"];
			// $payment_status = $_POST['payment_status'];

			// $insert_stmt->bind_param('ssss', $item_number, $transaction_id, $payment_amount, $payment_status);
			
            if (! $insert_stmt->execute()) {
                $paypal_ipn_status = "Payment has been completed but not stored into database";
            }
			 $paypal_ipn_status = "Payment has been completed and stored to database";
			}
		// }  
		// uncomment upper line to exit sandbox mode
    // }
} else {
    $paypal_ipn_status = "Payment verification failed";
}
?>