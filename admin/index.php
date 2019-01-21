<?php
/**
 * Created by PhpStorm.
 * User: nifemiadeyemi
 * Date: 12/24/2018
 * Time: 8:39 PM
 */
session_start();
$db = mysqli_connect('us-cdbr-iron-east-01.cleardb.net','be19cbdc234d44','eb807cf4','heroku_ffc1f7613441892');
if(!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']){
  header('Location: login.php');
}
if($_GET){
    extract($_GET);
    if($mode == 'sandals'){
        $stmt = $db->prepare('DELETE FROM `sandals` WHERE id = ? LIMIT 1');
        $stmt->bind_param('i',$delete);
        $stmt->execute();
        $stmt->close();
        header('Location: index.php');
    }else if($mode == 'reviews'){
        $stmt = $db->prepare('DELETE FROM `reviews` WHERE id = ? LIMIT 1');
        $stmt->bind_param('i',$delete);
        $stmt->execute();
        $stmt->close();
        header('Location: index.php');
    }else if($mode == 'logout'){
        $_SESSION['logged_in'] = false;
        header('Location: login.php');
    }
}

if($_POST){
    extract($_POST);
    switch ($action){
        case 'change_image' : {
            extract($_FILES);
            if(strpos($photo['type'],'image') != false){
                $extension = explode('.',$photo['name'])[1];
                $name = md5(microtime()).'.'.$extension;
                $stmt = $db->prepare('UPDATE `bio` SET bio_img = ? WHERE id = 1');
                $location = 'assets/images/'.$name;
                $stmt->bind_param('s',$location);
                $stmt->execute();
                move_uploaded_file($photo['tmp_name'],'../assets/images/'.$name);
            }
            break;
        }
        case 'change_desc' : {
            if($description){
                $stmt = $db->prepare('UPDATE `bio` SET bio = ? WHERE id = 1');
                $stmt->bind_param('s',$description);
                $stmt->execute();
            }
            break;
        }
        case 'upload_sandal' : {
            extract($_FILES);
            if(strpos($sandal['type'],'image') != false){
                $extension = explode('.', $sandal['name'])[1];
                $name = md5(microtime()) . '.' . $extension;
                $stmt = $db->prepare('INSERT INTO `sandals` (`image_path`) VALUES(?)');
                $location = 'assets/images/' . $name;
                $stmt->bind_param('s', $location);
                $stmt->execute();
                move_uploaded_file($sandal['tmp_name'], '../assets/images/'.$name);
            }
            break;
        }
        case 'edit_review' : {
            if($review){
                $stmt = $db->prepare('UPDATE `reviews` SET review = ? WHERE id = ? LIMIT 1');
                $stmt->bind_param('si',$review,$id);
                $stmt->execute();
            }
            break;
        }
        case 'add_review' : {
            if($review){
                $stmt = $db->prepare('INSERT INTO `reviews` (`review`) VALUES (?)');
                $stmt->bind_param('s',$review);
                $stmt->execute();
            }
        }
    }
    header('Location: index.php');
}
$bioresult = mysqli_query($db,'SELECT * FROM bio');
$bioarray = mysqli_fetch_assoc($bioresult);

$reviewsres = mysqli_query($db,'SELECT * FROM reviews');

$sandalsres = mysqli_query($db,'SELECT * FROM sandals');

