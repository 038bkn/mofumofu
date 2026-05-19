// ============================================================
// shop.js — ショップ画面の処理
// 配置先: public/js/shop.js
// ============================================================

const ITEM_ID_MAP = {
    'bell':           9,
    'ribbon':         10,
    'sunglasses':     11,
    'dango':          12,
    'valentine':      13,
    'sakura':         14,
    'sunflower':      15,
    'rainy':          16,
    'doll_boy':       1,
    'doll_girl':      2,
    'tanabata_man':   3,
    'tanabata_woman': 4,
    'hat':            5,
    'helmet_blue':    6,
    'helmet_red':     7,
    'tophat':         8,
};

document.addEventListener('DOMContentLoaded', function () {

    const confirmPopup   = document.getElementById('confirmPopup');
    const confirmClose   = document.getElementById('confirmClose');
    const confirmOverlay = document.getElementById('confirmOverlay');
    const confirmOk      = document.getElementById('confirmOk');
    const confirmMessage = document.getElementById('confirmMessage');

    // ============================================================
    // エラーポップアップを動的生成
    // ============================================================
    const errorPopup = document.createElement('div');
    errorPopup.id        = 'errorPopup';
    errorPopup.className = 'hidden fixed inset-0 flex items-center justify-center px-8 z-50';
    errorPopup.innerHTML = `
        <div class="absolute inset-0 bg-black/20" id="errorOverlay"></div>
        <div class="relative bg-white rounded-2xl shadow-lg p-6 w-full max-w-[320px]">
            <button id="errorClose" class="absolute top-3 right-3 w-6 h-6 flex items-center justify-center text-gray-400 hover:text-gray-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                    <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                </svg>
            </button>
            <p id="errorMessage" class="text-[14px] text-[#3a3a3a] leading-relaxed mt-2 mb-5"></p>
            <button id="errorOk" class="w-full h-11 bg-[#f4a0a0] rounded-full text-white text-[15px] font-medium active:scale-95 transition-transform">
                閉じる
            </button>
        </div>
    `;
    document.body.appendChild(errorPopup);

    function showError(msg) {
        document.getElementById('errorMessage').textContent = msg;
        errorPopup.classList.remove('hidden');
    }
    function closeError() {
        errorPopup.classList.add('hidden');
    }
    document.getElementById('errorClose').addEventListener('click', closeError);
    document.getElementById('errorOk').addEventListener('click', closeError);
    document.getElementById('errorOverlay').addEventListener('click', closeError);

    let isSubmitting  = false;
    let selectedItem  = null;
    let selectedPrice = null;
    let ownedItemIds  = new Set();

    // ============================================================
    // ユーザーのポイント取得
    // ============================================================
    async function loadUserPoints() {
        try {
            const res  = await fetch('/api/user', { headers: { 'Accept': 'application/json' } });
            const data = await res.json();
            const pts  = data.points ?? data.point ?? data.score ?? 0;
            document.getElementById('userPoints').textContent = pts;
        } catch (e) {
            document.getElementById('userPoints').textContent = '-';
        }
    }
    loadUserPoints();

    // ============================================================
    // 所持アイテム一覧を取得
    // ============================================================
    async function loadOwnedItems() {
        try {
            const response = await fetch('/api/user/items');
            const data = await response.json();

            if (data.status === 'success' && data.data) {
                data.data.forEach(function (ownedItem) {
                    ownedItemIds.add(ownedItem.item.id);
                });
            }

            updateShopDisplay();
        } catch (error) {
            console.error('Failed to load owned items:', error);
        }
    }
    loadOwnedItems();

    // ============================================================
    // ショップ表示の更新：所持済みアイテムを灰色・無効化
    // ============================================================
    function updateShopDisplay() {
        document.querySelectorAll('.shop-item-btn').forEach(function (btn) {
            const itemName = btn.getAttribute('data-item');
            const itemId = ITEM_ID_MAP[itemName];

            if (itemId && ownedItemIds.has(itemId)) {
                btn.disabled = true;
                btn.classList.add('opacity-50', 'cursor-not-allowed');

                const label = btn.parentElement.querySelector('span');
                if (label) {
                    label.textContent = '所持済み';
                    label.classList.add('text-[#999]');
                }

                btn.setAttribute('onclick', '');
            }
        });
    }

    // ============================================================
    // 購入確認ポップアップを開く
    // ============================================================
    window.openConfirm = function (itemName, price) {
        selectedItem  = itemName;
        selectedPrice = price;
        confirmMessage.textContent = itemName + ' を ' + price + ' ポイントで購入しますか？';
        confirmPopup.classList.remove('hidden');
        confirmOk.focus();
    };

    confirmClose.addEventListener('click', closeConfirm);
    confirmOverlay.addEventListener('click', closeConfirm);

    function closeConfirm() {
        confirmPopup.classList.add('hidden');
        selectedItem  = null;
        selectedPrice = null;
    }

    // ============================================================
    // 購入処理
    // ============================================================
    confirmOk.addEventListener('click', async function () {
        if (isSubmitting || !selectedItem) return;

        const itemId = ITEM_ID_MAP[selectedItem];
        if (!itemId) {
            showError('アイテムが見つかりませんでした。');
            return;
        }

        const currentPoints = parseInt(document.getElementById('userPoints').textContent);
        const selectedPrice = parseInt(document.querySelector('[data-item="' + selectedItem + '"]').getAttribute('data-price'));
        console.log('Purchase debug:', { itemId, selectedItem, currentPoints, selectedPrice });

        isSubmitting       = true;
        confirmOk.disabled = true;

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

            const res  = await fetch('/api/items/' + itemId + '/buy', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept':       'application/json',
                },
            });
            const data = await res.json();

            if (res.ok) {
                if (data.data?.total_points !== undefined) {
                    document.getElementById('userPoints').textContent = data.data.total_points;
                } else {
                    await loadUserPoints();
                }
                closeConfirm();
            } else {
                closeConfirm();
                showError(data.message ?? '購入に失敗しました。もう一度お試しください。');
            }
        } catch (e) {
            closeConfirm();
            showError('通信エラーが発生しました。もう一度お試しください。');
        } finally {
            isSubmitting       = false;
            confirmOk.disabled = false;
        }
    });

});