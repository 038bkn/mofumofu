<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>タスク登録</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: 'Hiragino Sans', 'Hiragino Kino Gothic ProN', 'Noto Sans JP', sans-serif; }
        input[type="date"], input[type="time"] { -webkit-appearance: none; appearance: none; }
        input:focus, textarea:focus { outline: none; }
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
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                <a href="/day-schedule?date={{ $dateObject->format('Y-m-d') }}"
                   class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-slate-100 transition text-slate-600 text-lg">
                    ←
                </a>
                <span class="text-base font-semibold text-slate-800">新規</span>
                <button id="saveBtn"
                        class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-slate-100 transition text-slate-600 text-lg">
                    ✓
                </button>
            </div>

            {{-- エラーメッセージ --}}
            <div id="errorMsg" class="hidden mx-5 mt-3 px-4 py-2 bg-red-50 border border-red-200 rounded-xl text-sm text-red-600"></div>

            {{-- フォーム --}}
            <div class="px-5 py-4 space-y-5">

                {{-- タイトル --}}
                <div class="border-b border-slate-100 pb-4">
                    <input type="text" id="taskTitle" placeholder="タイトル"
                           class="w-full text-base text-slate-800 placeholder-slate-300 bg-transparent border-none focus:ring-0 py-1">
                    <input type="text" id="taskLocation" placeholder="場所またはビデオ通話"
                           class="w-full text-sm text-slate-500 placeholder-slate-300 bg-transparent border-none focus:ring-0 py-1 mt-1">
                </div>

                {{-- 開始・終了 --}}
                <div class="space-y-3 border-b border-slate-100 pb-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-500">開始</span>
                        <div class="flex items-center gap-2">
                            <input type="date" id="startDate" value="{{ $dateObject->format('Y-m-d') }}"
                                   class="text-sm text-slate-700 bg-slate-100 rounded-lg px-2 py-1 border-none">
                            <input type="time" id="startTime" value="10:00"
                                   class="text-sm font-semibold text-rose-600 bg-rose-100 rounded-lg px-2 py-1 border-none">
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-500">終了</span>
                        <div class="flex items-center gap-2">
                            <input type="date" id="endDate" value="{{ $dateObject->format('Y-m-d') }}"
                                   class="text-sm text-slate-700 bg-slate-100 rounded-lg px-2 py-1 border-none">
                            <input type="time" id="endTime" value="11:00"
                                   class="text-sm font-semibold text-rose-600 bg-rose-100 rounded-lg px-2 py-1 border-none">
                        </div>
                    </div>
                </div>

                {{-- 難易度 --}}
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <span class="text-sm text-slate-500">難易度</span>
                    <div class="flex gap-1" id="difficultyStars">
                        @for ($i = 1; $i <= 5; $i++)
                            <button data-star="{{ $i }}"
                                    class="star-btn text-xl text-slate-200 hover:text-amber-400 transition">★</button>
                        @endfor
                    </div>
                </div>

                {{-- メモ --}}
                <div>
                    <textarea id="taskNote" placeholder="メモ" rows="4"
                              class="w-full text-sm text-slate-700 placeholder-slate-300 bg-slate-50 rounded-2xl px-4 py-3 border border-slate-100 resize-none focus:ring-0"></textarea>
                </div>

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
        // 難易度スター
        let difficulty = 0;

        function updateStars(count, hover = false) {
            document.querySelectorAll('.star-btn').forEach((s, i) => {
                s.style.color = i < count ? (hover ? '#fbbf24' : '#f59e0b') : '#e2e8f0';
            });
        }

        document.querySelectorAll('.star-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                difficulty = parseInt(btn.dataset.star);
                updateStars(difficulty);
            });
            btn.addEventListener('mouseover', () => updateStars(parseInt(btn.dataset.star), true));
            btn.addEventListener('mouseout',  () => updateStars(difficulty));
        });

        // 保存ボタン
        document.getElementById('saveBtn').addEventListener('click', async () => {
            const title     = document.getElementById('taskTitle').value.trim();
            const startDate = document.getElementById('startDate').value;
            const startTime = document.getElementById('startTime').value;
            const endTime   = document.getElementById('endTime').value;
            const note      = document.getElementById('taskNote').value.trim();

            if (!title) {
                showError('タイトルを入力してください');
                return;
            }

            const saveBtn = document.getElementById('saveBtn');
            saveBtn.textContent = '…';
            saveBtn.disabled = true;

            try {
                const res = await fetch('/api/tasks', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        title:      title,
                        difficulty: difficulty,
                        due_date:   startDate,
                        start_time: startTime,
                        end_time:   endTime,
                        ...(note ? { note } : {}),
                    }),
                });

                const data = await res.json();

                if (res.ok && data.status === 'success') {
                    window.location.href = `/day-schedule?date=${startDate}`;
                } else {
                    const msg = data.message || data.errors
                        ? Object.values(data.errors || {}).flat().join(' ')
                        : '登録に失敗しました。';
                    showError(msg || '登録に失敗しました。');
                    saveBtn.textContent = '✓';
                    saveBtn.disabled = false;
                }
            } catch (e) {
                showError('通信エラーが発生しました。');
                saveBtn.textContent = '✓';
                saveBtn.disabled = false;
            }
        });

        function showError(msg) {
            const el = document.getElementById('errorMsg');
            el.textContent = msg;
            el.classList.remove('hidden');
            setTimeout(() => el.classList.add('hidden'), 4000);
        }
    </script>
</body>
</html>