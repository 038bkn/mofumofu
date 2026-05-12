// ============================================================
// collection.js — コレクション画面の処理
// 配置先: public/js/collection.js
// ============================================================

// Blade側のasset()で生成したベースURLを使用
// collection.blade.phpのmeta[name="base-url"]から取得
const BASE_URL = '';
// with_sheepフォルダーのファイル名マッピング
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

let selectedItem = 'none';

// ============================================================
// アイテム選択
// ============================================================
function selectItem(itemName) {
    selectedItem = itemName;

    // キャラクター画像を切り替え（asset()ベースURLを使用）
    const characterImg = document.getElementById('characterImg');
    if (itemName === 'none' || !FILE_NAME_MAP[itemName]) {
        characterImg.src = BASE_URL + '/images/sheep.png';
    } else {
        const fileName = FILE_NAME_MAP[itemName];
        characterImg.src = BASE_URL + '/images/with_sheep/' + fileName;
    }

    // 選択中のアイテムにボーダーをつける
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
// 保存処理
// ============================================================
function saveEquip() {
    // TODO: バックエンド実装後にAPIを呼ぶ
    // PUT /api/user/items/{id}/equip
    alert('この機能はバックエンド実装後に有効になります。');
}

// ============================================================
// 初期化
// ============================================================
document.addEventListener('DOMContentLoaded', function () {
    selectItem('none');
});