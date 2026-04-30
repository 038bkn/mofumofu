let currentDate = new Date(2026, 3, 1); // 2026年4月1日

const monthNames = ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'];

function renderCalendar() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();

    // 年月を表示
    document.getElementById('monthDisplay').textContent = monthNames[month];
    document.getElementById('yearDisplay').textContent = year;

    // 月の最初の日と日数を取得
    const firstDay = new Date(year, month, 1).getDay();
    const lastDate = new Date(year, month + 1, 0).getDate();

    // カレンダーグリッドを初期化（曜日ヘッダーは残す）
    const calendarGrid = document.getElementById('calendarGrid');
    const dayElements = Array.from(calendarGrid.children).slice(7); // 最初の7つ（曜日）を除外
    dayElements.forEach(el => el.remove());

    // 前月の空白を追加
    for (let i = 0; i < firstDay; i++) {
        const span = document.createElement('span');
        span.className = 'text-sm text-slate-400 py-2';
        span.textContent = '';
        calendarGrid.appendChild(span);
    }

    // 当月の日付を追加
    for (let day = 1; day <= lastDate; day++) {
        const span = document.createElement('span');
        span.className = 'text-sm text-slate-900 py-2 cursor-pointer hover:bg-slate-100 rounded';
        span.textContent = day;
        span.addEventListener('click', () => {
            alert(`${year}年${month + 1}月${day}日が選択されました`);
        });
        calendarGrid.appendChild(span);
    }

    // 次月の空白を追加
    const totalCells = (firstDay + lastDate) % 7;
    if (totalCells !== 0) {
        const emptyDays = 7 - totalCells;
        for (let i = 0; i < emptyDays; i++) {
            const span = document.createElement('span');
            span.className = 'text-sm text-slate-400 py-2';
            span.textContent = '';
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

// ページ読み込み完了後に初期表示
document.addEventListener('DOMContentLoaded', function() {
    renderCalendar();
});
