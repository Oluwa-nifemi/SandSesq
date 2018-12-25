<?php
/**
 * Created by PhpStorm.
 * User: nifemiadeyemi
 * Date: 12/24/2018
 * Time: 2:56 PM
 */
session_start();

$db = mysqli_connect('localhost','root','','sandsesq');
$bioresult = mysqli_query($db,'SELECT * FROM bio');
$bioarray = mysqli_fetch_assoc($bioresult);

$reviewsres = mysqli_query($db,'SELECT * FROM reviews ORDER BY rand()');

$sandalsres = mysqli_query($db,'SELECT * FROM sandals ORDER BY rand()');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/css/index.css">
    <title>Sand Sesq</title>
</head>
<body>
    <div id="top">
        <nav>
            <ul id="large-nav">
                <li data-target="description">About</li>
                <li data-target="sandals">Sandals</li>
                <li data-target="reviews">Reviews</li>
                <li data-target="contact">Contact</li>
            </ul>
            <button id="navsmallbtn">
                <img src="assets/images/svg/navsmall.svg">
            </button>
            <div id="navsmall">
                <button><img src="assets/images/svg/cancel.svg"></button>
                <ul>
                    <li data-target="description">About</li>
                    <li data-target="sandals">Sandals</li>
                    <li data-target="reviews">Reviews</li>
                    <li data-target="contact">Contact</li>
                </ul>
            </div>
        </nav>
    </div>
    <div id="description">
        <div id="desc-img">
            <img src="<?=$bioarray['bio_img']?>" alt="">
        </div>
        <div id="desc-text">
            <h2>Abdul (Sandsesq)</h2>
            <p><?=$bioarray['bio']?></p>
        </div>
    </div>
    <div id="sandals">
        <h1>Sandals</h1>
        <?php
        $count = 1;
        while ($row = mysqli_fetch_assoc($sandalsres)) :
        ?>
        <div><img src="<?=$row['image_path']?>" alt="sandal"></div>
        <?php
            $count++;
            if($count >= 5)break;
            endwhile;
        ?>
        <div><h1>Sandals</h1></div>
        <?php
        $count = 1;
        while ($row = mysqli_fetch_assoc($sandalsres)) :
        ?>
            <div><img src="<?=$row['image_path']?>" alt="sandal"></div>
        <?php
            $count++;
            if($count >= 5)break;
            endwhile;
        ?>
    </div>
    <div id="reviews">
        <?php
            $count = 1;
            while ($row = mysqli_fetch_assoc($reviewsres)) :
        ?>
        <div>
            <span><img src="assets/images/svg/quote.svg" alt=""></span>
            <?=$row['review']?>
        </div>
        <?php
            $count++;
            if($count > 12)break;
            endwhile;
        ?>
    </div>
    <div id="contact-wrap">
        <div id="contact">
            <h1>Let's Keep in Touch</h1>
            <form action="add_message.php" method="post">
                <?php if(isset($_SESSION['success_flash']) && !empty($_SESSION['success_flash'])) : ?>
                    <div class="reply">Thank you, your message has been recorded I will get back to you as soon as possible</div>
                <?php
                $_SESSION['success_flash'] = '';
                endif;
                ?>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="number">Phone Number</label>
                    <input type="number" id="number" name="number" required>
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea name="message" id="message" required></textarea>
                </div>
                <div class="form-group submit">
                    <button type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <div id="social">
        <div>
            <a href="#"><img src="assets/images/Twitter.png" alt=""></a>
            <a href="#"><img src="assets/images/Email.png" alt=""></a>
            <a href="#"><img src="assets/images/FB.png" alt=""></a>
            <a href="#"><img src="assets/images/IG.png" alt=""></a>
            <a href="#"><img src="assets/images/Phone.png" alt=""></a>

        </div>
    </div>
    <script src="assets/js/index.js"></script>
</body>
</html>
