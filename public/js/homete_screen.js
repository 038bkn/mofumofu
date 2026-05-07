const chatArea = document.getElementById('chatArea');
const messageInput = document.getElementById('messageInput');

// 羊のほめ言葉リスト
const praiseMessages = [
    "えらい！本当にえらいよ！",
    "頑張ってるの、ちゃんと見てるよ。",
    "そんな風に考えられるなんて素敵だね。",
    "今日も一日お疲れ様。君は最高だよ！",
    "一歩進めたね。すごいじゃない！",
    "無理しすぎないでね。そのままの君が好きだよ。"
];

function sendMessage() {
    const text = messageInput.value.trim();
    if (!text) return;

    // 1. ユーザーのメッセージを表示
    addMessage(text, 'user');
    messageInput.value = '';

    // 2. 羊の反応（少し遅れて返信）
    setTimeout(() => {
        const randomPraise = praiseMessages[Math.floor(Math.random() * praiseMessages.length)];
        addMessage(randomPraise, 'bot');
    }, 800);
}

function addMessage(text, sender) {
    const row = document.createElement('div');
    row.className = `message-row ${sender}`;

    const bubble = document.createElement('div');
    bubble.className = 'bubble';
    bubble.textContent = text;

    if (sender === 'user') {
        const avatar = document.createElement('div');
        avatar.className = 'avatar';
        avatar.innerHTML = 'ユーザー<br>アイコン';
        row.appendChild(avatar);
    }

    row.appendChild(bubble);
    chatArea.appendChild(row);

    // 最新のメッセージまでスクロール
    chatArea.scrollTop = chatArea.scrollHeight;
}

// Enterキー対応
messageInput.addEventListener('keydown', (e) => {
   if (e.isComposing || e.keyCode === 229) return; if (e.key === 'Enter') {
    e.preventDefault();
    sendMessage();
   }
});