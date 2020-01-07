<?php
//include configuration file
include_once 'core_config.php';
?>
<html>
<head>
<title>Test</title>
</head>

<body>
<h1>Test</h1>

<form action="https://boiling-bayou-19352.herokuapp.com/ipn_listerner1.0.modify.php" method="post">
<!-- Get paypal email address from core_config.php -->
<input type="hidden" name="business" value="<?php echo $paypal_seller; ?>">

<!-- Specify product details -->
<!-- <input type="hidden" name="item_name" value="<?php echo $name; ?>">
<input type="hidden" name="item_number" value="<?php echo $id; ?>">
<input type="hidden" name="amount" value="<?php echo $price; ?>"> -->
<input name="payer_email" type="hidden" value="sb-0tuos643383@personal.example.com" /><input type="hidden" name="currency_code" value="USD">
<input name="mc_gross" type="hidden" value="500.00" />
	<input name="custom" type="hidden" value="some custom data" />
	<input name="address_status" type="hidden" value="confirmed" />
	<input name="item_number1" type="hidden" value="6" />
	<input name="item_number2" type="hidden" value="4" />
	<input name="payer_id" type="hidden" value="FW5W7ZUC3T4KL" />
	<input name="tax" type="hidden" value="0.00" />
	<input name="address_street" type="hidden" value="1234 Rock Road" />
	<input name="payment_date" type="hidden" value="14:55 15 Jan 07 2005 PST" />
	<input name="payment_status" type="hidden" value="Completed" />
	<input name="address_zip" type="hidden" value="12345" />
	<input name="mc_shipping" type="hidden" value="0.00" />
	<input name="mc_handling" type="hidden" value="0.00" />
	<input name="first_name" type="hidden" value="Jason" />
	<input name="last_name" type="hidden" value="Anderson" />
	<input name="mc_fee" type="hidden" value="0.02" />
	<input name="address_name" type="hidden" value="Jason Anderson" />
	<input name="notify_version" type="hidden" value="1.6" />
	<input name="payer_status" type="hidden" value="verified" />
	<!-- <input name="business" type="hidden" value="paypal@emailaddress.com" /> -->
	<input name="address_country" type="hidden" value="United States" />
	<input name="num_cart_items" type="hidden" value="2" />
	<input name="mc_handling1" type="hidden" value="0.00" />
	<input name="mc_handling2" type="hidden" value="0.00" />
	<input name="address_city" type="hidden" value="Los Angeles" />
	<input name="verify_sign" type="hidden" value="AlUbUcinRR5pIo2KwP4xjo9OxxHMAi6.s6AES.4Z6C65yv1Ob2eNqrHm" />
	<input name="mc_shipping1" type="hidden" value="0.00" />
	<input name="mc_shipping2" type="hidden" value="0.00" />
	<input name="tax1" type="hidden" value="0.00" />
	<input name="tax2" type="hidden" value="0.00" />
	<input name="txn_id" type="hidden" value="TESTER" />
	<input name="payment_type" type="hidden" value="instant" />
	<input name="last_name=Borduin" type="hidden" />
	<!-- <input name="payer_email" type="hidden" value="test@domain.com" /> -->
	<input name="item_name1" type="hidden" value="Rubber+clog" />
	<input name="address_state" type="hidden" value="CA" />
	<input name="payment_fee" type="hidden" value="0.02" />
	<input name="item_name2" type="hidden" value="Roman sandal" />
	<input name="invoice" type="hidden" value="123456" />
	<input name="quantity" type="hidden" value="1" />
	<input name="quantity1" type="hidden" value="1" />
	<input name="receiver_id" type="hidden" value="5HRS8SCK9NSJ2" />
	<input name="quantity2" type="hidden" value="1" />
	<input name="txn_type" type="hidden" value="web_accept" />
	<input name="mc_gross_1" type="hidden" value="0.01" />
	<input name="mc_currency" type="hidden" value="USD" />
	<input name="mc_gross_2" type="hidden" value="0.01" />
	<input name="payment_gross" type="hidden" value="0.02" />
	<input name="subscr_id" type="hidden" value="PP-1234" />
	<input name="test" type="submit" value="test" />

<!-- IPN Url -->
 <!-- <input type='hidden' name='notify_url' value='https://boiling-bayou-19352.herokuapp.com/ipn_listerner1.0.modify.php'> -->
<!-- Return URLs -->
<!-- <input type='hidden' name='cancel_return' value='<? echo $payment_return_cancel; ?>'> -->
<!-- <input type='hidden' name='return' value='<? echo $payment_return_success; ?>'> -->

<!-- Submit Button -->
<!-- <input type="hidden" name="cmd" value="_xclick">
<input type="submit" value="submit" name="test"> -->
</form>
</body>
</html>