<?php
// 檢查是否已登入
if (!isset($_SESSION['user'])) {
  header("Location: ./主頁(請開啟).html");
  exit();
}
$user = $_SESSION['user']
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../Bootstrap/bootstrap-5.0.0-dist/css/bootstrap.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <script src="../Bootstrap/bootstrap-5.0.0-dist/js/bootstrap.bundle.js"></script>
  <title>唱歌學日語</title>
  <style>
    body {
      background-color: #f8f9fa;
    }

    /* 輪播圖CSS */
    .card-container {
      position: relative;
      overflow: hidden;
    }

    /* 動畫效果 */
    .animation {
      height: auto;
      width: 200%;
      display: flex;
      animation: scroll 10S linear infinite;

      &:hover {
        animation-play-state: paused;
      }
    }

    @keyframes scroll {
      0% {
        transform: translateX(0%);
      }

      100% {
        transform: translateX(-50%);
      }

    }

    /* 動畫結束 */

    /* 翻轉卡片內容 */
    .flip-card {
      height: auto;
      width: 20%;
      perspective: 1000px;
      display: inline-block;
      vertical-align: top;
    }

    .flip-card-inner {
      height: auto;
      position: relative;
      transition: transform 0.6s;
      transform-style: preserve-3d;
    }

    /* 滑鼠懸停時翻轉 */
    .flip-card:hover .flip-card-inner {
      transform: rotateY(180deg);
    }

    /* 卡片正面 & 背面 */
    .flip-card-front,
    .flip-card-back {
      backface-visibility: hidden;
    }

    /* 正面樣式 */
    .flip-card-front img {
      display: block;
      width: 100%;
      height: auto;
      padding: 1%;
    }

    /* 背面樣式 */
    .flip-card-back {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      backface-visibility: hidden;
      transform: rotateY(180deg);
      background: url("../img/music/背景音符圖.jpg") no-repeat center center;
      background-size: cover;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      transition: opacity 0.5s ease;
      text-decoration: none;
    }

    .flip-card-back::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.6);
      z-index: 1;
    }

    .flip-card-back p {
      position: relative;
      z-index: 2;
      margin: 0;
    }

    .flip-card-back:hover p,
    .flip-card-back:hover a {
      color: #FF9900;
    }

    .flip-card-back .overlay {
      background: rgba(0, 0, 0, 0.3);
      padding: 20px;
      border-radius: 8px;
      text-align: center;
    }

    /* 翻轉片結束 */



    /* 熱播歌曲 */
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
    }

    .music-carousel {
      position: relative;
      overflow: hidden;
      margin-top: 10px;
    }

    .music-scroller {
      display: flex;
      gap: 20px;
      overflow-x: auto;
      scroll-behavior: smooth;
      padding: 10px 0;
      white-space: nowrap;
    }

    .music-scroller::-webkit-scrollbar {
      display: none;
    }

    .music-group {
      display: flex;
      flex-direction: column;
      gap: 30px;
    }

    /* 單首歌的外觀 */
    .music-item {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 8px;
      border-bottom: 1px solid #ddd;
      width: 500px;
      text-decoration: none;
      color: inherit;
    }

    .music-item img {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 5px;
      margin-right: 15px;
    }

    .info .title {
      font-size: 28px;
      font-weight: bold;
    }

    .info .artist {
      font-size: 25px;
      color: gray;
    }

    /* 左右箭頭按鈕 */
    .scroll-btn {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: rgba(0, 0, 0, 0.2);
      color: white;
      border: none;
      cursor: pointer;
      padding: 5px 10px;
      font-size: 18px;
      z-index: 10;
    }

    .scroll-btn.left {
      left: 0;
    }

    .scroll-btn.right {
      right: 0;
    }

    .scroll-btn:hover {
      background: rgba(0, 0, 0, 0.4);
    }

    /* 熱播結束 */


    /* 更多歌曲 */
    .grid-container {
      display: grid;
      gap: 20px;
      grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
      padding: 20px;
      max-width: 1200px;
      margin: 0 auto;
    }

    .card {
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      width: 100%;
      height: 300px;
      border: 1px solid #ccc;
      border-radius: 6px;
      background-color: #fff;
      text-align: center;
      position: relative;
      overflow: hidden;
      text-decoration: none;
      color: inherit;
      transition: box-shadow 0.3s;
    }

    .card img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 1s ease;
    }

    .card .info {
      height: 90px;
    }

    .card .title {
      font-size: 19px;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .card .artist {
      font-size: 15px;
      color: #555;
    }

    .card {
      text-decoration: none;
      color: inherit;
      position: relative;
      overflow: hidden;
    }

    .card:hover {
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .card:hover img {
      transform: scale(1.2);
    }

    /* 更多歌曲結束 */

    /* 頁尾 */
    .footer {
      background-color: #2f3a45;
      color: #fff;
      padding: 20px;
      font-size: 14px;
    }

    .footer-top {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .footer-left {
      display: flex;
      align-items: center;
    }

    .like-btn {
      background: none;
      border: 1px solid #fff;
      color: #fff;
      padding: 5px 10px;
      border-radius: 4px;
      cursor: pointer;
    }

    .like-btn:hover {
      background: #fff;
      color: #2f3a45;
    }

    .footer-links {
      list-style: none;
      display: flex;
      gap: 15px;
      margin: 0;
      padding: 0;
    }

    .footer-links li a {
      color: #fff;
      text-decoration: none;
      transition: color 0.2s;
    }

    .footer-links li a:hover {
      color: #ffd700;
    }

    .footer-right {
      display: flex;
      align-items: center;
    }

    .positive-icon {
      width: 80px;
      height: auto;
    }

    .footer-middle {
      text-align: center;
      margin: 20px 0;
    }

    .scroll-top-btn {
      display: inline-block;
      width: 40px;
      height: 40px;
      line-height: 40px;
      background-color: #fff;
      color: #2f3a45;
      border-radius: 50%;
      text-align: center;
      font-size: 18px;
      text-decoration: none;
    }

    .scroll-top-btn:hover {
      background-color: #ffd700;
      color: #2f3a45;
    }

    .footer-bottom {
      text-align: center;
      font-size: 12px;
      border-top: 1px solid #444;
      margin-top: 10px;
      padding-top: 10px;
    }

    /* 頁尾結束 */
    .custom{
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgb(0, 0, 0);
      background-color: rgba(0, 0, 0, 0.4);
    }
    /* w3school 彈跳視窗 */
    .custom-modal {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgb(0, 0, 0);
      background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
      background-color: #fefefe;
      margin: 15% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
      margin: 100px auto;
      text-align: center;
    }

    /* w3結束 */


    /* 登入按鈕 */
    .custom-backdrop {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 1050;
    }

    /* 自訂 Modal 內容 */
    .custom-modal2 {
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      max-width: 400px;
      width: 90%;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
      opacity: 0;
      transform: translateY(-20px);
      transition: opacity 0.3s ease, transform 0.3s ease;
    }

    /* 顯示時 */
    .custom-backdrop.active {
      display: flex;
    }

    .custom-modal2.active {
      opacity: 1;
      transform: translateY(0);
    }

    /* 關閉按鈕 */
    .custom-modal2 .close-btn {
      float: right;
      background: transparent;
      border: none;
      font-size: 20px;
      cursor: pointer;
    }

    .cads {
      position: relative;
      display: flex;
      flex-direction: column;
      min-width: 0;
      word-wrap: break-word;
      background-color: #fff;
      background-clip: border-box;
      border: 1px solid rgba(0, 0, 0, 0.125);
      border-radius: 0.25rem;
    }

    /* 登入按鈕結束 */
    /* 更多歌曲 */
    .cards {
      display: flex;
      flex-direction: column;
      background-color: #fff;
      border: 1px solid #ddd;
      border-radius: 0.25rem;
      text-decoration: none;
      color: inherit;
      overflow: hidden;
      transition: box-shadow 0.3s ease;
    }

    .cards:hover {
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .cards img {
      width: 100%;
      display: block;
      transition: transform 0.5s ease;
    }

    .cards:hover img {
      transform: scale(1.1);
    }

    .cards .info {
      padding: 10px;
    }

    .cards .title {
      font-size: 1.1rem;
      font-weight: bold;
      margin-bottom: 0.5rem;
    }

    .cards .artist {
      font-size: 0.9rem;
      color: #555;
    }

    /* 更多歌曲結束 */
  </style>
</head>

<body>
  <div id="modal" class="custom">
    <div class="modal-content">
      <h1>登入成功!</h1>
    </div>
  </div>
  <!-- 導覽列 -->
  <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #fff;">
    <div class="container">
      <!-- 左側Logo -->
      <a class="navbar-brand" href="#">
        <img src="../img/icon/logo.png" style="width: 80px;">
      </a>

      <!-- 選單按鈕（小螢幕） -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- 右側選單項目 -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
          <!-- <li class="nav-item">
            <a class="nav-link" href="#">歌手列表 <i class="fas fa-music"></i></a>
          </li> -->
          <li class="nav-item">
            <a class="nav-link" id="myBtn2" href="#">日語學習
              <!-- w3school 彈跳視窗 -->
              <div id="myModal2" class="custom-modal">
                <div class="modal-content">
                  <h1>敬請期待！</h1>
                </div>
              </div>
              <!-- w3school 彈跳視窗結束 -->
              <i class="fas fa-book-open"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="myBtn" href="#">訊息公告
              <!-- w3school 彈跳視窗 -->
              <div id="myModal1" class="custom-modal">
                <div class="modal-content">
                  <h1>目前歌曲還在陸續更新中</h1>
                  <h1>有任何問題都歡迎在錯誤回報那邊傳送訊息</h1>
                  <h1>感謝各位的配合！</h1>
                </div>
              </div>
              <!-- w3school 彈跳視窗結束 -->
              <i class="fas fa-comment"></i>
            </a>
          </li>
        </ul>
        <!-- <form class="d-flex ms-auto">
          <input class="form-control me-2" type="search" placeholder="搜尋" aria-label="搜尋">
          <button class="btn btn-outline-success" type="submit"><i class="fas fa-search"></i></button>
        </form> -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="./功能/留言板.html">錯誤回報
              <i class="fa-solid fa-question"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./logout.php" id="openModalBtn">登出<i class="fa-solid fa-user"></i></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- 輪播圖 -->
  <div class="container my-5 card-container">
    <h1>近期更新</h1>
    <div class="animation">
      <!-- 第一組 -->
      <div class="flip-card">
        <div class="flip-card-inner">
          <!-- 卡片正面 -->
          <div class="flip-card-front">
            <img src="../img/music/Official髭男dism-Pretender.jpg">
          </div>
          <!-- 卡片背面 -->
          <a href="./歌曲/Pretender.html" class="flip-card-back">
            <p style="font-size: 40px;">Pretender</p>
            <p>Official髭男dism</p>
          </a>
        </div>
      </div>

      <div class="flip-card">
        <div class="flip-card-inner">
          <!-- 卡片正面 -->
          <div class="flip-card-front">
            <img src="../img/music/RADWIMPS-前前前世.jpg">
          </div>
          <!-- 卡片背面 -->
          <a href="" class="flip-card-back">
            <p style="font-size: 40px;">前前前世</p>
            <p>RADWIMPS</p>
          </a>
        </div>
      </div>

      <div class="flip-card">
        <div class="flip-card-inner">
          <!-- 卡片正面 -->
          <div class="flip-card-front">
            <img src="../img/music/tuki-晚餐歌.jpg">
          </div>
          <!-- 卡片背面 -->
          <a href="./歌曲/晚餐歌.html" class="flip-card-back">
            <p style="font-size: 40px;">晚餐歌</p>
            <p>tuki</p>
          </a>
        </div>
      </div>

      <div class="flip-card">
        <div class="flip-card-inner">
          <!-- 卡片正面 -->
          <div class="flip-card-front">
            <img src="../img/music/Yoasobi-怪物.jpg">
          </div>
          <!-- 卡片背面 -->
          <a href="./歌曲/怪物.html" class="flip-card-back">
            <p style="font-size: 40px;">怪物</p>
            <p>Yoasobi</p>
          </a>
        </div>
      </div>

      <div class="flip-card">
        <div class="flip-card-inner">
          <!-- 卡片正面 -->
          <div class="flip-card-front">
            <img src="../img/music/米津玄師-灰色と青.jpg">
          </div>
          <!-- 卡片背面 -->
          <a href="" class="flip-card-back">
            <p style="font-size: 40px;">灰色と青</p>
            <p>米津玄師</p>
          </a>
        </div>
      </div>
      <!-- 第二組開始 -->
      <div class="flip-card">
        <div class="flip-card-inner">
          <!-- 卡片正面 -->
          <div class="flip-card-front">
            <img src="../img/music/Official髭男dism-Pretender.jpg">
          </div>
          <!-- 卡片背面 -->
          <a href="./歌曲/Pretender.html" class="flip-card-back">
            <p style="font-size: 40px;">Pretender</p>
            <p>Official髭男dism</p>
          </a>
        </div>
      </div>

      <div class="flip-card">
        <div class="flip-card-inner">
          <!-- 卡片正面 -->
          <div class="flip-card-front">
            <img src="../img/music/RADWIMPS-前前前世.jpg">
          </div>
          <!-- 卡片背面 -->
          <a href="" class="flip-card-back">
            <p style="font-size: 40px;">前前前世</p>
            <p>RADWIMPS</p>
          </a>
        </div>
      </div>

      <div class="flip-card">
        <div class="flip-card-inner">
          <!-- 卡片正面 -->
          <div class="flip-card-front">
            <img src="../img/music/tuki-晚餐歌.jpg">
          </div>
          <!-- 卡片背面 -->
          <a href="./歌曲/晚餐歌.html" class="flip-card-back">
            <p style="font-size: 40px;">晚餐歌</p>
            <p>tuki</p>
          </a>
        </div>
      </div>

      <div class="flip-card">
        <div class="flip-card-inner">
          <!-- 卡片正面 -->
          <div class="flip-card-front">
            <img src="../img/music/Yoasobi-怪物.jpg">
          </div>
          <!-- 卡片背面 -->
          <a href="./歌曲/怪物.html" class="flip-card-back">
            <p style="font-size: 40px;">怪物</p>
            <p>Yoasobi</p>
          </a>
        </div>
      </div>

      <div class="flip-card">
        <div class="flip-card-inner">
          <!-- 卡片正面 -->
          <div class="flip-card-front">
            <img src="../img/music/米津玄師-灰色と青.jpg">
          </div>
          <!-- 卡片背面 -->
          <a href="" class="flip-card-back">
            <p style="font-size: 40px;">灰色と青</p>
            <p>米津玄師</p>
          </a>
        </div>
      </div>
      <!-- 第二組結束 -->
    </div>
  </div>
  <!-- 熱播歌曲清單 -->
  <div class="container">
    <h1>最新歌曲</h1>
    <div class="music-carousel">
      <button class="scroll-btn left" onclick="scrollMusicList(-1)">&#10094;</button>
      <div class="music-scroller">
        <!--第一組-->
        <div class="music-group">
          <a class="music-item d-flex align-items-center" href="#">
            <img src="../img/music/Creepy Nuts-Bling-Bang-Bang-Born.jpg" alt="音樂封面">
            <div class="info">
              <div class="title">Bling-Bang-Bang-Born</div>
              <div class="artist">Creepy Nuts</div>
            </div>
          </a>
          <a class="music-item d-flex align-items-center" href="#">
            <img src="../img/music/RADWIMPS-前前前世.jpg" alt="音樂封面">
            <div class="info">
              <div class="title">前前前世</div>
              <div class="artist">RADWIMPS</div>
            </div>
          </a>
          <a class="music-item d-flex align-items-center" href="#">
            <img src="../img/music/米津玄師-Lemon.jpg" alt="音樂封面">
            <div class="info">
              <div class="title">Lemon</div>
              <div class="artist">米津玄師</div>
            </div>
          </a>
        </div>
        <!-- 第二組 -->
        <div class="music-group">
          <a class="music-item d-flex align-items-center" href="./歌曲/Pretender.html">
            <img src="../img/music/Official髭男dism-Pretender.jpg" alt="音樂封面">
            <div class="info">
              <div class="title">Pretender</div>
              <div class="artist">Official髭男dism-Pretender</div>
            </div>
          </a>
          <a class="music-item d-flex align-items-center" href="#">
            <img src="../img/music/Yoasobi-Idol.png" alt="音樂封面">
            <div class="info">
              <div class="title">Idol</div>
              <div class="artist">Yoasobi</div>
            </div>
          </a>
          <a class="music-item d-flex align-items-center" href="#">
            <img src="../img/music/米津玄師-灰色と青.jpg" alt="音樂封面">
            <div class="info">
              <div class="title">灰色と青</div>
              <div class="artist">米津玄師</div>
            </div>
          </a>
        </div>
        <!-- 第三組 -->
        <div class="music-group">
          <a class="music-item d-flex align-items-center" href="./歌曲/晚餐歌.html">
            <img src="../img/music/tuki-晚餐歌.jpg" alt="音樂封面">
            <div class="info">
              <div class="title">晚餐歌</div>
              <div class="artist">tuki</div>
            </div>
          </a>
          <a class="music-item d-flex align-items-center" href="#">
            <img src="../img/music/Kocchi no Kento-はいよろこんで.jpg" alt="音樂封面">
            <div class="info">
              <div class="title">はいよろこんで</div>
              <div class="artist">Kocchi no Kento</div>
            </div>
          </a>
          <a class="music-item d-flex align-items-center" href="./歌曲/怪物.html">
            <img src="../img/music/Yoasobi-怪物.jpg" alt="音樂封面">
            <div class="info">
              <div class="title">怪物</div>
              <div class="artist">Yoasobi</div>
            </div>
          </a>
        </div>
        <!-- 第四組 -->
        <div class="music-group">
          <a class="music-item d-flex align-items-center" href="#">
            <img src="../img/music/tuki-愛の賞味期限.jpg" alt="音樂封面">
            <div class="info">
              <div class="title">愛の賞味期限</div>
              <div class="artist">tuki</div>
            </div>
          </a>
          <a class="music-item d-flex align-items-center" href="#">
            <img src="../img/music/RADWIMPS-前前前世.jpg" alt="音樂封面">
            <div class="info">
              <div class="title">前前前世</div>
              <div class="artist">RADWIMPS</div>
            </div>
          </a>
          <a class="music-item d-flex align-items-center" href="#">
            <img src="../img/music/米津玄師-Lemon.jpg" alt="音樂封面">
            <div class="info">
              <div class="title">Lemon</div>
              <div class="artist">米津玄師</div>
            </div>
          </a>
        </div>
        <!-- 儲存下次可繼續增加 -->
        <!-- <div class="music-group">
        <a class="music-item d-flex align-items-center" href="#">
          <img src="圖片連結" alt="音樂封面">
          <div class="info">
            <div class="title">歌名</div>
            <div class="artist">歌手</div>
          </div>
        </a>
      </div> -->
        <!-- =========== -->
      </div>
      <button class="scroll-btn right" onclick="scrollMusicList(1)">&#10095;</button>
    </div>
  </div>
  <!-- 熱播歌曲結束 -->

  <!-- 更多歌曲 -->
  <div class="container">
    <h1>更多歌曲</h1>
    <div class="grid-container">
      <!-- 第一首歌 -->
      <a href="./歌曲/晚餐歌.html" class="cards">
        <div style="overflow: hidden;"><img src="../img/music/tuki-晚餐歌.jpg" alt="Cover"></div>
        <div class="info">
          <div class="title">晚餐歌</div>
          <div class="artist">tuki</div>
        </div>
      </a>
      <!-- 第二首歌 -->
      <a class="cards">
        <div style="overflow: hidden;"><img src="../img/music/tuki-愛の賞味期限.jpg" alt="Cover"></div>
        <div class="info">
          <div class="title">愛の賞味期限</div>
          <div class="artist">tuki</div>
        </div>
      </a>
      <a class="cards">
        <div style="overflow: hidden;"><img src="../img/music/Creepy Nuts-Bling-Bang-Bang-Born.jpg" alt="Cover"></div>
        <div class="info">
          <div class="title">Bling-Bang-Bang-Born</div>
          <div class="artist">Creepy Nuts</div>
        </div>
      </a>
      <a class="cards">
        <div style="overflow: hidden;"><img src="../img/music/RADWIMPS-前前前世.jpg" alt="Cover"></div>
        <div class="info">
          <div class="title">前前前世</div>
          <div class="artist">RADWIMPS</div>
        </div>
      </a>
      <a class="cards">
        <div style="overflow: hidden;"><img src="../img/music/Yoasobi-Idol.png" alt="Cover"></div>
        <div class="info">
          <div class="title">Idol</div>
          <div class="artist">Yoasobi</div>
        </div>
      </a>
      <a class="cards">
        <div style="overflow: hidden;"><img src="../img/music/米津玄師-Lemon.jpg" alt="Cover"></div>
        <div class="info">
          <div class="title">Lemon</div>
          <div class="artist">米津玄師</div>
        </div>
      </a>
      <a class="cards" href="./歌曲/Pretender.html">
        <div style="overflow: hidden;background-color: #555; "><img src="../img/music/Official髭男dism-Pretender.jpg"
            alt="Cover"></div>
        <div class="info">
          <div class="title">Pretender</div>
          <div class="artist">Official髭男dism</div>
        </div>
      </a>
      <a href="./歌曲/怪物.html" class="cards">
        <div style="overflow: hidden;"><img src="../img/music/Yoasobi-怪物.jpg" alt="Cover"></div>
        <div class="info">
          <div class="title">怪物</div>
          <div class="artist">Yoasobi</div>
        </div>
      </a>
      <a class="cards">
        <div style="overflow: hidden;"><img src="../img/music/米津玄師-灰色と青.jpg" alt="Cover"></div>
        <div class="info">
          <div class="title">灰色と青</div>
          <div class="artist">米津玄師</div>
        </div>
      </a>
      <a class="cards">
        <div style="overflow: hidden;"><img src="../img/music/Kocchi no Kento-はいよろこんで.jpg" alt="Cover"></div>
        <div class="info">
          <div class="title">はいよろこんで</div>
          <div class="artist">Kocchi no Kento</div>
        </div>
      </a>

      <!-- ...可以一直新增卡片... -->
      <!-- <a class="card">
      <img src="圖片連結" alt="Cover">
      <div class="info">
        <div class="title">歌名</div>
        <div class="artist">歌手</div>
      </div>
    </a> -->

    </div>
  </div>


  <!-- 頁尾 -->
  <footer class="footer">
    <div class="footer-top">
      <div class="footer-left">
        <button class="like-btn">
          <i class="fa-solid fa-thumbs-up"></i> 4.8
        </button>
      </div>
      <ul class="footer-links">
        <li><a href="#">首頁</a></li>
        <li><a href="#">訊息公告</a></li>
        <li><a href="#">會員問題</a></li>
        <li><a href="#">錯誤回報</a></li>
        <li><a href="#">舉報歌曲</a></li>
        <li><a href="#">隱私條款聲明</a></li>
        <li><a href="#">支援本站</a></li>
      </ul>
      <div class="footer-right">
        <img src="../img/icon/logo.png" alt="Positive" class="positive-icon">
      </div>
    </div>
    <div class="footer-middle">
      <a href="#" class="scroll-top-btn">
        <i class="fa-solid fa-angle-up"></i>
      </a>
    </div>
    <div class="footer-bottom">
      © 2025 ChInPen All Rights Reserved.
    </div>
  </footer>
  <!-- 頁尾結束 -->
</body>



<script>
  // 熱播歌曲按鈕
  function scrollMusicList(direction) {
    const scroller = document.querySelector('.music-scroller');
    const scrollAmount = 300;
    scroller.scrollTo({
      left: scroller.scrollLeft + direction * scrollAmount,
      behavior: 'smooth'
    });
  }


  // w3 schoole-----------------------------
  var modal1 = document.getElementById("myModal1");
  var btn = document.getElementById("myBtn");
  btn.onclick = function() {
    modal1.style.display = "block";
  }

  // 複製---------------------------
  var modal2 = document.getElementById('myModal2')
  var btn2 = document.getElementById("myBtn2");

  btn2.onclick = function() {
    modal2.style.display = "block";
  }

  window.onclick = function(event) {
    if (event.target == modal1) {
      modal1.style.display = "none";
    } else if (event.target == modal2) {
      modal2.style.display = "none";
    }
    if (event.target == modal){
      modal.style.display = "none"
    }
  }
  // w3結束------------------
  // 打亂更多歌曲
  document.addEventListener("DOMContentLoaded", function() {
    const container = document.querySelector('.grid-container');
    const cards = Array.from(container.children);
    for (let i = cards.length - 1; i > 0; i--) {
      const j = Math.floor(Math.random() * (i + 1));
      [cards[i], cards[j]] = [cards[j], cards[i]];
    }
    cards.forEach(card => container.appendChild(card));
  });
  // 打亂結束
</script>

</html>