let currentDate = new Date();
const monthNames = ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'];

// 難易度★に応じたポイント設定
const DIFFICULTY_POINTS = { 1: 5, 2: 10, 3: 15, 4: 20, 5: 25 };

function renderCalendar() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    document.getElementById('monthDisplay').textContent = monthNames[month];
    document.getElementById('yearDisplay').textContent = year;

    const firstDay = new Date(year, month, 1).getDay();
    const lastDate = new Date(year, month + 1, 0).getDate();
    const calendarGrid = document.getElementById('calendarGrid');
    
    // 既存の日付セルを削除（ヘッダー以外）
    Array.from(calendarGrid.children).slice(7).forEach(el => el.remove());

    // 空白セル
    for (let i = 0; i < firstDay; i++) {
        const span = document.createElement('span');
        span.className = 'text-sm text-slate-400 py-2';
        calendarGrid.appendChild(span);
    }

    // 日付セル
    for (let day = 1; day <= lastDate; day++) {
        const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
        const a = document.createElement('a');
        a.href = `/day-schedule?date=${dateStr}`;
        a.className = 'text-sm text-slate-900 py-2 cursor-pointer hover:bg-slate-100 rounded font-semibold no-underline flex items-center justify-center';
        a.textContent = day;

        const today = new Date();
        if (year === today.getFullYear() && month === today.getMonth() && day === today.getDate()) {
            a.className += ' bg-rose-500 text-white hover:bg-rose-600';
        }
        calendarGrid.appendChild(a);
    }
    loadMonthTasks(year, month);
}

async function loadMonthTasks(year, month) {
    const monthStr = `${year}-${String(month + 1).padStart(2, '0')}`;
    try {
        const response = await fetch(`/api/tasks?month=${monthStr}`, {
            headers: { 'Accept': 'application/json' }
        });
        const json = await response.json();
        const tasks = (json.status === 'success' && Array.isArray(json.data)) ? json.data : [];
        
        // status 1 が完了済み
        renderTodoList(tasks.filter(t => Number(t.status) !== 1));
        renderCompletedList(tasks.filter(t => Number(t.status) === 1));
    } catch (e) {
        console.error('Fetch error:', e);
    }
}

function renderTodoList(tasks) {
    const container = document.getElementById('todoList');
    container.innerHTML = tasks.length === 0 ? '<div class="p-3 text-slate-400">予定がありません</div>' : '';

    const today = new Date().toISOString().split('T')[0];

    tasks.forEach(task => {
        const isOverdue = task.due_date < today;
        const item = document.createElement('div');
        item.className = isOverdue
            ? 'rounded-2xl bg-rose-50 border border-rose-200 p-3 flex items-center justify-between mb-2 shadow-sm'
            : 'rounded-2xl bg-slate-50 border border-slate-200 p-3 flex items-center justify-between mb-2 shadow-sm';
        item.innerHTML = `
            <div class="flex items-center gap-3 flex-1 min-w-0">
                <input type="checkbox" class="w-6 h-6 rounded border-slate-300 text-rose-500 task-check cursor-pointer">
                <div class="flex flex-col flex-1 min-w-0 cursor-pointer task-link">
                    <span class="text-sm font-bold ${isOverdue ? 'text-rose-600' : 'text-slate-800'} truncate">${task.title}</span>
                    <span class="text-[10px] ${isOverdue ? 'text-rose-400' : 'text-amber-500'} font-bold">
                        ${isOverdue ? '期日切れ · ' : ''}★${task.difficulty || 1}
                    </span>
                </div>
            </div>
            <span class="text-xs ${isOverdue ? 'text-rose-400' : 'text-slate-400'} ml-2">${task.due_date.split('-').slice(1).join('/')}</span>
        `;
        
        // チェックボックスで更新
        item.querySelector('.task-check').addEventListener('change', () => updateTaskStatus(task));
        item.querySelector('.task-link').addEventListener('click', () => {
            window.location.href = `/task/detail?id=${task.id}&date=${task.due_date}`;
        });
        container.appendChild(item);
    });
}

async function updateTaskStatus(task) {
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    try {
        const response = await fetch(`/api/tasks/${task.id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({ _method: 'PUT', status: 1 })
        });

        if (response.ok) {
            // --- 修正部分 ---
            // サーバー側でポイントが加算されているため、フロントでの足し算は削除します。
            // 代わりに、最新の正しいポイントをAPIから取得して同期します。
            try {
                const userResponse = await fetch('/api/user', {
                    headers: { 'Accept': 'application/json' }
                });
                if (userResponse.ok) {
                    const userJson = await userResponse.json();
                    if (userJson.status === 'success' && userJson.points !== undefined) {
                        // サーバーの正確な値でローカルストレージを更新
                        localStorage.setItem('total_points', userJson.points);
                    }
                }
            } catch (userError) {
                console.error('最新ポイントの同期に失敗しました:', userError);
            }
            
            renderCalendar(); // カレンダー画面の更新
            // ----------------
        } else {
            showToast('更新に失敗しました。', 'error');
        }
    } catch (e) {
        showToast('ネットワークエラーが発生しました。', 'error');
    }
}

function renderCompletedList(tasks) {
    const container = document.getElementById('completedList');
    container.innerHTML = tasks.length === 0 ? '<p class="text-sm text-slate-400">完了済みはありません</p>' : '';

    tasks.forEach(task => {
        const item = document.createElement('div');
        item.className = 'rounded-2xl bg-white border border-slate-200 p-3 flex items-center justify-between opacity-60 mb-2 cursor-pointer hover:opacity-80 transition';
        item.innerHTML = `
            <div class="flex items-center gap-2 truncate">
                <span class="text-emerald-500 font-bold">✓</span>
                <span class="text-sm text-slate-400 line-through">${task.title}</span>
            </div>
            <span class="text-xs text-slate-400 ml-2 flex-shrink-0">${task.due_date.split('-').slice(1).join('/')}</span>
        `;
        item.addEventListener('click', () => {
            window.location.href = `/task/detail?id=${task.id}&date=${task.due_date}`;
        });
        container.appendChild(item);
    });
}

document.getElementById('prevBtn').addEventListener('click', () => { currentDate.setMonth(currentDate.getMonth() - 1); renderCalendar(); });
document.getElementById('nextBtn').addEventListener('click', () => { currentDate.setMonth(currentDate.getMonth() + 1); renderCalendar(); });
document.addEventListener('DOMContentLoaded', renderCalendar);