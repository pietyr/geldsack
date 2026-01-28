<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Wallet;
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
        $wallets = auth()->user()->wallets()->select(['id', 'name', 'balance'])->latest()->get();
        return Inertia::render('Wallets/Index', ['wallets' => $wallets]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'starting_balance' => ['nullable', 'numeric', 'min:0'],
        ]);

        $wallet = $request->user()->wallets()->create([
            'name' => $validated['name'],
            'balance' => (float)($validated['starting_balance'] ?? 0),
            'starting_balance' => (float)($validated['starting_balance'] ?? 0),
        ]);

        return redirect()
            ->route('wallets.index')
            ->with('success', 'Wallet created.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Wallets/Create');
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
    public function destroy(Request $request, Wallet $wallet)
    {
        abort_unless($wallet->user_id === $request->user()->id, 403);

        $wallet->delete();

        return redirect()
            ->route('wallets.index')
            ->with('success', 'Wallet deleted.');
    }
}
