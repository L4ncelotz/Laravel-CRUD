<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['category', 'subCategory', 'paymentMethod'])
            ->where('user_id', auth()->id())
            ->latest('transaction_date')
            ->get();
        return response()->json($transactions);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:sub_categories,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'transaction_date' => 'required|date',
        ]);

        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            ...$validated
        ]);

        return response()->json($transaction->load(['category', 'subCategory', 'paymentMethod']), 201);
    }

    public function show(Transaction $transaction)
    {
        $this->authorize('view', $transaction);
        return response()->json($transaction->load(['category', 'subCategory', 'paymentMethod']));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $this->authorize('update', $transaction);

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:sub_categories,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'transaction_date' => 'required|date',
        ]);

        $transaction->update($validated);
        return response()->json($transaction->load(['category', 'subCategory', 'paymentMethod']));
    }

    public function destroy(Transaction $transaction)
    {
        $this->authorize('delete', $transaction);
        $transaction->delete();
        return response()->json(null, 204);
    }
} 