/* detail.js */
document.addEventListener('DOMContentLoaded', async () => {
    const taskId = window.taskId;
    const scheduleDate = window.scheduleDate;
    const contentArea = document.getElementById('taskContent');
    const editBtn = document.getElementById('editBtn');
    const deleteBtn = document.getElementById('deleteBtn');

    let currentTask = null;
    let isEditMode = false;

    if (!taskId) {
        contentArea.innerHTML = '<p class="text-center text-red-400">IDが正しくありません</p>';
        return;
    }

    async function loadTask() {
        try {
            const response = await fetch(`/api/tasks/${taskId}`);
            const result = await response.json();

            if (response.ok && result.status === 'success') {
                currentTask = result.data;
                renderViewMode();
            } else {
                contentArea.innerHTML =
                    '<p class="text-center text-red-400">タスクが見つかりませんでした</p>';
            }
        } catch {
            contentArea.innerHTML =
                '<p class="text-center text-red-400">読み込みに失敗しました</p>';
        }
    }

    function renderViewMode() {
        isEditMode = false;

        let stars = '';
        for (let i = 1; i <= 5; i++) {
            stars += i <= (currentTask.difficulty || 0) ? '★' : '☆';
        }

        const formattedDate = currentTask.due_date.replace(/-/g, '/');
        const isDone = Number(currentTask.status) === 1;

        contentArea.innerHTML = `
            <div class="text-center">
                <h2 class="text-2xl font-bold text-slate-800 mb-2">${currentTask.title}</h2>

                <p class="text-slate-500 mb-2">${formattedDate}</p>

                <div class="text-amber-400 text-2xl mb-4 tracking-widest">
                    ${stars}
                </div>

                <p class="text-slate-600 font-bold text-lg mb-4">
                    ${currentTask.start_time ? currentTask.start_time.substring(0,5) : ''}
                    ${currentTask.end_time ? ' 〜 ' + currentTask.end_time.substring(0,5) : ''}
                </p>

                ${currentTask.location
                    ? `<p class="text-sm text-slate-400 mb-4">📍 ${currentTask.location}</p>`
                    : ''}

                <div class="text-left bg-white p-5 rounded-2xl border border-slate-100 shadow-sm mt-6">
                    <p class="font-bold mb-2 text-slate-700 border-b border-slate-50 pb-2">メモ</p>
                    <p class="text-slate-600 whitespace-pre-wrap leading-relaxed text-sm">
                        ${currentTask.note || 'メモはありません'}
                    </p>
                </div>

                <button id="toggleStatusBtn"
                    class="w-full mt-6 font-bold py-3 rounded-full
                        ${isDone
                            ? 'bg-slate-200 text-slate-600'
                            : 'bg-green-400 text-white'}">
                    ${isDone ? '未完了に戻す' : '完了にする'}
                </button>
            </div>
        `;

        document.getElementById('toggleStatusBtn')
            .addEventListener('click', toggleStatus);

        editBtn.textContent = '編集する';
    }

    function renderEditMode() {
        isEditMode = true;

        contentArea.innerHTML = `
            <div class="space-y-4">

                <input id="editTitle"
                    class="w-full border rounded-xl p-3"
                    value="${currentTask.title || ''}">

                <div class="flex gap-2">
                    <input id="editStart"
                        type="time"
                        class="flex-1 border rounded-xl p-3"
                        value="${currentTask.start_time ? currentTask.start_time.substring(0,5) : ''}">

                    <input id="editEnd"
                        type="time"
                        class="flex-1 border rounded-xl p-3"
                        value="${currentTask.end_time ? currentTask.end_time.substring(0,5) : ''}">
                </div>

                <input id="editLocation"
                    class="w-full border rounded-xl p-3"
                    placeholder="場所"
                    value="${currentTask.location || ''}">

                <textarea id="editNote"
                    class="w-full border rounded-xl p-3 h-32"
                    placeholder="メモ">${currentTask.note || ''}</textarea>

                <button id="saveBtn"
                    class="w-full bg-[#b8e0e9] text-slate-700 font-bold py-3 rounded-full">
                    保存する
                </button>
            </div>
        `;

        editBtn.textContent = 'キャンセル';

        document.getElementById('saveBtn')
            .addEventListener('click', saveTask);
    }

    async function toggleStatus() {
        const newStatus = Number(currentTask.status) === 1 ? 0 : 1;

        try {
            const response = await fetch(`/api/tasks/${taskId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN':
                        document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ status: newStatus })
            });

            const json = await response.json();

            if (response.ok) {
                currentTask = { ...currentTask, status: newStatus };
                if (newStatus === 1 && json.earned_points) {
                    showToast(`完了！ +${json.earned_points}pt 獲得`, 'success');
                }
                renderViewMode();
            } else {
                showToast('ステータスの変更に失敗しました', 'error');
            }
        } catch {
            showToast('通信エラーが発生しました', 'error');
        }
    }

    async function saveTask() {
        const data = {
            title: document.getElementById('editTitle').value,
            start_time: document.getElementById('editStart').value || null,
            end_time: document.getElementById('editEnd').value || null,
            location: document.getElementById('editLocation').value || null,
            note: document.getElementById('editNote').value || null
        };

        try {
            const response = await fetch(`/api/tasks/${taskId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN':
                        document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            });

            if (response.ok) {
                currentTask = {
                    ...currentTask,
                    ...data
                };
                renderViewMode();
                showToast('保存しました', 'success');
            } else {
                showToast('保存に失敗しました', 'error');
            }
        } catch {
            showToast('通信エラーが発生しました', 'error');
        }
    }

    editBtn.addEventListener('click', () => {
        if (isEditMode) {
            renderViewMode();
        } else {
            renderEditMode();
        }
    });

    deleteBtn.addEventListener('click', () => {
        showConfirm('この予定を削除しますか？', async () => {
            try {
                const response = await fetch(`/api/tasks/${taskId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN':
                            document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                if (response.ok) {
                    window.location.href =
                        `/day-schedule?date=${scheduleDate}`;
                } else {
                    showToast('削除に失敗しました', 'error');
                }
            } catch {
                showToast('通信エラーが発生しました', 'error');
            }
        });
    });

    loadTask();
});