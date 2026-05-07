<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mofumofu Project</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-900 font-sans">

    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-2xl shadow-xl max-w-md w-full border border-slate-100">
            <h1 class="text-3xl font-bold text-indigo-600 mb-4 text-center">
                Hello Tailwind!
            </h1>
            <p class="text-slate-600 leading-relaxed mb-6">
                Laravel + Vanilla JS + Tailwind CSS の環境構築テスト用
            </p>
            <a href="/calendar" class="w-full inline-flex justify-center bg-indigo-500 hover:bg-indigo-600 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
                カレンダーを見る
            </a>
        </div>
    </div>

    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>