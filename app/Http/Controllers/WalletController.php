<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $user = auth()->user();
        $wallets = $user->wallets()->select('id', 'name', 'starting_balance')->get();
        return Inertia::render('Wallet/Index', compact('wallets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = auth()->user();
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:255',
            'starting_balance' => 'nullable|decimal:0,2',
        ]);
        $validated['starting_balance'] ??= 0;
        $user->wallets()->create($validated);
        return redirect()->route('wallets.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Wallet/Create');
    }

    /**
     * Display the specified resource.
     */
    public function show(Wallet $wallet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wallet $wallet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wallet $wallet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wallet $wallet)
    {
        //
    }
}
