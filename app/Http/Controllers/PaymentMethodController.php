<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = PaymentMethod::where('user_id', auth()->id())->get();
        return response()->json($paymentMethods);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:cash,credit_card,debit_card,bank_transfer,e_wallet,other',
            'details' => 'nullable|string',
        ]);

        $paymentMethod = PaymentMethod::create([
            'user_id' => auth()->id(),
            ...$validated
        ]);

        return response()->json($paymentMethod, 201);
    }

    public function show(PaymentMethod $paymentMethod)
    {
        $this->authorize('view', $paymentMethod);
        return response()->json($paymentMethod);
    }

    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $this->authorize('update', $paymentMethod);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:cash,credit_card,debit_card,bank_transfer,e_wallet,other',
            'details' => 'nullable|string',
        ]);

        $paymentMethod->update($validated);
        return response()->json($paymentMethod);
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        $this->authorize('delete', $paymentMethod);
        $paymentMethod->delete();
        return response()->json(null, 204);
    }
} 