$contactres = mysqli_query($db,'SELECT * FROM contact');
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="../assets/css/admin.css">
        <title>Sand Sesq</title>
    </head>
    <body>
        <nav>
            <ul id="large-nav">
                <li data-target="about">About</li>
                <li data-target="sandals">Sandals</li>
                <li data-target="reviews">Reviews</li>
                <li data-target="contact">Contact</li>
                <li><a href="index.php?mode=logout">Logout</a></li>
            </ul>
            <button id="navsmallbtn">
                <img src="../assets/images/svg/navsmall.svg">
            </button>
            <div id="navsmall">
                <button><img src="../assets/images/svg/cancel.svg"></button>
                <ul>
                    <li data-target="about">About</li>
                    <li data-target="sandals">Sandals</li>
                    <li data-target="reviews">Reviews</li>
                    <li data-target="contact">Contact</li>
                    <li><a href="index.php?mode=logout">Logout</a></li>
                </ul>
            </div>
        </nav>
        <h2 class="header">Description</h2>
        <div id="about">
            <div id="about-img">
                <h2>Description image</h2>
                <img src="../<?=$bioarray['bio_img']?>" alt="">
                <form id="change_image" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="change_image">
                    <label>Change image</label>
                    <input type="file" name="photo" id="photo" required>
                    <button type="submit">Change</button>
                </form>
            </div>
            <div id="about-desc">
                <h2>Description Text<button id="edit-desc">Edit</button></h2>
                <div>
                    <?=$bioarray['bio']?>
                </div>
                <form method="post">
                    <input type="hidden" name="action" value="change_desc">
                    <textarea name="description" required><?=$bioarray['bio']?></textarea>
                    <button type="submit">Change</button>
                    <button type="button" id="edit-desc-cancel">Cancel</button>
                </form>
            </div>
        </div>
        <h2 class="header">Sandals</h2>
        <div id="sandals">
            <?php while ($row = mysqli_fetch_assoc($sandalsres)) :?>
            <div>
                <?php if(mysqli_num_rows($sandalsres) > 7): ?>
                    <button><a href="index.php?delete=<?=$row['id']?>&mode=sandals"><img src="../assets/images/svg/delete.svg" alt=""></a></button>
                <?php endif; ?>
                <img src="../<?=$row['image_path']?>" alt="">
            </div>
            <?php endwhile; ?>
            <form id="upload_sandal" method="post" enctype="multipart/form-data">
                <input type="hidden" name="action" value="upload_sandal">
                <label>Upload Sandal</label>
                <input type="file" name="sandal" id="photo" required>
                <button type="submit">Add</button>
            </form>
        </div>
        <h2 class="header">Reviews</h2>
        <div id="reviews">
            <?php while ($row = mysqli_fetch_assoc($reviewsres)) : ?>
            <div class="item">
                <div>
                    <?=$row['review']?>
                    <button class="item-edit">
                        <img src="../assets/images/svg/pencil.svg">
                    </button>
                    <button>
                        <a href="index.php?delete=<?=$row['id']?>&mode=reviews">
                            <img src="../assets/images/svg/delete.svg">
                        </a>
                    </button>
                </div>
                <form class="edit_review" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="edit_review">
                    <input type="hidden" name="id" value="<?=$row['id']?>">
                    <label>Edit Review</label>
                    <textarea name="review" required><?=$row['review']?></textarea>
                    <button type="submit"><img src="../assets/images/svg/tick.svg"></button>
                    <button class="cancel-edit" type="button"><img src="../assets/images/svg/forbidden.svg"></button>
                </form>
            </div>
            <?php endwhile; ?>
            <div>
                <div class="img">
                    <button id="add_review_btn">
                        <img src="../assets/images/svg/add.svg" alt="">
                    </button>
                </div>
                <form id="add_review" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="add_review">
                    <label>Add Review</label>
                    <textarea name="review" required></textarea>
                    <button type="submit"><img src="../assets/images/svg/tick.svg"></button>
                    <button class="cancel-edit" type="button"><img src="../assets/images/svg/forbidden.svg"></button>
                </form>
            </div>
        </div>
        <h2 class="header">Contact</h2>
        <div id="contact">
            <?php while ($row = mysqli_fetch_assoc($contactres)) : ?>
            <div>
                <p><?=$row['name']?></p>
                <p><?=$row['email']?></p>
                <p><?=$row['phone_number']?></p>
                <p><?=$row['message']?></p>
            </div>
            <?php endwhile; ?>
        </div>
        <p id="copyright">Copyright &copy; Sandsesq Website 2018</p>
    <script src="../assets/js/admin.js"></script>
    </body>
</html>
