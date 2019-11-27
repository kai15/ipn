<?php
// // STEP 1: read POST data
// // Reading POSTed data directly from $_POST causes serialization issues with array data in the POST.
// // Instead, read raw POST data from the input stream.
// $raw_post_data = file_get_contents('php://input');
// $raw_post_array = explode('&', $raw_post_data);
// $myPost = array();
// foreach ($raw_post_array as $keyval) {
//   $keyval = explode ('=', $keyval);
//   if (count($keyval) == 2)
//     $myPost[$keyval[0]] = urldecode($keyval[1]);
// }
// // read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'
// $req = 'cmd=_notify-validate';
// if (function_exists('get_magic_quotes_gpc')) {
//   $get_magic_quotes_exists = true;
// }
// foreach ($myPost as $key => $value) {
//   if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
//     $value = urlencode(stripslashes($value));
//   } else {
//     $value = urlencode($value);
//   }
//   $req .= "&$key=$value";
// }

// // Step 2: POST IPN data back to PayPal to validate
// // $ch = curl_init('https://www.sandbox.paypal.com/cgi-bin/webscr');
// $ch = curl_init('https://ipnpb.sandbox.paypal.com/cgi-bin/webscr');
// curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
// curl_setopt($ch, CURLOPT_POST, 1);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
// curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
// curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
// curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
// curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//     'User-Agent: PHP-IPN-Verification-Script','Connection: Close'));
// // In wamp-like environments that do not come bundled with root authority certificates,
// // please download 'cacert.pem' from "https://curl.haxx.se/docs/caextract.html" and set
// // the directory path of the certificate as shown below:
// // curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
// if ( !($res = curl_exec($ch)) ) {
//   echo "Got " . curl_error($ch) . " when processing IPN data";
//   curl_close($ch);
//   exit;
// }
// curl_close($ch);

// if (strcmp ($res, "VERIFIED") == 0) {
//   echo "AHUY";
//   // The IPN is verified, process it:
//   // check whether the payment_status is Completed
//   // check that txn_id has not been previously processed
//   // check that receiver_email is your Primary PayPal email
//   // check that payment_amount/payment_currency are correct
//   // process the notification
//   // assign posted variables to local variables
//   $item_name = $_POST['item_name'];
//   $item_number = $_POST['item_number'];
//   $payment_status = $_POST['payment_status'];
//   $payment_amount = $_POST['mc_gross'];
//   $payment_currency = $_POST['mc_currency'];
//   $txn_id = $_POST['txn_id'];
//   $receiver_email = $_POST['receiver_email'];
//   $payer_email = $_POST['payer_email'];
//   // IPN message values depend upon the type of notification sent.
//   // To loop through the &_POST array and print the NV pairs to the screen:
//   foreach($_POST as $key => $value) {
//     echo $key . " = " . $value . "<br>";
//   }
// } else if (strcmp ($res, "INVALID") == 0) {
//   // IPN invalid, log for manual investigation
//   echo "The response from IPN was: <b>" .$res ."</b>";
// }

?>

<?php
class PaypalIPN
{
    /**
     * @var bool $use_sandbox     Indicates if the sandbox endpoint is used.
     */
    private $use_sandbox = false;
    /**
     * @var bool $use_local_certs Indicates if the local certificates are used.
     */
    private $use_local_certs = true;
    /** Production Postback URL */
    const VERIFY_URI = 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr';
    /** Sandbox Postback URL */
    const SANDBOX_VERIFY_URI = 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr';
    /** Response from PayPal indicating validation was successful */
    const VALID = 'VERIFIED';
    /** Response from PayPal indicating validation failed */
    const INVALID = 'INVALID';
    /**
     * Sets the IPN verification to sandbox mode (for use when testing,
     * should not be enabled in production).
     * @return void
     */
    public function useSandbox()
    {
        $this->use_sandbox = true;
    }
    /**
     * Sets curl to use php curl's built in certs (may be required in some
     * environments).
     * @return void
     */
    public function usePHPCerts()
    {
        $this->use_local_certs = false;
    }
    /**
     * Determine endpoint to post the verification data to.
     * @return string
     */
    public function getPaypalUri()
    {
        if ($this->use_sandbox) {
            return self::SANDBOX_VERIFY_URI;
        } else {
            return self::SANDBOX_VERIFY_URI;
        }
    }
    /**
     * Verification Function
     * Sends the incoming post data back to PayPal using the cURL library.
     *
     * @return bool
     * @throws Exception
     */
    public function verifyIPN()
    {
        if ( ! count($_POST)) {
            throw new Exception("Missing POST Data");
        }
        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        foreach ($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2) {
                // Since we do not want the plus in the datetime string to be encoded to a space, we manually encode it.
                if ($keyval[0] === 'payment_date') {
                    if (substr_count($keyval[1], '+') === 1) {
                        $keyval[1] = str_replace('+', '%2B', $keyval[1]);
                    }
                }
                $myPost[$keyval[0]] = urldecode($keyval[1]);
            }
        }
        // Build the body of the verification post request, adding the _notify-validate command.
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
        // Post the data back to PayPal, using curl. Throw exceptions if errors occur.
        $ch = curl_init($this->getPaypalUri());
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        // This is often required if the server is missing a global cert bundle, or is using an outdated one.
        if ($this->use_local_certs) {
            curl_setopt($ch, CURLOPT_CAINFO, __DIR__ . "/cert/cacert.pem");
        }
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
        $res = curl_exec($ch);
        if ( ! ($res)) {
            $errno = curl_errno($ch);
            $errstr = curl_error($ch);
            curl_close($ch);
            throw new Exception("cURL error: [$errno] $errstr");
        }
        $info = curl_getinfo($ch);
        $http_code = $info['http_code'];
        if ($http_code != 200) {
            throw new Exception("PayPal responded with http code $http_code");
        }
        curl_close($ch);
        // Check if PayPal verifies the IPN data, and if so, return true.
        if ($res == self::VALID) {
            echo "The response from IPN was: <b>" .$res ."</b>";
            return true;
        } else {
            echo "The response from IPN was: <b>" .$res ."</b>";
            return false;
        }
    }
}