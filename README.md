### サーバー起動コマンド
`php artisan serve`

## 開発ルール

### 1. 担当ディレクトリを守る
自分が担当するファイル以外は、むやみに変更・追加しないでください。

- 触ってよい場所
  - `resources/views/` （HTML/Bladeファイル）
  - `public/css/` （スタイルシート）
  - `public/js/` （JavaScriptファイル）
  - `public/images/` （画像ファイル）
  - `routes/` （URLの設定）

### 2. ファイル名の命名規則
新しく画面（Bladeファイル）を作るときは、ファイル名を必ずすべて小文字にしてください。単語を繋ぐときはアンダースコア `_` またはハイフン `-` を使います。

- 良い例: `login.blade.php`
- 悪い例: `Login.blade.php`

### 3. CSS / JavaScript の書き方
CSSやJSファイルは直接 `public/` フォルダの中に作成し、Bladeファイルから以下のように読み込んでください。

```html
<!-- CSSの読み込み -->
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<!-- JSの読み込み -->
<script src="{{ asset('js/main.js') }}"></script>
```

### 4. 新しい画面のURLを追加したい場合
`routes/web.php` に追記しますが、今は画面を表示するだけのシンプルな書き方にしてください。
DBの代わりとしてSessionを使った保存処理や、コントローラーを作成することは禁止です。

```php
// routes/web.php の記述例
Route::get('/calendar', function () {
    return view('calendar_screen');
});
```

---

## レビューとマージ（合流）の流れ

このリポジトリの `main` ブランチには直接コードをPushできません。必ず以下の手順を踏んでください。

1. 自分のブランチで作業する
   作業前に必ず今いるブランチ（例: `feature/〇〇(名前)`）を確認してください。
2. Pull Requestを作成する
   作業が終わったら GitHub 上で `main` ブランチに向けて PR を作成します。
3. AIレビュワー（CodeRabbit）のチェックを受ける
   PRを出すと、数分以内に AI（CodeRabbit）が自動でコードをレビューしてコメントをくれます。
   - 指摘された箇所があれば修正してください。
   - 指摘の意味がわからない場合は、コメント欄で `@coderabbitai なぜこう直すの？` と返信すると AI が解説してくれます。

---
