// ===== アイコン =====

function handleIconUpload(event) {
    const file = event.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function (e) {
        const dataUrl = e.target.result;

        const img = document.getElementById("iconImage");
        const placeholder = document.getElementById("iconPlaceholder");
        img.src = dataUrl;
        img.style.display = "block";
        placeholder.style.display = "none";

        localStorage.setItem("userIcon", dataUrl);
    };
    reader.readAsDataURL(file);
}

// ===== ユーザー名 =====

function toggleNameEdit() {
    const area = document.getElementById("nameEditArea");
    const input = document.getElementById("nameInput");
    const current = document.getElementById("usernameDisplay").textContent;

    // ②styleで表示/非表示を切り替え（Tailwindのhidden問題を回避）
    if (area.style.display === "flex") {
        area.style.display = "none";
    } else {
        input.value = (current !== "読み込み中…" && current !== "未設定") ? current : "";
        area.style.display = "flex";
        input.focus();
    }
}

function saveName() {
    const input = document.getElementById("nameInput");
    const name = input.value.trim();

    if (!name) {
        alert("ユーザー名を入力してください");
        return;
    }

    localStorage.setItem("username", name);
    document.getElementById("usernameDisplay").textContent = name;
    document.getElementById("nameEditArea").style.display = "none";
}

// ===== ログアウトモーダル =====

function showLogoutModal() {
    // ③styleで表示（Tailwindのhidden問題を回避）
    document.getElementById("logoutModal").style.display = "flex";
}

function hideLogoutModal() {
    document.getElementById("logoutModal").style.display = "none";
}

function executeLogout() {
    const form = document.createElement("form");
    form.method = "POST";
    form.action = "/logout";

    const token = document.createElement("input");
    token.type = "hidden";
    token.name = "_token";
    token.value = document.querySelector('meta[name="csrf-token"]').content;

    form.appendChild(token);
    document.body.appendChild(form);
    form.submit();
}

// ===== 初期ロード =====

window.addEventListener("DOMContentLoaded", function () {

    // アイコン復元
    const savedIcon = localStorage.getItem("userIcon");
    if (savedIcon) {
        const img = document.getElementById("iconImage");
        const placeholder = document.getElementById("iconPlaceholder");
        img.src = savedIcon;
        img.style.display = "block";
        placeholder.style.display = "none";
    }

    // ユーザー名復元
    const savedName = localStorage.getItem("username");
    document.getElementById("usernameDisplay").textContent = savedName || "未設定";

    // メールアドレス復元
    const savedEmail = localStorage.getItem("email");
    document.getElementById("emailDisplay").textContent = savedEmail || "未設定";

    // フォントサイズ復元
    const savedFont = localStorage.getItem("fontSize");
    if (savedFont) {
        document.documentElement.style.fontSize = savedFont + "px";
    }
});