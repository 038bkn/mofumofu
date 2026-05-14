<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>もふすけ - ホーム</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* =============================================
           羊：画面中央下部に大きく固定
           ============================================= */
        .sheep-img {
            position: fixed;
            bottom: 68px;
            left: 50%;
            transform: translateX(-50%); /* 完全中央 */
            width: min(80vh, 700px);
            z-index: 0;
            pointer-events: none;
        }

        /* =============================================
           吹き出し：コンテナ左上に固定
           left は JS で動的計算
           ============================================= */
        .cloud-wrap {
            position: fixed;
            top: 40px;
            z-index: 10;
        }

        /* PC（601px以上）：吹き出し大きめ */
        @media (min-width: 601px) {
            .cloud-wrap {
                width: 520px;
                height: 330px;
            }
            .cloud-inner {
                padding: 0 50px 40px 100px; /* 左を多めに取りテキストを中央寄りに */
                font-size: 15px;
            }
        }

        /* スマホ（600px以下）：吹き出し小さめ */
        @media (max-width: 600px) {
            .cloud-wrap {
                width: 190px;
                height: 130px;
            }
            .cloud-inner {
                padding: 0 26px 14px 26px;
                font-size: 11px;
            }
        }

        /* =============================================
           コレクション・ショップボタン
           left・top は JS で動的計算
           ============================================= */
        .collection-btn {
            position: fixed;
            z-index: 10;
        }
    </style>
</head>

<body class="bg-[#fde8e8] min-h-screen flex justify-center items-start overflow-x-hidden">

    <!-- 中央コンテナ（スマホ上限390px、PC画面では中央寄せ） -->
    <div id="main-container" class="w-full max-w-[390px] min-h-screen bg-[#fde8e8] relative">

        <!-- 吹き出し -->
        <div class="cloud-wrap" id="cloud-wrap">
            <div
                class="w-full h-full bg-contain bg-no-repeat bg-center flex items-center justify-center"
                style="background-image: url('{{ asset('images/cloud.png') }}');"
            >
                <div class="cloud-inner text-[#4a3f3f] leading-relaxed text-left w-full">
                    {{-- カレンダー画面で登録した今日期限のタスクをここに表示する --}}
                    {{-- 例: $todayTasks = Task::whereDate('due_date', today())->get() --}}
                    <p class="font-bold mb-1">今日も1日がんばろうメ〜！</p>
                    <p>今日が期限のやることがあるメ〜！</p>
                    {{-- @foreach($todayTasks as $task) --}}
                    {{-- <p>・{{ $task->title }}　{{ $task->due_time }}まで</p> --}}
                    {{-- @endforeach --}}
                </div>
            </div>
        </div>

        <!-- コレクション・ショップボタン -->
        <div class="collection-btn" id="collection-btn">
            <button
                onclick="openPopup()"
                class="bg-[#efe8cf] border border-[#b6aa83] rounded-2xl px-4 py-2 text-[#4a3f3f] text-xs font-bold leading-tight shadow-sm active:scale-95 transition"
            >
                コレクション<br>ショップ
            </button>
        </div>

        <!-- 羊 -->
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
        /* =============================================
           コンテナの実際の left を取得し、
           吹き出し・ボタンをピクセル精度で配置する
           ============================================= */
        function positionElements() {
            const container = document.getElementById('main-container');
            const rect      = container.getBoundingClientRect();
            const cLeft     = rect.left;
            const cRight    = rect.right;
            const isMobile  = window.innerWidth <= 600;

            // --- 吹き出し ---
            const cloud = document.getElementById('cloud-wrap');
            const cloudW2 = cloud.offsetWidth;
            // PC：画面中央に吹き出しを配置
            cloud.style.left = isMobile
                ? cLeft + 'px'
                : (window.innerWidth / 2 - cloudW2 / 2) + 'px';

            // --- コレクション・ショップボタン ---
            const btn        = document.getElementById('collection-btn');

            if (isMobile) {
                // スマホ：コンテナ右端から内側に配置
                btn.style.left = (cRight - 90) + 'px';
                btn.style.top  = '110px';
            } else {
                // PC：吹き出しの右隣に配置
                btn.style.left = (window.innerWidth / 2 - cloudW2 / 2 + cloudW2 + 8) + 'px';
                btn.style.top  = '220px';
            }
        }

        positionElements();
        window.addEventListener('resize', positionElements);

        function openPopup() {
            document.getElementById('popup').classList.remove('hidden');
        }
        function closePopup() {
            document.getElementById('popup').classList.add('hidden');
        }
    </script>

</body>
</html>