<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>もふすけ - ホーム</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .sheep-img {
            width: 700px;
            max-width: none;
            position: absolute;
            bottom: 50px;
            right: -100px;
            z-index: 0;
        }
        .cloud-wrap {
            width: 400px;
            height: 280px;
            position: absolute;
            top: -50px;
            left: -20px;
            z-index: 10;
        }
    </style>
</head>

<body class="bg-[#fde8e8] min-h-screen flex justify-center items-start overflow-x-hidden">

    <div class="w-full max-w-[390px] min-h-screen bg-[#fde8e8] flex flex-col relative overflow-visible">

        <!-- 吹き出し（左上・はみ出し） -->
        <div class="cloud-wrap">
            <div
                class="w-full h-full bg-contain bg-no-repeat bg-center flex items-end justify-center pb-10 px-12"
                style="background-image: url('{{ asset('images/cloud.png') }}');"
            >
                <div class="text-[#4a3f3f] text-xs leading-relaxed text-left w-full">
                    <!-- TODO: バックエンド実装後に今日のタスクを表示 -->
                    <p class="font-bold mb-1">今日も1日がんばろうメ〜！</p>
                    <p>今日が期限のやることがあるメ〜！</p>
                </div>
            </div>
        </div>

        <!-- コレクション・ショップボタン（右上） -->
        <div class="absolute z-10" style="top: 200px; right: 16px;">
            <button
                onclick="openPopup()"
                class="bg-[#efe8cf] border border-[#b6aa83] rounded-2xl px-4 py-2 text-[#4a3f3f] text-xs font-bold leading-tight shadow-sm active:scale-95 transition"
            >
                コレクション<br>ショップ
            </button>
        </div>

        <!-- 羊（大きく・右寄せ） -->
        <img
            src="{{ asset('images/sheep.png') }}"
            alt="羊"
            class="sheep-img"
        >

        <!-- 下ナビ -->
        <nav class="fixed bottom-0 left-0 w-full h-[68px] bg-[#cdeef9] border-t border-[#b5d9e4] z-20">
            <div class="w-full max-w-[390px] mx-auto h-full flex justify-around items-center">

                <a href="/chat" class="flex flex-col items-center gap-1 text-[#5b5b5b]">
                    <img src="{{ asset('images/icon/fukidashi.png') }}" alt="ひとりごと" class="w-7 h-7 object-contain">
                    <span class="text-[10px]">ひとりごと</span>
                </a>

                <a href="/home" class="flex flex-col items-center gap-1 text-[#5b5b5b]">
                    <img src="{{ asset('images/icon/home.png') }}" alt="ホーム" class="w-7 h-7 object-contain">
                    <span class="text-[10px]">ホーム</span>
                </a>

                <a href="/calendar" class="flex flex-col items-center gap-1 text-[#5b5b5b]">
                    <img src="{{ asset('images/icon/calendar.png') }}" alt="ToDo" class="w-7 h-7 object-contain">
                    <span class="text-[10px]">ToDo</span>
                </a>

                <a href="/setting" class="flex flex-col items-center gap-1 text-[#5b5b5b]">
                    <img src="{{ asset('images/icon/haguruma.png') }}" alt="設定" class="w-7 h-7 object-contain">
                    <span class="text-[10px]">設定</span>
                </a>

            </div>
        </nav>

    </div>

    <!-- ポップアップ -->
    <div
        id="popup"
        class="hidden fixed inset-0 bg-black/20 z-50 flex justify-center items-center"
        onclick="closePopup()"
    >
        <div
            class="relative w-[280px] h-[200px] flex items-center justify-center bg-contain bg-no-repeat bg-center"
            style="background-image: url('{{ asset('images/cloud.png') }}');"
            onclick="event.stopPropagation()"
        >
            <div class="flex flex-col gap-3 mt-[-10px]">
                <a
                    href="/collection"
                    class="bg-[#fff9e6] active:bg-[#efe8cf] active:scale-95 transition-all rounded-full py-3 px-8 text-[#4a3f3f] font-bold shadow-sm border border-[#e8dfc5] text-center text-sm"
                >
                    コレクション画面
                </a>
                <a
                    href="/shop"
                    class="bg-[#fff9e6] active:bg-[#efe8cf] active:scale-95 transition-all rounded-full py-3 px-8 text-[#4a3f3f] font-bold shadow-sm border border-[#e8dfc5] text-center text-sm"
                >
                    ショップ画面
                </a>
            </div>
        </div>
    </div>

    <script>
        function openPopup() {
            document.getElementById('popup').classList.remove('hidden');
        }
        function closePopup() {
            document.getElementById('popup').classList.add('hidden');
        }
    </script>

</body>
</html>