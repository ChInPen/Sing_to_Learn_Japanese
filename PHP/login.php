<?php
session_start(); // 必須啟動 session

$host = 'localhost';
$name = 'sing_to_learn_japanese';
$user = 'root';
$pass = ''; // XAMPP 預設密碼

try {
    $dsn = "mysql:host=$host;dbname=$name;charset=utf8mb4";
    $db = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("❌ 資料庫連線失敗：" . $e->getMessage());
}

// 取得表單輸入值
$email = $_REQUEST['email'] ?? '';
$password = $_REQUEST['password'] ?? '';

// 查詢資料庫是否有此用戶
$sql = "SELECT * FROM users WHERE email = ? AND password = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$email, $password]);
$user = $stmt->fetch();

if (!$user) {
    // 🔹 如果沒有找到用戶，跳出視窗並導向 `register.html`
    echo "<script>alert('尚未註冊，請進行註冊！'); window.location.href = '../index.html';</script>";
    exit();
} else {
    // 🔹 登入成功，儲存 session
    $_SESSION['user'] = $user;

    // 🔹 轉跳到 `welcome.php`
    header("Location: welcome.php");
    exit();
}
?>
