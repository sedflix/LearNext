<?php
$mysqli = new mysqli("localhost", "root", "", "hack");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

if(!isset($_COOKIE['user_id'])) {
    header("Location: http://localhost/hack/login.php");
} else {
    $user_ID = $_COOKIE['user_id'];
}

?>