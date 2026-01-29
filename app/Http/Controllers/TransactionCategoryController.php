<?php

namespace App\Http\Controllers;

use App\Models\TransactionCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TransactionCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $categories = auth()->user()->transactionCategories()->select(['id', 'name', 'type'])->latest()->get();
        return Inertia::render('TransactionCategories/Index', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'type' => ['required', 'string', 'in:income,expense'],
        ]);
        auth()->user()->transactionCategories()->create([
            'name' => $validated['name'],
            'type' => $validated['type'],
        ]);
        return redirect()->route('categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('TransactionCategories/Create');
    }

    /**
     * Display the specified resource.
     */
    public function show(TransactionCategory $transactionCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransactionCategory $transactionCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransactionCategory $transactionCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransactionCategory $transactionCategory)
    {
        //
    }
}
