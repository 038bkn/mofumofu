<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>タスク詳細</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Hiragino Sans', 'Hiragino Kino Gothic ProN', 'Noto Sans JP', sans-serif; }

        /* 完了演出 */
        #pointToast {
            position: fixed; left: 50%; top: 50%;
            transform: translate(-50%, -50%) scale(0.8);
            background: linear-gradient(135deg, #f59e0b, #f97316);
            color: white; padding: 20px 32px; border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            opacity: 0; pointer-events: none;
            transition: opacity 0.3s, transform 0.3s;
            z-index: 50; text-align: center;
        }
        #pointToast.show {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1);
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-900">
    @php
        use Carbon\Carbon;
        $dateObject = Carbon::parse($date);
    @endphp

    <div class="min-h-screen flex flex-col items-center p-4 gap-4">
        <div class="w-full max-w-xl bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">

            {{-- ヘッダー --}}
            <div class="flex items-center justify-between px-5 py-4">
                <a href="/day-schedule?date={{ $dateObject->format('Y-m-d') }}"
                   class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-slate-100 transition text-slate-600 text-lg">
                    ←
                </a>
                <span class="text-base font-semibold text-slate-800">詳細</span>
                <div class="w-9"></div>
            </div>

            {{-- タスク詳細カード --}}
            <div class="mx-5 mb-5 bg-slate-50 rounded-2xl p-5 border border-slate-100">
                <div id="taskContent" class="space-y-3">
                    <div class="text-sm text-slate-300 text-center py-4">読み込み中…</div>
                </div>
            </div>

            {{-- アクションボタン --}}
            <div class="px-5 pb-6 flex justify-center gap-3">
                <button id="completeBtn" type="button"
                        class="hidden px-8 py-3 bg-emerald-400 hover:bg-emerald-500 active:bg-emerald-600 text-white text-sm font-semibold rounded-full shadow transition">
                    完了にする
                </button>
                <button id="deleteBtn" type="button"
                        class="px-8 py-3 bg-rose-400 hover:bg-rose-500 active:bg-rose-600 text-white text-sm font-semibold rounded-full shadow transition">
                    予定を削除
                </button>
            </div>

        </div>

        {{-- ボトムナビ --}}
        <nav class="w-full max-w-xl bg-white rounded-3xl shadow border border-slate-200 px-6 py-3">
            <div class="flex justify-between items-center">
                <button class="flex flex-col items-center gap-1 text-slate-400 hover:text-slate-600 transition">
                    <span class="text-2xl">💬</span><span class="text-xs">ひとりごと</span>
                </button>
                <button class="flex flex-col items-center gap-1 text-slate-400 hover:text-slate-600 transition">
                    <span class="text-2xl">🏠</span><span class="text-xs">ホーム</span>
                </button>
                <button class="flex flex-col items-center gap-1 text-slate-900">
                    <span class="text-2xl">📅</span><span class="text-xs font-semibold">ToDo</span>
                </button>
                <button class="flex flex-col items-center gap-1 text-slate-400 hover:text-slate-600 transition">
                    <span class="text-2xl">⚙️</span><span class="text-xs">設定</span>
                </button>
            </div>
        </nav>
    </div>

    {{-- ポイント獲得トースト --}}
    <div id="pointToast">
        <div class="text-2xl font-bold mb-1">🎉 タスク完了！</div>
        <div class="text-lg">+<span id="earnedPoints">0</span> pt</div>
        <div class="text-xs mt-1 opacity-90">合計 <span id="totalPoints">0</span> pt</div>
    </div>

    <script>
        const params       = new URLSearchParams(location.search);
        const taskId       = params.get('id');
        const scheduleDate = "{{ $dateObject->format('Y-m-d') }}";
        const weekDays     = ['日', '月', '火', '水', '木', '金', '土'];

        function escHtml(str) {
            return String(str)
                .replace(/&/g, '&amp;').replace(/</g, '&lt;')
                .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        }

        function getCsrfToken() {
            const meta = document.querySelector('meta[name="csrf-token"]');
            return meta ? meta.content : '';
        }

        // API からタスクを取得して表示
        async function loadTask() {
            if (!taskId) {
                showError('タスクIDが指定されていません。');
                return;
            }

            try {
                const response = await fetch(`/api/tasks/${taskId}`, {
                    headers: { 'Accept': 'application/json' },
                });
                const json = await response.json();

                if (!response.ok || json.status !== 'success') {
                    showError(json.message || 'タスクが見つかりません。');
                    return;
                }
                renderTask(json.data);
            } catch (e) {
                showError('通信エラーが発生しました。');
            }
        }

        function renderTask(task) {
            const dueDate = (task.due_date || '').slice(0, 10);
            const d       = dueDate ? new Date(dueDate + 'T00:00:00') : null;
            const dow     = d ? weekDays[d.getDay()] : '';
            const dateStr = dueDate ? `${dueDate.replace(/-/g, '/')} ${dow}曜日` : '';

            const filled  = Number(task.difficulty) || 0;
            const stars   = '★'.repeat(filled) + '☆'.repeat(5 - filled);

            const startStr = (task.start_time || '').slice(0, 5);
            const endStr   = (task.end_time   || '').slice(0, 5);
            const timeStr  = startStr && endStr ? `${startStr} － ${endStr}` : startStr;

            const isDone = Number(task.status) === 1;

            document.getElementById('taskContent').innerHTML = `
                <h2 class="text-base font-bold ${isDone ? 'text-slate-400 line-through' : 'text-slate-800'}">${escHtml(task.title)}</h2>
                <div class="text-sm text-slate-500 space-y-1">
                    ${dateStr ? `<p>${escHtml(dateStr)}</p>` : ''}
                    <p>難易度　<span class="text-amber-400 tracking-widest">${stars}</span></p>
                    ${timeStr ? `<p class="text-slate-600 font-medium">${escHtml(timeStr)}</p>` : ''}
                    ${task.location ? `<p>📍 ${escHtml(task.location)}</p>` : ''}
                    ${isDone ? `<p class="text-emerald-500 font-semibold">✓ 完了済み</p>` : ''}
                </div>
                ${task.note
                    ? `<p class="text-sm text-slate-600 mt-2 whitespace-pre-wrap">${escHtml(task.note)}</p>`
                    : '<p class="text-sm text-slate-300 mt-2">メモなし</p>'}
            `;

            // 未完了なら「完了にする」ボタンを表示
            if (!isDone) {
                document.getElementById('completeBtn').classList.remove('hidden');
            }
        }

        function showError(msg) {
            document.getElementById('taskContent').innerHTML =
                `<p class="text-sm text-red-400 text-center py-4">${escHtml(msg)}</p>`;
        }

        // 完了演出
        function showPointToast(earned, total) {
            document.getElementById('earnedPoints').textContent = earned;
            document.getElementById('totalPoints').textContent  = total;
            const toast = document.getElementById('pointToast');
            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
                window.location.href = `/day-schedule?date=${scheduleDate}`;
            }, 1800);
        }

        // 完了処理
        document.getElementById('completeBtn').addEventListener('click', async () => {
            if (!taskId) return;

            const btn = document.getElementById('completeBtn');
            btn.disabled = true;

            try {
                const response = await fetch(`/api/tasks/${taskId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ status: 1 }),
                });
                const json = await response.json();

                if (response.ok && json.status === 'success') {
                    showPointToast(json.earned_points ?? 0, json.total_points ?? 0);
                    return;
                }

                alert(json.message || '完了に失敗しました。');
            } catch (e) {
                alert('通信エラーが発生しました。');
            } finally {
                btn.disabled = false;
            }
        });

        // 削除処理
        document.getElementById('deleteBtn').addEventListener('click', async () => {
            if (!taskId) { alert('タスクIDが取得できませんでした。'); return; }
            if (!confirm('この予定を削除しますか？')) return;

            try {
                const response = await fetch(`/api/tasks/${taskId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'Accept': 'application/json',
                    },
                });
                const json = await response.json();

                if (response.ok && json.status === 'success') {
                    window.location.href = `/day-schedule?date=${scheduleDate}`;
                    return;
                }

                alert(json.message || '削除に失敗しました。');
            } catch (e) {
                alert('通信エラーが発生しました。');
            }
        });

        loadTask();
    </script>
</body>
</html>
