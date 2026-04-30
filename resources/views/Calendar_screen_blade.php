<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>カレンダー</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 text-slate-900 font-sans">
    <div class="min-h-screen flex flex-col items-center p-4 gap-4">
        <div class="w-full max-w-xl bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">
            <div class="bg-rose-100 px-6 py-5">
                <h1 class="text-center text-2xl font-semibold text-slate-800">カレンダー</h1>
            </div>
            <div class="p-5">
                <div class="rounded-3xl border border-slate-200 overflow-hidden">
                    <div class="bg-slate-100 px-5 py-4 border-b border-slate-200 flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500" id="monthDisplay">4月</p>
                            <p class="text-xl font-semibold text-slate-900" id="yearDisplay">2026</p>
                        </div>
                        <div class="flex gap-2">
                            <button id="prevBtn" class="w-10 h-10 rounded-2xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50">‹</button>
                            <button id="nextBtn" class="w-10 h-10 rounded-2xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50">›</button>
                        </div>
                    </div>
                    <div class="grid grid-cols-7 gap-2 p-4 text-center" id="calendarGrid">
                        <span class="text-xs font-semibold uppercase text-slate-400">日</span>
                        <span class="text-xs font-semibold uppercase text-slate-400">月</span>
                        <span class="text-xs font-semibold uppercase text-slate-400">火</span>
                        <span class="text-xs font-semibold uppercase text-slate-400">水</span>
                        <span class="text-xs font-semibold uppercase text-slate-400">木</span>
                        <span class="text-xs font-semibold uppercase text-slate-400">金</span>
                        <span class="text-xs font-semibold uppercase text-slate-400">土</span>
                    </div>
                </div>

                <div class="mt-6 grid gap-4">
                    <div class="rounded-3xl border border-slate-200 p-4">
                        <h2 class="text-lg font-semibold text-slate-900 mb-3">ToDo</h2>
                        <div class="space-y-3 text-sm text-slate-700" id="todoList">
                            <div class="rounded-2xl bg-slate-50 border border-slate-200 p-3">予定がありません</div>
                        </div>
                    </div>
                    <div class="rounded-3xl border border-slate-200 p-4 bg-slate-50">
                        <h2 class="text-lg font-semibold text-slate-900 mb-3">完了</h2>
                        <p class="text-sm text-slate-500">完了した予定はここに表示されます。</p>
                    </div>
                </div>
            </div>
        </div>

        <nav class="w-full max-w-xl bg-white rounded-3xl shadow-inner border border-slate-200 px-5 py-4">
            <div class="flex justify-between items-center text-slate-600">
                <button class="flex flex-col items-center gap-1 text-slate-900">
                    <span class="text-2xl">💬</span>
                    <span class="text-xs">ひとりごと</span>
                </button>
                <button class="flex flex-col items-center gap-1">
                    <span class="text-2xl">🏠</span>
                    <span class="text-xs">ホーム</span>
                </button>
                <button class="flex flex-col items-center gap-1 text-slate-900">
                    <span class="text-2xl">📅</span>
                    <span class="text-xs">ToDo</span>
                </button>
                <button class="flex flex-col items-center gap-1">
                    <span class="text-2xl">⚙️</span>
                    <span class="text-xs">設定</span>
                </button>
            </div>
        </nav>
    </div>

    <script>
        let currentDate = new Date(2026, 3, 1);
        const monthNames = ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'];

        function renderCalendar() {
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            document.getElementById('monthDisplay').textContent = monthNames[month];
            document.getElementById('yearDisplay').textContent = year;

            const firstDay = new Date(year, month, 1).getDay();
            const lastDate = new Date(year, month + 1, 0).getDate();
            const calendarGrid = document.getElementById('calendarGrid');
            const dayElements = Array.from(calendarGrid.children).slice(7);
            dayElements.forEach(el => el.remove());

            for (let i = 0; i < firstDay; i++) {
                const span = document.createElement('span');
                span.className = 'text-sm text-slate-400 py-2';
                calendarGrid.appendChild(span);
            }

            for (let day = 1; day <= lastDate; day++) {
                const span = document.createElement('span');
                span.className = 'text-sm text-slate-900 py-2 cursor-pointer hover:bg-slate-100 rounded';
                span.textContent = day;
                span.addEventListener('click', () => alert(`${year}年${month + 1}月${day}日`));
                calendarGrid.appendChild(span);
            }

            const totalCells = (firstDay + lastDate) % 7;
            if (totalCells !== 0) {
                for (let i = 0; i < 7 - totalCells; i++) {
                    const span = document.createElement('span');
                    span.className = 'text-sm text-slate-400 py-2';
                    calendarGrid.appendChild(span);
                }
            }
        }

        document.getElementById('prevBtn').addEventListener('click', () => {
            const newDate = new Date(currentDate.getFullYear(), currentDate.getMonth() - 1, 1);
            if (newDate.getFullYear() >= 2000) {
                currentDate = newDate;
                renderCalendar();
            }
        });

        document.getElementById('nextBtn').addEventListener('click', () => {
            const newDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 1);
            if (newDate.getFullYear() <= 2030) {
                currentDate = newDate;
                renderCalendar();
            }
        });

        document.addEventListener('DOMContentLoaded', () => renderCalendar());
    </script>
</body>
</html>
