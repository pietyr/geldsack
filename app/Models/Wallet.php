<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['name', 'starting_balance', 'user_id'])]
class Wallet extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
