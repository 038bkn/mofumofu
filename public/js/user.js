// ===== ブラウザバック対策：ページ表示時に認証チェック =====

async function checkAuthOnPageShow() {
    try {
        const response = await fetch('/api/auth/check', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            // キャッシュを使わず必ずサーバーに問い合わせる
            cache: 'no-store',
        });

        if (response.status === 401 || response.status === 403) {
            // 未認証ならlocalStorageをクリアしてログイン画面へ（履歴を置き換えてバックできなくする）
            localStorage.clear();
            location.replace('/login');
        }
    } catch (error) {
        console.error('認証チェックエラー:', error);
    }
}

// pageshow はキャッシュから復元された場合（bfcache）にも発火する
window.addEventListener('pageshow', function (event) {
    // 画面が「戻る」で表示されたら【必ず毎回】即座に認証チェックを行います
    checkAuthOnPageShow();
});

// ===== アイコン =====

function handleIconUpload(event) {
    const file = event.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function (e) {
        const dataUrl = e.target.result;

        const img = document.getElementById("iconImage");
        const placeholder = document.getElementById("iconPlaceholder");
        if (img && placeholder) {
            img.src = dataUrl;
            img.style.display = "block";
            placeholder.style.display = "none";
        }

        localStorage.setItem("userIcon", dataUrl);
    };
    reader.readAsDataURL(file);
}

// ===== ユーザー名 =====

function toggleNameEdit() {
    const area = document.getElementById("nameEditArea");
    const input = document.getElementById("nameInput");
    const current = document.getElementById("usernameDisplay").textContent;

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
        showToast('ユーザー名を入力してください', 'error');
        return;
    }

    localStorage.setItem("username", name);
    document.getElementById("usernameDisplay").textContent = name;
    document.getElementById("nameEditArea").style.display = "none";
}

// ===== ログアウトモーダル =====

function showLogoutModal() {
    document.getElementById("logoutModal").style.display = "flex";
}

function hideLogoutModal() {
    document.getElementById("logoutModal").style.display = "none";
}

// ★ 処理がスッキリと一本化され、確実に挙動するよう修正しました
async function executeLogout() {
    try {
        const response = await fetch('/logout', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });

        // 成功、またはセッション切れ（401）の場合
        if (response.ok || response.status === 401) {
            alert('ログアウトしました');
            // フロントのキャッシュ情報も完全に破棄する
            localStorage.clear();
            // replace() で履歴を上書きし、戻るボタンでログイン前のページに戻れなくする
            location.replace('/login');
        } else {
            alert('ログアウト処理に失敗しました');
        }

    } catch (error) {
        console.error('ログアウトエラー:', error);
    }
}

// ===== 初期ロード =====

window.addEventListener("DOMContentLoaded", function () {
    // ページ初回ロード時にも認証チェック
    checkAuthOnPageShow();

    // アイコン復元
    const savedIcon = localStorage.getItem("userIcon");
    if (savedIcon) {
        const img = document.getElementById("iconImage");
        const placeholder = document.getElementById("iconPlaceholder");
        if (img && placeholder) {
            img.src = savedIcon;
            img.style.display = "block";
            placeholder.style.display = "none";
        }
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