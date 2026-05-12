<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;

    /**
     * マスターデータなので一括代入は基本的に管理側でのみ使用
     */
    protected $fillable = [
        'name',
        'category',
        'price',
        'image_path',
        'equipped_image_path',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
        ];
    }

    /**
     * このアイテムを所有しているユーザーの所有レコード群
     */
    public function ownedItems(): HasMany
    {
        return $this->hasMany(OwnedItem::class);
    }
}
