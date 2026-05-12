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

    function getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.content : '';
    }

    // フォーム送信 → API POST
    document.getElementById('taskForm').addEventListener('submit', async (event) => {
        event.preventDefault();

        const title    = document.getElementById('taskTitle').value.trim();
        const location = document.getElementById('taskLocation').value.trim();
        const start    = document.getElementById('taskStart').value;
        const end      = document.getElementById('taskEnd').value;
        const note     = document.getElementById('taskNote').value.trim();

        // フロント側バリデーション
        if (!title) {
            alert('タイトルを入力してください。');
            return;
        }
        if (!difficulty) {
            alert('難易度を選択してください。');
            return;
        }
        if (start && end && start >= end) {
            alert('終了時刻は開始時刻より後にしてください。');
            return;
        }

        const payload = {
            title:      title,
            difficulty: difficulty,
            due_date:   taskDate,
            start_time: start || null,
            end_time:   end   || null,
            note:       note  || null,
            location:   location || null,
        };

        const saveBtn = document.getElementById('saveBtn');
        if (saveBtn) saveBtn.disabled = true;

        try {
            const response = await fetch('/api/tasks', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json',
                },
                body: JSON.stringify(payload),
            });
            const json = await response.json();

            if (response.ok && json.status === 'success') {
                // 作成成功 → 日次スケジュールへ
                window.location.href = `/day-schedule?date=${taskDate}`;
                return;
            }

            alert(json.message || 'タスクの登録に失敗しました。');
        } catch (e) {
            alert('通信エラーが発生しました。もう一度お試しください。');
        } finally {
            if (saveBtn) saveBtn.disabled = false;
        }
    });
});
