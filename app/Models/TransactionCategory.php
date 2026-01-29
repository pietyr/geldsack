<?php
declare(strict_types=1);

namespace App\Models;

use App\Enums\TransactionCategoryType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionCategory extends Model
{
    protected $fillable = ['name', 'type', 'user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'type' => TransactionCategoryType::class,
        ];
    }
}
