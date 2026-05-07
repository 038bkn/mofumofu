<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>なぐさめて画面</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500&display=swap');
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --nagusame-bg: #87cefa; /* 水色の背景 */
            --bubble-cream: #fef9e7;
            --text-dark: #5a4a4a;
        }
        body {
            font-family: 'Noto Sans JP', sans-serif;
            background: #f0f0f0;
            display: flex; justify-content: center; align-items: center; min-height: 100vh;
            overflow: hidden; /* 画面全体のスクロールを防ぐ */
        }

        /* --- レスポンシブ対応の枠 --- */
        .phone-frame {
            width: 100%;
            max-width: 450px; /* PCで見た時の最大幅 */
            height: 100vh;    /* 画面いっぱいの高さ */
            background: var(--nagusame-bg);
            display: flex;
            flex-direction: column;
            position: relative;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        /* スマホ実機用の設定（横幅が狭い時） */
        @media (max-width: 480px) {
            .phone-frame {
                max-width: 100%;
                box-shadow: none;
            }
        }

        /* 戻るボタン */
        .back-nav { padding: 15px; z-index: 10; }
        .back-link {
            display: inline-block;
            background: var(--bubble-cream);
            padding: 8px 16px;
            border-radius: 20px;
            text-decoration: none;
            color: var(--text-dark);
            font-size: 14px;
            font-weight: 500;
        }

        /* チャットエリア */
        .chat-area {
            flex: 1;
            overflow-y: auto;
            padding: 12px 16px;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }
        .message-row { display: flex; align-items: flex-end; gap: 8px; margin-bottom: 5px; }
        .message-row.user { flex-direction: row-reverse; }
        
        .bubble {
            max-width: 75%;
            padding: 12px 16px;
            border-radius: 20px;
            font-size: 14px;
            background: var(--bubble-cream);
            color: var(--text-dark);
            position: relative;
            word-wrap: break-word;
        }
        
        .avatar {
            width: 40px; height: 40px;
            background: white;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 10px; flex-shrink: 0;
        }

        /* キャラクター固定エリア */
        .mascot-container { text-align: center; padding: 10px 0; }
        .mascot-img { width: 100px; }

        /* 入力エリア */
        .input-area {
            background: #b0e0e6;
            padding: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .text-input {
            flex: 1;
            padding: 12px 15px;
            border-radius: 25px;
            border: none;
            outline: none;
            font-size: 16px;
        }
        .send-btn {
            background: white;
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
<div class="phone-frame">
    <div class="back-nav">
        <a href="/chat" class="back-link">ひとりごとに戻る</a>
    </div>

    <div class="chat-area" id="chatArea"></div>

    <div class="mascot-container">
        <svg class="mascot-img" viewBox="0 0 100 100">
            <ellipse cx="50" cy="62" rx="28" ry="22" fill="white"/>
            <ellipse cx="50" cy="52" rx="15" ry="13" fill="#fce8e6"/>
            <circle cx="45" cy="50" r="2" fill="#c8a0a0"/>
            <circle cx="55" cy="50" r="2" fill="#c8a0a0"/>
            <path d="M40,65 Q40,70 43,70 Q46,70 46,65 Q46,60 43,55 Q40,60 40,65" fill="#87cefa" opacity="0.7"/>
            <text x="30" y="95" font-size="8" fill="white">nagusamete</text>
        </svg>
    </div>

    <div class="input-area">
        <input type="text" id="messageInput" class="text-input" placeholder="テキスト入力">
        <button class="send-btn" id="sendBtn">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="#5a4a4a" stroke-width="2">
                <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
            </svg>
        </button>
    </div>
</div>

<script src="{{ asset('js/nagusame_screen.js') }}"></script>
</body>
</html>