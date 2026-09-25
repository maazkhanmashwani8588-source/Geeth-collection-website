<?php
include("includes/config.php");

if(isset($_POST['register'])){

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // BASIC VALIDATION
    if(empty($name) || empty($email) || empty($password)){
        die("All fields are required");
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        die("Invalid email format");
    }

    if(strlen($password) < 6){
        die("Password must be at least 6 characters");
    }

    // CHECK IF EMAIL EXISTS
    $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        die("Email already exists");
    }

    // HASH PASSWORD (SECURE)
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // INSERT USER SAFELY
    $stmt = $conn->prepare("INSERT INTO users (name,email,password) VALUES (?,?,?)");
    $stmt->bind_param("sss", $name, $email, $hashedPassword);

    if($stmt->execute()){
        header("Location: login.php");
        exit();
    } else {
        echo "Registration failed";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Register</title>

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
    text-align:center;
}

/* TITLE */
h2{
    margin-bottom:20px;
    font-size:24px;
    color:#111;
}

/* INPUTS */
input{
    width:100%;
    padding:12px;
    margin:10px 0;
    border:1px solid #ddd;
    border-radius:6px;
    outline:none;
    font-size:14px;
    transition:0.3s;
}

/* INPUT FOCUS */
input:focus{
    border-color:#FF4DA6;
    box-shadow:0 0 5px rgba(255,77,166,0.3);
}

/* REGISTER BUTTON */
.register-btn{
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

.register-btn:hover{
    background:#e63d91;
}

/* LINKS */
a{
    display:block;
    margin-top:12px;
    color:#FF4DA6;
    text-decoration:none;
    font-size:14px;
}

a:hover{
    text-decoration:underline;
}

/* ERROR MESSAGE */
.error{
    color:red;
    margin-bottom:10px;
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

    .register-btn{
        padding:11px;
        font-size:14px;
    }

    a{
        font-size:13px;
    }

    .error{
        font-size:13px;
    }
}
</style>

</head>

<body>

<div class="box">

<h2>Register</h2>

<?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>

<form method="POST">

<input type="text" name="name" placeholder="Name" required>

<input type="email" name="email" placeholder="Email" required>

<input type="password" name="password" placeholder="Password" required>

<button class="register-btn" name="register">Create Account</button>

</form>

<a href="login.php">Already have an account? Login</a>

</div>

</body>
</html>