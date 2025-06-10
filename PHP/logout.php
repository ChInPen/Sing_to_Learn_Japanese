<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
session_destroy();
echo json_encode(["success" => true, "message" => "登出成功"]);
exit();
?>