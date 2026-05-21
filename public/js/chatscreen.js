const chatArea = document.getElementById('chatArea');
const messageInput = document.getElementById('messageInput');
const sendBtn = document.getElementById('sendBtn');

sendBtn.addEventListener('click', () => {
    handleSend();
});

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

    addMessage(text, 'user');
    messageInput.value = '';

    addPoints(5);
}

async function addPoints(amount) {
    const token = document.querySelector('meta[name="csrf-token"]')?.content || '';
    try {
        const res = await fetch('/api/points/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': token,
            },
            body: JSON.stringify({ amount }),
        });
        if (res.ok) {
            const json = await res.json();
            if (json.status === 'success' && json.points !== undefined) {
                localStorage.setItem('total_points', json.points);
                showPointToast(amount, json.points);
            }
        }
    } catch (e) {
        console.error('ポイント保存エラー:', e);
    }
}

function showPointToast(amount, total) {
    const toast = document.createElement('div');
    toast.textContent = `+${amount}pt ⭐ 合計 ${total}pt`;
    toast.style.cssText = `
        position: fixed; bottom: 120px; left: 50%; transform: translateX(-50%);
        background: rgba(90,74,74,0.85); color: white;
        padding: 10px 24px; border-radius: 30px; font-size: 14px;
        z-index: 999; opacity: 1; transition: opacity 1s ease;
        white-space: nowrap; box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    `;
    document.body.appendChild(toast);
    setTimeout(() => { toast.style.opacity = '0'; }, 1500);
    setTimeout(() => { toast.remove(); }, 2500);
}

function addMessage(text, sender) {
    const row = document.createElement('div');
    row.className = `message-row ${sender}`;

    const bubble = document.createElement('div');
    bubble.className = 'bubble';
    bubble.textContent = text;

    row.appendChild(bubble);
    chatArea.appendChild(row);
    chatArea.scrollTop = chatArea.scrollHeight;
}