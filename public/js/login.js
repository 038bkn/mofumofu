// ============================================================
// login.js  — ログイン画面の処理
// 配置先: public/js/login.js
// ============================================================

document.addEventListener('DOMContentLoaded', function () {

    const loginBtn = document.getElementById('loginBtn');
    const errorMsg = document.getElementById('errorMsg');

    // ログインボタンクリック
    loginBtn.addEventListener('click', handleLogin);

    // Enterキーでもログイン実行
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') handleLogin();
    });

    // ============================================================
    // ログイン処理
    // ============================================================
    async function handleLogin() {
        const email    = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;

        // フロント側バリデーション
        if (!email || !password) {
            showError('メールアドレスとパスワードを入力してください。');
            return;
        }

        setLoading(true);
        hideError();

        try {
            const response = await fetch('/api/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ email, password }),
            });

            const data = await response.json();

            if (response.ok && data.status === 'success') {
                // ログイン成功 → ホーム画面へ遷移
                window.location.href = '/home';
            } else {
                const msg = data.message || 'メールアドレスまたはパスワードが正しくありません。';
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

    /** ローディング状態の切り替え */
    function setLoading(isLoading) {
        loginBtn.disabled = isLoading;
        if (isLoading) {
            loginBtn.classList.add('loading');
        } else {
            loginBtn.classList.remove('loading');
        }
    }

    /** エラーメッセージを表示 */
    function showError(msg) {
        errorMsg.textContent = msg;
        errorMsg.classList.add('show');
    }

    /** エラーメッセージを非表示 */
    function hideError() {
        errorMsg.classList.remove('show');
    }

    /** CSRFトークンをmetaタグから取得 */
    function getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.content : '';
    }

});