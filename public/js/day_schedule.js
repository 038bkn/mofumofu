document.addEventListener('DOMContentLoaded', () => {
    const scheduleContainer = document.getElementById('scheduleContainer');
    const scheduleDate = window.scheduleDate;

    function escHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    // localStorageから該当日のタスクを取得
    function fetchTasks() {
        const tasks = JSON.parse(localStorage.getItem('tasks') || '[]');
        return tasks.filter(t => t.due_date === scheduleDate);
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

                const eventBox = document.createElement('div');
                eventBox.style.cssText = 'background:#1e293b; border-radius:10px; padding:8px 12px; color:white; margin-bottom:4px; cursor:pointer;';
                eventBox.innerHTML = `
                    <div style="font-size:13px; font-weight:600;">${escHtml(task.title)}</div>
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

    renderTasks(fetchTasks());
});