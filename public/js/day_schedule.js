document.addEventListener('DOMContentLoaded', async () => {
    const container = document.getElementById('scheduleContainer');
    const date = window.scheduleDate;

    if (!container || !date) return;

    const pxPerHour = 64;
    const pxPerMinute = pxPerHour / 60;

    // ===== タイムライン生成 =====
    container.innerHTML = '';

    for (let hour = 0; hour < 24; hour++) {
        const row = document.createElement('div');

        row.className =
            'flex gap-3 sm:gap-4 border-b border-slate-100 relative';

        row.style.height = `${pxPerHour}px`;

        row.innerHTML = `
            <div class="w-12 sm:w-14 text-right text-[10px]
                        text-slate-300 pt-2 flex-shrink-0
                        font-mono select-none">
                ${String(hour).padStart(2, '0')}:00
            </div>

            <div class="flex-1 relative"
                 id="slot-${hour}"
                 style="height:${pxPerHour}px;">
            </div>
        `;

        container.appendChild(row);
    }

    // ===== タスク取得 =====
    try {
        const response =
            await fetch(`/api/tasks?date=${date}`);

        const result = await response.json();

        if (
            result.status === 'success' &&
            Array.isArray(result.data)
        ) {

            result.data.forEach(task => {

                if (!task.start_time) return;

                const start =
                    task.start_time.slice(0,5);

                const end =
                    task.end_time
                        ? task.end_time.slice(0,5)
                        : null;

                const [startH, startM] =
                    start.split(':').map(Number);

                const startTotal =
                    startH * 60 + startM;

                let duration = 60;

                if (end) {
                    const [endH, endM] =
                        end.split(':').map(Number);

                    duration =
                        (endH * 60 + endM) -
                        startTotal;

                    if (duration <= 0) {
                        duration = 30;
                    }
                }

                const slot =
                    document.getElementById(
                        `slot-${startH}`
                    );

                if (!slot) return;

                const top =
                    startM * pxPerMinute;

                const height =
                    Math.max(
                        duration * pxPerMinute,
                        36
                    );

                const isDone =
                    Number(task.status) === 1;

                const eventBox =
                    document.createElement('div');

                eventBox.className = `
                    absolute left-0 right-2
                    rounded-xl px-3 py-2
                    text-white text-xs
                    cursor-pointer shadow
                    overflow-hidden
                    ${isDone
                        ? 'bg-slate-400 opacity-70'
                        : 'bg-slate-800'}
                `;

                eventBox.style.top =
                    `${top}px`;

                eventBox.style.height =
                    `${height}px`;

                eventBox.style.zIndex = '10';

                eventBox.innerHTML = `
                    <div class="font-bold
                        ${isDone
                            ? 'line-through'
                            : ''}">
                        ${task.title}
                    </div>

                    <div class="text-[10px]
                        opacity-80 mt-1">
                        ${start}
                        ${end
                            ? `〜${end}`
                            : ''}
                    </div>
                `;

                eventBox.addEventListener(
                    'click',
                    () => {
                        window.location.href =
                            `/task/detail?id=${task.id}&date=${date}`;
                    }
                );

                slot.appendChild(eventBox);
            });
        }

    } catch (e) {
        console.error(
            'Task fetch error:',
            e
        );
    }
});