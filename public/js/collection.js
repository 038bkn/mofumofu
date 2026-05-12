// ============================================================
// collection.js — コレクション画面の処理
// 配置先: public/js/collection.js
// ============================================================

// with_sheepフォルダーに存在するアイテム一覧
// ※ with_sheepにない場合はsheep.png（装備なし）のまま
const WITH_SHEEP_ITEMS = [
    'bell', 'doll_boy', 'doll_girl', 'rainy', 'ribbon',
    'sunglasses', 'valentine', 'dango', 'hat', 'helmet_blue',
    'helmet_red', 'sakura', 'sunflower', 'tanabata_man',
    'tanabata_woman', 'tophat'
];

// with_sheepフォルダーのファイル名マッピング
// スペースありのファイル名に対応
const FILE_NAME_MAP = {
    'bell':          's_ bell.png',
    'doll_boy':      's_ doll_boy.png',
    'doll_girl':     's_ doll_girl.png',
    'rainy':         's_ rainy.png',
    'ribbon':        's_ ribbon.png',
    'sunglasses':    's_ sunglasses.png',
    'valentine':     's_ valentine.png',
    'dango':         's_dango.png',
    'hat':           's_hat.png',
    'helmet_blue':   's_helmet_blue.png',
    'helmet_red':    's_helmet_red.png',
    'sakura':        's_sakura.png',
    'sunflower':     's_sunflower.png',
    'tanabata_man':  's_tanabata_man.png',
    'tanabata_woman':'s_tanabata_woman.png',
    'tophat':        's_tophat.png',
};

let selectedItem = 'none';

// ============================================================
// アイテム選択
// ============================================================
function selectItem(itemName) {
    selectedItem = itemName;

    // キャラクター画像を切り替え
    const characterImg = document.getElementById('characterImg');
    if (itemName === 'none' || !FILE_NAME_MAP[itemName]) {
        characterImg.src = '/images/sheep.png';
    } else {
        const fileName = FILE_NAME_MAP[itemName];
        characterImg.src = '/images/with_sheep/' + fileName;
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
    // 現在はセッションに保存して前の画面へ戻る
    window.history.back();
}

// ============================================================
// 初期化
// ============================================================
document.addEventListener('DOMContentLoaded', function () {
    // デフォルトは「なし」を選択状態にする
    selectItem('none');
});