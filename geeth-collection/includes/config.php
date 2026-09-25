<?php

/* =========================
   DATABASE CONFIGURATION
   ========================= */

$hostname = "localhost";
$username = "root";
$password = "";
$dbname   = "geeth_store";

/* Create connection */
$conn = mysqli_connect($hostname, $username, $password, $dbname);

/* Check connection */
if (!$conn) {
    // In production, avoid showing detailed errors to users
    die("Database connection failed");
}

/* Set charset for proper text handling */
mysqli_set_charset($conn, "utf8");

/* =========================
   SESSION START (SAFE)
   ========================= */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>