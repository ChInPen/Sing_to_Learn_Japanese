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
  const Username = document.getElementById("Username");
  const UserEmail = document.getElementById("UserEmail");
  const registerPassword = document.getElementById("registerPassword");
  const registerConfirmPassword = document.getElementById("registerConfirmPassword");
  const name = Username.value.trim();
  const email = UserEmail.value.trim();
  const password = registerPassword.value.trim();
  const password2 = registerConfirmPassword.value.trim();

  if (!name || !email || !password || !password2) {
    alert("請完整填寫註冊資料！");
    return;
  }
  if (password !== password2) {
    alert("密碼不一致!");
    return;
  }

  fetch("php/register.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: `username=${encodeURIComponent(name)}&email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
  })
    .then(response => response.text())
    .then(data => {
      alert("註冊成功");
      document.getElementById('registerForm').style.display = 'none';
      document.getElementById('loginForm').style.display = 'block';
    })
    .catch(error => console.error("發生錯誤:", error));
}
