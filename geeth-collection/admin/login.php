<?php
include("../includes/config.php");

if(isset($_POST['login'])){

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? AND role='admin'");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if($user && password_verify($password, $user['password'])){

        // SECURITY: regenerate session
        session_regenerate_id(true);

        $_SESSION['admin'] = $user['id'];
        $_SESSION['admin_name'] = $user['name'];

        header("Location: dashboard.php");
        exit();

    } else {
        $error = "Invalid login details!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>

    <style>
       *{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:Arial;
    background:#111;

    min-height:100vh;

    display:flex;
    justify-content:center;
    align-items:center;

    padding:20px;
}

/* FORM BOX */
.box{
    width:100%;
    max-width:320px;

    background:#fff;
    padding:30px;

    border-radius:10px;
    box-shadow:0 0 20px rgba(0,0,0,0.3);
}

/* TITLE */
h2{
    text-align:center;
    margin-bottom:20px;
    color:#111;
}

/* INPUTS */
input{
    width:100%;
    padding:12px;
    margin:10px 0;

    border:1px solid #ccc;
    border-radius:5px;

    outline:none;
    font-size:14px;
    transition:0.3s;
}

/* INPUT FOCUS */
input:focus{
    border-color:#ff4da6;
    box-shadow:0 0 5px rgba(255,77,166,0.3);
}

/* BUTTON */
button{
    width:100%;
    padding:12px;

    background:#ff4da6;
    color:#fff;

    border:none;
    border-radius:5px;

    cursor:pointer;
    transition:0.3s;
    font-size:15px;
}

button:hover{
    background:#e63d91;
}

/* ERROR */
.error{
    color:red;
    text-align:center;
    margin-bottom:10px;
    font-size:14px;
}

/* MOBILE */
@media(max-width:480px){

    body{
        padding:15px;
    }

    .box{
        padding:22px;
    }

    h2{
        font-size:22px;
    }

    input{
        padding:11px;
        font-size:13px;
    }

    button{
        padding:11px;
        font-size:14px;
    }
}
    </style>
</head>

<body>

<div class="box">

    <h2>Admin Login</h2>

    <form method="POST">

        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit" name="login">Login</button>

        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

    </form>

</div>

</body>
</html>