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

        @php
            $ownedSet = array_flip($ownedItemIds);
            $items = [
                ['name' => 'bell',          'id' => 9,  'price' => 80],
                ['name' => 'dango',         'id' => 12, 'price' => 120],
                ['name' => 'doll_boy',      'id' => 1,  'price' => 500],
                ['name' => 'doll_girl',     'id' => 2,  'price' => 500],
                ['name' => 'hat',           'id' => 5,  'price' => 100],
                ['name' => 'helmet_blue',   'id' => 6,  'price' => 150],
                ['name' => 'helmet_red',    'id' => 7,  'price' => 150],
                ['name' => 'rainy',         'id' => 16, 'price' => 150],
                ['name' => 'ribbon',        'id' => 10, 'price' => 100],
                ['name' => 'sakura',        'id' => 14, 'price' => 200],
                ['name' => 'sunflower',     'id' => 15, 'price' => 200],
                ['name' => 'sunglasses',    'id' => 11, 'price' => 200],
                ['name' => 'tanabata_man',  'id' => 3,  'price' => 800],
                ['name' => 'tanabata_woman','id' => 4,  'price' => 800],
                ['name' => 'tophat',        'id' => 8,  'price' => 300],
                ['name' => 'valentine',     'id' => 13, 'price' => 250],
            ];
        @endphp

        <!-- アイテムグリッド -->
        <div class="flex-1 px-4 pb-8">
            <div class="grid grid-cols-3 gap-x-4 gap-y-6">

                @foreach ($items as $item)
                @php $owned = isset($ownedSet[$item['id']]); @endphp
                <div class="flex flex-col items-center gap-1">
                    <button
                        @if(!$owned) onclick="openConfirm('{{ $item['name'] }}', {{ $item['price'] }})" @endif
                        data-item="{{ $item['name'] }}"
                        data-price="{{ $item['price'] }}"
                        @if($owned) disabled data-owned="1" @endif
                        class="shop-item-btn w-full aspect-square bg-white rounded-full shadow-sm flex items-center justify-center overflow-hidden @if($owned) opacity-50 cursor-not-allowed @endif"
                        style="{{ $owned ? 'position:relative' : '' }}"
                    >
                        <img src="{{ asset('images/item/' . $item['name'] . '.png') }}" alt="{{ $item['name'] }}" class="w-4/5 h-4/5 object-contain">
                        @if($owned)
                            <div style="position:absolute;inset:0;background:rgba(0,0,0,0.45);display:flex;align-items:center;justify-content:center;">
                                <span style="color:#fff;font-size:11px;font-weight:700;text-shadow:0 1px 2px rgba(0,0,0,0.5)">購入済み</span>
                            </div>
                        @endif
                    </button>
                    <span class="text-[11px] {{ $owned ? 'text-[#999]' : 'text-[#555]' }}">
                        {{ $owned ? '購入済み' : '必要ポイント ' . $item['price'] }}
                    </span>
                </div>
                @endforeach

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

    <script>
        window.INITIAL_OWNED_ITEM_IDS = @json($ownedItemIds);
    </script>
    <script src="{{ asset('js/shop.js') }}"></script>
</body>
</html>
