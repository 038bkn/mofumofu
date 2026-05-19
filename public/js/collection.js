// ============================================================
// collection.js — コレクション画面の処理
// 配置先: public/js/collection.js
// ============================================================

const BASE_URL = '';

const FILE_NAME_MAP = {
    'bell':           's_ bell.png',
    'doll_boy':       's_ doll_boy.png',
    'doll_girl':      's_ doll_girl.png',
    'rainy':          's_ rainy.png',
    'ribbon':         's_ ribbon.png',
    'sunglasses':     's_ sunglasses.png',
    'valentine':      's_ valentine.png',
    'dango':          's_dango.png',
    'hat':            's_hat.png',
    'helmet_blue':    's_helmet_blue.png',
    'helmet_red':     's_helmet_red.png',
    'sakura':         's_sakura.png',
    'sunflower':      's_sunflower.png',
    'tanabata_man':   's_tanabata_man.png',
    'tanabata_woman': 's_tanabata_woman.png',
    'tophat':         's_tophat.png',
};

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

let selectedItem = 'none';
let ownedItemIds = new Set();

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

        updateItemDisplay();
    } catch (error) {
        console.error('Failed to load owned items:', error);
    }
}

// ============================================================
// アイテム表示の更新：所持していないアイテムを灰色にする
// ============================================================
function updateItemDisplay() {
    document.querySelectorAll('.item-btn').forEach(function (btn) {
        const itemName = btn.getAttribute('data-item');
        const itemId = ITEM_ID_MAP[itemName];
        const isOwned = itemName === 'none' || (itemId && ownedItemIds.has(itemId));

        if (!isOwned) {
            btn.classList.add('opacity-50', 'cursor-not-allowed');
            btn.disabled = true;
        }
    });
}

// ============================================================
// アイテム選択
// ============================================================
function selectItem(itemName) {
    const itemId = ITEM_ID_MAP[itemName];
    const isOwned = itemName === 'none' || (itemId && ownedItemIds.has(itemId));
    if (!isOwned) {
        return;
    }

    selectedItem = itemName;

    const characterImg = document.getElementById('characterImg');
    if (itemName === 'none' || !FILE_NAME_MAP[itemName]) {
        characterImg.src = BASE_URL + '/images/sheep.png';
    } else {
        const fileName = FILE_NAME_MAP[itemName];
        characterImg.src = BASE_URL + '/images/with_sheep/' + fileName;
    }

    document.querySelectorAll('.item-btn').forEach(function (btn) {
        btn.classList.remove('border-[#f4a0a0]');
        btn.classList.add('border-transparent');
    });
    const selectedBtn = document.querySelector('[data-item="' + itemName + '"]');
    if (selectedBtn) {
        selectedBtn.classList.remove('border-transparent');
        selectedBtn.classList.add('border-[#f4a0a0]');
    }
}

// ============================================================
// 保存処理：選択アイテムをlocalStorageに保存してホームへ戻る
// ============================================================
function saveEquip() {
    localStorage.setItem('equippedItem', selectedItem);
    window.location.href = '/home';
}

// ============================================================
// 初期化
// ============================================================
document.addEventListener('DOMContentLoaded', function () {
    loadOwnedItems();
});