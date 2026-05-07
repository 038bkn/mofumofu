const chatArea = document.getElementById('chatArea');
const messageInput = document.getElementById('messageInput');

// 羊のなぐさめ言葉リスト
const comfortMessages = [
    "つらかったね。よしよし。",
    "そんなこともあるよ。あまり自分を責めないで。",
    "今日はゆっくり休んでいいんだよ。",
    "一生懸命やったこと、私は知ってるからね。",
    "泣きたいときは泣いてもいいんだよ。そばにいるから。",
    "明日はきっと、今日より少しだけ楽になるよ。"
];

function sendMessage() {
    const text = messageInput.value.trim();
    if (!text) return;

    addMessage(text, 'user');
    messageInput.value = '';

    setTimeout(() => {
        const randomComfort = comfortMessages[Math.floor(Math.random() * comfortMessages.length)];
        addMessage(randomComfort, 'bot');
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
    chatArea.scrollTop = chatArea.scrollHeight;
}

messageInput.addEventListener('keydown', (e) => {
     if (e.key === 'Enter' && !e.isComposing) {
        e.preventDefault();
        sendMessage();
     }
});