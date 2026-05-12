// ============================================================
// shop.js — ショップ画面の処理
// 配置先: public/js/shop.js
// ============================================================

document.addEventListener('DOMContentLoaded', function () {

    const confirmPopup  = document.getElementById('confirmPopup');
    const confirmClose  = document.getElementById('confirmClose');
    const confirmOverlay = document.getElementById('confirmOverlay');
    const confirmOk     = document.getElementById('confirmOk');
    const confirmMessage = document.getElementById('confirmMessage');

    // 重複送信防止フラグ
    let isSubmitting = false;
    let selectedItem  = null;
    let selectedPrice = null;

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

    // ポップアップを閉じる
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
    confirmOk.addEventListener('click', function () {
        if (isSubmitting) return;

        // 重複送信防止フラグをON
        isSubmitting = true;
        confirmOk.disabled = true;

        // TODO: バックエンド実装後にAPIを呼ぶ
        // POST /api/items/{id}/buy
        alert('この機能はバックエンド実装後に有効になります。');

        // フラグをOFFに戻す
        isSubmitting = false;
        confirmOk.disabled = false;
        closeConfirm();
    });

    // ============================================================
    // ユーザーのポイント取得
    // TODO: バックエンド実装後にAPIから取得する
    // GET /api/user
    // ============================================================
    // 現在はダミーで0を表示
    document.getElementById('userPoints').textContent = 0;

});