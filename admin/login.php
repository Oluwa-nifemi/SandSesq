<?php
/**
 * Created by PhpStorm.
 * User: nifemiadeyemi
 * Date: 12/25/2018
 * Time: 4:13 AM
 */
session_start();
$db = mysqli_connect('localhost','root','','sandsesq');
if($_POST){
    extract($_POST);

    if(!empty($password) && !empty($username)){
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param('s',$username);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = mysqli_fetch_assoc($result);
        if(mysqli_num_rows($result) >= 0){
            if(password_verify($password,$row['password'])){
                $_SESSION['logged_in'] = true;
                header('Location: index.php');
            }else{
                $error = "Your password is incorrect";
            }
        }else{
            $error = "Your username wasn't found in the database";
        }
    }else{
        $error = "Please fill all the fields";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
    <form method="post">
        <div id="errors">
            <?=isset($error) && !empty($error) ? $error : '';?>
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </div>
        <button type="submit">Login</button>
    </form>
</body>
</html>
