/* detail.js */
document.addEventListener('DOMContentLoaded', async () => {
    const taskId = window.taskId;
    const scheduleDate = window.scheduleDate;
    const contentArea = document.getElementById('taskContent');

    if (!taskId) {
        contentArea.innerHTML = '<p class="text-center text-red-400">IDが正しくありません</p>';
        return;
    }

    try {
        const response = await fetch(`/api/tasks/${taskId}`);
        const result = await response.json();

        if (response.ok && result.status === 'success') {
            const task = result.data;
            
            let stars = '';
            for (let i = 1; i <= 5; i++) {
                stars += i <= (task.difficulty || 0) ? '★' : '☆';
            }

            const formattedDate = task.due_date.replace(/-/g, '/');

            contentArea.innerHTML = `
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-slate-800 mb-2">${task.title}</h2>
                    <p class="text-slate-500 mb-2">${formattedDate}</p>
                    <div class="text-amber-400 text-2xl mb-4 tracking-widest">${stars}</div>
                    
                    <p class="text-slate-600 font-bold text-lg mb-4">
                        ${task.start_time ? task.start_time.substring(0,5) : ''} 
                        ${task.end_time ? ' 〜 ' + task.end_time.substring(0,5) : ''}
                    </p>
                    
                    ${task.location ? `<p class="text-sm text-slate-400 mb-4">📍 ${task.location}</p>` : ''}
                    
                    <div class="text-left bg-white p-5 rounded-2xl border border-slate-100 shadow-sm mt-6">
                        <p class="font-bold mb-2 text-slate-700 border-b border-slate-50 pb-2">メモ</p>
                        <p class="text-slate-600 whitespace-pre-wrap leading-relaxed text-sm">${task.note || 'メモはありません'}</p>
                    </div>
                </div>
            `;
        } else {
            contentArea.innerHTML = '<p class="text-center text-red-400">タスクが見つかりませんでした</p>';
        }
    } catch (e) {
        contentArea.innerHTML = '<p class="text-center text-red-400">読み込みに失敗しました</p>';
    }

    // 削除ボタン
    document.getElementById('deleteBtn').addEventListener('click', async () => {
        if (!confirm('この予定を削除しますか？')) return;

        try {
            const response = await fetch(`/api/tasks/${taskId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                window.location.href = `/day-schedule?date=${scheduleDate}`;
            } else {
                alert('削除に失敗しました');
            }
        } catch (e) {
            alert('通信エラーが発生しました');
        }
    });
});