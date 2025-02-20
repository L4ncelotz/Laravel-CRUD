<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SubCategoryController extends Controller
{
    use AuthorizesRequests;

    public function index(Category $category)
    {
        $this->authorize('view', $category);
        return response()->json($category->subCategories);
    }

    public function store(Request $request, Category $category)
    {
        $this->authorize('update', $category);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $subCategory = $category->subCategories()->create($validated);
        return response()->json($subCategory, 201);
    }

    public function update(Request $request, SubCategory $subCategory)
    {
        $this->authorize('update', $subCategory->category);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $subCategory->update($validated);
        return response()->json($subCategory);
    }

    public function destroy(SubCategory $subCategory)
    {
        $this->authorize('delete', $subCategory->category);
        $subCategory->delete();
        return response()->json(null, 204);
    }
} 