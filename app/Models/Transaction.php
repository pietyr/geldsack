<?php

namespace App\Models;

use App\Enums\TransactionType;
use Carbon\CarbonImmutable;
use Eloquent;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property TransactionType $type
 * @property numeric $amount
 * @property int|null $source_wallet_id
 * @property int|null $destination_wallet_id
 * @property int|null $category_id
 * @property bool $is_archived
 * @property string|null $description
 * @property CarbonImmutable $date
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Category|null $category
 * @property-read Wallet|null $destinationWallet
 * @property-read Wallet|null $sourceWallet
 * @property-read User $user
 * @method static Builder<static>|Transaction newModelQuery()
 * @method static Builder<static>|Transaction newQuery()
 * @method static Builder<static>|Transaction query()
 * @method static Builder<static>|Transaction whereAmount($value)
 * @method static Builder<static>|Transaction whereCategoryId($value)
 * @method static Builder<static>|Transaction whereCreatedAt($value)
 * @method static Builder<static>|Transaction whereDate($value)
 * @method static Builder<static>|Transaction whereDescription($value)
 * @method static Builder<static>|Transaction whereDestinationWalletId($value)
 * @method static Builder<static>|Transaction whereId($value)
 * @method static Builder<static>|Transaction whereIsArchived($value)
 * @method static Builder<static>|Transaction whereSourceWalletId($value)
 * @method static Builder<static>|Transaction whereType($value)
 * @method static Builder<static>|Transaction whereUpdatedAt($value)
 * @method static Builder<static>|Transaction whereUserId($value)
 * @mixin Eloquent
 */
#[Fillable('type', 'amount', 'source_wallet_id', 'destination_wallet_id', 'category_id', 'is_archived', 'description', 'date')]
class Transaction extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sourceWallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'source_wallet_id');
    }

    public function destinationWallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'destination_wallet_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date' => 'datetime',
            'type' => TransactionType::class,
            'amount' => 'decimal:2',
            'is_archived' => 'boolean',
        ];
    }
}
