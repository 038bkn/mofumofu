// ===== アイコン =====

function handleIconUpload(event) {
    const file = event.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function (e) {
        const dataUrl = e.target.result;

        // 画像を表示
        const img = document.getElementById("iconImage");
        const placeholder = document.getElementById("iconPlaceholder");
        img.src = dataUrl;
        img.style.display = "block";
        placeholder.style.display = "none";

        // localStorageに保存
        localStorage.setItem("userIcon", dataUrl);
    };
    reader.readAsDataURL(file);
}

// ===== ユーザー名 =====

function toggleNameEdit() {
    const area = document.getElementById("nameEditArea");
    const input = document.getElementById("nameInput");
    const current = document.getElementById("usernameDisplay").textContent;

    if (area.classList.contains("visible")) {
        area.classList.remove("visible");
    } else {
        input.value = current !== "読み込み中…" ? current : "";
        area.classList.add("visible");
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
    document.getElementById("nameEditArea").classList.remove("visible");
}

// ===== ログアウトモーダル =====

function showLogoutModal() {
    document.getElementById("logoutModal").classList.add("visible");
}

function hideLogoutModal() {
    document.getElementById("logoutModal").classList.remove("visible");
}

function executeLogout() {
    // Laravelのログアウト処理
    const form = document.createElement("form");
    form.method = "POST";
    form.action = "/logout";

    const token = document.createElement("input");
    token.type = "hidden";
    token.name = "_token";
    token.value = document.querySelector('meta[name="csrf-token"]')
        ? document.querySelector('meta[name="csrf-token"]').content
        : "";

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
    if (savedName) {
        document.getElementById("usernameDisplay").textContent = savedName;
    } else {
        document.getElementById("usernameDisplay").textContent = "未設定";
    }

    // メールアドレス復元（表示のみ）
    const savedEmail = localStorage.getItem("email");
    if (savedEmail) {
        document.getElementById("emailDisplay").textContent = savedEmail;
    } else {
        document.getElementById("emailDisplay").textContent = "未設定";
    }

    // フォントサイズ復元
    const savedFont = localStorage.getItem("fontSize");
    if (savedFont) {
        document.documentElement.style.fontSize = savedFont + "px";
    }
});