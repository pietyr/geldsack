<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\CarbonImmutable;
use Eloquent;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property int $user_id
 * @property numeric $starting_balance
 * @property string $name
 * @property-read Collection<int, Transaction> $incomingTransactions
 * @property-read int|null $incoming_transactions_count
 * @property-read Collection<int, Transaction> $outgoingTransactions
 * @property-read int|null $outgoing_transactions_count
 * @property-read User $user
 * @method static Builder<static>|Wallet newModelQuery()
 * @method static Builder<static>|Wallet newQuery()
 * @method static Builder<static>|Wallet query()
 * @method static Builder<static>|Wallet whereCreatedAt($value)
 * @method static Builder<static>|Wallet whereId($value)
 * @method static Builder<static>|Wallet whereName($value)
 * @method static Builder<static>|Wallet whereStartingBalance($value)
 * @method static Builder<static>|Wallet whereUpdatedAt($value)
 * @method static Builder<static>|Wallet whereUserId($value)
 * @mixin Eloquent
 */
#[Fillable(['name', 'starting_balance', 'user_id'])]
class Wallet extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function outgoingTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'source_wallet_id');
    }

    public function incomingTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'destination_wallet_id');
    }

    protected function casts(): array
    {
        return [
            'starting_balance' => 'decimal:2',
        ];
    }
}
