<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>もふすけ - コレクション</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#fde8e8] min-h-screen flex justify-center items-start">
    <div class="w-full max-w-[390px] min-h-screen bg-[#fde8e8] flex flex-col">

        <!-- ヘッダー -->
        <div class="flex items-center justify-between px-4 pt-4 pb-2">
            <!-- 戻るボタン -->
            <button onclick="window.history.back()" class="w-8 h-8 flex items-center justify-center text-[#3a3a3a]">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
            </button>
            <!-- 保存ボタン -->
            <button id="saveBtn" onclick="saveEquip()" class="w-8 h-8 flex items-center justify-center text-[#3a3a3a]">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
            </button>
        </div>

        <!-- キャラクター表示エリア -->
        <div class="flex justify-center items-center py-4">
            <img
                id="characterImg"
                src="{{ asset('images/sheep.png') }}"
                alt="キャラクター"
                class="w-36 h-36 object-contain"
            >
        </div>

        <!-- アイテムグリッド -->
        <div class="flex-1 px-4 pb-6">
            <div class="grid grid-cols-4 gap-3" id="itemGrid">

                <!-- 装備なし -->
                <button
                    onclick="selectItem('none')"
                    data-item="none"
                    class="item-btn aspect-square bg-white rounded-full shadow-sm flex items-center justify-center border-2 border-transparent"
                >
                    <span class="text-[10px] text-gray-400">なし</span>
                </button>

                <!-- bell -->
                <button
                    onclick="selectItem('bell')"
                    data-item="bell"
                    class="item-btn aspect-square bg-white rounded-full shadow-sm flex items-center justify-center border-2 border-transparent overflow-hidden"
                >
                    <img src="{{ asset('images/item/bell.png') }}" alt="bell" class="w-full h-full object-cover">
                </button>

                <!-- dango -->
                <button
                    onclick="selectItem('dango')"
                    data-item="dango"
                    class="item-btn aspect-square bg-white rounded-full shadow-sm flex items-center justify-center border-2 border-transparent overflow-hidden"
                >
                    <img src="{{ asset('images/item/dango.png') }}" alt="dango" class="w-full h-full object-cover">
                </button>

                <!-- doll_boy -->
                <button
                    onclick="selectItem('doll_boy')"
                    data-item="doll_boy"
                    class="item-btn aspect-square bg-white rounded-full shadow-sm flex items-center justify-center border-2 border-transparent overflow-hidden"
                >
                    <img src="{{ asset('images/item/doll_boy.png') }}" alt="doll_boy" class="w-full h-full object-cover">
                </button>

                <!-- doll_girl -->
                <button
                    onclick="selectItem('doll_girl')"
                    data-item="doll_girl"
                    class="item-btn aspect-square bg-white rounded-full shadow-sm flex items-center justify-center border-2 border-transparent overflow-hidden"
                >
                    <img src="{{ asset('images/item/doll_girl.png') }}" alt="doll_girl" class="w-full h-full object-cover">
                </button>

                <!-- hat -->
                <button
                    onclick="selectItem('hat')"
                    data-item="hat"
                    class="item-btn aspect-square bg-white rounded-full shadow-sm flex items-center justify-center border-2 border-transparent overflow-hidden"
                >
                    <img src="{{ asset('images/item/hat.png') }}" alt="hat" class="w-full h-full object-cover">
                </button>

                <!-- helmet_blue -->
                <button
                    onclick="selectItem('helmet_blue')"
                    data-item="helmet_blue"
                    class="item-btn aspect-square bg-white rounded-full shadow-sm flex items-center justify-center border-2 border-transparent overflow-hidden"
                >
                    <img src="{{ asset('images/item/helmet_blue.png') }}" alt="helmet_blue" class="w-full h-full object-cover">
                </button>

                <!-- helmet_red -->
                <button
                    onclick="selectItem('helmet_red')"
                    data-item="helmet_red"
                    class="item-btn aspect-square bg-white rounded-full shadow-sm flex items-center justify-center border-2 border-transparent overflow-hidden"
                >
                    <img src="{{ asset('images/item/helmet_red.png') }}" alt="helmet_red" class="w-full h-full object-cover">
                </button>

                <!-- rainy -->
                <button
                    onclick="selectItem('rainy')"
                    data-item="rainy"
                    class="item-btn aspect-square bg-white rounded-full shadow-sm flex items-center justify-center border-2 border-transparent overflow-hidden"
                >
                    <img src="{{ asset('images/item/rainy.png') }}" alt="rainy" class="w-full h-full object-cover">
                </button>

                <!-- ribbon -->
                <button
                    onclick="selectItem('ribbon')"
                    data-item="ribbon"
                    class="item-btn aspect-square bg-white rounded-full shadow-sm flex items-center justify-center border-2 border-transparent overflow-hidden"
                >
                    <img src="{{ asset('images/item/ribbon.png') }}" alt="ribbon" class="w-full h-full object-cover">
                </button>

                <!-- sakura -->
                <button
                    onclick="selectItem('sakura')"
                    data-item="sakura"
                    class="item-btn aspect-square bg-white rounded-full shadow-sm flex items-center justify-center border-2 border-transparent overflow-hidden"
                >
                    <img src="{{ asset('images/item/sakura.png') }}" alt="sakura" class="w-full h-full object-cover">
                </button>

                <!-- sunflower -->
                <button
                    onclick="selectItem('sunflower')"
                    data-item="sunflower"
                    class="item-btn aspect-square bg-white rounded-full shadow-sm flex items-center justify-center border-2 border-transparent overflow-hidden"
                >
                    <img src="{{ asset('images/item/sunflower.png') }}" alt="sunflower" class="w-full h-full object-cover">
                </button>

                <!-- sunglasses -->
                <button
                    onclick="selectItem('sunglasses')"
                    data-item="sunglasses"
                    class="item-btn aspect-square bg-white rounded-full shadow-sm flex items-center justify-center border-2 border-transparent overflow-hidden"
                >
                    <img src="{{ asset('images/item/sunglasses.png') }}" alt="sunglasses" class="w-full h-full object-cover">
                </button>

                <!-- tanabata_man -->
                <button
                    onclick="selectItem('tanabata_man')"
                    data-item="tanabata_man"
                    class="item-btn aspect-square bg-white rounded-full shadow-sm flex items-center justify-center border-2 border-transparent overflow-hidden"
                >
                    <img src="{{ asset('images/item/tanabata_man.png') }}" alt="tanabata_man" class="w-full h-full object-cover">
                </button>

                <!-- tanabata_woman -->
                <button
                    onclick="selectItem('tanabata_woman')"
                    data-item="tanabata_woman"
                    class="item-btn aspect-square bg-white rounded-full shadow-sm flex items-center justify-center border-2 border-transparent overflow-hidden"
                >
                    <img src="{{ asset('images/item/tanabata_woman.png') }}" alt="tanabata_woman" class="w-full h-full object-cover">
                </button>

                <!-- tophat -->
                <button
                    onclick="selectItem('tophat')"
                    data-item="tophat"
                    class="item-btn aspect-square bg-white rounded-full shadow-sm flex items-center justify-center border-2 border-transparent overflow-hidden"
                >
                    <img src="{{ asset('images/item/tophat.png') }}" alt="tophat" class="w-full h-full object-cover">
                </button>

                <!-- valentine -->
                <button
                    onclick="selectItem('valentine')"
                    data-item="valentine"
                    class="item-btn aspect-square bg-white rounded-full shadow-sm flex items-center justify-center border-2 border-transparent overflow-hidden"
                >
                    <img src="{{ asset('images/item/valentine.png') }}" alt="valentine" class="w-full h-full object-cover">
                </button>

            </div>
        </div>

    </div>

    <script src="{{ asset('js/collection.js') }}"></script>
</body>
</html>