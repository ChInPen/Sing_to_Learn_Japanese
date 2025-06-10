<?php
session_start();
$host = 'localhost';
$name = 'sing_to_learn_japanese';
$user = 'root';
$pass = '';
try {
    $dsn = "mysql:host=$host;dbname=$name;charset=utf8mb4";
    $db = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die(json_encode(["success" => false, "message" => "資料庫連線失敗：" . $e->getMessage()]));
}
// 獲取帳密
$input = json_decode(file_get_contents("php://input"), true); // 適用 fetch 傳 JSON 的情況
$email = $input['email'] ?? '';
$password = $input['password'] ?? '';
// 查詢使用者
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$email]);
$user = $stmt->fetch();
if (!$user || !password_verify($password, $user['password'])) {
    http_response_code(401);
    echo json_encode(["success" => false, "message" => "帳號或密碼錯誤"]);
    exit();
}
// 登入成功，儲存 session
$_SESSION['user'] = [
    'id' => $user['id'],
    'email' => $user['email'],
    'username' => $user['username']
];
echo json_encode([
    "success" => true,
    "message" => "登入成功",
    "user" => $_SESSION['user']
]);
