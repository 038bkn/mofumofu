document.addEventListener('DOMContentLoaded', () => {
    const taskDate = document.getElementById('taskDate').value;

    document.getElementById('taskForm').addEventListener('submit', (event) => {
        event.preventDefault();

        const title = document.getElementById('taskTitle').value.trim();
        const start = document.getElementById('taskStart').value;
        const end = document.getElementById('taskEnd').value;
        const note = document.getElementById('taskNote').value.trim();

        if (!title || !start || !end) {
            alert('タイトルと開始・終了時刻を入力してください。');
            return;
        }
        if (start >= end) {
            alert('終了時刻は開始時刻より後にしてください。');
            return;
        }

        // 一時保存（確認画面で表示するため）
        const task = { title, start, end, note, date: taskDate, id: Date.now() };
        localStorage.setItem('pendingTask', JSON.stringify(task));

        // 確認画面へ遷移
        window.location.href = `/task/detail?date=${taskDate}`;
    });
});