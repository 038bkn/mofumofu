// ============================================================
// forgot_password.js — パスワード再設定画面の処理
// 配置先: public/js/forgot_password.js
// ============================================================

document.addEventListener('DOMContentLoaded', function () {

    const submitBtn  = document.getElementById('submitBtn');
    const errorMsg   = document.getElementById('errorMsg');
    const popup      = document.getElementById('popup');
    const popupClose = document.getElementById('popupClose');
    const popupOverlay = document.getElementById('popupOverlay');

    // 送信ボタンクリック
    submitBtn.addEventListener('click', handleSubmit);

    // Enterキーでも送信
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') handleSubmit();
    });

    // ポップアップを閉じる（バツ印）
    popupClose.addEventListener('click', closePopup);

    // ポップアップを閉じる（背景クリック）
    popupOverlay.addEventListener('click', closePopup);

    // ============================================================
    // 送信処理
    // ============================================================
    async function handleSubmit() {
        const email = document.getElementById('email').value.trim();

        // フロント側バリデーション
        if (!email) {
            showError('メールアドレスを入力してください。');
            return;
        }

        setLoading(true);
        hideError();

        try {
            const response = await fetch('/api/forgot-password', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ email }),
            });

            const data = await response.json();

            if (response.ok && data.status === 'success') {
                // 送信成功 → ポップアップ表示
                openPopup();
            } else {
                const msg = data.message || 'メールの送信に失敗しました。もう一度お試しください。';
                showError(msg);
            }

        } catch (e) {
            showError('通信エラーが発生しました。もう一度お試しください。');
        } finally {
            setLoading(false);
        }
    }

    // ============================================================
    // ポップアップ
    // ============================================================
    function openPopup() {
        popup.classList.remove('hidden');
    }

    function closePopup() {
        popup.classList.add('hidden');
        // 閉じたらログイン画面へ戻る
        window.location.href = '/login';
    }

    // ============================================================
    // ユーティリティ
    // ============================================================
    function setLoading(isLoading) {
        submitBtn.disabled = isLoading;
        if (isLoading) {
            submitBtn.classList.add('loading');
        } else {
            submitBtn.classList.remove('loading');
        }
    }

    function showError(msg) {
        errorMsg.textContent = msg;
        errorMsg.classList.remove('hidden');
    }

    function hideError() {
        errorMsg.classList.add('hidden');
    }

    function getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.content : '';
    }

});