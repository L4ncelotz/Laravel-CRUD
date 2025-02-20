<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('check.ownership')->except(['index', 'store']);
    }

    public function index()
    {
        try {
            $categories = Category::where('user_id', auth()->id())
                ->with('subCategories')
                ->get();
                
            return response()->json([
                'status' => 'success',
                'data' => $categories
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch categories',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(CategoryRequest $request)
    {
        try {
            $category = Category::create([
                'user_id' => auth()->id(),
                'name' => $request->name,
                'type' => $request->type,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Category created successfully',
                'data' => $category
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create category',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Category $category)
    {
        try {
            return response()->json([
                'status' => 'success',
                'data' => $category->load('subCategories')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch category',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(CategoryRequest $request, Category $category)
    {
        try {
            $category->update($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Category updated successfully',
                'data' => $category
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update category',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Category $category)
    {
        try {
            $category->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Category deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete category',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 