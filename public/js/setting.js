let selectedMode = "sweet";

// モード切替
function selectMode(mode) {
    selectedMode = mode;

    const mode1 = document.getElementById("mode1");
    const mode2 = document.getElementById("mode2");

    if (mode === "sweet") {
        mode1.classList.add("bg-rose-300", "text-white");
        mode1.classList.remove("bg-white", "text-slate-700");
        mode1.setAttribute("aria-pressed", "true");

        mode2.classList.add("bg-white", "text-slate-700");
        mode2.classList.remove("bg-rose-300", "text-white");
        mode2.setAttribute("aria-pressed", "false");
    } else {
        mode2.classList.add("bg-rose-300", "text-white");
        mode2.classList.remove("bg-white", "text-slate-700");
        mode2.setAttribute("aria-pressed", "true");

        mode1.classList.add("bg-white", "text-slate-700");
        mode1.classList.remove("bg-rose-300", "text-white");
        mode1.setAttribute("aria-pressed", "false");
    }
}

// モード保存
function saveMode() {
    fetch("/api/user/mode", {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({ mode: selectedMode }),
    })
        .then(response => {
            if (!response.ok) {
                throw new Error("ネットワークエラー");
            }
            return response.json();
        })
        .then(data => {
            if (data.status === "success") {
                localStorage.setItem("mode", selectedMode);
                hideError();
            } else {
                showError("設定の保存に失敗しました。もう一度お試しください。");
            }
        })
        .catch(error => {
            console.error("Error:", error);
            showError("設定の保存に失敗しました。もう一度お試しください。");
        });
}

// フォントサイズをCSS変数に反映
function applyFontSize(size) {
    document.documentElement.style.setProperty("--font-size-base", size + "px");
    document.documentElement.style.fontSize = size + "px";
}

// フォント保存
function saveFont() {
    try {
        const size = document.getElementById("fontSlider").value;
        localStorage.setItem("fontSize", size);
        applyFontSize(size);
        hideError();
    } catch (e) {
        showError("フォントサイズの保存に失敗しました。もう一度お試しください。");
    }
}

// エラー表示・非表示
function showError(msg) {
    const errorMsg = document.getElementById("errorMsg");
    errorMsg.textContent = msg;
    errorMsg.classList.remove("hidden");
}

function hideError() {
    const errorMsg = document.getElementById("errorMsg");
    errorMsg.classList.add("hidden");
}

// 初期ロード
window.addEventListener("DOMContentLoaded", function () {
    // モード
    const savedMode = localStorage.getItem("mode");
    if (savedMode) {
        selectedMode = savedMode;
        selectMode(savedMode);
    } else {
        selectMode("sweet");
    }

    // フォント
    const savedFont = localStorage.getItem("fontSize");
    if (savedFont) {
        document.getElementById("fontSlider").value = savedFont;
        applyFontSize(savedFont);
    }

    hideError();
});