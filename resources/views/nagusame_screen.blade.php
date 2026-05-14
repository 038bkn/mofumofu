<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>なぐさめ画面</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500&display=swap');
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --nagusame-bg: #87cefa;
            --bubble-cream: #fef9e7;
            --input-bg: #c8e6f5;
            --text-dark: #5a4a4a;
        }
        body {
           font-family: 'Noto Sans JP', sans-serif;
           background: var(--nagusame-bg); /* 全体を水色に */
           display: flex; 
           justify-content: center;
           height: 100vh; 
           overflow: hidden;
        }
        .phone-frame {
           width: 100%; 
           height: 100%;
           display: flex; 
           flex-direction: column;
        }

        .back-nav { padding: 15px; }
        .back-link {
            display: inline-block; background: var(--bubble-cream);
            padding: 8px 20px; border-radius: 20px;
            text-decoration: none; color: var(--text-dark); font-size: 14px; font-weight: 500;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .chat-area {
            flex: 1; overflow-y: auto; padding: 20px;
            display: flex; flex-direction: column; gap: 14px;
        }

        .mascot-container {
           text-align: center;
           padding: 10px 0;
        }
        .mascot-container img {
           width: 250px;
           display: block;
           margin: 0 auto;
        }
        .mascot-label {
          margin-top: -30px;
          font-size: 20px;
          color: #ffffff;
          position: relative;
          z-index: 5;
          font-weight: bold;
          text-shadow: 1px 1px 4px rgba(0,0,0,0.2);
        }

        .input-area {
           background: var(--input-bg);
           padding: 20px;
           width: 100%;
        }
        .input-container {
            max-width: 1000px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .text-input {
            flex: 1; padding: 15px 25px; border-radius: 30px; border: none; outline: none; font-size: 16px;
        }
        .send-btn {
            background: white; border: none; width: 50px; height: 50px;
            border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        /* メッセージスタイル（共通） */
        .message-row { display: flex; align-items: flex-end; gap: 8px; margin-bottom: 5px; }
        .message-row.user { flex-direction: row-reverse; }
        .bubble {
            max-width: 70%; padding: 12px 18px; border-radius: 20px;
            font-size: 15px; background: var(--bubble-cream); color: var(--text-dark);
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>
<div class="phone-frame">
    <div class="back-nav">
        <a href="{{ route('chat') }}" class="back-link">← ひとりごとに戻る</a>
    </div>

    <div class="chat-area" id="chatArea"></div>

    <div class="mascot-container">
        <img src="{{ asset('images/sheep.png') }}" alt="羊">
        <div class="mascot-label">nagusamete</div>
    </div>

    <div class="input-area">
        <div class="input-container">
            <input type="text" id="messageInput" class="text-input" placeholder="今の気持ちを入力...">
            <button class="send-btn" type="button" onclick="sendMessage()">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="#5a4a4a" stroke-width="2">
                    <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
                </svg>
            </button>
        </div>
    </div>
</div>
<script src="{{ asset('js/nagusame_screen.js') }}"></script>
</body>
</html>