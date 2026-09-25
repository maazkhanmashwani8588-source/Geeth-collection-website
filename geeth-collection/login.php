<?php
session_start(); // IMPORTANT (MUST BE FIRST)

include("includes/config.php");

if(isset($_POST['login'])){

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if(empty($email) || empty($password)){
        $error = "All fields are required";
    } else {

        // GET USER
        $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // VERIFY PASSWORD
        if($user && password_verify($password, $user['password'])){

            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = htmlspecialchars($user['name']);

            header("Location: user/dashboard.php");
            exit();

        } else {
            $error = "Invalid email or password";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:Arial;
    background:linear-gradient(135deg,#111,#222);
    min-height:100vh;

    display:flex;
    justify-content:center;
    align-items:center;

    padding:20px;
}

/* MAIN BOX */
.box{
    background:#fff;
    padding:30px;
    width:100%;
    max-width:350px;
    border-radius:12px;
    box-shadow:0 10px 25px rgba(0,0,0,0.3);
    text-align:left;
}

/* TITLE */
h2{
    margin-bottom:20px;
    text-align:center;
    font-size:24px;
}

/* INPUTS */
input{
    width:100%;
    display:block;
    padding:12px;
    margin:10px 0;
    border:1px solid #ddd;
    border-radius:6px;
    outline:none;
    font-size:14px;
}

/* INPUT FOCUS */
input:focus{
    border-color:#FF4DA6;
}

/* LOGIN BUTTON */
.login-btn{
    width:100%;
    padding:12px;
    margin-top:10px;
    border:none;
    border-radius:6px;
    cursor:pointer;
    background:#FF4DA6;
    color:#fff;
    font-size:15px;
    transition:0.3s;
}

.login-btn:hover{
    background:#e63d91;
}

/* CANCEL BUTTON */
.cancel-btn{
    width:100%;
    padding:12px;
    margin-top:10px;
    border:none;
    border-radius:6px;
    cursor:pointer;
    background:#444;
    color:#fff;
    display:block;
    text-align:center;
    text-decoration:none;
    transition:0.3s;
}

.cancel-btn:hover{
    background:#222;
}

/* REGISTER LINK */
a{
    display:block;
    margin-top:10px;
    color:#FF4DA6;
    text-decoration:none;
    text-align:center;
}

/* ERROR */
.error{
    color:red;
    margin-bottom:10px;
    text-align:center;
    font-size:14px;
}

/* ================= TABLET ================= */
@media (max-width:768px){

    .box{
        padding:25px;
    }

    h2{
        font-size:22px;
    }
}

/* ================= MOBILE ================= */
@media (max-width:480px){

    body{
        padding:15px;
        align-items:center;
    }

    .box{
        padding:20px;
        border-radius:10px;
    }

    h2{
        font-size:20px;
    }

    input{
        padding:11px;
        font-size:13px;
    }

    .login-btn,
    .cancel-btn{
        padding:11px;
        font-size:14px;
    }

    .error{
        font-size:13px;
    }
}
</style>

</head>

<body>

<div class="box">

<h2>Login</h2>

<?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>

<form method="POST">

<input type="email" name="email" placeholder="Email" required>

<input type="password" name="password" placeholder="Password" required>

<button class="login-btn" name="login">Login</button>

</form>

<!-- CANCEL BUTTON (FIXED) -->
<a href="index.php" class="cancel-btn">Cancel</a>

<a href="register.php">Don't have an account? Register</a>

</div>

</body>
</html>