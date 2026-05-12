<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>ほめて画面</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500&display=swap');
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --homete-bg: #ffb6c1;
            --bubble-cream: #fef9e7;
            --text-dark: #5a4a4a;
        }
        body {
            font-family: 'Noto Sans JP', sans-serif;
            background: #f0f0f0;
            display: flex; justify-content: center; align-items: center; min-height: 100vh;
            overflow: hidden;
        }
        .phone-frame {
            width: 100%;
            max-width: 450px;
            height: 100vh;
            height: 100dvh;
            background: var(--homete-bg);
            display: flex; flex-direction: column;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        @media (max-width: 480px) {
            .phone-frame { max-width: 100%; box-shadow: none; }
        }

        .back-nav { padding: 15px; }
        .back-link {
            display: inline-block; background: var(--bubble-cream);
            padding: 8px 16px; border-radius: 20px;
            text-decoration: none; color: var(--text-dark); font-size: 14px;
        }

        .chat-area {
            flex: 1; overflow-y: auto; padding: 12px 16px;
            display: flex; flex-direction: column; gap: 14px;
        }
        .message-row { display: flex; align-items: flex-end; gap: 8px; margin-bottom: 10px; }
        .message-row.user { flex-direction: row-reverse; }
        .bubble {
            max-width: 75%; padding: 12px 16px; border-radius: 20px;
            font-size: 14px; background: var(--bubble-cream); color: var(--text-dark);
            word-wrap: break-word;
        }

        .mascot-container {
            text-align: center;
            padding: 8px 0 4px;
        }
        .mascot-container img {
            width: 300px;
        }
         .mascot-label {
           margin-top: -30px; /* ここを大きくマイナスにする */
           font-size: 20px;
           color: `#5a4a4a`;
           position: relative;
           z-index: 5;
           font-weight: bold; /* 文字を見やすく */
           text-shadow: 0 1px 2px rgba(255,255,255,0.45);
}

        .input-area {
            background: #fce8e6; padding: 15px;
            display: flex; align-items: center; gap: 10px;
        }
        .text-input {
            flex: 1; padding: 12px 15px; border-radius: 25px; border: none; outline: none; font-size: 16px;
        }
        .send-btn {
            background: white; border: none; width: 45px; height: 45px;
            border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;
        }
    </style>
</head>
<body>
<div class="phone-frame">
    <div class="back-nav"><a href="/chat" class="back-link">ひとりごとに戻る</a></div>

    <div class="chat-area" id="chatArea"></div>

    <div class="mascot-container">
    <img src="{{ asset('images/sheep.png') }}" alt="羊">
    <div class="mascot-label">homete!</div>
</div>

    <div class="input-area">
        <input type="text" id="messageInput" class="text-input" placeholder="テキスト入力">
        <button class="send-btn" onclick="sendMessage()">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="#f4a0b0" stroke-width="2">
                <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
            </svg>
        </button>
    </div>
</div>
<script src="{{ asset('js/homete_screen.js') }}"></script>
</body>
</html>