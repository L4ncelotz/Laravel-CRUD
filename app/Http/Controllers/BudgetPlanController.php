<?php

namespace App\Http\Controllers;

use App\Models\BudgetPlan;
use Illuminate\Http\Request;

class BudgetPlanController extends Controller
{
    public function index()
    {
        $budgetPlans = BudgetPlan::with('category')
            ->where('user_id', auth()->id())
            ->get();
        return response()->json($budgetPlans);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $budgetPlan = BudgetPlan::create([
            'user_id' => auth()->id(),
            ...$validated
        ]);

        return response()->json($budgetPlan->load('category'), 201);
    }

    public function show(BudgetPlan $budgetPlan)
    {
        $this->authorize('view', $budgetPlan);
        return response()->json($budgetPlan->load('category'));
    }

    public function update(Request $request, BudgetPlan $budgetPlan)
    {
        $this->authorize('update', $budgetPlan);

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $budgetPlan->update($validated);
        return response()->json($budgetPlan->load('category'));
    }

    public function destroy(BudgetPlan $budgetPlan)
    {
        $this->authorize('delete', $budgetPlan);
        $budgetPlan->delete();
        return response()->json(null, 204);
    }
} 