<?php

include("../includes/config.php");
include("auth.php");

/* ================= PHPMailer ================= */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
/* ============================================ */

if(!isset($_GET['id'])){
    die("Invalid ID");
}

$id = $_GET['id'];

/* GET USER MESSAGE */
$stmt = $conn->prepare("SELECT * FROM contacts WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if(!$data){
    die("Message not found");
}

/* SEND REPLY */
if(isset($_POST['send'])){

    $reply = $_POST['reply'];

    /* SAVE IN DATABASE */
    $stmt = $conn->prepare("UPDATE contacts SET reply=? WHERE id=?");
    $stmt->bind_param("si",$reply,$id);
    $stmt->execute();

    /* SEND EMAIL USING PHPMailer */
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;

        $mail->Username = 'geetcollection447@gmail.com';
        $mail->Password = 'ydmmzcxsgqxadnck'; 

        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('your-email@gmail.com', 'Geet Collection');
        $mail->addAddress($data['email'], $data['name']);

        $mail->isHTML(true);
        $mail->Subject = 'Reply from Geet Collection';

        $mail->Body = "
        <h3>Hello {$data['name']},</h3>
        <p>{$reply}</p>
        <br>
        <p>Regards,<br><b>Geet Collection</b></p>
        ";

        $mail->send();

        echo "<script>alert('Reply sent successfully'); window.location='contacts.php';</script>";

    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<style>
body{
    font-family:Arial;
    background:#f5f7fb;
    margin:0;
    padding:15px;
}

/* MAIN BOX */
.box{
    width:100%;
    max-width:450px;
    margin:40px auto;
    background:#fff;
    padding:25px;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
    transition:0.3s;
    box-sizing:border-box;
}

.box:hover{
    transform:translateY(-5px);
}

/* HEADINGS */
h3{
    margin-bottom:10px;
    font-size:20px;
}

/* TEXT */
p{
    color:#555;
    line-height:1.6;
    font-size:15px;
}

/* TEXTAREA */
textarea{
    width:100%;
    height:120px;
    padding:10px;
    margin-top:10px;
    border-radius:6px;
    border:1px solid #ddd;
    font-size:15px;
    outline:none;
    resize:vertical;
    box-sizing:border-box;
}

/* BUTTON */
button{
    margin-top:10px;
    padding:12px;
    width:100%;
    background:#4f46e5;
    color:#fff;
    border:none;
    cursor:pointer;
    border-radius:6px;
    transition:0.3s;
    font-size:16px;
    box-sizing:border-box;
}

button:hover{
    background:#3730a3;
}

/* TABLET */
@media (max-width:768px){
    .box{
        width:92%;
        padding:20px;
        margin:30px auto;
    }
}

/* MOBILE SMALL PHONES */
@media (max-width:480px){
    body{
        padding:10px;
    }

    .box{
        width:100%;
        padding:18px;
        margin:20px auto;
        border-radius:8px;
    }

    h3{
        font-size:18px;
    }

    p{
        font-size:14px;
    }

    button{
        font-size:15px;
        padding:11px;
    }
}
</style>

</head>

<body>

<div class="box">

<h3>Reply to <?php echo $data['name']; ?></h3>

<p><b>Message:</b> <?php echo $data['message']; ?></p>

<form method="POST">
<textarea name="reply" placeholder="Write your reply..." required></textarea>
<button name="send">Send Reply</button>
</form>

</div>

</body>
</html>