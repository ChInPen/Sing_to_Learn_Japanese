<?php
// 個別刪除session
//unset($_SESSION['user']);
// 全部刪除session
session_destroy();
// 結束後跳轉到login.html
header('Location:../index.html');
?>