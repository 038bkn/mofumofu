<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ホーム画面</title>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>

  <body class="bg-[#f6f6f6] flex justify-center py-6 font-sans">

    <!-- スマホ画面 -->
    <div class="relative w-[375px] h-[812px] bg-[#f6dede] overflow-hidden shadow-xl rounded-[40px] border border-gray-200">

    <!-- 吹き出し -->
    <div 
      class="absolute top-10 left-1/2 -translate-x-1/2 w-[540px] h-[280px] bg-contain bg-no-repeat bg-center z-10 flex items-center justify-center p-8"
      style="background-image: url('/images/cloud.png');"
    >
    <div class="text-[#4a3f3f] font-bold text-sm leading-relaxed text-center mt-[-10px]">
    </div>
    </div>


    <!-- 羊画像 -->
    <img
      src="/images/sheep.png"
      alt="羊"
      class="absolute bottom-[70px] left-1/2 -translate-x-1/2 w-[600px] z-10"
    />

    <!-- コレクションボタン -->
    <button
      onclick="openPopup()"
      class="absolute right-8 top-[300px] bg-[#efe8cf] border border-[#b6aa83] rounded-full px-7 py-4 text-[#4a3f3f] font-bold leading-tight z-20 shadow-sm hover:scale-105 transition"
    >
      コレクション<br />
      ショップ
    </button>

  <!-- ポップアップ -->
    <div id="popup"
    class="hidden absolute inset-0 bg-black/20 z-50 flex justify-center items-end pb-[420px] p-6"
    onclick="closePopup()">
  
    <div
      class="relative w-[320px] h-[220px] flex items-center justify-center bg-contain bg-no-repeat bg-center"
      style="background-image: url('/images/cloud.png');"
      onclick="event.stopPropagation()"
    >
    <div class="flex flex-col gap-3 mt-[-20px]"> 
      <button
        class="bg-[#fff9e6] hover:bg-[#efe8cf] active:scale-95 transition-all rounded-full py-3 px-8 text-[#4a3f3f] font-bold shadow-sm border border-[#e8dfc5]"
      >
        コレクション画面
      </button>

      <button
        class="bg-[#fff9e6] hover:bg-[#efe8cf] active:scale-95 transition-all rounded-full py-3 px-8 text-[#4a3f3f] font-bold shadow-sm border border-[#e8dfc5]"
      >
        ショップ画面
      </button>
    </div>
  </div>

  <div class="absolute top-[350px] right-[20px] transform pointer-events-none">
    <img
      src="/images/sheep.png" 
      alt="小さな羊"
      class="w-300 h-auto filter drop-shadow-md"
    />
  </div>
</div>

    <!-- 下ナビ -->
    <nav class="absolute bottom-0 left-0 w-full h-[90px] bg-[#cdeef9] flex justify-around items-center border-t border-[#b5d9e4] z-20">

      <button class="flex flex-col items-center text-[#5b5b5b]">
        <span class="text-3xl">💬</span>
        <span class="text-xs mt-1">ひとりごと</span>
      </button>

      <button class="flex flex-col items-center text-[#5b5b5b]">
        <span class="text-3xl">🏠</span>
        <span class="text-xs mt-1">ホーム</span>
      </button>

      <button class="flex flex-col items-center text-[#5b5b5b]">
        <span class="text-3xl">📅</span>
        <span class="text-xs mt-1">ToDo</span>
      </button>

      <button class="flex flex-col items-center text-[#5b5b5b]">
        <span class="text-3xl">⚙️</span>
        <span class="text-xs mt-1">設定</span>
      </button>

    </nav>

  </div>
  <script>
  function openPopup() {
    document.getElementById("popup").classList.remove("hidden");
  }

  function closePopup() {
    document.getElementById("popup").classList.add("hidden");
  }
</script>

</body>
</html>