<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    /**
     * 一括代入可能な属性
     */
    protected $fillable = [
        'user_id',
        'title',
        'difficulty',
        'status',
        'due_date',
        'start_time',
        'end_time',
        'note',
        'location',
        'completed_at',
    ];

    /**
     * キャスト
     *
     * - due_date は 'Y-m-d' 文字列で返したいので 'date:Y-m-d'
     * - start_time / end_time は DB の TIME 型のまま 'HH:MM:SS' 文字列で扱う
     */
    protected function casts(): array
    {
        return [
            'difficulty'   => 'integer',
            'status'       => 'integer',
            'due_date'     => 'date:Y-m-d',
            'completed_at' => 'datetime',
        ];
    }

    /**
     * タスクを所有するユーザー
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
