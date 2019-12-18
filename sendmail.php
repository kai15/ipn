<?php
function emailPayment($username,$email, $total, $jobtitle, $ipn, $status, $time) {
include_once('../class.phpmailer.php');

		$mail             = new PHPMailer(); // defaults to using php "mail()"
		$body             = '
		<body>

		<p><font color="#000080"><font face="Arial" size="4">
		<span style="font-size: 12px">Dear '.$username.',<br>
		Thank you for your purchase.<br>The details of which are below.<br></span></font></font></p>
		<span style="font-size: 12px;color: #000000; ">
		<p><font color="#000080">
		<table style="font-family:Arial, Helvetica, sans-serif;font-size:12px;">
			<tr>
				<td>Username:</td>
				<td>'.$username.'</td>
			</tr>
			<tr>
				<td>Email:</td>
				<td>'.$email.'</td>
			</tr>
			<tr>
				<td>Job Title:</td>
				<td>'.$jobtitle.'</td>
			</tr>
			<tr>
				<td>Date, Time:</td>
				<td>'.$time.'</td>
			</tr>
			<tr>
				<td>Payment ID:</td>
				<td>'.$ipn.'</td>
			</tr>
			<tr>
				<td>Status:</td>
				<td>'.$status.'</td>
			</tr>
		</table>
		  <br>
		  Thank you.
		  </span></font>
		  <span style="font-size: 12px;color: #00007F; "><br>
					<strong>C</strong>lient <strong>S</strong>ervices </span><br>
					<br>
					<img src="http://www.recruitment-boutique.com/images/signature_gmail.jpg"><br>
					<br>
					<span style="font-size: 12px;color: #00007F; ">t +44 (0) 20 8123 9129 <br>
					<br>
					www.recruitment-boutique.com<br>
					<br>
					Recruitment Boutique is registered in UK:  Kemp House, 152 City Road, London EC1V 2NX
					Company no: 07686179
					<br>
					The opinions expressed within this email represent solely those of the author. The 
					information in this Internet
					email is confidential and may be legally privileged. It is intended solely for the 
					addressee. Access to this 
					internet email by anyone else is unauthorised. If you are not the intended recipient, any 
					disclosure, copying, 
					distribution or any action taken or omitted to be taken in reliance on it, is prohibited and 
					may be unlawful.
					<br>
					<br>
					This message has been scanned for viruses. <br>
					
					</span>
					</body>';
		$body             = str_replace("\\",'',$body);

		$mail->From       = "enquiries@recruitment-boutique.com";
		$mail->FromName   = "Recruitment Boutique client support";
		$mail->Subject    = "Payment at Recruitment Boutique";
		$mail->MsgHTML($body);
		$mail->AddAddress($email, $username);
		//$mail->AddAddress("aang@ourteam.org.uk", "aang");
		 if($mail->Send()){
		 	return true;
		 }else{
		 	return false;
		 }
}
function emailCreditPayment($username,$email, $total, $credit, $ipn, $status, $time) {
		include_once('../class.phpmailer.php');

		$mail             = new PHPMailer(); // defaults to using php "mail()"
		$body             = '
		<body>

		<p><font color="#000080"><font face="Arial" size="4">
		<span style="font-size: 12px">Dear '.$username.',<br>
		Thank you for your payment. <br>The details are below:<br></span></font></font></p>
		<span style="font-size: 12px;color: #000000; ">
		<p><font color="#000080">
		<table style="font-family:Arial, Helvetica, sans-serif;font-size:12px;">
			<tr>
				<td>Username:</td>
				<td>'.$username.'</td>
			</tr>
			<tr>
				<td>Email:</td>
				<td>'.$email.'</td>
			</tr>
			<tr>
				<td>Credit:</td>
				<td>'.$credit.'</td>
			</tr>
			<tr>
				<td>Date, Time:</td>
				<td>'.$time.'</td>
			</tr>
			<tr>
				<td>Payment ID:</td>
				<td>'.$ipn.'</td>
			</tr>
			<tr>
				<td>Status:</td>
				<td>'.$status.'</td>
			</tr>
		</table>
		  <br>
		  Thank you.
		  </span></font>
		  <span style="font-size: 12px;color: #00007F; "><br>
					<strong>C</strong>lient <strong>S</strong>ervices </span><br>
					<br>
					<img src="http://www.recruitment-boutique.com/images/signature_gmail.jpg"><br>
					<br>
					<span style="font-size: 12px;color: #00007F; ">t +44 (0) 20 8123 9129 <br>
					<br>
					www.recruitment-boutique.com<br>
					<br>
					Recruitment Boutique is registered in UK:  Kemp House, 152 City Road, London EC1V 2NX
					Company no: 07686179
					<br>
					The opinions expressed within this email represent solely those of the author. The 
					information in this Internet
					email is confidential and may be legally privileged. It is intended solely for the 
					addressee. Access to this 
					internet email by anyone else is unauthorised. If you are not the intended recipient, any 
					disclosure, copying, 
					distribution or any action taken or omitted to be taken in reliance on it, is prohibited and 
					may be unlawful.
					<br>
					<br>
					This message has been scanned for viruses. <br>
					
					</span>
					</body>';
		$body             = str_replace("\\",'',$body);

		$mail->From       = "enquiries@recruitment-boutique.com";
		$mail->FromName   = "Recruitment Boutique client support";
		$mail->Subject    = "Payment at Recruitment Boutique";
		$mail->MsgHTML($body);
		$mail->AddAddress($email, $username);
		#$mail->AddAddress("sofian@javainspiration.com", "Sofian");
		//$mail->AddAddress("aang@ourteam.org.uk", "aang");
		 if($mail->Send()){
		 	return true;
		 }else{
		 	return false;
		 }
}



