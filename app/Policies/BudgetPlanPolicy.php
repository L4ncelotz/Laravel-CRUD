<?php

namespace App\Policies;

use App\Models\BudgetPlan;
use App\Models\User;

class BudgetPlanPolicy
{
    public function view(User $user, BudgetPlan $budgetPlan)
    {
        return $user->id === $budgetPlan->user_id;
    }

    public function update(User $user, BudgetPlan $budgetPlan)
    {
        return $user->id === $budgetPlan->user_id;
    }

    public function delete(User $user, BudgetPlan $budgetPlan)
    {
        return $user->id === $budgetPlan->user_id;
    }
} 