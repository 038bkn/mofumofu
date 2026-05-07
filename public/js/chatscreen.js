const chatArea = document.getElementById('chatArea');
const messageInput = document.getElementById('messageInput');
const sendBtn = document.getElementById('sendBtn');
const STORAGE_KEY = 'chat_history';

// 1. ページ読み込み時に履歴を表示
window.addEventListener('DOMContentLoaded', () => {
    const savedData = JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
    savedData.forEach(msg => {
        addMessageToUI(msg.text);
    });
});

// 2. 送信ボタンクリック
sendBtn.addEventListener('click', () => {
    handleSend();
});

// 3. Enterキーでの送信
messageInput.addEventListener('keydown', (e) => {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        handleSend();
    }
});

function handleSend() {
    const text = messageInput.value.trim();
    if (!text) return;

    // UIに表示
    addMessageToUI(text);
    
    // 保存
    saveMessage(text);

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

function saveMessage(text) {
    const history = JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
    history.push({ text: text });
    localStorage.setItem(STORAGE_KEY, JSON.stringify(history));
}