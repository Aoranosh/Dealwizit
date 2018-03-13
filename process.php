<?php
$name = $_POST["name"];
$email = $_POST["email"];
$message = $_POST["message"];

$EmailTo = "chenxuefranck@gmail.com";
$Subject = "T\'as reçu un message !";

// prepare email body text
$Body .= "Name: ";
$Body .= $name;
$Body .= "\n";

$Body .= "Email: ";
$Body .= $email;
$Body .= "\n";

$Body .= "Message: ";
$Body .= $message;
$Body .= "\n";

// send email
$success = mail($EmailTo, $Subject, $Body, "From:".$email);

// redirect to success page
if ($success && $errorMSG == ""){
   echo "success";
}else{
    if($errorMSG == ""){
        echo "Ca ne marche pas :(";
    } else {
        echo $errorMSG;
    }
}

// SECONDE VALIDATION
$errorMSG = "";

// NAME
if (empty($_POST["name"])) {
    $errorMSG = "Quel est votre nom ? ";
} else {
    $name = $_POST["name"];
}

// EMAIL
if (empty($_POST["email"])) {
    $errorMSG .= "Quel est votre email ? ";
} else {
    $email = $_POST["email"];
}

// MESSAGE
if (empty($_POST["message"])) {
    $errorMSG .= "Quel est votre message ? ";
} else {
    $message = $_POST["message"];
}

?>
