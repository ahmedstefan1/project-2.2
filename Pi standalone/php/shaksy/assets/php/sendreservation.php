<?php
/**
 * Pistacia Send Reservation script
 *
 * This script send reservation contact form data to email
 *
 * author: Bumbella
 * contact: http://themeforest.net/user/bumbella
 *
 */
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
{

    $rules = array(
        'firstName' => 'required',
        'lastName' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'guestNumber' => 'required',
        'reservationTime' => 'required',
        'reservationDate' => 'required');

    $data = array(
        'firstName' => $_POST['firstName'],
        'lastName' => $_POST['lastName'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'guestNumber' => $_POST['guestNumber'],
        'reservationTime' => $_POST['reservationTime'],
        'reservationDate' => $_POST['reservationDate']);

    require_once('class/Validator.php');
    $validator = new Validator();

    if ($validator->validate($data, $rules))
    {
        $to = "pistaciatheme@gmail.com";
        $subject = "Reservation form - Pistacia - Restaurant & Food HTML5 Template";
        $message = 'first name:' . $_POST['firstName'] .
                '<br>Last name:' . $_POST['lastName'] .
                '<br>Email:' . $_POST['email'] .
                '<br>Phone:' . $_POST['phone'] .
                '<br>Date:' . $_POST['reservationDate'] . ' ' . $_POST['reservationTime'] .
                '<br>Guest number:' . $_POST['guestNumber'] .
                '<br>Message:' . $_POST['reservationMessage'];

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
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