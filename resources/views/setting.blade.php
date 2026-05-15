<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>もふすけ - 設定</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --font-size-base: 16px;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family:'Hiragino Kaku Gothic ProN','Hiragino Sans','Noto Sans JP',sans-serif;
            background: #fde8e8;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: var(--font-size-base);
        }

        .phone-wrapper {
            width: 100%;
            max-width: 390px;
            min-height: 100vh;
            background-color: #fde8e8;
            display: flex;
            flex-direction: column;
            padding: 0 32px;
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

        /* ヘッダーラベル */
        .screen-label {
            font-size: 11px;
            color: #aaa;
            padding: 12px 0 0;
        }
        /* タイトル */
        .title-area {
            margin-top: 50px;
            margin-bottom: 40px;
            text-align: center;
        }

        .app-title {
            font-size: 36px;
            font-weight: 400;
            color: #333;
        }

        /* 設定 */
        .form-area {
            display: flex;
            flex-direction: column;
        }

        .setting-section {
            margin-bottom: 40px;
        }

        .field-label {
            font-size: var(--font-size-base);
            color: #333;
            margin-bottom: 18px;
        }

        .setting-row {
            display: flex;
            justify-content: flex-end;
        }

        /* ボタン */
        .change-btn {
            padding: 0.6em 1.5em;
            border: none;
            border-radius: 20px;
            background: #dcdcdc;
            font-size: var(--font-size-base);
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
            min-width: 6em;
            padding: 0.6em 1.2em;
            border: none;
            border-radius: 20px;
            background: #ffffff;
            color: #333333;
            font-size: var(--font-size-base);
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
            <label
                class="field-label"
                for="fontSlider"
                style="display:block;">
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
            <div class="setting-row" style="margin-top:16px;">
                <button
                    type="button"
                    class="change-btn"
                    onclick="saveFont()">

                    変更

                </button>
            </div>
        </div>

        <!-- エラーメッセージ -->
        <div id="errorMsg" class="hidden mt-4 bg-[#fff0f0] border border-[#f4a0a0] rounded-lg px-3.5 py-2.5 text-[13px] text-[#c0392b] leading-relaxed"></div>
    </div>
</div>

<!-- ナビゲーション -->
<nav class="w-full max-w-sm bg-white rounded-3xl shadow-inner border border-slate-200 px-5 py-4 mb-4">
    <div class="flex justify-between items-center text-slate-600">
        <button
            type="button"
            onclick="location.href='/hitorigoto'"
            class="flex flex-col items-center gap-1">
            <span class="text-2xl">💬</span>
            <span class="text-xs">ひとりごと</span>
        </button>
        <button
            type="button"
            onclick="location.href='/home'"
            class="flex flex-col items-center gap-1">
            <span class="text-2xl">🏠</span>
            <span class="text-xs">ホーム</span>
        </button>
        <button
            type="button"
            onclick="location.href='/todo'"
            class="flex flex-col items-center gap-1">
            <span class="text-2xl">📅</span>
            <span class="text-xs">ToDo</span>
        </button>
        <button
            type="button"
            onclick="location.href='/setting'"
            class="flex flex-col items-center gap-1 text-rose-400 font-semibold">
            <span class="text-2xl">⚙️</span>
            <span class="text-xs">設定</span>
        </button>
    </div>
</nav>

<script src="{{ asset('js/setting.js') }}"></script>

</body>
</html>