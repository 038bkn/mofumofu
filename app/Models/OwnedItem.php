<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OwnedItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'is_equipped',
    ];

    protected function casts(): array
    {
        return [
            'is_equipped' => 'boolean',
        ];
    }

    /**
     * 所有者
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 元になるアイテムマスタ
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
