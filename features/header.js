// 彈跳視窗
const modal1 = document.getElementById("myModal1");
const btn = document.getElementById("myBtn");
if (btn && modal1) {
  btn.onclick = () => modal1.style.display = "block";
}

const modal2 = document.getElementById("myModal2");
const btn2 = document.getElementById("myBtn2");
if (btn2 && modal2) {
  btn2.onclick = () => modal2.style.display = "block";
}

window.onclick = function (event) {
  if (event.target === modal1) modal1.style.display = "none";
  if (event.target === modal2) modal2.style.display = "none";
  if (event.target === document.getElementById("customBackdrop")) {
    document.getElementById("customBackdrop").classList.remove("active");
    document.getElementById("customModal").classList.remove("active");
  }
};
// 登入彈窗
const openModalBtn = document.getElementById('openModalBtn');
const customBackdrop = document.getElementById('customBackdrop');
const customModal = document.getElementById('customModal');
const closeModalBtn = document.getElementById('closeModalBtn');

const loginForm = document.getElementById('loginForm');
const registerForm = document.getElementById('registerForm');
const showRegister = document.getElementById('showRegister');
const showLogin = document.getElementById('showLogin');

openModalBtn?.addEventListener('click', () => {
  customBackdrop.classList.add('active');
  customModal.classList.add('active');
  loginForm.style.display = 'block';
  registerForm.style.display = 'none';
});

closeModalBtn?.addEventListener('click', () => {
  customBackdrop.classList.remove('active');
  customModal.classList.remove('active');
});

showRegister?.addEventListener('click', (e) => {
  e.preventDefault();
  loginForm.style.display = 'none';
  registerForm.style.display = 'block';
});

showLogin?.addEventListener('click', (e) => {
  e.preventDefault();
  loginForm.style.display = 'block';
  registerForm.style.display = 'none';
});

function verify(event) {
  event.preventDefault();
  const Username = document.getElementById("Username").value.trim();
  const UserEmail = document.getElementById("UserEmail").value.trim();
  const registerPassword = document.getElementById("registerPassword").value;
  const registerConfirmPassword = document.getElementById("registerConfirmPassword").value;
  const errDiv = document.getElementById("registerError");

  if (!Username || !UserEmail || !registerPassword || !registerConfirmPassword) {
    errDiv.textContent = "請完整填寫註冊資料！";
    errDiv.style.display = "block";
    return;
  }
  if (registerPassword !== registerConfirmPassword) {
    errDiv.textContent = "密碼不一致！";
    errDiv.style.display = "block";
    return;
  }
  fetch("php/register.php", {
    method: "POST",
    credentials: "include",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: `username=${encodeURIComponent(Username)}&email=${encodeURIComponent(UserEmail)}&password=${encodeURIComponent(registerPassword)}&confirm_password=${encodeURIComponent(registerConfirmPassword)}`
  })
    .then(res => res.json())
    .then(data => {
      if (!data.success) {
        errDiv.textContent = data.error;
        errDiv.style.display = "block";
      } else {
        alert("註冊成功！已自動登入");
        location.reload();
      }
    })
    .catch(err => {
      console.error(err);
      errDiv.textContent = "伺服器錯誤，請稍後再試";
      errDiv.style.display = "block";
    });
}

function handleLogin(event) {
  event.preventDefault();

  const email = document.getElementById("loginUsername").value.trim();
  const password = document.getElementById("loginPassword").value.trim();
  const openModalBtn = document.getElementById("openModalBtn")
  const outModalBtn = document.getElementById("outModalBtn")
  const customBackdrop = document.getElementById("customBackdrop")
  if (!email || !password) {
    alert("請輸入帳號與密碼！");
    return;
  }

  fetch("php/login.php", {
    method: "POST",
    credentials: "include",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ email, password })
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert("登入成功！");
        openModalBtn.style.display = "none"
        outModalBtn.style.display = "block"
        customBackdrop.classList.remove('active');
      } else {
        alert(data.message || "登入失敗");
      }
    })
    .catch(err => {
      console.error("登入錯誤：", err);
      alert("伺服器錯誤，請稍後再試");
    });
}
// 登出
const outModalBtn = document.getElementById("outModalBtn")
outModalBtn.addEventListener("click", function (event) {
  event.preventDefault();
  fetch("php/logout.php", {
    method: "POST",
    credentials: "include"
  })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert("登出成功！");
        location.reload();
      } else {
        alert("登出失敗：" + data.message);
      }
    })
    .catch(error => {
      console.error("登出錯誤：", error);
      alert("伺服器錯誤，請稍後再試");
    });

})
fetch("php/check_login.php", {
  method: "GET",
  credentials: "include"
})
  .then(response => response.json())
  .then(data => {
    if (data.loggedIn) {
      console.log("使用者已登入:", data.user);
      openModalBtn.style.display = "none"
      outModalBtn.style.display = "block"
    } else {
      console.log("使用者未登入");
    }
  })
  .catch(error => console.error("檢查登入狀態錯誤：", error));

