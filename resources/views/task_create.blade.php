{{-- task_create.blade.php --}}
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>新規登録</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { 
            font-family: 'Hiragino Sans', 'Hiragino Kino Gothic ProN', 'Noto Sans JP', sans-serif;
            height: 100vh;
            height: -webkit-fill-available;
        }
        html { height: -webkit-fill-available; }
        .input-card { background: white; border-radius: 1.2rem; padding: 1rem 1.25rem; margin-bottom: 0.75rem; border: 1px solid #f1f5f9; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    </style>
</head>
<body class="bg-white text-slate-900 m-0 p-0 overflow-hidden">
    @php $taskDate = request('date', date('Y-m-d')); @endphp

    <div class="w-full h-screen flex flex-col bg-slate-50 overflow-hidden">
        <form id="taskForm" class="flex-1 flex flex-col min-h-0">
            {{-- ヘッダー --}}
            <div class="flex items-center justify-between px-5 py-4 bg-white border-b border-slate-100 flex-shrink-0">
                <a href="/day-schedule?date={{ $taskDate }}" class="text-xl p-2 -ml-2 text-slate-400">←</a>
                <span class="font-bold text-lg text-slate-700">新規登録</span>
                <button type="submit" id="saveBtn" class="text-blue-500 font-bold px-2 py-1">保存</button>
            </div>

            {{-- メインコンテンツ (スクロールエリア) --}}
            <div class="flex-1 overflow-y-auto px-5 py-6">
                <input type="hidden" id="taskDate" value="{{ $taskDate }}">
                
                <div class="input-card">
                    <input type="text" id="taskTitle" placeholder="タイトル" class="w-full text-lg font-bold focus:outline-none" required>
                </div>

                <div class="input-card">
                    <input type="text" id="taskLocation" placeholder="場所を追加" class="w-full text-sm focus:outline-none">
                </div>

                {{-- 時刻欄を縦並びに修正 --}}
                <div class="input-card">
                    <label class="block text-[10px] text-slate-400 mb-1">開始時刻</label>
                    <input type="time" id="taskStart" class="w-full text-base focus:outline-none">
                </div>

                <div class="input-card">
                    <label class="block text-[10px] text-slate-400 mb-1">終了時刻</label>
                    <input type="time" id="taskEnd" class="w-full text-base focus:outline-none">
                </div>

                <div class="input-card">
                    <p class="text-xs text-slate-400 mb-3">難易度</p>
                    <div class="flex gap-4 justify-center py-1">
                        @foreach(range(1, 5) as $i)
                            <button type="button" class="star-btn text-3xl text-slate-200" data-star="{{ $i }}">★</button>
                        @endforeach
                    </div>
                </div>

                <div class="input-card">
                    <textarea id="taskNote" rows="5" placeholder="詳細メモ..." class="w-full text-sm focus:outline-none resize-none"></textarea>
                </div>
            </div>
        </form>

        {{-- ボトムナビ --}}
        <nav class="w-full flex justify-center items-center text-slate-600 flex-shrink-0 border-t border-[#9ecfde]" style="background-color: #b8e0e9; height: 80px;">
            <div class="w-full max-w-2xl px-6 flex justify-between items-center">
                <a href="/chat" class="flex flex-col items-center gap-1"><span>💬</span><span class="text-[10px] font-bold">ひとりごと</span></a>
                <a href="/home" class="flex flex-col items-center gap-1"><span>🏠</span><span class="text-[10px] font-bold">ホーム</span></a>
                <a href="/calendar" class="flex flex-col items-center gap-1 text-slate-900"><span>🗓️</span><span class="text-[10px] font-bold border-b-2 border-slate-900">ToDo</span></a>
                <a href="/setting" class="flex flex-col items-center gap-1"><span>⚙️</span><span class="text-[10px] font-bold">設定</span></a>
            </div>
        </nav>
    </div>

    <script src="{{ asset('js/task_create.js') }}"></script>
</body>
</html>