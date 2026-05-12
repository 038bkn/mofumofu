<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>ひとりごと画面</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500&display=swap');
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --pink-bg: #f9d5d3;
            --blue-bar: #c8e6f5;
            --bubble-cream: #fef9e7;
            --text-dark: #5a4a4a;
        }
        body {
            font-family: 'Noto Sans JP', sans-serif;
            background: #f0f0f0;
            display: flex; justify-content: center;
            height: 100vh; overflow: hidden;
        }

        .phone-frame {
            width: 100%; max-width: 450px; height: 100%;
            background: var(--pink-bg); display: flex; flex-direction: column;
        }

        /* ホームボタンエリア */
        .top-nav { padding: 12px 15px; }
        .home-btn {
            width: 48px; height: 48px; border-radius: 50%;
            background: white; border: none; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        .home-btn img { width: 26px; height: 26px; }

        /* チャットエリア（吹き出しが上に積まれる） */
        .chat-area {
            flex: 1; overflow-y: auto;
            padding: 10px 20px; display: flex; flex-direction: column; gap: 15px;
        }

        /* 羊のエリア（画面中央に固定表示） */
        .mascot-area {
            display: flex; justify-content: center; align-items: center;
            padding: 10px 0 5px;
        }
        .mascot-area img {
            width: 160px;
            opacity: 0.9;
        }

        /* メッセージのスタイル */
        .message-row { display: flex; align-items: flex-end; gap: 8px; margin-bottom: 5px; }
        .message-row.user { flex-direction: row-reverse; }
        .bubble {
            max-width: 75%; padding: 12px 16px; border-radius: 20px;
            font-size: 14px; background: var(--bubble-cream); color: var(--text-dark);
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            word-wrap: break-word;
        }

        /* 入力エリア */
        .input-area { background: var(--blue-bar); padding: 15px; }
        .tag-row { display: flex; gap: 10px; margin-bottom: 10px; }
        .tag-btn {
            border: none; width: 40px; height: 40px; border-radius: 50%;
            cursor: pointer; font-size: 18px; background: white;
            display: flex; align-items: center; justify-content: center;
        }
        .input-row { display: flex; gap: 10px; align-items: center; }
        .text-input {
            flex: 1; padding: 12px 20px; border-radius: 25px;
            border: none; outline: none; font-size: 16px;
        }
        .send-btn {
            background: #e8e8e8; border: none; width: 45px; height: 45px;
            border-radius: 50%; cursor: pointer; display: flex;
            align-items: center; justify-content: center;
        }
    </style>
</head>
<body>
<div class="phone-frame">

    <!-- ホームへ戻るボタン（仮） -->
    <div class="top-nav">
        <button class="home-btn" onclick="alert('ホーム画面は未実装です')">
             🏠
        </button>
    </div>

    <!-- チャット吹き出しエリア -->
    <div class="chat-area" id="chatArea"></div>

    <!-- 羊のキャラクター -->
    <div class="mascot-area">
        <img src="{{ asset('images/sleep_white.png') }}" alt="羊">
    </div>

    <!-- 入力エリア -->
    <div class="input-area">
        <div class="tag-row">
            <button class="tag-btn" onclick="location.href='/homete'">🌸</button>
            <button class="tag-btn" onclick="location.href='/nagusame'">💧</button>
        </div>
        <div class="input-row">
            <input type="text" id="messageInput" class="text-input" placeholder="ひとりごとを入力...">
            <button class="send-btn" id="sendBtn">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="#5a4a4a" stroke-width="2">
                    <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
                </svg>
            </button>
        </div>
    </div>

</div>
<script src="{{ asset('js/chatscreen.js') }}"></script>
</body>
</html>