document.addEventListener('DOMContentLoaded', () => {
    const params = new URLSearchParams(location.search);
    const taskId = params.get('id');
    // Blade側の window.scheduleDate から取得
    const scheduleDate = window.scheduleDate;
    const weekDays = ['日', '月', '火', '水', '木', '金', '土'];

    function escHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;').replace(/</g, '&lt;')
            .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    function loadTask() {
        if (!taskId) {
            showError('タスクIDが指定されていません。');
            return;
        }

        const tasks = JSON.parse(localStorage.getItem('tasks') || '[]');
        const task = tasks.find(t => String(t.id) === String(taskId));

        if (!task) {
            showError('タスクが見つかりません。');
            return;
        }

        renderTask(task);
    }

    function renderTask(task) {
        const d = new Date(task.due_date + 'T00:00:00');
        const dow = weekDays[d.getDay()];
        const dateStr = `${task.due_date.replace(/-/g, '/')} ${dow}曜日`;

        let stars = '';
        for (let i = 1; i <= 5; i++) {
            stars += i <= task.difficulty ? '★' : '☆';
        }

        const startStr = (task.start_time || '').slice(0, 5);
        const endStr = (task.end_time || '').slice(0, 5);
        const timeStr = startStr && endStr ? `${startStr} 〜 ${endStr}` : startStr;

        document.getElementById('taskContent').innerHTML = `
            <h2 class="text-base font-bold text-slate-800 mb-2">${escHtml(task.title)}</h2>
            <div class="text-sm text-slate-500 space-y-1">
                <p>${escHtml(dateStr)}</p>
                <p>難易度　<span class="text-amber-400 tracking-widest">${stars}</span></p>
                ${timeStr ? `<p class="text-slate-600 font-medium">${escHtml(timeStr)}</p>` : ''}
            </div>
            ${task.note
                ? `<p class="text-sm text-slate-600 mt-4 p-3 bg-white rounded-xl border border-slate-100 whitespace-pre-wrap">${escHtml(task.note)}</p>`
                : '<p class="text-sm text-slate-300 mt-4">メモなし</p>'}
        `;
    }

    function showError(msg) {
        document.getElementById('taskContent').innerHTML =
            `<p class="text-sm text-red-400 text-center py-4">${escHtml(msg)}</p>`;
    }

    // 削除処理
    const deleteBtn = document.getElementById('deleteBtn');
    if (deleteBtn) {
        deleteBtn.addEventListener('click', () => {
            if (!taskId) return;
            if (!confirm('この予定を削除しますか？')) return;

            const tasks = JSON.parse(localStorage.getItem('tasks') || '[]');
            const updated = tasks.filter(t => String(t.id) !== String(taskId));
            localStorage.setItem('tasks', JSON.stringify(updated));

            window.location.href = `/day-schedule?date=${scheduleDate}`;
        });
    }

    loadTask();
});