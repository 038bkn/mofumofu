document.addEventListener('DOMContentLoaded', () => {
    const taskDate = document.getElementById('taskDate').value;

    // 難易度スター
    let difficulty = 0;

    function updateStars(count, hover = false) {
        document.querySelectorAll('.star-btn').forEach((s, i) => {
            s.style.color = i < count ? (hover ? '#fbbf24' : '#f59e0b') : '#e2e8f0';
        });
    }

    document.querySelectorAll('.star-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            difficulty = parseInt(btn.dataset.star);
            updateStars(difficulty);
        });
        btn.addEventListener('mouseover', () => updateStars(parseInt(btn.dataset.star), true));
        btn.addEventListener('mouseout',  () => updateStars(difficulty));
    });

    // フォーム送信
    document.getElementById('taskForm').addEventListener('submit', (event) => {
        event.preventDefault();

        const title = document.getElementById('taskTitle').value.trim();
        const start = document.getElementById('taskStart').value;
        const end   = document.getElementById('taskEnd').value;
        const note  = document.getElementById('taskNote').value.trim();

        if (!title || !start || !end) {
            alert('タイトルと開始・終了時刻を入力してください。');
            return;
        }
        if (start >= end) {
            alert('終了時刻は開始時刻より後にしてください。');
            return;
        }

        // タスクオブジェクトを作成
        const task = {
            id:         Date.now(),
            title:      title,
            start_time: start,
            end_time:   end,
            note:       note,
            difficulty: difficulty,
            due_date:   taskDate,
            completed:  false,
        };

        // localStorageのタスク配列に追加して保存
        const tasks = JSON.parse(localStorage.getItem('tasks') || '[]');
        tasks.push(task);
        localStorage.setItem('tasks', JSON.stringify(tasks));

        // スケジュール画面へ遷移
        window.location.href = `/day-schedule?date=${taskDate}`;
    });
});