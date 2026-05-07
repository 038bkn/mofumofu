<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width,
                   initial-scale=1.0">

    <title>設定</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family:
                'Hiragino Kaku Gothic ProN',
                'Hiragino Sans',
                'Noto Sans JP',
                sans-serif;

            background: #fde8e8;

            min-height: 100vh;

            display: flex;
            justify-content: center;
        }

        .phone-wrapper {
            width: 100%;
            max-width: 390px;

            min-height: 100vh;

            background: #fde8e8;

            padding: 0 28px;
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
            font-size: 18px;

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

            font-size: 15px;

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

            font-size: 15px;

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

    <!-- 戻る -->

    <div class="back-area">

        <button
            type="button"
            class="back-btn"
            onclick="history.back()">

            ←

        </button>

    </div>

    <!-- タイトル -->

    <div class="title-area">

        <h1 class="app-title">

            設定

        </h1>

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
                    onclick="location.href='/profile'">

                    変更

                </button>

            </div>

        </div>

        <!-- モード -->

        <div class="setting-section">

            <div class="field-label">

                モード選択

            </div>

            <div class="mode-buttons">

                <button
                    type="button"
                    id="mode1"
                    class="mode-btn"
                    onclick="selectMode('sweet')">

                    あまあま

                </button>

                <button
                    type="button"
                    id="mode2"
                    class="mode-btn"
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

            <div class="field-label">

                フォントサイズ変更

            </div>

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
