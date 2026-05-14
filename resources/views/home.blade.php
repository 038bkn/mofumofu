<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>もふすけ - ホーム</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background: #fde8e8; overflow-x: hidden; }

        /* ========== PC（601px以上） ========== */
        @media (min-width: 601px) {
            .sp-only { display: none !important; }

            .sheep-img {
                position: fixed;
                bottom: 68px;
                left: 50%;
                transform: translateX(-50%);
                width: min(80vh, 700px);
                z-index: 0;
                pointer-events: none;
            }
            .cloud-wrap {
                position: fixed;
                top: 40px;
                width: 520px;
                height: 330px;
                z-index: 10;
            }
            .cloud-inner { padding: 0 50px 40px 100px; font-size: 15px; }
            .collection-btn { position: fixed; z-index: 10; }
        }

        /* ========== スマホ（600px以下） ========== */
        @media (max-width: 600px) {
            .pc-only { display: none !important; }

            /* 羊：画面下半分を大きく占有 */
            .sp-sheep {
                position: fixed;
                bottom: 0px;
                left: 85%;
                transform: translateX(-50%);
                width: 1300px;       /* 画面幅より大きくして迫力を出す */
                z-index: 1;
                pointer-events: none;
                max-width: none;
                height: 550px;
                object-fit: cover;
            }

            /* 吹き出し：画面中央上側に大きく */
            .sp-cloud {
                position: fixed;
                top: 0;
                left: 50%;
                transform: translateX(-50%);
                width: 130vw;
                height: 82vw;
                z-index: 10;
            }
            .sp-cloud-inner {
                padding: 6px 30px 28px 28px;
                font-size: 13px;
                line-height: 1.6;
            }

            /* ボタン：吹き出しの下あたり・右 */
            .sp-btn {
                position: fixed;
                top: 80vw;
                right: 12px;
                z-index: 10;
            }
        }
    </style>
</head>
<body class="flex justify-center items-start min-h-screen">

    <!-- ========== PC ========== -->
    <div class="pc-only w-full max-w-[390px] min-h-screen bg-[#fde8e8] relative">
        <div class="cloud-wrap" id="cloud-wrap">
            <div class="w-full h-full bg-contain bg-no-repeat bg-center flex items-start justify-center pt-[10%] pb-[22%]"
                style="background-image: url('{{ asset('images/cloud.png') }}');">
                <div class="cloud-inner text-[#4a3f3f] leading-relaxed text-left w-full">
                    <p class="font-bold mb-1">今日も1日がんばろうメ〜！</p>
                    <p>今日が期限のやることがあるメ〜！</p>
                    {{-- @foreach($todayTasks as $task) --}}
                    {{-- <p>・{{ $task->title }}　{{ $task->due_time }}まで</p> --}}
                    {{-- @endforeach --}}
                </div>
            </div>
        </div>
        <div class="collection-btn" id="collection-btn">
            <button onclick="openPopup()"
                class="bg-[#efe8cf] border border-[#b6aa83] rounded-2xl px-6 py-3 text-[#4a3f3f] text-sm font-bold leading-tight shadow-sm active:scale-95 transition">
                コレクション<br>ショップ
            </button>
        </div>
        <div class="fixed top-4 right-4 z-10 bg-[#efe8cf] border border-[#b6aa83] rounded-2xl px-4 py-2 text-[#4a3f3f] text-sm font-bold shadow-sm">
            ⭐ {{ $points }} pt
        </div>
        <img src="{{ asset('images/sheep.png') }}" alt="羊" class="sheep-img">
    </div>

    <!-- ========== スマホ ========== -->
    <div class="sp-only">
        <!-- 羊 -->
        <img src="{{ asset('images/sheep.png') }}" alt="羊" class="sp-sheep">

        <!-- 吹き出し -->
        <div class="sp-cloud">
            <div class="w-full h-full bg-contain bg-no-repeat bg-center flex items-start justify-center pt-[10%] pb-[28%]"
                style="background-image: url('{{ asset('images/cloud.png') }}');">
                <div class="sp-cloud-inner text-[#4a3f3f] text-left">
                    <p class="font-bold mb-1">今日も1日がんばろうメ〜！</p>
                    <p>今日が期限のやることがあるメ〜！</p>
                    {{-- @foreach($todayTasks as $task) --}}
                    {{-- <p>・{{ $task->title }}　{{ $task->due_time }}まで</p> --}}
                    {{-- @endforeach --}}
                </div>
            </div>
        </div>

        <!-- ボタン -->
        <div class="sp-btn">
            <button onclick="openPopup()"
                class="bg-[#efe8cf] border border-[#b6aa83] rounded-2xl px-4 py-2 text-[#4a3f3f] text-xs font-bold leading-tight shadow-sm active:scale-95 transition">
                コレクション<br>ショップ
            </button>
        </div>

        <!-- ポイント表示 -->
        <div class="fixed top-4 right-4 z-10 bg-[#efe8cf] border border-[#b6aa83] rounded-2xl px-3 py-1.5 text-[#4a3f3f] text-xs font-bold shadow-sm">
            ⭐ {{ $points }} pt
        </div>
    </div>

    <!-- ========== フッター ========== -->
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

    <!-- ========== ポップアップ ========== -->
    <div id="popup" class="hidden fixed inset-0 z-50" onclick="closePopup()">
        <div id="popup-bubble" class="absolute flex flex-col items-center"
            style="bottom: calc(68px + 48%); left: 50%; transform: translateX(-50%);"
            onclick="event.stopPropagation()">
            <div id="popup-cloud"
                class="relative flex items-center justify-center bg-contain bg-no-repeat bg-center"
                style="background-image: url('{{ asset('images/cloud.png') }}');">
                <div class="flex flex-col gap-3 mt-[-40px]">
                    <a href="/collection"
                        class="bg-[#fff9e6] active:bg-[#efe8cf] active:scale-95 transition-all rounded-full py-3 px-10 text-[#4a3f3f] font-bold shadow-sm border border-[#e8dfc5] text-center text-sm">
                        コレクション画面
                    </a>
                    <a href="/shop"
                        class="bg-[#fff9e6] active:bg-[#efe8cf] active:scale-95 transition-all rounded-full py-3 px-10 text-[#4a3f3f] font-bold shadow-sm border border-[#e8dfc5] text-center text-sm">
                        ショップ画面
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        /* PCのみJS配置 */
        function positionPC() {
            if (window.innerWidth <= 600) return;
            const cloud  = document.getElementById('cloud-wrap');
            const btn    = document.getElementById('collection-btn');
            const cloudW = cloud.offsetWidth;
            cloud.style.left = (window.innerWidth / 2 - cloudW / 2) + 'px';
            btn.style.left   = (window.innerWidth / 2 + cloudW / 2 + 8) + 'px';
            btn.style.top    = '220px';
        }
        positionPC();
        window.addEventListener('resize', positionPC);

        function openPopup() {
            const popup    = document.getElementById('popup');
            const cloud    = document.getElementById('popup-cloud');
            const isMobile = window.innerWidth <= 600;
            cloud.style.width  = isMobile ? '280px' : '380px';
            cloud.style.height = isMobile ? '200px' : '260px';
            popup.classList.remove('hidden');
            popup.style.background = 'rgba(0,0,0,0.15)';
        }
        function closePopup() {
            document.getElementById('popup').classList.add('hidden');
        }
    </script>
</body>
</html>