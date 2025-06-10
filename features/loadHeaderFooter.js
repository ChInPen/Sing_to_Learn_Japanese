function loadHTML(id, file) {
  return fetch(file)
    .then(res => {
      if (!res.ok) throw new Error(`載入 ${file} 失敗`);
      return res.text();
    })
    .then(html => {
      document.getElementById(id).innerHTML = html;
    });
}
document.addEventListener("DOMContentLoaded", () => {
  // 載入 header，然後載入 header.js（包含事件綁定）
  loadHTML("header-placeholder", "features/header.html")
    .then(() => {
      const script = document.createElement("script");
      script.src = "features/header.js";
      script.defer = true; // 可加強穩定性
      document.body.appendChild(script);
    })
    .catch(err => console.error("Header 載入失敗:", err));

  // 載入 footer（不需要附加 script）
  loadHTML("footer-placeholder", "features/footer.html")
    .catch(err => console.error("Footer 載入失敗:", err));
});
