<?php
session_start();
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);

if (!$redis->get('user_session') || !isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "Please login first"]);
    exit;
}

$mysqli = new mysqli('localhost', 'username', 'password', 'database');
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$user_id = $_SESSION['user_id'];

// Fetch user data from database
$stmt = $mysqli->prepare("SELECT username, email, created_at FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($username, $email, $created_at);

if ($stmt->fetch()) {
    echo json_encode(["status" => "success", "data" => [
        "username" => $username,
        "email" => $email,
        "created_at" => $created_at
    ]]);
} else {
    echo json_encode(["status" => "error", "message" => "User not found"]);
}

$stmt->close();
?>
