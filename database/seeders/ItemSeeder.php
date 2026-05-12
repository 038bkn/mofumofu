<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * public/images/item 配下のショップ画像と
     * public/images/with_sheep 配下の装着時画像を組にして投入。
     * image_path をキーに updateOrCreate するので何度実行してもOK。
     */
    public function run(): void
    {
        $items = [
            // ──── キャラ本体 ────
            ['file' => 'doll_boy.png',       'equipped' => 's_ doll_boy.png',    'name' => '男の子人形',     'category' => 'character', 'price' => 500],
            ['file' => 'doll_girl.png',      'equipped' => 's_ doll_girl.png',   'name' => '女の子人形',     'category' => 'character', 'price' => 500],
            ['file' => 'tanabata_man.png',   'equipped' => 's_tanabata_man.png', 'name' => '七夕の彦星',     'category' => 'character', 'price' => 800],
            ['file' => 'tanabata_woman.png', 'equipped' => 's_tanabata_woman.png','name'=> '七夕の織姫',     'category' => 'character', 'price' => 800],

            // ──── 帽子 ────
            ['file' => 'hat.png',            'equipped' => 's_hat.png',          'name' => 'ふつうの帽子',   'category' => 'hat',       'price' => 100],
            ['file' => 'helmet_blue.png',    'equipped' => 's_helmet_blue.png',  'name' => '青いヘルメット', 'category' => 'hat',       'price' => 150],
            ['file' => 'helmet_red.png',     'equipped' => 's_helmet_red.png',   'name' => '赤いヘルメット', 'category' => 'hat',       'price' => 150],
            ['file' => 'tophat.png',         'equipped' => 's_tophat.png',       'name' => 'シルクハット',   'category' => 'hat',       'price' => 300],

            // ──── 小物 ────
            ['file' => 'bell.png',           'equipped' => 's_ bell.png',        'name' => '鈴',             'category' => 'accessory', 'price' => 80],
            ['file' => 'ribbon.png',         'equipped' => 's_ ribbon.png',      'name' => 'リボン',         'category' => 'accessory', 'price' => 100],
            ['file' => 'sunglasses.png',     'equipped' => 's_ sunglasses.png',  'name' => 'サングラス',     'category' => 'accessory', 'price' => 200],
            ['file' => 'dango.png',          'equipped' => 's_dango.png',        'name' => 'お団子',         'category' => 'accessory', 'price' => 120],
            ['file' => 'valentine.png',      'equipped' => 's_ valentine.png',   'name' => 'バレンタイン',   'category' => 'accessory', 'price' => 250],

            // ──── 背景 ────
            ['file' => 'sakura.png',         'equipped' => 's_sakura.png',       'name' => '桜の背景',       'category' => 'background','price' => 200],
            ['file' => 'sunflower.png',      'equipped' => 's_sunflower.png',    'name' => 'ひまわりの背景', 'category' => 'background','price' => 200],
            ['file' => 'rainy.png',          'equipped' => 's_ rainy.png',       'name' => '雨の日の背景',   'category' => 'background','price' => 150],
        ];

        foreach ($items as $row) {
            $imagePath         = '/images/item/'       . $row['file'];
            $equippedImagePath = '/images/with_sheep/' . $row['equipped'];

            Item::updateOrCreate(
                ['image_path' => $imagePath],
                [
                    'name'                => $row['name'],
                    'category'            => $row['category'],
                    'price'               => $row['price'],
                    'equipped_image_path' => $equippedImagePath,
                ],
            );
        }
    }
}
