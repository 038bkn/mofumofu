// ============================================================
// login.js  — ログイン画面の処理
// 配置先: public/js/login.js
// ============================================================

// Laravelのバリデーションキー → 日本語メッセージ変換
const VALIDATION_MESSAGES = {
    'validation.email':    'メールアドレスの形式が正しくありません。',
    'validation.required': '入力してください。',
    'validation.min':      'パスワードは8文字以上で入力してください。',
    'validation.max':      '入力が長すぎます。',
    'validation.unique':   'すでに使用されています。',
};

function translateError(msg) {
    if (!msg) return 'メールアドレスまたはパスワードが正しくありません。';
    // キーが一致すれば日本語に変換、なければそのまま返す
    return VALIDATION_MESSAGES[msg] ?? msg;
}

// login.blade.php の onclick="handleLogin()" からグローバルで呼ばれる
async function handleLogin() {
    const email    = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;

    // フロント側バリデーション
    if (!email) {
        showError('メールアドレスまたはユーザー名を入力してください。');
        return;
    }
    if (!password) {
        showError('パスワードを入力してください。');
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
            window.location.href = '/home';
        } else {
            showError(translateError(data.message));
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
    const loginBtn = document.getElementById('loginBtn');
    loginBtn.disabled = isLoading;
    if (isLoading) {
        loginBtn.classList.add('loading');
    } else {
        loginBtn.classList.remove('loading');
    }
}

function showError(msg) {
    const errorMsg = document.getElementById('errorMsg');
    errorMsg.textContent = msg;
    errorMsg.classList.remove('hidden');
    errorMsg.classList.add('show');
}

function hideError() {
    const errorMsg = document.getElementById('errorMsg');
    errorMsg.classList.add('hidden');
    errorMsg.classList.remove('show');
}

function getCsrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.content : '';
}

// Enterキーでもログイン実行
document.addEventListener('DOMContentLoaded', function () {
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') handleLogin();
    });
});