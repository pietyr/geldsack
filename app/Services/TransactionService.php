<?php
declare(strict_types=1);

namespace App\Services;

use App\Enums\TransactionType;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;

final class TransactionService
{
    public function create(User $user, array $data): Transaction
    {
        return DB::transaction(function () use ($user, $data) {
            $wallet = Wallet::query()
                ->whereKey((int)$data['wallet'])
                ->where('user_id', $user->id)
                ->lockForUpdate()
                ->firstOrFail();

            $amount = (float)$data['amount'];
            $delta = $this->signedDelta($data['type'], $amount);

            $transaction = $user->transactions()->create([
                'wallet_id' => $wallet->id,
                'transaction_category_id' => (int)$data['category'],
                'type' => $data['type'],
                'amount' => $amount,
                'description' => $data['description'] ?? null,
                'date' => $data['date'],
            ]);

            $wallet->update([
                'balance' => (float)$wallet->balance + $delta,
            ]);

            return $transaction;
        });
    }

    private function signedDelta(string|TransactionType $type, float $amount): float
    {
        $typeValue = $type instanceof TransactionType ? $type->value : $type;

        return $typeValue === 'income' ? $amount : -$amount;
    }

    public function update(User $user, Transaction $transaction, array $data): Transaction
    {
        return DB::transaction(function () use ($user, $transaction, $data) {
            if ($transaction->user_id !== $user->id) {
                abort(403);
            }

            $oldWalletId = (int)$transaction->wallet_id;
            $newWalletId = (int)$data['wallet'];

            $walletIdsToLock = array_values(array_unique([$oldWalletId, $newWalletId]));
            sort($walletIdsToLock);

            $wallets = Wallet::query()
                ->whereIn('id', $walletIdsToLock)
                ->where('user_id', $user->id)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $oldWallet = $wallets->get($oldWalletId);
            $newWallet = $wallets->get($newWalletId);

            if (!$oldWallet || !$newWallet) {
                abort(404);
            }

            $oldDelta = $this->signedDelta($transaction->type, (float)$transaction->amount);

            $newAmount = (float)$data['amount'];
            $newDelta = $this->signedDelta($data['type'], $newAmount);

            if ($oldWalletId === $newWalletId) {
                $oldWallet->update([
                    'balance' => (float)$oldWallet->balance + ($newDelta - $oldDelta),
                ]);
            } else {
                $oldWallet->update([
                    'balance' => (float)$oldWallet->balance - $oldDelta,
                ]);

                $newWallet->update([
                    'balance' => (float)$newWallet->balance + $newDelta,
                ]);
            }

            $transaction->update([
                'wallet_id' => $newWalletId,
                'transaction_category_id' => (int)$data['category'],
                'type' => $data['type'],
                'amount' => $newAmount,
                'description' => $data['description'] ?? null,
                'date' => $data['date'],
            ]);

            return $transaction;
        });
    }

    public function delete(User $user, Transaction $transaction): void
    {
        DB::transaction(function () use ($user, $transaction) {
            if ($transaction->user_id !== $user->id) {
                abort(403);
            }

            $wallet = Wallet::query()
                ->whereKey((int)$transaction->wallet_id)
                ->where('user_id', $user->id)
                ->lockForUpdate()
                ->firstOrFail();

            $delta = $this->signedDelta($transaction->type, (float)$transaction->amount);

            $wallet->update([
                'balance' => (float)$wallet->balance - $delta,
            ]);

            $transaction->delete();
        });
    }
}
