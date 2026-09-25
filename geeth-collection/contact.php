<?php 
include("includes/header.php"); 
include("includes/config.php");

if(isset($_POST['send'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $stmt = $conn->prepare("INSERT INTO contacts (name,email,message) VALUES (?,?,?)");
    $stmt->bind_param("sss",$name,$email,$message);
    $stmt->execute();

    $success = "Message sent successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:Arial;
    background:#f5f7fb;
    min-height:100vh;
    padding:20px;
}

/* MAIN BOX */
.box{
    width:100%;
    max-width:420px;
    margin:40px auto;
    background:#fff;
    padding:25px;
    border-radius:12px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    transition:0.3s;
    text-align:left;
}

/* HOVER EFFECT */
.box:hover{
    transform:translateY(-5px);
}

/* TITLE */
h2{
    text-align:center;
    margin-bottom:15px;
    font-size:24px;
    color:#111;
}

/* INPUTS + TEXTAREA */
input,
textarea{
    width:100%;
    display:block;
    padding:12px;
    margin:10px 0;
    border:1px solid #ddd;
    border-radius:6px;
    font-family:Arial;
    font-size:14px;
    transition:0.3s;
    resize:vertical;
}

/* TEXTAREA */
textarea{
    min-height:120px;
}

/* FOCUS */
input:focus,
textarea:focus{
    outline:none;
    border-color:#ff4da6;
    box-shadow:0 0 5px rgba(255,77,166,0.3);
}

/* BUTTON */
button{
    width:100%;
    padding:12px;
    background:#ff4da6;
    border:none;
    color:#fff;
    cursor:pointer;
    border-radius:6px;
    transition:0.3s;
    font-size:15px;
}

button:hover{
    background:#e63d91;
}

/* SUCCESS MESSAGE */
.success{
    text-align:center;
    color:green;
    margin-bottom:10px;
    font-size:14px;
}

/* TABLET */
@media (max-width:768px){

    body{
        padding:15px;
    }

    .box{
        padding:22px;
    }

    h2{
        font-size:22px;
    }
}

/* MOBILE */
@media (max-width:480px){

    body{
        padding:10px;
    }

    .box{
        padding:18px;
        margin:20px auto;
        border-radius:10px;
    }

    h2{
        font-size:20px;
    }

    input,
    textarea{
        padding:11px;
        font-size:13px;
    }

    button{
        padding:11px;
        font-size:14px;
    }

    .success{
        font-size:13px;
    }
}
</style>

</head>

<body>

<div class="box">

<h2>Contact Us</h2>

<?php if(isset($success)){ ?>
<p class="success"><?php echo $success; ?></p>
<?php } ?>

<form method="POST">

<input type="text" name="name" placeholder="Your Name" required>
<input type="email" name="email" placeholder="Your Email" required>
<textarea name="message" placeholder="Your Message" required></textarea>

<button type="submit" name="send">Send Message</button>

</form>

</div>

</body>
</html>

<?php include("includes/footer.php"); ?>