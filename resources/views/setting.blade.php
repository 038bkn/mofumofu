<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>もふすけ - 設定</title>
    <style>
        /* ①CSS変数でフォントサイズを管理 */
        :root {
            --font-size-base: 16px;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }
        body {
            font-family:'Hiragino Kaku Gothic ProN','Hiragino Sans','Noto Sans JP',sans-serif;
            background: #fde8e8;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            /* ②bodyのフォントサイズをCSS変数に連動 */
            font-size: var(--font-size-base);
        }
        .phone-wrapper {
            width: 100%;
            max-width: 390px;
            min-height: 100vh;
            background: #fde8e8;
            display: flex;
            flex-direction: column;
            padding: 0 32px;
        }
        /* ヘッダーラベル */
        .screen-label {
            font-size: 11px;
            color: #aaa;
            padding: 12px 0 0;
        }
        /* 戻る */
        .back-area {
            margin-top: 20px;
        }
        .back-btn {
            width: 44px;
            height: 44px;
            border: none;
            border-radius: 50%;
            background: #f2f2f2;
            font-size: 20px;
            cursor: pointer;
        }
        /* タイトル */
        .title-area {
            margin-top: 72px;
            margin-bottom: 52px;
            text-align: center;
        }
        .app-title {
            font-size: 42px;
            font-weight: 400;
            color: #3a3a3a;
            letter-spacing: 0.05em;
        }
        /* 設定 */
        .form-area {
            display: flex;
            flex-direction: column;
            gap: 0;
        }
        .setting-section {
            margin-bottom: 40px;
        }
        .field-label {
            /* ③pxではなくremで指定してCSS変数の影響を受けるように */
            font-size: 1.125rem;
            color: #333;
            margin-bottom: 18px;
        }
        .setting-row {
            display: flex;
            justify-content: flex-end;
        }
        /* ボタン */
        .change-btn {
            width: 90px;
            height: 38px;
            border: none;
            border-radius: 20px;
            background: #dcdcdc;
            font-size: 0.9375rem;
            cursor: pointer;
        }
        /* モード */
        .mode-buttons {
            display: flex;
            justify-content: center;
            gap: 14px;
            margin-bottom: 16px;
        }
        .mode-btn {
            min-width: 110px;
            padding: 10px 18px;
            border: none;
            border-radius: 20px;
            background: #ffffff;
            color: #333333;
            font-size: 0.9375rem;
            cursor: pointer;
            transition: 0.2s;
        }
        /* フォント */
        .font-labels {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .font-slider {
            width: 100%;
        }
    </style>
</head>
<body>
<div class="phone-wrapper">
    <div class="screen-label">設定</div>
    <!-- 戻る -->
    <div class="back-area">
        <button
            type="button"
            class="back-btn"
            onclick="history.back()">
            ←
        </button>
    </div>
    <div class="form-area">
        <!-- プロフィール -->
        <div class="setting-section">
            <div class="field-label">
                メインプロフィール
            </div>
            <div class="setting-row">
                <button
                    type="button"
                    class="change-btn"
                    onclick="location.href='/user'">
                    変更
                </button>
            </div>
        </div>
        <!-- モード -->
        <div class="setting-section">
            <div class="field-label">
                モード選択
            </div>
            <!-- ①aria-pressedでスクリーンリーダーに選択状態を伝える -->
            <div
                class="mode-buttons"
                role="group"
                aria-label="モード選択">
                <button
                    type="button"
                    id="mode1"
                    class="mode-btn"
                    aria-pressed="true"
                    onclick="selectMode('sweet')">
                    あまあま
                </button>
                <button
                    type="button"
                    id="mode2"
                    class="mode-btn"
                    aria-pressed="false"
                    onclick="selectMode('strict')">
                    飴と鞭
                </button>
            </div>
            <div class="setting-row">
                <button
                    type="button"
                    class="change-btn"
                    onclick="saveMode()">
                    変更
                </button>
            </div>
        </div>
        <!-- フォント -->
        <div class="setting-section">
            <!-- ③forとidを対応させてlabelとinputを関連付け -->
            <label
                class="field-label"
                for="fontSlider">
                フォントサイズ変更
            </label>
            <div class="font-labels">
                <span>小</span>
                <span>大</span>
            </div>
            <input
                type="range"
                min="12"
                max="24"
                value="16"
                id="fontSlider"
                class="font-slider"
                aria-label="フォントサイズ"
            >
            <div class="setting-row">
                <button
                    type="button"
                    class="change-btn"
                    onclick="saveFont()">
                    変更
                </button>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/setting.js') }}"></script>
</body>
</html>