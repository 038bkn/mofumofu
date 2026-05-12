function showError(message) {
    const el = document.getElementById("errorMsg");
    el.textContent = message;
    el.style.display = "block";
}

function hideError() {
    const el = document.getElementById("errorMsg");
    el.textContent = "";
    el.style.display = "none";
}

function saveChanges() {
    hideError();

    const email       = document.getElementById("emailInput").value.trim();
    const newPass     = document.getElementById("newPassword").value;
    const confirmPass = document.getElementById("confirmPassword").value;

    // バリデーション
    if (!email) {
        showError("メールアドレスを入力してください");
        return;
    }

    if (!newPass) {
        showError("パスワードを入力してください");
        return;
    }

    if (newPass.length < 6) {
        showError("パスワードは6文字以上で入力してください");
        return;
    }

    if (newPass !== confirmPass) {
        showError("パスワードが一致しません");
        return;
    }

    // Laravelへ送信
    const form = document.createElement("form");
    form.method = "POST";
    form.action = "/pass/update";

    const fields = {
        "_token":                    document.querySelector('meta[name="csrf-token"]').content,
        "email":                     email,
        "new_password":              newPass,
        "new_password_confirmation": confirmPass,
    };

    Object.entries(fields).forEach(([name, value]) => {
        const input = document.createElement("input");
        input.type  = "hidden";
        input.name  = name;
        input.value = value;
        form.appendChild(input);
    });

    document.body.appendChild(form);
    form.submit();
}

// 初期ロード
window.addEventListener("DOMContentLoaded", function () {
    // メールアドレスをlocalStorageから復元
    const savedEmail = localStorage.getItem("email");
    if (savedEmail) {
        document.getElementById("emailInput").value = savedEmail;
    }

    // フォントサイズ復元
    const savedFont = localStorage.getItem("fontSize");
    if (savedFont) {
        document.documentElement.style.fontSize = savedFont + "px";
    }
});
