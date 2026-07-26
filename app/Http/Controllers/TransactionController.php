<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\TransactionType;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $user = auth()->user();
        $transactions = $user->transactions;
        return Inertia::render('Transaction/Index', compact('transactions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = auth()->user();
        $validated = $request->validate([
            'amount' => 'required|decimal:0,2',
            'type' => ['required', Rule::enum(TransactionType::class)],
            'date' => 'required|date',
            'category_id' => ['required', Rule::exists('categories', 'id')->where('user_id', $user->id)],
            'destination_wallet_id' => ['required', Rule::exists('wallets', 'id')->where('user_id', $user->id)],
        ]);
        $user->transactions()->create($validated);
        return redirect()->route('transactions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): Response
    {
        $user = auth()->user();
        $categories = $user->categories()->select('id', 'name', 'type')->get();
        $transactionType = TransactionType::tryFrom($request->query('type', '')) ?? TransactionType::Expense;
        $transactionType = $transactionType->value;
        $wallets = $user->wallets()->select('id', 'name')->get();
        return Inertia::render('Transaction/Create', compact('categories', 'transactionType', 'wallets'));
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
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
