const chatArea = document.getElementById('chatArea');
const messageInput = document.getElementById('messageInput');
const sendBtn = document.getElementById('sendBtn');

// 送信ボタンクリック時のイベント
sendBtn.addEventListener('click', () => {
    handleSend();
});

// Enterキーでの送信
messageInput.addEventListener('keydown', (e) => {
    if (e.isComposing || e.keyCode === 229) return;
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        handleSend();
    }
});

function handleSend() {
    const text = messageInput.value.trim();
    if (!text) return;

    // UIに表示するだけの処理
    addMessageToUI(text);

    // 入力欄をクリア
    messageInput.value = '';
}

function addMessageToUI(text) {
    const row = document.createElement('div');
    row.className = 'message-row user';

    const avatar = document.createElement('div');
    avatar.className = 'avatar';
    avatar.textContent = '私';

    const bubble = document.createElement('div');
    bubble.className = 'bubble';
    bubble.textContent = text;

    row.appendChild(avatar);
    row.appendChild(bubble);
    chatArea.appendChild(row);

    // 自動スクロール
    chatArea.scrollTop = chatArea.scrollHeight;
}