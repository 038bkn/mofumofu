<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        }
        .phone-frame {
            width: 360px; height: 700px;
            background: var(--nagusame-bg);
            border-radius: 24px; overflow: hidden;
            display: flex; flex-direction: column;
            position: relative;
        }
        /* 戻るボタン */
        .back-nav { padding: 20px; }
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
            flex: 1; overflow-y: auto;
            padding: 12px 16px;
            display: flex; flex-direction: column; gap: 14px;
        }
        .message-row { display: flex; align-items: flex-end; gap: 8px; margin-bottom: 10px; }
        .message-row.user { flex-direction: row-reverse; }
        .bubble {
            max-width: 70%; padding: 12px 16px;
            border-radius: 25px; font-size: 13px;
            background: var(--bubble-cream);
            color: var(--text-dark);
            position: relative;
        }
        /* 吹き出しのしっぽ */
        .message-row.user .bubble::after {
            content: ""; position: absolute; right: -8px; bottom: 10px;
            border-left: 12px solid var(--bubble-cream);
            border-top: 8px solid transparent; border-bottom: 8px solid transparent;
        }
        .message-row.bot .bubble::after {
            content: ""; position: absolute; left: -8px; bottom: 10px;
            border-right: 12px solid var(--bubble-cream);
            border-top: 8px solid transparent; border-bottom: 8px solid transparent;
        }
        .avatar { width: 40px; height: 40px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 10px; text-align: center; }

        /* キャラクター固定エリア */
        .mascot-container { text-align: center; padding-bottom: 20px; }
        .mascot-img { width: 120px; }

        /* 入力エリア */
        .input-area {
            background: #b0e0e6; padding: 15px;
            display: flex; align-items: center; gap: 10px;
        }
        .text-input {
            flex: 1; padding: 10px 15px;
            border-radius: 20px; border: none; outline: none;
        }
        .send-btn {
            background: white; border: none; width: 40px; height: 40px;
            border-radius: 50%; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
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
        <button class="send-btn" onclick="sendMessage()">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
        </button>
    </div>
</div>

<script src="{{ asset('js/nagusame_screen.js') }}"></script>
</body>
</html>