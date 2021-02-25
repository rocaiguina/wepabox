<?php
function clean_string($string) {
    $bad = array("content-type","bcc:","to:","cc:","href");
    return str_replace($bad,"",$string);
}




$response = array();
if (
    isset($_POST['firstname']) &&
    isset($_POST['lastname']) &&
    isset($_POST['email'])
) {
    $email_to = "solizvaldezedgar@gmail.com, info@wepabox.com";
    //$email_to = "Simon@lauracasselman.com";
    $email_subject = "Your email subject line";

    $first_name = $_POST['firstname']; // required
    $last_name = $_POST['lastname']; // required
    $email_from = $_POST['email']; // required
    $phone_number = $_POST['phonenumber']; // required
    $comments = $_POST['message'];

    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
    if(preg_match($email_exp,$email_from)) {
        $email_message .= "First Name: ".clean_string($first_name)."\n";
        $email_message .= "Last Name: ".clean_string($last_name)."\n";
        $email_message .= "Email: ".clean_string($email_from)."\n";
        $email_message .= "Phone Number: ".clean_string($phone_number)."\n";
        $email_message .= "Comments: ".clean_string($comments)."\n";
        // create email headers
        $headers = 'From: '.$email_from."\r\n".
            'Reply-To: '.$email_from."\r\n" .
            'X-Mailer: PHP/' . phpversion();
        @mail($email_to, $email_subject, $email_message, $headers);

        $response['success'] = "Thank you for contacting us. We will be in touch with you very soon.";
    }else{
        $response['error'] = "The Email Address you entered does not appear to be valid.";
    }

} else {
    $response['error'] = "We are sorry, but there appears to be a problem with the form you submitted.";
}
echo json_encode($response);exit();