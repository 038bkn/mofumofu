let currentDate = new Date();
const monthNames = ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'];

// 難易度ごとのポイント設定
const DIFFICULTY_POINTS = { 1: 5, 2: 10, 3: 15, 4: 20, 5: 25 };

function renderCalendar() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    document.getElementById('monthDisplay').textContent = monthNames[month];
    document.getElementById('yearDisplay').textContent = year;
    const firstDay = new Date(year, month, 1).getDay();
    const lastDate = new Date(year, month + 1, 0).getDate();
    const calendarGrid = document.getElementById('calendarGrid');
    Array.from(calendarGrid.children).slice(7).forEach(el => el.remove());
    for (let i = 0; i < firstDay; i++) {
        const span = document.createElement('span');
        span.className = 'text-sm text-slate-400 py-2';
        calendarGrid.appendChild(span);
    }
    for (let day = 1; day <= lastDate; day++) {
        const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
        const a = document.createElement('a');
        a.href = `/day-schedule?date=${dateStr}`;
        a.className = 'text-sm text-slate-900 py-2 cursor-pointer hover:bg-slate-100 rounded font-semibold no-underline flex items-center justify-center';
        a.textContent = day;
        const today = new Date();
        if (year === today.getFullYear() && month === today.getMonth() && day === today.getDate()) {
            a.className += ' bg-rose-500 text-white';
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
        renderTodoList(tasks.filter(t => Number(t.status) !== 1));
        renderCompletedList(tasks.filter(t => Number(t.status) === 1));
    } catch (e) { console.error('Fetch error'); }
}

function renderTodoList(tasks) {
    const container = document.getElementById('todoList');
    container.innerHTML = tasks.length === 0 ? '<div class="p-3 text-slate-400">予定がありません</div>' : '';
    tasks.forEach(task => {
        const item = document.createElement('div');
        item.className = 'rounded-2xl bg-slate-50 border border-slate-200 p-3 flex items-center justify-between mb-2';
        item.innerHTML = `
            <div class="flex items-center gap-3 flex-1 min-w-0">
                <input type="checkbox" class="w-5 h-5 rounded border-slate-300 text-rose-500 task-check">
                <div class="flex flex-col flex-1 min-w-0 cursor-pointer task-link">
                    <span class="text-sm font-medium text-slate-800 truncate">${task.title}</span>
                    <span class="text-[10px] text-amber-500">★${task.difficulty || 1}</span>
                </div>
            </div>
            <span class="text-xs text-slate-400 ml-2">${task.due_date.split('-').slice(1).join('/')}</span>
        `;
        item.querySelector('.task-check').addEventListener('change', () => updateTaskStatus(task));
        item.querySelector('.task-link').addEventListener('click', () => {
            window.location.href = `/task/detail?id=${task.id}&date=${task.due_date}`;
        });
        container.appendChild(item);
    });
}

async function updateTaskStatus(task) {
    // metaタグからトークンを取得
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    if (!token) {
        console.error('CSRF token not found. Please add <meta name="csrf-token" content="{{ csrf_token() }}"> to your head.');
        alert('セッション情報の取得に失敗しました。ページを再読み込みしてください。');
        return;
    }

    try {
        const response = await fetch(`/api/tasks/${task.id}`, {
            method: 'POST', // LaravelのPUT擬似送信のためPOSTを使用
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': token // ★ここでトークンを送信します
            },
            body: JSON.stringify({
                _method: 'PUT', // LaravelでPUTとして認識させるための指定
                status: 1
            })
        });

        if (response.ok) {
            // ポイント付与処理
            const earned = DIFFICULTY_POINTS[task.difficulty || 1] || 5;
            let current = parseInt(localStorage.getItem('total_points') || '0');
            localStorage.setItem('total_points', current + earned);
            
            // 画面を更新して完了欄へ移動させる
            renderCalendar();
        } else {
            const errorData = await response.json();
            console.error('Update failed:', errorData);
            alert('更新に失敗しました。再度お試しください。');
        }
    } catch (e) {
        console.error('Network error:', e);
        alert('ネットワークエラーが発生しました。');
    }
}

function renderCompletedList(tasks) {
    const container = document.getElementById('completedList');
    container.innerHTML = tasks.length === 0 ? '<p class="text-sm text-slate-400">完了済みはありません</p>' : '';
    tasks.forEach(task => {
        const item = document.createElement('div');
        item.className = 'rounded-2xl bg-white border border-slate-200 p-3 flex items-center justify-between opacity-60 mb-2';
        item.innerHTML = `<div class="flex items-center gap-2 truncate"><span class="text-emerald-500">✓</span><span class="text-sm text-slate-400 line-through">${task.title}</span></div>`;
        container.appendChild(item);
    });
}

document.getElementById('prevBtn').addEventListener('click', () => { currentDate.setMonth(currentDate.getMonth() - 1); renderCalendar(); });
document.getElementById('nextBtn').addEventListener('click', () => { currentDate.setMonth(currentDate.getMonth() + 1); renderCalendar(); });
document.addEventListener('DOMContentLoaded', renderCalendar);