function emailCreditPaymentTemp($username,$email,$total_trx, $credit, $usersid, $name) {
		include_once('../class.phpmailer.php');

		$mail             = new PHPMailer(); // defaults to using php "mail()"
		$body             = '
		<body>

		<p><font color="#000080"><font face="Arial" size="4">
		<span style="font-size: 12px">Dear '.$username.',<br>
		Payment Temp.<br></span></font></font></p>
		<span style="font-size: 12px;color: #000000; ">
		<p><font color="#000080">
		<table style="font-family:Arial, Helvetica, sans-serif;font-size:12px;">
			<tr>
				<td>Total:</td>
				<td>'.$total_trx.'</td>
			</tr>
			<tr>
				<td>Credit:</td>
				<td>'.$credit.'</td>
			</tr>
			<tr>
				<td>Username:</td>
				<td>'.$name.'</td>
			</tr>
			<tr>
				<td>User ID:</td>
				<td>'.$usersid.'</td>
			</tr>

		</table>
		  <br>
		  Thank you.
		  </span></font>
		  <span style="font-size: 12px;color: #00007F; "><br>
					<strong>C</strong>lient <strong>S</strong>ervices </span><br>
					<br>
					<img src="http://www.recruitment-boutique.com/images/signature_gmail.jpg"><br>
					<br>
					<span style="font-size: 12px;color: #00007F; ">t +44 (0) 20 8123 9129 <br>
					<br>
					www.recruitment-boutique.com<br>
					<br>
					Recruitment Boutique is registered in UK:  Kemp House, 152 City Road, London EC1V 2NX
					Company no: 07686179
					<br>
					The opinions expressed within this email represent solely those of the author. The 
					information in this Internet
					email is confidential and may be legally privileged. It is intended solely for the 
					addressee. Access to this 
					internet email by anyone else is unauthorised. If you are not the intended recipient, any 
					disclosure, copying,  
					distribution or any action taken or omitted to be taken in reliance on it, is prohibited and 
					may be unlawful.
					<br>
					<br>
					This message has been scanned for viruses. <br>
					
					</span>
					</body>';
		$body             = str_replace("\\",'',$body);

		$mail->From       = "enquiries@recruitment-boutique.com";
		$mail->FromName   = "Recruitment Boutique client support";
		$mail->Subject    = "Payment Temp";
		$mail->MsgHTML($body);
		$mail->AddAddress($email, $username);
		//$mail->AddAddress("aang@ourteam.org.uk", "aang");
		 if($mail->Send()){
		 	return true;
		 }else{
		 	return false;
		 }
}


function emailNotify($data) {
		include_once('../class.phpmailer.php');

		$mail             = new PHPMailer(); // defaults to using php "mail()"
		$body             = '
		<body>

		<p><font color="#000080"><font face="Arial" size="4">
		<span style="font-size: 12px">Dear Sofian,<br>
		There is users make a payment on RB <br>The details are below:<br></span></font></font></p>
		<span style="font-size: 12px;color: #000000; ">
		<p><font color="#000080">
		'.json_encode($data).'
		  <br>
		  Thank you.
		  </span></font>
		  <span style="font-size: 12px;color: #00007F; "><br>
					<strong>C</strong>lient <strong>S</strong>ervices </span><br>
					<br>
					<img src="http://www.recruitment-boutique.com/images/signature_gmail.jpg"><br>
					<br>
					<span style="font-size: 12px;color: #00007F; ">t +44 (0) 20 8123 9129 <br>
					<br>
					www.recruitment-boutique.com<br>
					<br>
					Recruitment Boutique is registered in UK:  Kemp House, 152 City Road, London EC1V 2NX
					Company no: 07686179
					<br>
					The opinions expressed within this email represent solely those of the author. The 
					information in this Internet
					email is confidential and may be legally privileged. It is intended solely for the 
					addressee. Access to this 
					internet email by anyone else is unauthorised. If you are not the intended recipient, any 
					disclosure, copying, 
					distribution or any action taken or omitted to be taken in reliance on it, is prohibited and 
					may be unlawful.
					<br>
					<br>
					This message has been scanned for viruses. <br>
					
					</span>
					</body>';
		$body             = str_replace("\\",'',$body);

		$mail->From       = "enquiries@recruitment-boutique.com"; 
		$mail->FromName   = "Recruitment Boutique client support";
		$mail->Subject    = "Payment at Recruitment Boutique";
		$mail->MsgHTML($body);
		//$mail->AddAddress("raden.sofian.bahri@gmail.com", "sofian");
		//$mail->AddAddress("aang@ourteam.org.uk", "aang");
		 if($mail->Send()){
		 	return true;
		 }else{
		 	return false;
		 }
}