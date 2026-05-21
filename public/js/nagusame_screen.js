const chatArea = document.getElementById('chatArea');
const messageInput = document.getElementById('messageInput');

const comfortMessages = [
    // 気持ちを受け止める
    "つらかったね。よしよし。",
    "そんなこともあるよ。あまり自分を責めないで。",
    "今日はゆっくり休んでいいんだよ。",
    "一生懸命やったこと、私は知ってるからね。",
    "泣きたいときは泣いてもいいんだよ。そばにいるから。",
    "明日はきっと、今日より少しだけ楽になるよ。",
    "その気持ち、ちゃんと受け止めてるよ。",
    "辛い思いをしたんだね。それは本当に大変だったね。",
    "無理しなくていいよ。今はただ休んでて。",
    "全部話してくれてありがとう。ちゃんと聞いてるよ。",
    "そう感じるのは、おかしくないよ。当然だよ。",
    "気持ちを吐き出せただけで、えらいよ。",
    "どんな気持ちも、全部受け止めるからね。",
    "つらいって言えたこと、勇気あるよ。",
    "ここに来てくれてよかった。一緒にいるよ。",

    // 寄り添う
    "一人じゃないよ。ここにいるからね。",
    "そばにいるよ。何も言わなくてもいいよ。",
    "ずっとそばで見守ってるよ。",
    "何があっても、君の味方だよ。",
    "つらいときは、もたれかかってきていいよ。",
    "一緒に乗り越えようね。",
    "君のこと、ちゃんと気にかけてるよ。",
    "どんな時でも、ここにいるよ。",
    "話したいときはいつでも聞くよ。",
    "君が泣いてても、ちゃんとそばにいるよ。",
    "何も解決しなくていい。ただそばにいるよ。",
    "今夜は一人じゃないよ。",
    "どんな君でも、受け止めるよ。",
    "弱くていいんだよ。そのままでいて。",
    "君の気持ちは、ちゃんと大切だよ。",

    // 自分を責めないように
    "自分を責めないで。君のせいじゃないよ。",
    "完璧じゃなくていい。誰だって失敗するよ。",
    "できなくても、それは仕方ないことだよ。",
    "頑張れない日があっても、いいんだよ。",
    "うまくいかない日は、誰にでもあるよ。",
    "失敗しても、君の価値は変わらないよ。",
    "結果がどうでも、やろうとした君はえらいよ。",
    "自分を大切にしてね。君は大事な存在だから。",
    "責めるのをやめて、今日は自分を労ってね。",
    "誰かに優しくできる君が、自分にも優しくしていいんだよ。",
    "うまくいかなかったのは、君が悪いんじゃないよ。",
    "そんなに自分を追い込まなくていいよ。",
    "もっと自分に優しくしていいんだよ。",
    "君はもう十分頑張ってるよ。",
    "どうか自分を許してあげてね。",

    // 明日への言葉
    "今日は終わりにしようね。また明日があるよ。",
    "明日の自分に期待しなくていいよ。今日は休もう。",
    "今夜はゆっくり眠ってね。",
    "今日は十分頑張ったよ。明日のことは明日考えよう。",
    "朝になったら、また一緒に考えようね。",
    "今はただ休んで。明日また動き出せばいいよ。",
    "辛い夜は必ず終わるよ。朝が来るから。",
    "今日乗り越えたら、また一歩進めてるよ。",
    "明日の君はきっと、今日より少し楽になってるよ。",
    "夜は全部暗く見えるけど、朝になれば変わるよ。",

    // 感情を肯定する
    "泣いていいよ。涙は弱さじゃないから。",
    "怒っていいよ。その気持ちは正しいよ。",
    "悲しいと感じていいんだよ。",
    "しんどいって思うのは、それだけ真剣だからだよ。",
    "傷ついた気持ち、大切にしてね。",
    "感情を感じることは、生きてる証拠だよ。",
    "どんな気持ちも、ちゃんと意味があるよ。",
    "モヤモヤしてていいよ。答えを出さなくていい。",
    "複雑な気持ちのまま、いていいんだよ。",
    "感じたことを、正直に話してくれてありがとう。",

    // 体を気遣う
    "ちゃんとご飯食べてる？体を大事にしてね。",
    "今日はゆっくりお風呂に入ってね。",
    "体が疲れてると、気持ちも沈むよ。横になってね。",
    "今夜はたくさん眠ってね。",
    "温かいものを飲んで、一息ついてね。",
    "体を温めると、少し楽になるよ。",
    "今日は無理せず、体を休めてね。",
    "深呼吸してみて。ゆっくりね。",
    "肩の力を抜いて。そのままでいいよ。",
    "自分の体の声を聞いてあげてね。",

    // 特別な言葉
    "君がいてくれてよかった。",
    "君の存在は、それだけで大切なんだよ。",
    "どんな状況でも、君のことを応援してるよ。",
    "君が笑える日が来るまで、ずっとそばにいるよ。",
    "今は辛くても、君の人生はまだ続くよ。",
    "君が生きていてくれるだけで、十分だよ。",
    "どうか自分を見捨てないでね。",
    "君の痛みは、本物だよ。ちゃんとわかってるよ。",
    "今夜は一緒にいるよ。怖くないよ。",
    "君のことが、とても心配だよ。大切にしてね。",
    "どんなに暗くても、君の光は消えないよ。",
    "つらい時ほど、自分を責めないでね。",
    "今日も生きてくれてありがとう。",
    "君がここにいてくれるだけで、嬉しいよ。",
    "どんな時も、君のことを忘れないよ。",
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

messageInput.addEventListener('keydown', (e) => {
    if (e.key === 'Enter' && !e.isComposing) {
        e.preventDefault();
        sendMessage();
    }
});

window.addEventListener("DOMContentLoaded", () => {

    const savedFont =
        localStorage.getItem("fontSize");

    if (savedFont) {

        document.documentElement.style.setProperty(
            "--font-size-base",
            savedFont + "px"
        );
    }
});