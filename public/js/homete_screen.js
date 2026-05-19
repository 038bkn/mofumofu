const chatArea = document.getElementById('chatArea');
const messageInput = document.getElementById('messageInput');

const praiseMessages = [
    // 頑張りを認める
    "えらい！本当にえらいよ！",
    "頑張ってるの、ちゃんと見てるよ。",
    "今日も一日お疲れ様。君は最高だよ！",
    "一歩進めたね。すごいじゃない！",
    "無理しすぎないでね。そのままの君が好きだよ。",
    "今日もよく頑張ったね。本当に偉いよ。",
    "ちゃんと前に進んでるよ。すごいことだよ。",
    "毎日コツコツ続けてるの、かっこいいよ。",
    "疲れてても頑張れるなんて、本当に強いね。",
    "今日の自分を褒めてあげてね。十分すごいから。",
    "今日も最後までやりきったね。えらいよ！",
    "小さな努力も全部積み重なってるよ。",
    "やろうと思えただけでもすごいことだよ。",
    "諦めずに続けてるの、本当にかっこいいよ。",
    "どんなに小さくても、前進してるよ。",
    "今日の頑張りは絶対に無駄にならないよ。",
    "つらい中でも動けたの、本当にえらいよ。",
    "自分のペースで頑張れてる、それが一番大事だよ。",
    "今日もよく乗り越えたね。尊敬するよ。",
    "頑張ってる姿、誰かがきっと見てるよ。",

    // 存在を認める
    "そんな風に考えられるなんて素敵だね。",
    "君がいるだけで、世界が少し明るくなるよ。",
    "そのままの君が一番好きだよ。",
    "君はもう十分すごいんだよ。",
    "ただ生きてるだけで、えらいんだよ。",
    "君の優しさ、ちゃんと伝わってるよ。",
    "君のこと、誰かがきっと大切に思ってるよ。",
    "完璧じゃなくていい。今の君で十分だよ。",
    "君がいてくれるだけで、嬉しいよ。",
    "君の存在はそれだけで価値があるよ。",
    "弱くていいんだよ。それも君の一部だから。",
    "自分を責めないで。君は十分やってるよ。",
    "君の気持ち、ちゃんと受け取ってるよ。",
    "今日の君も、昨日の君も、ちゃんと好きだよ。",
    "ありのままの君が一番輝いてるよ。",

    // 励ます
    "うまくいかない日もあるよ。でも君はちゃんとやれてるよ。",
    "失敗しても大丈夫。また立ち上がれるから。",
    "今日できなかったことは、明日でいいよ。",
    "休むことも大事なこと。ゆっくりしてね。",
    "焦らなくていいよ。君のペースで進めばいい。",
    "辛い時でも前を向こうとしてるの、えらいよ。",
    "たまには自分に優しくしてあげてね。",
    "君の努力は絶対に無駄にならないよ。",
    "うまくいかなくても、挑戦したことがすごいんだよ。",
    "今は辛くても、きっと笑える日が来るよ。",
    "一人で抱え込まないでね。君の味方はいるよ。",
    "今日は休んでいいよ。明日また頑張ればいい。",
    "できないことより、できたことを見てみてね。",
    "少しずつでいいよ。焦らなくて大丈夫。",
    "今の自分を責めないで。よくやってるよ。",
    "うまくいかない日があるから、うまくいく日が輝くんだよ。",
    "転んでも立ち上がれる君が好きだよ。",
    "辛い経験も、全部君の力になってるよ。",
    "どんな結果でも、挑戦した君はかっこいいよ。",
    "今日も生きてくれてありがとう。",

    // 褒める
    "センスいいね！さすがだよ。",
    "気づけることが、もうすごいんだよ。",
    "行動できるって、本当にすごいことだよ。",
    "それ、なかなかできることじゃないよ。",
    "君ってやっぱりすごいな〜！",
    "その発想、天才じゃない？",
    "さすがだね！本当に尊敬するよ。",
    "君の頑張り、ちゃんと実を結ぶよ。",
    "どんなことにも真剣に向き合えるの、かっこいいよ。",
    "君みたいな人が近くにいたら、きっと嬉しいと思うよ。",
    "そのアイデア、すごくいいと思うよ！",
    "君の丁寧さ、本当に素晴らしいよ。",
    "細かいところまで気づけるの、さすがだよ。",
    "君の行動力、本当に尊敬するよ。",
    "そんなに考えられるなんて、かしこいね。",
    "君の真剣な姿、すごくかっこいいよ。",
    "努力できることって、才能だよ。君はそれを持ってるよ。",
    "君の笑顔、みんなを元気にしてるよ。",
    "君が頑張ってると、こっちまで嬉しくなるよ。",
    "その粘り強さ、本当にすごいよ。",

    // 日常を労う
    "今日もご飯食べられた？それだけでえらいよ。",
    "ちゃんと眠れてる？体を大切にしてね。",
    "今日も外に出られたなら、それだけでもすごいよ。",
    "今日も一日生き抜いたね。お疲れ様。",
    "朝起きられただけでもえらいんだよ。",
    "今日もいろいろあったね。本当にお疲れ様。",
    "自分の気持ちに正直でいられてるの、素敵だよ。",
    "今日も自分と向き合えたね。すごいよ。",
    "小さなことでも、気にかけられるの、優しいね。",
    "今日もちゃんと自分のことを大切にしてね。",

    // 特別な褒め言葉
    "君は特別な存在だよ。忘れないでね。",
    "世界中探しても、君みたいな人はいないよ。",
    "君のことが、めーっちゃ好きだよ！",
    "君と話せて、嬉しいな。",
    "君の頑張りは、誰かの勇気になってるよ。",
    "君がいる世界は、もっと素敵になってるよ。",
    "君のこと、ずっと応援してるよ。",
    "君はもっと自分を好きになっていいんだよ。",
    "君の可能性は無限大だよ。",
    "君なら絶対大丈夫。信じてるよ！",
    "どんな君でも、ちゃんと受け止めるよ。",
    "君の未来、きっと明るいよ。",
    "君が笑ってるとこ、見たいな。",
    "もっと自分を褒めてあげてね。十分すごいんだから。",
    "今日も君に会えてよかったよ。ありがとう。",
];

function sendMessage() {
    const text = messageInput.value.trim();
    if (!text) return;

    addMessage(text, 'user');
    messageInput.value = '';

    setTimeout(() => {
        const randomPraise = praiseMessages[Math.floor(Math.random() * praiseMessages.length)];
        addMessage(randomPraise, 'bot');
    }, 800);

    addPoints(5);
}

function addPoints(amount) {
    const current = parseInt(localStorage.getItem('total_points') || '0', 10);
    const newTotal = current + amount;
    localStorage.setItem('total_points', newTotal);
    showPointToast(amount, newTotal);
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

messageInput.addEventListener('keydown', (e) => {
    if (e.isComposing || e.keyCode === 229) return;
    if (e.key === 'Enter') {
        e.preventDefault();
        sendMessage();
    }
});