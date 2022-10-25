<?php
	header('Content-type: application/json');

	$ctrl = @trim($_POST['save']);
	
	if ($ctrl != "reserveEvt") { die; exit; } 	
	
	$name = @trim($_POST['name']);
	$email_address = @trim(stripslashes($_POST['email']));
	$telf = @trim(stripslashes($_POST['telf']));
	$service = @trim(stripslashes($_POST['service']));
	$sevent = @trim(stripslashes($_POST['sevent']));
	$rdate = @trim(stripslashes($_POST['time']));
	$commensals = @trim(stripslashes($_POST['guests']));
	$comments = @trim(stripslashes($_POST['message']));
	$maillist = @trim(stripslashes($_POST['maillist']));
	
	if(empty($email_address) || !filter_var($email_address,FILTER_VALIDATE_EMAIL)) {
		$status = array( 'type'=>'failure',
				         'message'=>'Ops!! Something wrong on server side. Message has not been sent. Sorry!');	
		echo json_encode($status);
		die;
	}

    $email_from = $email_address;
    $email_to = 'info@BellmontRestaurant.com'; 

    $body = 'Name: ' . $name . "\n\n" . 'Email: ' . $email_address . "\n\n" . 'Subject: ' . "\n\n" . 'Message: ' . $comments;
	
	$email_subject = "Pata Negra event Reservation order submitted by:  $name";
	$email_body = "<html><body><p>";
	$email_body .= "You have received a new Reservation order. <br><br>".
					  " Here are the details:<br> <br>  <strong>Name:</strong> $name <br> ".
					  " <strong>e-mail:</strong> $email_address  <strong>&nbsp;&nbsp;Phone:</strong> $telf   ".					   
					  " <strong>&nbsp;&nbsp;Special event:</strong> Pata Negra 2017 June, 15 <br><br> ".
					  " <strong>Requested time:</strong> $rdate   <strong>&nbsp;&nbsp;Commensals:</strong> $commensals<br><br> <strong>Comments:</strong> <br> $comments";
	$email_body .= "</p></body></html>";
	 		   
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

	// $headers  = "From: info@BellmontRestaurant.com\n";
	// $headers .= "Reply-To: info@BellmontRestaurant.com\n";	
	$headers .= "From: info@BellmontRestaurant.com\n";
	$headers .= "Reply-To: info@BellmontRestaurant.com\n";		   		   

    $success = mail($email_to, $email_subject, $email_body, $headers);
	
	if ($success) {
	      $status = array(
				'type'=>'success',
				'message'=>'Thank you for your request. We will contact you shortly. Gracias.'
			);
    } else {     
		  $status = array(
				'type'=>'failure',
				'message'=>'Ops!! Something wrong on server side. Message has not been sent. Sorry!'
			);	
	}	
	
//  
// create autoresponse email body and send it	
// 
	$to = $email_address;  
	$email_subject = "Bellmónt Spanish Restaurant has received your reservation request";
	$email_body = "<html><body><p>";
	$email_body .= "Thanks for contacting us. We have received your request and will contact you shortly. <br><br>".
					  " Kind regards,<br> ".
					  "<font color=DarkBlue><strong>The Bellmónt Team</strong></font> <br><br> ";
	$email_body .= "<font color=SteelBlue><small>";
	$email_body .= "<strong>Bellmónt Spanish Restaurant</strong><br>".
				   " 339 Miracle Mile<br>Coral Gables, FL 33134<br> ".
				   " Phone: (786) 502.4684<br>Direct: (305) 321.5077<br> ";				  
	$email_body .= "<a target='_blank' href='http://bellmontrestaurant.com'>http://bellmontrestaurant.com</a><br>";
	$email_body .= "<small></font> <br> ";
	$email_body .= "</p></body></html>";
	 
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

	// $headers  = "From: info@BellmontRestaurant.com\n";
	// $headers .= "Reply-To: info@BellmontRestaurant.com\n";	
	$headers .= "From: info@BellmontRestaurant.com\n";
	$headers .= "Reply-To: info@BellmontRestaurant.com\n";		   
	
    $success = mail($to, $email_subject, $email_body, $headers);
	
	if ($success) {
	      $status = array(
				'type'=>'success',
				'message'=>'Thank you for your request. We will contact you shortly. Gracias.'
			);
    } else {     
		  $status = array(
				'type'=>'failure',
				'message'=>'Ops!! Something wrong on server side. Message has not been sent. Sorry!'
			);	
	}
	
    echo json_encode($status);
    die;