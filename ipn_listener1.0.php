<?php
// include_once('sendmail.php');
// $link = mysql_connect("213.171.200.67", "boutique", "B0ut!Qu3");
// mysql_select_db("boutiquedb", $link);


// STEP 1: read POST data

// Reading POSTed data directly from $_POST causes serialization issues with array data in the POST.
// Instead, read raw POST data from the input stream.
if ( ! count($_POST)) {
	throw new Exception("Missing POST Data");
}
$raw_post_data = file_get_contents('php://input');
$raw_post_array = explode('&', $raw_post_data);
$myPost = array();
foreach ($raw_post_array as $keyval) {
	$keyval = explode('=', $keyval);
	if (count($keyval) == 2) {
		if ($keyval[0] === NULL) {
			if (substr_count($keyval[1], '+') === 1) {
				$keyval[1] = str_replace('+', '%2B', $keyval[1]);
			}
		}
		$myPost[$keyval[0]] = urldecode($keyval[1]);
	}
}
// read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'
$req = 'cmd=_notify-validate';
$get_magic_quotes_exists = false;
if (function_exists('get_magic_quotes_gpc')) {
	$get_magic_quotes_exists = true;
}
foreach ($myPost as $key => $value) {
	if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
		$value = urlencode(stripslashes($value));
	} else {
		$value = urlencode($value);
	}
	$req .= "&$key=$value";
}

// mysql_query("insert into log_dat(log_name, log_post, log_response, log_time) value('read POST data', '$req', 'none', now())");

// Step 2: POST IPN data back to PayPal to validate
// $res		= "empty";
// $ch = curl_init('https://ipnpb.paypal.com/cgi-bin/webscr');
$ch = curl_init('https://ipnpb.sandbox.paypal.com/cgi-bin/webscr');
// $ch = curl_init();
// curl_setopt($ch, CURLOPT_USERAGENT, 'PayPal');
// curl_setopt($ch, CURLOPT_HEADER, false);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
// curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
// curl_setopt($ch, CURLOPT_POST, true);
// curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
// curl_setopt($ch, CURLOPT_URL, 'https://ipnpb.paypal.com/cgi-bin/webscr');
// $res = curl_exec($ch);
// $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
// curl_close($ch);
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSLVERSION, 6);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
$res = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// mysql_query("insert into log_dat(log_name, log_post, log_response, log_time) value('compare result', '$req', '$res', now())");

// $_POST = $myPost;
$data_text = "";
foreach ($_POST as $key => $value) {
    $data_text .= $key . " = " . $value . "\r\n";
}

if (strcmp(($res), ("VERIFIED")) == 0) {
	echo "SAKSES";
	// The IPN is verified, process it
	// mysql_query("insert into log_dat(log_name, log_post, log_response, log_time) value('response from paypal', '$req', '".json_encode($myPost).'&&USERSID='.$_GET['iud']."', now())");

	// #update the credits
	// $users_id		= $_GET['iud'];
	// $quser			= mysql_query("select * from users where md5(id)='$users_id'");
	// $duser			= mysql_fetch_array($quser);

	// //emailNotify($duser);

	// $userid		= $duser['id'];
	// $qcredit 	= mysql_query("select * from credit_payment_temp where userid = '$userid'");
	// $dcredit 	= mysql_fetch_array($qcredit);
	// $credit 	= $dcredit['total_credit'];
	// #cek payment_status is Completed
	// if(isset($_POST['payment_status'])){
	// 	if($_POST['payment_status'] == "Completed"){
	// 		$transaction_id	= mysql_real_escape_string($_POST['txn_id']);
	// 		$total			= mysql_real_escape_string($_POST['mc_gross']);
	// 		$currency		= mysql_real_escape_string($_POST['mc_currency']);
	// 		$status			= mysql_real_escape_string($_POST['payment_status']);
	// 		$time			= date("d-m-Y H:i:s");

	// 		if ($transaction_id == "7XS19393P66165248") {
	// 			return;
	// 		}

	// 		//please be aware of this, client's credit will be added if transaction is successfull
	// 		// $qtrans=mysql_query("insert into credit_payment(transaction_id, total_credit, amount, currency, submitdate, payment_status, userid)
	// 		// 															values('$transaction_id', '$credit', '".$total."', '".$currency."', now(), '$status', '$userid')");
	// 		if($qtrans){
	// 			//please be aware of this, client's credit will be added if transaction is successfull
	// 			// $qupdate=mysql_query("update users set credits=credits+'".$credit."' where id='".$userid."'");

	// 			if($qupdate){
	// 				#emailCreditPayment($duser['username'], $duser['email'], $currency.$total, $credit, $transaction_id, $status, $time);
	// 				// emailCreditPayment('Sofian', 'raden.sofian.bahri@gmail.com', $currency.$total, $credit, $transaction_id, $status, $time);
	// 				// emailCreditPayment('Jason', 'jason@recruitment-boutique.com', $currency.$total, $credit, $transaction_id, $status, $time);
	// 				mysql_query("delete from credit_payment_temp where userid = '$userid'");
	// 			}else{
	// 				$error=mysql_error();
	// 				#emailCreditPayment($duser['username'], $duser['email'], $currency.$total, $credit, $transaction_id, $status, $time);
	// 				// emailCreditPayment('Sofian', 'raden.sofian.bahri@gmail.com', $currency.$total, $credit, $transaction_id, $status.' credit failed to be updated '.$error, $time);
	// 			}
	// 		}else{
	// 			$error=mysql_error();
	// 			#emailCreditPayment($duser['username'], $duser['email'], $currency.$total, $credit, $transaction_id, $status, $time);
	// 			// emailCreditPayment('Sofian', 'raden.sofian.bahri@gmail.com', $currency.$total, $credit, $transaction_id, $status.' credit failed to be inserted to credit payment '.$error, $time);
	// 		}
	// 	}else{
	// 		#emailCreditPayment($duser['username'], $duser['email'], $currency.$total, $credit, $transaction_id, $status, $time);
	// 		// emailCreditPayment('Sofian', 'raden.sofian.bahri@gmail.com', $currency.$total, $credit, $transaction_id, $status, $time);
	// }
	// }

} else {
	echo count($myPost) . " ";
	echo "JAJAL";
	// IPN invalid, log for manual investigation
	// mysql_query("insert into log_dat(log_name, log_post, log_response, log_time) value('INVALID', '$req', '$res', now())");
	// // emailCreditPayment('Sofian', 'raden.sofian.bahri@gmail.com', $req, json_encode($_POST), "INVALID", "", "");

}
