// ============================================================
// register.js  — 新規登録画面の処理
// 配置先: public/js/register.js
// ============================================================

document.addEventListener('DOMContentLoaded', function () {

    const registerBtn = document.getElementById('registerBtn');
    const errorMsg    = document.getElementById('errorMsg');

    // 登録ボタンクリック
    registerBtn.addEventListener('click', handleRegister);

    // Enterキーでも登録実行
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') handleRegister();
    });

    // ============================================================
    // 登録処理
    // ============================================================
    async function handleRegister() {
        const name     = document.getElementById('name').value.trim();
        const email    = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;

        // フロント側バリデーション
        if (!name) {
            showError('ユーザ名を入力してください。');
            return;
        }
        if (!email) {
            showError('メールアドレスを入力してください。');
            return;
        }
        if (!password) {
            showError('パスワードを入力してください。');
            return;
        }
        if (password.length < 8) {
            showError('パスワードは8文字以上で入力してください。');
            return;
        }

        setLoading(true);
        hideError();

        try {
            const response = await fetch('/api/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ name, email, password }),
            });

            const data = await response.json();

            if (response.ok && data.status === 'success') {
                // 登録成功 → ホーム画面へ
                window.location.href = '/home';
            } else {
                const msg = data.message || '登録に失敗しました。もう一度お試しください。';
                showError(msg);
            }

        } catch (e) {
            showError('通信エラーが発生しました。もう一度お試しください。');
        } finally {
            setLoading(false);
        }
    }

    // ============================================================
    // ユーティリティ
    // ============================================================

    function setLoading(isLoading) {
        registerBtn.disabled = isLoading;
        if (isLoading) {
            registerBtn.classList.add('loading');
        } else {
            registerBtn.classList.remove('loading');
        }
    }

    function showError(msg) {
        errorMsg.textContent = msg;
        errorMsg.classList.add('show');
    }

    function hideError() {
        errorMsg.classList.remove('show');
    }

    function getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.content : '';
    }

});