<?php
session_start();

// remove all session data
$_SESSION = [];

// destroy session
session_unset();
session_destroy();

// optional: delete session cookie (extra security)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], 
        $params["domain"], 
        $params["secure"], 
        $params["httponly"]
    );
}

// redirect to home or login
header("Location: index.php");
exit();
?>