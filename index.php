<?php

$error = '';
$name = '';
$email = '';
$message = '';

function clean_text($string) {
    $string=trim($string);
    $string=stripslashes($string);
    $string=htmlspecialchars($string);
    return $string
}

if(isset($_POST["submit"])) {
    if(empty($_POST["name"])) {
        $error .= '<p><label class="text danger">Please enter your name<label></p>';
    } else {
        $name = clean_text($_POST["name"]);
        if(!preg_match("/^[a-zA-Z ]*$/",$name)) {
            $error .= '<p><label class="text-danger">Only letters and white space allowed</label></p>';
        }
    }
    if(empty($_POST["email"])) {
        $error .= '<p><label class="text danger">Please enter your email<label></p>';
    } else {
        $email = clean_text($_POST["email"]);
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error .= '<p><label class="text-danger">Invalid email format</label></p>';
        }
    }
    if(empty($_POST["message"])) {
        $error .= '<p><label class="text danger">Message is required</label></p>';
    } else {
        $message = clean_text($_POST["message"]);
    }
    if($error == '') {
        $file_open = fopen("Contact.csv", "a");
        $no_rows = count(file("Contact.csv"));
        if($no_rows > 1) {
            $no_rows = ($no_rows - 1) + 1;
        }
        $form_data = array(
            'sr_no' => $no_rows,
            'name' => $name,
            'email' => $email,
            'message' => $message
        );
        fputcsv($file_open, $form_data);
        $error = '<label class="text success">Thank you for contacting me</label>';
        $name = '';
        $email = '';
        $message = '';
    }
}?>