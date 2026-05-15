document.addEventListener('DOMContentLoaded', async () => {
    const container = document.getElementById('scheduleContainer');
    const date = window.scheduleDate;

    if (!container || !date) return;

    // 1. 24時間の枠を生成
    container.innerHTML = '';
    for (let hour = 0; hour < 24; hour++) {
        const row = document.createElement('div');
        row.className = 'flex gap-3 sm:gap-4 items-stretch border-b border-slate-100';
        row.innerHTML = `
            <div class="w-12 sm:w-14 text-right text-[10px] text-slate-300 pt-3 flex-shrink-0 font-mono">
                ${String(hour).padStart(2, '0')}:00
            </div>
            <div class="flex-1 py-2 min-h-[64px] relative task-slot" id="slot-${hour}"></div>
        `;
        container.appendChild(row);
    }

    // 2. タスクを取得して配置
    try {
        const response = await fetch(`/api/tasks?date=${date}`);
        const result = await response.json();

        if (result.status === 'success' && Array.isArray(result.data)) {
            result.data.forEach(task => {
                if (!task.start_time) return;
                
                const hour = parseInt(task.start_time.split(':')[0]);
                const slot = document.getElementById(`slot-${hour}`);
                
                if (slot) {
                    const el = document.createElement('div');
                    const isDone = task.is_completed;
                    el.className = `mb-1 p-2 rounded-lg text-white text-xs cursor-pointer ${isDone ? 'bg-slate-400 opacity-70' : 'bg-slate-800'}`;
                    el.innerHTML = `
                        <div class="font-bold ${isDone ? 'line-through' : ''}">${task.title}</div>
                        ${task.start_time ? `<div class="text-[10px] opacity-80">${task.start_time}</div>` : ''}
                    `;
                    el.onclick = () => window.location.href = `/task/detail?id=${task.id}`;
                    slot.appendChild(el);
                }
            });
        }
    } catch (e) {
        console.error("Task fetch error:", e);
    }
});


    function renderError(message) {
        scheduleContainer.innerHTML = `
            <div style="text-align:center; padding:16px; font-size:13px; color:#dc2626;">
                ${escHtml(message)}
            </div>`;
    }

    function renderTasks(tasks) {
        scheduleContainer.innerHTML = '';

        tasks.sort((a, b) => (a.start_time || '').localeCompare(b.start_time || ''));

        for (let hour = 0; hour < 24; hour++) {
            const row = document.createElement('div');
            row.style.cssText = 'display:flex; align-items:flex-start; min-height:52px; border-bottom:1px solid #f1f5f9;';

            const timeLabel = document.createElement('div');
            timeLabel.style.cssText = 'width:52px; flex-shrink:0; text-align:right; padding-right:12px; padding-top:10px; font-size:11px; color:#94a3b8; user-select:none;';
            timeLabel.textContent = `${String(hour).padStart(2, '0')}:00`;

            const cell = document.createElement('div');
            cell.style.cssText = 'flex:1; padding:6px 0; min-height:52px;';

            const events = tasks.filter(task => {
                const h = parseInt((task.start_time || '00:00').slice(0, 2), 10);
                return h === hour;
            });

            events.forEach(task => {
                const startStr = (task.start_time || '').slice(0, 5);
                const endStr   = (task.end_time   || '').slice(0, 5);
                const isDone   = Number(task.status) === 1;

                const eventBox = document.createElement('div');
                eventBox.style.cssText = `background:${isDone ? '#94a3b8' : '#1e293b'}; border-radius:10px; padding:8px 12px; color:white; margin-bottom:4px; cursor:pointer;${isDone ? ' opacity:0.7;' : ''}`;
                eventBox.innerHTML = `
                    <div style="font-size:13px; font-weight:600;${isDone ? ' text-decoration:line-through;' : ''}">${escHtml(task.title)}</div>
                    ${startStr ? `<div style="font-size:11px; color:#cbd5e1; margin-top:2px;">${startStr}${endStr ? ' - ' + endStr : ''}</div>` : ''}
                    ${task.note ? `<div style="font-size:11px; color:#cbd5e1; margin-top:4px;">${escHtml(task.note)}</div>` : ''}
                `;
                eventBox.addEventListener('click', () => {
                    window.location.href = `/task/detail?id=${task.id}&date=${scheduleDate}`;
                });
                cell.appendChild(eventBox);
            });

            row.appendChild(timeLabel);
            row.appendChild(cell);
            scheduleContainer.appendChild(row);
        }

        if (tasks.length === 0) {
            const empty = document.createElement('div');
            empty.style.cssText = 'text-align:center; padding:16px; font-size:13px; color:#94a3b8;';
            empty.textContent = 'この日の予定はまだありません。';
            scheduleContainer.insertBefore(empty, scheduleContainer.firstChild);
        }
    }

    fetchTasks().then(renderTasks);
