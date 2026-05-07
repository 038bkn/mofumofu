<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>タスク詳細</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Hiragino Sans', 'Hiragino Kino Gothic ProN', 'Noto Sans JP', sans-serif; }
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

            {{-- 削除ボタン --}}
            <div class="px-5 pb-6 flex justify-center">
                <button id="deleteBtn"
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

        // localStorageからタスクを読み込んで表示
        function loadTask() {
            if (!taskId) {
                showError('タスクIDが指定されていません。');
                return;
            }

            const tasks = JSON.parse(localStorage.getItem('tasks') || '[]');
            const task  = tasks.find(t => String(t.id) === String(taskId));

            if (!task) {
                showError('タスクが見つかりません。');
                return;
            }

            renderTask(task);
        }

        function renderTask(task) {
            const d       = new Date(task.due_date + 'T00:00:00');
            const dow     = weekDays[d.getDay()];
            const dateStr = `${task.due_date.replace(/-/g, '/')} ${dow}曜日`;

            const filled  = task.difficulty || 0;
            const stars   = '★'.repeat(filled) + '☆'.repeat(5 - filled);

            const startStr = (task.start_time || '').slice(0, 5);
            const endStr   = (task.end_time   || '').slice(0, 5);
            const timeStr  = startStr && endStr ? `${startStr} － ${endStr}` : startStr;

            document.getElementById('taskContent').innerHTML = `
                <h2 class="text-base font-bold text-slate-800">${escHtml(task.title)}</h2>
                <div class="text-sm text-slate-500 space-y-1">
                    <p>${escHtml(dateStr)}</p>
                    <p>難易度　<span class="text-amber-400 tracking-widest">${stars}</span></p>
                    ${timeStr ? `<p class="text-slate-600 font-medium">${escHtml(timeStr)}</p>` : ''}
                </div>
                ${task.note
                    ? `<p class="text-sm text-slate-600 mt-2 whitespace-pre-wrap">${escHtml(task.note)}</p>`
                    : '<p class="text-sm text-slate-300 mt-2">メモなし</p>'}
            `;
        }

        function showError(msg) {
            document.getElementById('taskContent').innerHTML =
                `<p class="text-sm text-red-400 text-center py-4">${escHtml(msg)}</p>`;
        }

        // 削除処理
        document.getElementById('deleteBtn').addEventListener('click', () => {
            if (!taskId) { alert('タスクIDが取得できませんでした。'); return; }
            if (!confirm('この予定を削除しますか？')) return;

            const tasks   = JSON.parse(localStorage.getItem('tasks') || '[]');
            const updated = tasks.filter(t => String(t.id) !== String(taskId));
            localStorage.setItem('tasks', JSON.stringify(updated));

            window.location.href = `/day-schedule?date=${scheduleDate}`;
        });

        loadTask();
    </script>
</body>
</html>