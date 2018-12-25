<?php
/**
 * Created by PhpStorm.
 * User: nifemiadeyemi
 * Date: 12/24/2018
 * Time: 9:44 PM
 */
session_start();
$db = mysqli_connect('localhost','root','','sandsesq');

if($_POST) {
    extract($_POST);
    $stmt = $db->prepare('INSERT INTO `contact`(`name`, `email`, `phone_number`, `message`) VALUES(?,?,?,?)');
    $stmt->bind_param('ssis', $name, $email, $number, $message);
    $stmt->execute();
    $_SESSION['success_flash'] = 'Success!';
    header('Location: index.php');
}
