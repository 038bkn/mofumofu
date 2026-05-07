let selectedMode = "sweet";

// モード切替
function selectMode(mode) {
    selectedMode = mode;

    const mode1 = document.getElementById("mode1");
    const mode2 = document.getElementById("mode2");

    if (mode === "sweet") {
        mode1.style.backgroundColor = "#f4a0a0";
        mode1.style.color = "#ffffff";
        mode1.setAttribute("aria-pressed", "true");

        mode2.style.backgroundColor = "#ffffff";
        mode2.style.color = "#333333";
        mode2.setAttribute("aria-pressed", "false");
    } else {
        mode2.style.backgroundColor = "#f4a0a0";
        mode2.style.color = "#ffffff";
        mode2.setAttribute("aria-pressed", "true");

        mode1.style.backgroundColor = "#ffffff";
        mode1.style.color = "#333333";
        mode1.setAttribute("aria-pressed", "false");
    }
}

// モード保存
function saveMode() {
    localStorage.setItem("mode", selectedMode);
    alert("モードを保存しました");
}

// フォントサイズをCSS変数に反映
function applyFontSize(size) {
    document.documentElement.style.setProperty("--font-size-base", size + "px");
}

// フォント保存
function saveFont() {
    const size = document.getElementById("fontSlider").value;
    localStorage.setItem("fontSize", size);
    applyFontSize(size);
    alert("フォントサイズを保存しました");
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
});