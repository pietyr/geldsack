<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => ['required', 'date'],
            'type' => ['required', 'in:income,expense'],
            'category' => ['required', 'exists:transaction_categories,id'],
            'amount' => ['required', 'numeric', 'min:0',],
            'wallet' => ['required', 'exists:wallets,id'],
            'description' => ['nullable', 'string'],
        ]);
        dd($validated);

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
