<?php
/**
 * Pistacia Send Contact
 *
 * This script send contact form data to email
 *
 * author: Bumbella
 * contact: http://themeforest.net/user/bumbella
 *
 *
 *
 */
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
{

    $rules = array(
        'name' => 'required',
        'email' => 'required|email');

    $data = array(
        'name' => $_POST['name'],
        'email' => $_POST['email']);

    require_once('class/Validator.php');
    $validator = new Validator();

    if ($validator->validate($data, $rules))
    {
        $to = "pistaciatheme@gmail.com";
        $subject = "Contact form - Pistacia - Restaurant & Food HTML5 Template";
        $message = 'Name:' . $_POST['name'] . '<br>Email:' . $_POST['email'] . '<br>Message:' . $_POST['cntMessage'];

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'To: <pistaciatheme@gmail.com>' . "\r\n";
        $headers .= 'From: <' . $_POST['email'] . '>' . "\r\n";

        mail($to, $subject, $message, $headers);
        echo '<div class = "label label-lg label-success">Message has been sent</div>';
    }
    else
    {
        echo '<div class = "label label-lg label-danger">The contact unsuccess</div>';
    }
}