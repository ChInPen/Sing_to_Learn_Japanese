<?php
$host = 'localhost';
$dbname = 'sing_to_learn_japanese';
$user = 'root';

$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
$db = new PDO($dsn, $user);

// 取得使用者輸入
$username = $_POST['username']; // 暱稱
$email_2 = $_POST['email']; // 信箱
$password_2 = $_POST['password']; // 密碼
$confirm_password = $_POST['confirm_password']; // 確認密碼

// 檢查 email 是否已註冊
$stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email_2]);
if ($stmt->fetch()) {
    die("此 email 已被註冊");
}
$hashed_password = password_hash($password_2, PASSWORD_DEFAULT);
$sql = "INSERT INTO Users (username, email, password) VALUES (?, ?, ?)";
$stmt = $db->prepare($sql);
$stmt->execute([$username, $email_2, $hashed_password]);
// 取得新使用者的 ID
$uid = $db->lastInsertId();
// 設定 session
$_SESSION['user'] = [
    "id" => $uid,
    "username" => $username,
    "email" => $email_2
];

header("Location: ../index.html");
exit();
