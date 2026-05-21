(function () {
    const style = document.createElement('style');
    style.textContent = `
        #_toast {
            position: fixed;
            top: 24px;
            left: 50%;
            transform: translateX(-50%) translateY(-12px);
            padding: 12px 28px;
            border-radius: 9999px;
            font-weight: 700;
            font-size: 14px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            z-index: 9999;
            opacity: 0;
            transition: opacity 0.25s ease, transform 0.25s ease;
            pointer-events: none;
            white-space: nowrap;
            max-width: calc(100vw - 48px);
            text-align: center;
            font-family: 'Hiragino Sans', 'Noto Sans JP', sans-serif;
        }
        #_toast.visible {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
        #_toast.success { background: #4ade80; color: #fff; }
        #_toast.error   { background: #f87171; color: #fff; }
        #_toast.info    { background: #334155; color: #fff; }

        #_confirm_overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.35);
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.2s ease;
        }
        #_confirm_overlay.visible { opacity: 1; }
        #_confirm_box {
            background: #fff;
            border-radius: 24px;
            padding: 28px 24px 20px;
            width: calc(100vw - 64px);
            max-width: 320px;
            text-align: center;
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
            transform: translateY(12px);
            transition: transform 0.2s ease;
            font-family: 'Hiragino Sans', 'Noto Sans JP', sans-serif;
        }
        #_confirm_overlay.visible #_confirm_box { transform: translateY(0); }
        #_confirm_msg {
            font-weight: 700;
            font-size: 16px;
            color: #1e293b;
            margin-bottom: 20px;
        }
        #_confirm_btns {
            display: flex;
            gap: 10px;
        }
        #_confirm_cancel {
            flex: 1;
            padding: 12px;
            border-radius: 9999px;
            border: 1.5px solid #e2e8f0;
            background: #fff;
            font-weight: 700;
            font-size: 14px;
            color: #64748b;
            cursor: pointer;
        }
        #_confirm_ok {
            flex: 1;
            padding: 12px;
            border-radius: 9999px;
            border: none;
            background: #f87171;
            font-weight: 700;
            font-size: 14px;
            color: #fff;
            cursor: pointer;
        }
    `;
    document.head.appendChild(style);

    let timer = null;

    window.showToast = function (message, type) {
        type = type || 'info';

        const existing = document.getElementById('_toast');
        if (existing) {
            clearTimeout(timer);
            existing.remove();
        }

        const toast = document.createElement('div');
        toast.id = '_toast';
        toast.className = type;
        toast.textContent = message;
        document.body.appendChild(toast);

        requestAnimationFrame(function () {
            requestAnimationFrame(function () {
                toast.classList.add('visible');
            });
        });

        timer = setTimeout(function () {
            toast.classList.remove('visible');
            setTimeout(function () {
                if (toast.parentNode) toast.remove();
            }, 300);
        }, 3000);
    };

    window.showConfirm = function (message, onOk, okLabel, cancelLabel) {
        okLabel     = okLabel     || '削除する';
        cancelLabel = cancelLabel || 'キャンセル';

        const overlay = document.createElement('div');
        overlay.id = '_confirm_overlay';
        overlay.innerHTML = `
            <div id="_confirm_box">
                <p id="_confirm_msg">${message}</p>
                <div id="_confirm_btns">
                    <button id="_confirm_cancel">${cancelLabel}</button>
                    <button id="_confirm_ok">${okLabel}</button>
                </div>
            </div>
        `;
        document.body.appendChild(overlay);

        requestAnimationFrame(function () {
            requestAnimationFrame(function () {
                overlay.classList.add('visible');
            });
        });

        function close() {
            overlay.classList.remove('visible');
            setTimeout(function () {
                if (overlay.parentNode) overlay.remove();
            }, 200);
        }

        overlay.querySelector('#_confirm_cancel').addEventListener('click', close);
        overlay.querySelector('#_confirm_ok').addEventListener('click', function () {
            close();
            onOk();
        });
        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) close();
        });
    };
}());
