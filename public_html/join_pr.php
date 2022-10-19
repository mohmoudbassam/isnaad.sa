<?php
session_start();
require("sendgrid-php/sendgrid-php.php");
if (isset($_POST['email'])) {

    $email_to = "sales@isnaad.sa";
    $email_subject = "join request";
    $name = $_POST['name'];
    $comName = $_POST['comName'];
    $email_from = $_POST['email'];
    $with = $_POST['with'];
    $without = $_POST['without'];
    $store_url = $_POST['store_url'];
    $mnsa = $_POST['mnsa'];
    $phone = $_POST['phone'];
    $mnsaName = $_POST['mnsaName'];
    $message = $_POST['message'];


    $email_message = "Form details below.\n\n";


    function clean_string($string)
    {
        $bad = array("content-type", "bcc:", "to:", "cc:", "href");
        return str_replace($bad, "", $string);
    }

    $send = true;
    if ($mnsa == '') {

        if ($mnsaName == '') {
            $send = false;
        }
    }
    if ($mnsa == 'other') {

        if ($mnsaName == '') {
            $send = false;
        }
    }
    if ($with == 1) {
        $with = '0-50';
    } elseif ($with == 2) {
        $with = '50-100';
    } elseif ($with == 3) {
        $with = '100-200';
    } elseif ($with == 4) {
        $with = '200-500';
    } elseif ($with == 5) {
        $with = '500-1000';
    }
    if ($without == 1) {
        $without = '0-50';
    } elseif ($without == 2) {
        $without = '50-100';
    } elseif ($without == 3) {
        $without = '100-200';
    } elseif ($without == 4) {
        $without = '200-500';
    } elseif ($without == 5) {
        $without = '500-1000';
    }

    $email_message .= "Name: " . clean_string($name) . "\n";
    $email_message .= "Email: " . clean_string($email_from) . "\n";
    $email_message .= "phone: " . clean_string($phone) . "\n";
    $email_message .= "store url: " . clean_string($store_url) . "\n";
    $email_message .= "The platform used: " . clean_string($mnsa) . "\n";
    $email_message .= "The store name: " . clean_string($comName) . "\n";
    $email_message .= "Orders With Advertising campaign:" . clean_string($with) . "\n";
    $email_message .= "Orders Without Advertising campaign:" . clean_string($without) . "\n";

    $email_message .= "Message: " . clean_string($message) . "\n";

// create email headers
//    $headers ="Content-Type: text/plain; charset=UTF-8\r\n" .
//     'From: '.$email_from."\r\n".
//        'Reply-To: '.$email_from."\r\n" .
//        'X-Mailer: PHP/' . phpversion();
//        if($send){
//  mail($email_to, $email_subject, $email_message, $headers);
//    $_SESSION['ok']='ok';
//        }else{
//            $_SESSION['no']='no';
//        }
// die( mail($email_to, $email_subject, $email_message, $headers));
//info@isnaad.sa
    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("malkhatib@isnaad.sa",$name);
    $email->setSubject("Isnaad Join Us Form");
    $email->addTo("info@isnaad.sa", "Isnaad Join Us Form");
    $email->addContent(
        "text/html", getTable($name,
            $email_from,
            $phone,
            $store_url,
            $mnsa,
            $comName,
            $with,
            $without,
            $message)
    );
    $sendgrid = new \SendGrid('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');
    try {
        $response = $sendgrid->send($email);
   
       

    } catch (Exception $e) {
        echo 'Caught exception: ' . $e->getMessage() . "\n";
    }
    header("location:joinus.php");

}

function getTable($name, $email_from, $phone, $store_url, $mnsa, $comName, $with, $without, $message)
{

    return "<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>
<body>

<h2> from $name</h2>

<table>
    <tr>
        <th>Name</th>
        <th>$name</th>


    </tr>
    <tr>
        <th>Email</th>
        <th>$email_from</th>


    </tr>  <tr>
        <th>store url</th>
        <th>$store_url</th>


    </tr> <tr>
        <th>The platform Used</th>
        <th>$mnsa</th>


    </tr> <tr>
        <th>The Store Name</th>
        <th>$comName</th>


    </tr>
    <tr>
        <td>Message</td>
        <td>$message</td>


    </tr>

    <tr>
        <td>phone</td>
        <td>$phone</td>


    </tr>
     <tr>
        <td>Orders With Advertising campaign</td>
        <td>$with</td>


    </tr> 
    <tr>
        <td>Orders Without Advertising campaign</td>
        <td>$without</td>


    </tr>
 

</table>

</body>
</html>

";
}

?>
