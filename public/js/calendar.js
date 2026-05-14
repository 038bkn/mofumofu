let currentDate = new Date();
const monthNames = ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'];

// ────────────────────────────────────────────────
// カレンダー描画
// ────────────────────────────────────────────────
function renderCalendar() {
    const year  = currentDate.getFullYear();
    const month = currentDate.getMonth();

    document.getElementById('monthDisplay').textContent = monthNames[month];
    document.getElementById('yearDisplay').textContent  = year;

    const firstDay     = new Date(year, month, 1).getDay();
    const lastDate     = new Date(year, month + 1, 0).getDate();
    const calendarGrid = document.getElementById('calendarGrid');

    // ヘッダー行（曜日）以外を削除
    Array.from(calendarGrid.children).slice(7).forEach(el => el.remove());

    // 月初前の空白
    for (let i = 0; i < firstDay; i++) {
        const span = document.createElement('span');
        span.className = 'text-sm text-slate-400 py-2';
        calendarGrid.appendChild(span);
    }

    // 日付セル
    for (let day = 1; day <= lastDate; day++) {
        const span = document.createElement('span');
        span.className = 'text-sm text-slate-900 py-2 cursor-pointer hover:bg-slate-100 rounded';
        span.textContent = day;
        span.addEventListener('click', () => {
            const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            window.location.href = `/day-schedule?date=${dateStr}`;
        });
        calendarGrid.appendChild(span);
    }

    // 末尾の空白（6行揃え）
    const totalCells = (firstDay + lastDate) % 7;
    if (totalCells !== 0) {
        for (let i = 0; i < 7 - totalCells; i++) {
            const span = document.createElement('span');
            span.className = 'text-sm text-slate-400 py-2';
            calendarGrid.appendChild(span);
        }
    }

    loadMonthTasks(year, month);
}

// ────────────────────────────────────────────────
// API から該当月のタスクを取得して表示
// ────────────────────────────────────────────────
async function loadMonthTasks(year, month) {
    const monthStr = `${year}-${String(month + 1).padStart(2, '0')}`;

    let tasks = [];
    try {
        const response = await fetch(`/api/tasks?month=${monthStr}`, {
            headers: { 'Accept': 'application/json' },
        });
        const json = await response.json();

        if (!response.ok || json.status !== 'success') {
            renderError(json.message || 'タスクの取得に失敗しました。');
            return;
        }
        tasks = Array.isArray(json.data) ? json.data : [];
    } catch (e) {
        renderError('通信エラーが発生しました。');
        return;
    }

    const now = new Date();
    const todoList      = [];
    const completedList = [];

    tasks.forEach(task => {
        const isDone = Number(task.status) === 1;

        // 終了日時を組み立て（due_date + end_time）
        const endDatetime = task.due_date && task.end_time
            ? new Date(`${task.due_date}T${task.end_time}`)
            : null;

        if (isDone) {
            // status=1（明示的に完了済み）→ 完了欄
            completedList.push(task);
        } 
            else {
            // それ以外（未完了 or 終了時間未到達）→ ToDo欄
            todoList.push(task);
        }
    });

    todoList.sort((a, b)      => sortKey(a).localeCompare(sortKey(b)));
    completedList.sort((a, b) => sortKey(a).localeCompare(sortKey(b)));

    renderTodoList(todoList);
    renderCompletedList(completedList);
}

function renderError(message) {
    const todo      = document.getElementById('todoList');
    const completed = document.getElementById('completedList');
    if (todo) {
        todo.innerHTML = `<div class="rounded-2xl bg-rose-50 border border-rose-200 p-3 text-sm text-rose-600">${escHtml(message)}</div>`;
    }
    if (completed) completed.innerHTML = '';
}

function sortKey(task) {
    return `${task.due_date || ''}T${task.start_time || '00:00'}`;
}

// ────────────────────────────────────────────────
// ToDo リスト描画
// ────────────────────────────────────────────────
function renderTodoList(tasks) {
    const container = document.getElementById('todoList');
    container.innerHTML = '';

    if (tasks.length === 0) {
        container.innerHTML = `
            <div class="rounded-2xl bg-slate-50 border border-slate-200 p-3 text-slate-400">
                予定がありません
            </div>`;
        return;
    }

    tasks.forEach(task => {
        const item = document.createElement('div');
        item.className = 'rounded-2xl bg-slate-50 border border-slate-200 p-3 flex items-center justify-between cursor-pointer hover:bg-slate-100 transition';
        item.innerHTML = `
            <div class="flex items-center gap-2 min-w-0">
                <span class="text-slate-400 flex-shrink-0">○</span>
                <span class="text-sm font-medium text-slate-800 truncate">${escHtml(task.title)}</span>
            </div>
            <span class="text-xs text-slate-400 flex-shrink-0 ml-2">${formatDate(task.due_date)}</span>
        `;
        item.addEventListener('click', () => {
            window.location.href = `/task/detail?id=${task.id}&date=${task.due_date}`;
        });
        container.appendChild(item);
    });
}

// ────────────────────────────────────────────────
// 完了リスト描画
// ────────────────────────────────────────────────
function renderCompletedList(tasks) {
    const container = document.getElementById('completedList');
    container.innerHTML = '';

    if (tasks.length === 0) {
        container.innerHTML = `<p class="text-sm text-slate-400">完了した予定はここに表示されます。</p>`;
        return;
    }

    tasks.forEach(task => {
        const item = document.createElement('div');
        item.className = 'rounded-2xl bg-white border border-slate-200 p-3 flex items-center justify-between';
        item.innerHTML = `
            <div class="flex items-center gap-2 min-w-0">
                <span class="text-emerald-400 flex-shrink-0">✓</span>
                <span class="text-sm text-slate-400 line-through truncate">${escHtml(task.title)}</span>
            </div>
            <span class="text-xs text-slate-400 flex-shrink-0 ml-2">${formatDate(task.due_date)}</span>
        `;
        container.appendChild(item);
    });
}

// ────────────────────────────────────────────────
// ユーティリティ
// ────────────────────────────────────────────────
function escHtml(str) {
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}

function formatDate(dateStr) {
    if (!dateStr) return '';
    const [, m, d] = dateStr.split('-');
    return `${parseInt(m)}/${parseInt(d)}`;
}

// ────────────────────────────────────────────────
// ナビボタン
// ────────────────────────────────────────────────
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