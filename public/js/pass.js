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

async function saveChanges() {
    hideError();

    const email       = document.getElementById("emailInput").value.trim();
    const newPass     = document.getElementById("newPassword").value;
    const confirmPass = document.getElementById("confirmPassword").value;

    // フロントエンドバリデーション
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

    try {
        const response = await fetch('/api/user/credentials', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({
                email:                 email,
                password:              newPass,
                password_confirmation: confirmPass,
            }),
        });

        const data = await response.json();

        if (response.ok && data.status === 'success') {
            localStorage.setItem('email', email);
            location.href = '/user';
            return;
        }

        // バリデーションエラー (422)
        if (response.status === 422 && data.errors) {
            const errors = data.errors;
            if (errors.email) {
                showError(errors.email[0]);
            } else if (errors.password) {
                showError(errors.password[0]);
            } else {
                showError('入力内容を確認してください。');
            }
            return;
        }

        showError('保存に失敗しました。もう一度お試しください。');

    } catch (err) {
        console.error(err);
        showError('通信エラーが発生しました。もう一度お試しください。');
    }
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
