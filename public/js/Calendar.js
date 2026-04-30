let currentDate = new Date(2026, 3, 1);
const monthNames = ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'];

function renderCalendar() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();

    document.getElementById('monthDisplay').textContent = monthNames[month];
    document.getElementById('yearDisplay').textContent = year;

    const firstDay = new Date(year, month, 1).getDay();
    const lastDate = new Date(year, month + 1, 0).getDate();
    const calendarGrid = document.getElementById('calendarGrid');
    const dayElements = Array.from(calendarGrid.children).slice(7);
    dayElements.forEach(el => el.remove());

    for (let i = 0; i < firstDay; i++) {
        const span = document.createElement('span');
        span.className = 'text-sm text-slate-400 py-2';
        calendarGrid.appendChild(span);
    }

    for (let day = 1; day <= lastDate; day++) {
        const span = document.createElement('span');
        span.className = 'text-sm text-slate-900 py-2 cursor-pointer hover:bg-slate-100 rounded';
        span.textContent = day;
        span.addEventListener('click', () => {
            const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            window.location.href = `/day-schedule?date=${dateStr}`;
        });
        calendarGrid.appendChild(span);
    }

    const totalCells = (firstDay + lastDate) % 7;
    if (totalCells !== 0) {
        for (let i = 0; i < 7 - totalCells; i++) {
            const span = document.createElement('span');
            span.className = 'text-sm text-slate-400 py-2';
            calendarGrid.appendChild(span);
        }
    }
}

document.getElementById('prevBtn').addEventListener('click', () => {
    const newDate = new Date(currentDate.getFullYear(), currentDate.getMonth() - 1, 1);
    if (newDate.getFullYear() >= 2000) {
        currentDate = newDate;
        renderCalendar();
    }
});

document.getElementById('nextBtn').addEventListener('click', () => {
    const newDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 1);
    if (newDate.getFullYear() <= 2030) {
        currentDate = newDate;
        renderCalendar();
    }
});

document.addEventListener('DOMContentLoaded', () => renderCalendar());
