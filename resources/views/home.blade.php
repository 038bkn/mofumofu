<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>もふすけ - ホーム</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background: #fde8e8;
            overflow-x: hidden;
        }

        @media (min-width: 601px) {

            .sp-only {
                display: none !important;
            }

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

            .cloud-inner {
                padding: 10px 80px 50px 100px;
                font-size: 15px;
            }

            .collection-btn {
                position: fixed;
                z-index: 10;
            }
        }

        @media (max-width: 600px) {

            .pc-only {
                display: none !important;
            }

            .sp-sheep {
                position: fixed;
                bottom: 0px;
                left: 85%;
                transform: translateX(-50%);
                width: 1300px;
                z-index: 1;
                pointer-events: none;
                max-width: none;
                height: 550px;
                object-fit: cover;
            }

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

    {{-- PC --}}
    <div class="pc-only w-full max-w-[390px] min-h-screen bg-[#fde8e8] relative">

        {{-- 吹き出し --}}
        <div class="cloud-wrap" id="cloud-wrap">

            <div
                class="w-full h-full bg-contain bg-no-repeat bg-center flex items-start justify-center pt-[10%] pb-[22%]"
                style="background-image: url('{{ asset('images/cloud.png') }}');"
            >

            <div class="cloud-inner text-[#4a3f3f] leading-relaxed text-left w-full"
                id="todayTasks">
            </div>

            </div>

        </div>

        {{-- 今日のタスク --}}
       

        {{-- コレクション --}}
        <div class="collection-btn" id="collection-btn">

            <button
                onclick="openPopup()"
                class="bg-[#efe8cf]
                       border border-[#b6aa83]
                       rounded-2xl
                       px-6 py-3
                       text-[#4a3f3f]
                       text-sm
                       font-bold
                       shadow-sm
                       active:scale-95
                       transition"
            >
                コレクション<br>
                ショップ
            </button>

        </div>

        {{-- ポイント --}}
        <div
            class="fixed top-4 right-4 z-10
                   bg-[#efe8cf]
                   border border-[#b6aa83]
                   rounded-full
                   px-4 py-2
                   text-[#4a3f3f]
                   text-sm
                   font-bold
                   shadow-sm
                   flex items-center gap-1"
        >

            <span class="text-yellow-500">⭐</span>

            <span class="total-points-display">
                0
            </span>

            pt

        </div>

        {{-- 羊 --}}
        <img
            src="{{ asset('images/sheep.png') }}"
            alt="羊"
            class="sheep-img"
            id="pc-sheep"
        >

    </div>

    {{-- スマホ --}}
    <div class="sp-only">

        {{-- 羊 --}}
        <img
            src="{{ asset('images/sheep.png') }}"
            alt="羊"
            class="sp-sheep"
            id="sp-sheep"
        >

        {{-- 吹き出し --}}
        <div class="sp-cloud">

            <div
                class="w-full h-full
                       bg-contain
                       bg-no-repeat
                       bg-center
                       flex items-start justify-center
                       pt-[10%]
                       pb-[28%]"
                style="background-image: url('{{ asset('images/cloud.png') }}');"
            >

                <div class="sp-cloud-inner text-[#4a3f3f] text-left">

                    <p class="font-bold mb-1">
                        今日も1日がんばろうメ〜！
                    </p>


                </div>

            </div>

        </div>


        {{-- ボタン --}}
        <div class="sp-btn">

            <button
                onclick="openPopup()"
                class="bg-[#efe8cf]
                       border border-[#b6aa83]
                       rounded-2xl
                       px-4 py-2
                       text-[#4a3f3f]
                       text-xs
                       font-bold
                       shadow-sm
                       active:scale-95
                       transition"
            >
                コレクション<br>
                ショップ
            </button>

        </div>

        {{-- ポイント --}}
        <div
            class="fixed top-4 right-4 z-10
                   bg-[#efe8cf]
                   border border-[#b6aa83]
                   rounded-full
                   px-5 py-2
                   text-[#4a3f3f]
                   text-base
                   font-bold
                   shadow-sm
                   flex items-center gap-1"
        >

            <span class="text-yellow-500">⭐</span>

            <span class="total-points-display">
                0
            </span>

            pt

        </div>

    </div>

    {{-- 下ナビ --}}
    <nav
        class="fixed bottom-0 left-0 w-full h-[68px]
               bg-[#cdeef9]
               border-t border-[#b5d9e4]
               z-20"
    >

        <div
            class="w-full max-w-[390px]
                   mx-auto
                   h-full
                   flex justify-around items-center"
        >

            <a href="/chat" class="flex flex-col items-center justify-center">
                <img src="{{ asset('images/icon/chat.png') }}" class="w-16 h-16 object-contain">
            </a>

            <a href="/home" class="flex flex-col items-center justify-center">
                <img src="{{ asset('images/icon/home.png') }}" class="w-16 h-16 object-contain">
            </a>

            <a href="/calendar" class="flex flex-col items-center justify-center">
                <img src="{{ asset('images/icon/todo.png') }}" class="w-16 h-16 object-contain">
            </a>

            <a href="/setting" class="flex flex-col items-center justify-center">
                <img src="{{ asset('images/icon/setting.png') }}" class="w-16 h-16 object-contain">
            </a>

        </div>

    </nav>

    {{-- ポップアップ --}}
    <div
        id="popup"
        class="hidden fixed inset-0 z-50"
        onclick="closePopup()"
    >

        <div
            id="popup-bubble"
            class="absolute flex flex-col items-center"
            style="bottom: calc(68px + 48%); left: 50%; transform: translateX(-50%);"
            onclick="event.stopPropagation()"
        >

            <div
                id="popup-cloud"
                class="relative
                       flex items-center justify-center
                       bg-contain
                       bg-no-repeat
                       bg-center"
                style="background-image: url('{{ asset('images/cloud.png') }}');"
            >

                <div class="flex flex-col gap-3 mt-[-40px]">

                    <a
                        href="/collection"
                        class="bg-[#fff9e6]
                               rounded-full
                               py-3 px-10
                               text-[#4a3f3f]
                               font-bold
                               shadow-sm
                               border border-[#e8dfc5]
                               text-center text-sm"
                    >
                        コレクション画面
                    </a>

                    <a
                        href="/shop"
                        class="bg-[#fff9e6]
                               rounded-full
                               py-3 px-10
                               text-[#4a3f3f]
                               font-bold
                               shadow-sm
                               border border-[#e8dfc5]
                               text-center text-sm"
                    >
                        ショップ画面
                    </a>

                </div>

            </div>

        </div>

    </div>

    <script>

        function updatePoints() {

            const points = localStorage.getItem('total_points') || '0';

            document.querySelectorAll('.total-points-display')
                .forEach(el => el.textContent = points);
        }

        document.addEventListener('DOMContentLoaded', updatePoints);

        function positionPC() {

            if (window.innerWidth <= 600) return;

            const cloud = document.getElementById('cloud-wrap');
            const btn = document.getElementById('collection-btn');

            if (cloud && btn) {

                const cloudW = cloud.offsetWidth;

                cloud.style.left =
                    (window.innerWidth / 2 - cloudW / 2) + 'px';

                btn.style.left =
                    (window.innerWidth / 2 + cloudW / 2 + 8) + 'px';

                btn.style.top = '220px';
            }
        }

        window.addEventListener('resize', positionPC);

        positionPC();

        function openPopup() {

            const popup = document.getElementById('popup');
            const cloud = document.getElementById('popup-cloud');

            const isMobile = window.innerWidth <= 600;

            cloud.style.width = isMobile ? '280px' : '380px';
            cloud.style.height = isMobile ? '200px' : '260px';

            popup.classList.remove('hidden');

            popup.style.background = 'rgba(0,0,0,0.15)';
        }

        function closePopup() {
            document.getElementById('popup').classList.add('hidden');
        }

        (function() {

            const item = localStorage.getItem('equippedItem');

            const map = {
                'bell':'s_ bell.png',
                'doll_boy':'s_ doll_boy.png',
                'doll_girl':'s_ doll_girl.png',
                'rainy':'s_ rainy.png',
                'ribbon':'s_ ribbon.png',
                'sunglasses':'s_ sunglasses.png',
                'valentine':'s_ valentine.png',
                'dango':'s_dango.png',
                'hat':'s_hat.png',
                'helmet_blue':'s_helmet_blue.png',
                'helmet_red':'s_helmet_red.png',
                'sakura':'s_sakura.png',
                'sunflower':'s_sunflower.png',
                'tanabata_man':'s_tanabata_man.png',
                'tanabata_woman':'s_tanabata_woman.png',
                'tophat':'s_tophat.png'
            };

            if (item && map[item]) {

                const src = '/images/with_sheep/' + map[item];

                if(document.getElementById('pc-sheep')) {
                    document.getElementById('pc-sheep').src = src;
                }

                if(document.getElementById('sp-sheep')) {
                    document.getElementById('sp-sheep').src = src;
                }
            }

        })();

    </script>

    <script src="{{ asset('js/home.js') }}"></script>

</body>
</html>