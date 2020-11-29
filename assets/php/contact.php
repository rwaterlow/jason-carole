<?php

// configure
//$from = 'Contact from site <demo@domain.com> ';
//$sendTo = '<demo@domain.com>';
$from = $_POST['email'];
$sendTo = 'rufuswaterlow.com <info@rufuswaterlow.com>';
$subject = 'New message from the website';
$fields = array('form_name' => 'Name', 'form_email' => 'Email Address', 'form_attendance' => 'Attending', 'form_message' => 'Message');
$okMessage = 'Your information has successfully been submitted. Thank you for being in touch!';
$errorMessage = 'There was an error while submitting the form. Please try again shortly';

//sending

try
{
	$emailText = "You have a new message from a site visitor:\n\n";

	foreach ($_POST as $key => $value) {

		if (isset($fields[$key])) {
			$emailText .= "$fields[$key]: $value\n";
		}
	}

	$headers = array('Content-Type: text/plain; charset="UTF-8";',
		'From: ' . $from,
		'Reply-To: ' . $from,
		'Return-Path: ' . $from,
	);

	mail($sendTo, $subject, $emailText, implode("\n", $headers));

	$responseArray = array('type' => 'success', 'message' => $okMessage);
}

catch (\Exception $e)
{
	$responseArray = array('type' => 'danger', 'message' => $errorMessage);
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
	$encoded = json_encode($responseArray);

	header('Content-Type: application/json');

	echo $encoded;
}

else {
	echo $responseArray['message'];
}

