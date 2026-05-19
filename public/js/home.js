async function loadTodayTasks() {

    const container =
        window.innerWidth <= 600
            ? document.getElementById('todayTasksMobile')
            : document.getElementById('todayTasks');

    if (!container) return;

    const today = new Date();

    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const day = String(today.getDate()).padStart(2, '0');

    const todayStr = `${year}-${month}-${day}`;

    try {

        const response = await fetch(`/api/tasks?month=${year}-${month}`, {
            headers: {
                'Accept': 'application/json'
            }
        });

        const json = await response.json();

        const tasks =
            (json.status === 'success' && Array.isArray(json.data))
                ? json.data
                : [];

        // 今日の未完了タスクだけ
        const todayTasks = tasks.filter(task =>
            task.due_date === todayStr &&
            Number(task.status) !== 1
        );

        renderTodayTasks(todayTasks);

    } catch (e) {

        console.error(e);

        container.innerHTML = `
            <p class="text-sm text-red-400">
                読み込み失敗メ〜…
            </p>
        `;
    }
}

function renderTodayTasks(tasks) {

    const container =
        window.innerWidth <= 600
            ? document.getElementById('todayTasksMobile')
            : document.getElementById('todayTasks');

    if (!container) return;

    // タスクなし
    if (tasks.length === 0) {

        container.innerHTML = `
            <p class="font-bold mb-2">
                今日も1日がんばろうメ〜！
            </p>

            <p class="text-sm text-[#6b5b5b]">
                今日のタスクはないメ〜！
            </p>
        `;

        return;
    }

    // タイトル
    container.innerHTML = `
        <p class="font-bold mb-2">
            今日も1日がんばろうメ〜！
        </p>

    `;

    // タスク表示
    tasks.forEach(task => {

        const item = document.createElement('div');

        item.className = `
            bg-white/70
            rounded-xl
            px-3
            py-2
            mb-2
            border
            border-white/60
            cursor-pointer
            hover:bg-white
            transition
        `;

        item.innerHTML = `
            <div class="flex justify-between items-center gap-2">

                <p class="text-sm font-bold text-[#4a3f3f] truncate">
                    ${task.title}
                </p>

                <span class="text-xs text-yellow-500 whitespace-nowrap">
                    ★${task.difficulty || 1}
                </span>

            </div>
        `;

        // タスク詳細へ
        item.addEventListener('click', () => {

            window.location.href =
                `/task/detail?id=${task.id}&date=${task.due_date}`;

        });

        container.appendChild(item);
    });
}

// 読み込み時
document.addEventListener('DOMContentLoaded', loadTodayTasks);