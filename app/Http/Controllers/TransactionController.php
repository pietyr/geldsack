<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\TransactionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $transactions = auth()->user()
            ->transactions()
            ->with([
                'wallet:id,name',
                'category:id,name',
            ])
            ->select([
                'id',
                'amount',
                'wallet_id',
                'transaction_category_id',
                'description',
                'date',
                'type'
            ])
            ->latest()
            ->get();

        return Inertia::render('Transactions/Index', ['transactions' => $transactions]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, TransactionService $transactionService): RedirectResponse
    {
        $validated = $request->validate([
            'date' => ['required', 'date'],
            'type' => ['required', 'in:income,expense'],
            'category' => ['required', 'exists:transaction_categories,id'],
            'amount' => ['required', 'numeric', 'min:0',],
            'wallet' => ['required', 'exists:wallets,id'],
            'description' => ['nullable', 'string'],
        ]);

        $transactionService->create($request->user(), $validated);


        return redirect()->route('transactions.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $categories = auth()->user()
            ->transactionCategories()
            ->select(['id', 'name', 'type'])
            ->orderBy('name')
            ->get();
        $wallets = auth()->user()
            ->wallets()->select(['id', 'name'])->get();
        return Inertia::render('Transactions/Create', ['categories' => $categories, 'wallets' => $wallets]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction): Response
    {
        abort_unless($transaction->user_id === auth()->id(), 403);

        $transaction->load([
            'wallet:id,name',
            'category:id,name,type',
        ]);

        $categories = auth()->user()
            ->transactionCategories()
            ->select(['id', 'name', 'type'])
            ->orderBy('name')
            ->get();

        $wallets = auth()->user()
            ->wallets()
            ->select(['id', 'name'])
            ->orderBy('name')
            ->get();

        return Inertia::render('Transactions/Edit', [
            'transaction' => $transaction,
            'categories' => $categories,
            'wallets' => $wallets,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction, TransactionService $transactionService): RedirectResponse
    {
        $validated = $request->validate([
            'date' => ['required', 'date'],
            'type' => ['required', 'in:income,expense'],
            'category' => ['required', 'exists:transaction_categories,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'wallet' => ['required', 'exists:wallets,id'],
            'description' => ['nullable', 'string'],
        ]);

        $transactionService->update($request->user(), $transaction, $validated);

        return redirect()->route('transactions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Transaction $transaction, TransactionService $transactionService): RedirectResponse
    {
        $transactionService->delete($request->user(), $transaction);

        return redirect()->route('transactions.index');
    }
}
