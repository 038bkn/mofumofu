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
            background: var(--pink-bg);
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

        .top-nav { padding: 15px; }
        .home-btn {
            width: 48px; height: 48px; border-radius: 50%;
            background: white; border: none; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        .home-btn img {
            width: 28px; height: 28px; object-fit: contain;
        }

        .chat-area {
            flex: 1; overflow-y: auto;
            padding: 20px; display: flex; flex-direction: column; gap: 15px;
        }

        .mascot-area {
            display: flex; justify-content: center; align-items: center;
            padding-bottom: 20px;
        }
        .mascot-area img {
            width: 250px;
            opacity: 0.9;
        }

        .input-area { 
            background: var(--blue-bar);
            padding: 15px 30px;
            width: 100%;
        }

        .input-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .tag-row { 
            display: flex;
            gap: 10px;
            justify-content: flex-start;
        }

        .tag-btn {
            border: none; width: 45px; height: 45px; border-radius: 50%;
            cursor: pointer; font-size: 20px; background: white;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .input-row { display: flex; gap: 15px; align-items: center; }
        .text-input {
            flex: 1; padding: 15px 25px; border-radius: 30px;
            border: none; outline: none; font-size: 16px;
        }
        .send-btn {
            background: #e8e8e8; border: none; width: 50px; height: 50px;
            border-radius: 50%; cursor: pointer; display: flex;
            align-items: center; justify-content: center;
        }

        .message-row { display: flex; align-items: flex-end; gap: 8px; margin-bottom: 5px; }
        .message-row.user { flex-direction: row-reverse; }
        .bubble {
            max-width: 70%; padding: 12px 18px; border-radius: 20px;
            font-size: 15px; background: var(--bubble-cream); color: var(--text-dark);
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            word-wrap: break-word;
        }
    </style>
</head>
<body>
<div class="phone-frame">

    <div class="top-nav">
        <button class="home-btn" onclick="location.href='/home'">
            <img src="{{ asset('images/icon/home.png') }}" alt="ホーム">
        </button>
    </div>

    <div class="chat-area" id="chatArea">
        
    </div>

    <div class="mascot-area">
        <img src="{{ asset('images/sheep.png') }}" alt="羊">
    </div>

    <div class="input-area">
        <div class="input-container">
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

</div>
<script src="{{ asset('js/chatscreen.js') }}"></script>
</body>
</html>