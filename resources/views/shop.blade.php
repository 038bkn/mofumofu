<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>もふすけ - ショップ</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#fde8e8] min-h-screen flex justify-center items-start">
    <div class="w-full max-w-[390px] min-h-screen bg-[#fde8e8] flex flex-col">

        <!-- ヘッダー -->
        <div class="flex items-center justify-between px-4 pt-8 pb-2">
            <!-- 戻るボタン -->
            <button onclick="window.history.back()" aria-label="戻る" class="w-8 h-8 flex items-center justify-center text-[#3a3a3a]">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
            </button>
            <!-- ポイント数 -->
            <div class="text-[13px] text-[#3a3a3a]">
                ポイント数：<span id="userPoints">0</span>
            </div>
        </div>

        <!-- ショップ看板 -->
        <div class="flex justify-center items-center px-8 py-2">
            <div class="relative w-48">
                <img src="{{ asset('images/kanban.png') }}" alt="看板" class="w-full object-contain">
                <span class="absolute inset-0 flex items-end justify-center text-[20px] text-[#3a3a3a] font-bold tracking-widest pb-12" style="font-family: 'Hiragino Maru Gothic ProN', 'BIZ UDPGothic', sans-serif;">ショップ</span>
            </div>
        </div>

        <!-- アイテムグリッド -->
        <div class="flex-1 px-4 pb-8">
            <div class="grid grid-cols-3 gap-x-4 gap-y-6">

                <!-- bell -->
                <div class="flex flex-col items-center gap-1">
                    <button
                        onclick="openConfirm('bell', 80)"
                        data-item="bell"
                        data-price="80"
                        class="shop-item-btn w-full aspect-square bg-white rounded-full shadow-sm flex items-center justify-center overflow-hidden"
                    >
                        <img src="{{ asset('images/item/bell.png') }}" alt="bell" class="w-4/5 h-4/5 object-contain">
                    </button>
                    <span class="text-[11px] text-[#555]">必要ポイント 80</span>
                </div>

                <!-- dango -->
                <div class="flex flex-col items-center gap-1">
                    <button
                        onclick="openConfirm('dango', 120)"
                        data-item="dango"
                        data-price="120"
                        class="shop-item-btn w-full aspect-square bg-white rounded-full shadow-sm flex items-center justify-center overflow-hidden"
                    >
                        <img src="{{ asset('images/item/dango.png') }}" alt="dango" class="w-4/5 h-4/5 object-contain">
                    </button>
                    <span class="text-[11px] text-[#555]">必要ポイント 120</span>
                </div>

                <!-- doll_boy -->
                <div class="flex flex-col items-center gap-1">
                    <button
                        onclick="openConfirm('doll_boy', 500)"
                        data-item="doll_boy"
                        data-price="500"
                        class="shop-item-btn w-full aspect-square bg-white rounded-full shadow-sm flex items-center justify-center overflow-hidden"
                    >
                        <img src="{{ asset('images/item/doll_boy.png') }}" alt="doll_boy" class="w-4/5 h-4/5 object-contain">
                    </button>
                    <span class="text-[11px] text-[#555]">必要ポイント 500</span>
                </div>

                <!-- doll_girl -->
                <div class="flex flex-col items-center gap-1">
                    <button
                        onclick="openConfirm('doll_girl', 500)"
                        data-item="doll_girl"
                        data-price="500"
                        class="shop-item-btn w-full aspect-square bg-white rounded-full shadow-sm flex items-center justify-center overflow-hidden"
                    >
                        <img src="{{ asset('images/item/doll_girl.png') }}" alt="doll_girl" class="w-4/5 h-4/5 object-contain">
                    </button>
                    <span class="text-[11px] text-[#555]">必要ポイント 500</span>
                </div>

                <!-- hat -->
                <div class="flex flex-col items-center gap-1">
                    <button
                        onclick="openConfirm('hat', 100)"
                        data-item="hat"
                        data-price="100"
                        class="shop-item-btn w-full aspect-square bg-white rounded-full shadow-sm flex items-center justify-center overflow-hidden"
                    >
                        <img src="{{ asset('images/item/hat.png') }}" alt="hat" class="w-4/5 h-4/5 object-contain">
                    </button>
                    <span class="text-[11px] text-[#555]">必要ポイント 100</span>
                </div>

                <!-- helmet_blue -->
                <div class="flex flex-col items-center gap-1">
                    <button
                        onclick="openConfirm('helmet_blue', 150)"
                        data-item="helmet_blue"
                        data-price="150"
                        class="shop-item-btn w-full aspect-square bg-white rounded-full shadow-sm flex items-center justify-center overflow-hidden"
                    >
                        <img src="{{ asset('images/item/helmet_blue.png') }}" alt="helmet_blue" class="w-4/5 h-4/5 object-contain">
                    </button>
                    <span class="text-[11px] text-[#555]">必要ポイント 150</span>
                </div>

                <!-- helmet_red -->
                <div class="flex flex-col items-center gap-1">
                    <button
                        onclick="openConfirm('helmet_red', 150)"
                        data-item="helmet_red"
                        data-price="150"
                        class="shop-item-btn w-full aspect-square bg-white rounded-full shadow-sm flex items-center justify-center overflow-hidden"
                    >
                        <img src="{{ asset('images/item/helmet_red.png') }}" alt="helmet_red" class="w-4/5 h-4/5 object-contain">
                    </button>
                    <span class="text-[11px] text-[#555]">必要ポイント 150</span>
                </div>

                <!-- rainy -->
                <div class="flex flex-col items-center gap-1">
                    <button
                        onclick="openConfirm('rainy', 150)"
                        data-item="rainy"
                        data-price="150"
                        class="shop-item-btn w-full aspect-square bg-white rounded-full shadow-sm flex items-center justify-center overflow-hidden"
                    >
                        <img src="{{ asset('images/item/rainy.png') }}" alt="rainy" class="w-4/5 h-4/5 object-contain">
                    </button>
                    <span class="text-[11px] text-[#555]">必要ポイント 150</span>
                </div>

                <!-- ribbon -->
                <div class="flex flex-col items-center gap-1">
                    <button
                        onclick="openConfirm('ribbon', 100)"
                        data-item="ribbon"
                        data-price="100"
                        class="shop-item-btn w-full aspect-square bg-white rounded-full shadow-sm flex items-center justify-center overflow-hidden"
                    >
                        <img src="{{ asset('images/item/ribbon.png') }}" alt="ribbon" class="w-4/5 h-4/5 object-contain">
                    </button>
                    <span class="text-[11px] text-[#555]">必要ポイント 100</span>
                </div>

                <!-- sakura -->
                <div class="flex flex-col items-center gap-1">
                    <button
                        onclick="openConfirm('sakura', 200)"
                        data-item="sakura"
                        data-price="200"
                        class="shop-item-btn w-full aspect-square bg-white rounded-full shadow-sm flex items-center justify-center overflow-hidden"
                    >
                        <img src="{{ asset('images/item/sakura.png') }}" alt="sakura" class="w-4/5 h-4/5 object-contain">
                    </button>
                    <span class="text-[11px] text-[#555]">必要ポイント 200</span>
                </div>

                <!-- sunflower -->
                <div class="flex flex-col items-center gap-1">
                    <button
                        onclick="openConfirm('sunflower', 200)"
                        data-item="sunflower"
                        data-price="200"
                        class="shop-item-btn w-full aspect-square bg-white rounded-full shadow-sm flex items-center justify-center overflow-hidden"
                    >
                        <img src="{{ asset('images/item/sunflower.png') }}" alt="sunflower" class="w-4/5 h-4/5 object-contain">
                    </button>
                    <span class="text-[11px] text-[#555]">必要ポイント 200</span>
                </div>

                <!-- sunglasses -->
                <div class="flex flex-col items-center gap-1">
                    <button
                        onclick="openConfirm('sunglasses', 200)"
                        data-item="sunglasses"
                        data-price="200"
                        class="shop-item-btn w-full aspect-square bg-white rounded-full shadow-sm flex items-center justify-center overflow-hidden"
                    >
                        <img src="{{ asset('images/item/sunglasses.png') }}" alt="sunglasses" class="w-4/5 h-4/5 object-contain">
                    </button>
                    <span class="text-[11px] text-[#555]">必要ポイント 200</span>
                </div>

                <!-- tanabata_man -->
                <div class="flex flex-col items-center gap-1">
                    <button
                        onclick="openConfirm('tanabata_man', 800)"
                        data-item="tanabata_man"
                        data-price="800"
                        class="shop-item-btn w-full aspect-square bg-white rounded-full shadow-sm flex items-center justify-center overflow-hidden"
                    >
                        <img src="{{ asset('images/item/tanabata_man.png') }}" alt="tanabata_man" class="w-4/5 h-4/5 object-contain">
                    </button>
                    <span class="text-[11px] text-[#555]">必要ポイント 800</span>
                </div>

                <!-- tanabata_woman -->
                <div class="flex flex-col items-center gap-1">
                    <button
                        onclick="openConfirm('tanabata_woman', 800)"
                        data-item="tanabata_woman"
                        data-price="800"
                        class="shop-item-btn w-full aspect-square bg-white rounded-full shadow-sm flex items-center justify-center overflow-hidden"
                    >
                        <img src="{{ asset('images/item/tanabata_woman.png') }}" alt="tanabata_woman" class="w-4/5 h-4/5 object-contain">
                    </button>
                    <span class="text-[11px] text-[#555]">必要ポイント 800</span>
                </div>

                <!-- tophat -->
                <div class="flex flex-col items-center gap-1">
                    <button
                        onclick="openConfirm('tophat', 300)"
                        data-item="tophat"
                        data-price="300"
                        class="shop-item-btn w-full aspect-square bg-white rounded-full shadow-sm flex items-center justify-center overflow-hidden"
                    >
                        <img src="{{ asset('images/item/tophat.png') }}" alt="tophat" class="w-4/5 h-4/5 object-contain">
                    </button>
                    <span class="text-[11px] text-[#555]">必要ポイント 300</span>
                </div>

                <!-- valentine -->
                <div class="flex flex-col items-center gap-1">
                    <button
                        onclick="openConfirm('valentine', 250)"
                        data-item="valentine"
                        data-price="250"
                        class="shop-item-btn w-full aspect-square bg-white rounded-full shadow-sm flex items-center justify-center overflow-hidden"
                    >
                        <img src="{{ asset('images/item/valentine.png') }}" alt="valentine" class="w-4/5 h-4/5 object-contain">
                    </button>
                    <span class="text-[11px] text-[#555]">必要ポイント 250</span>
                </div>

            </div>
        </div>

    </div>

    <!-- 購入確認ポップアップ -->
    <div
        id="confirmPopup"
        class="hidden fixed inset-0 flex items-center justify-center px-8 z-50"
        role="dialog"
        aria-modal="true"
        aria-labelledby="confirmMessage"
    >
        <div class="absolute inset-0 bg-black/20" id="confirmOverlay"></div>
        <div class="relative bg-white rounded-2xl shadow-lg p-6 w-full max-w-[320px]">
            <!-- バツ印 -->
            <button
                id="confirmClose"
                aria-label="閉じる"
                class="absolute top-3 right-3 w-6 h-6 flex items-center justify-center text-gray-400 hover:text-gray-600 transition-colors"
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5" aria-hidden="true">
                    <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                </svg>
            </button>
            <p id="confirmMessage" class="text-[14px] text-[#3a3a3a] leading-relaxed mt-2 mb-5"></p>
            <!-- 承認ボタン -->
            <button
                id="confirmOk"
                class="w-full h-11 bg-[#f4a0a0] rounded-full text-white text-[15px] font-medium active:scale-95 transition-transform"
            >
                購入する
            </button>
        </div>
    </div>

    <script src="{{ asset('js/shop.js') }}"></script>
</body>
</html>