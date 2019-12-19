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
<?php
//Fetch products from db in most secured way.
$prep_stmt = "SELECT * FROM paypal_products";
$stmt = $mysqli->prepare($prep_stmt);
if ($stmt) {
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $name, $price);
if ($stmt->num_rows >= 1) {
while ($stmt->fetch()) {
echo 'Product Name: '.$name;
echo '<br>';
echo 'Price: '.'$'.$price.'';
?>

<form action="<?php echo $paypal_url; ?>" method="post">
<!-- Get paypal email address from core_config.php -->
<input type="hidden" name="business" value="<?php echo $paypal_seller; ?>">

<!-- Specify product details -->
<input type="hidden" name="item_name" value="<?php echo $name; ?>">
<input type="hidden" name="item_number" value="<?php echo $id; ?>">
<input type="hidden" name="amount" value="<?php echo $price; ?>">
<input type="hidden" name="currency_code" value="USD">

<!-- IPN Url -->
 <input type='hidden' name='notify_url' value='https://boiling-bayou-19352.herokuapp.com/ipn_listerner1.0.modify.php'>
<!-- Return URLs -->
<input type='hidden' name='cancel_return' value='<? echo $payment_return_cancel; ?>'>
<input type='hidden' name='return' value='<? echo $payment_return_success; ?>'>

<!-- Submit Button -->
<input type="hidden" name="cmd" value="_xclick">
<input type="submit" value="Buy Now!" name="submit">
</form>

<?php
}
} else {echo 'No Products in DB';}
$stmt->close();
}
?>
</body>
</html>