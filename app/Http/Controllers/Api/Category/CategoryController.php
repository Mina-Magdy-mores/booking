<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdataCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Services\CategoryServices;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public $categoryServices;
    public function __construct()
    {
        $this->categoryServices = new CategoryServices();
    }
    public function index(Request $request)
    {
        $categories = $this->categoryServices->getCategories($request->per_page);
        if (!$categories) {
            return response()->json([
                'status' => false,
                'message' => 'Categories not found'
            ], 404);
        }
        return response()->json([
            'status' => true,
            'categories' => CategoryResource::collection($categories)->response()->getData(true)
        ], 200);
    }
    public function show($id)
    {
        $category = $this->categoryServices->getCategory($id);
        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found'
            ], 404);
        }
        return response()->json([
            'status' => true,
            'category' => new CategoryResource($category)
        ], 200);
    }
    public function store(CreateCategoryRequest $request)
    {
        $validatedData = $request->validated();
        $category = $this->categoryServices->create($validatedData);
        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category not created'
            ], 500);
        }
        return response()->json([
            'status' => true,
            'category' => new CategoryResource($category)
        ], 201);
    }
    public function update(UpdataCategoryRequest $request, $id)
    {
        $category = $this->categoryServices->getCategory($id);
        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found'
            ], 404);
        }
        $validatedData = $request->validated();
        $update = $this->categoryServices->update($category, $validatedData);
        if (!$update) {
            return response()->json([
                'status' => false,
                'message' => 'Category not updated'
            ], 500);
        }
        return response()->json([
            'status' => true,
            'category' => new CategoryResource($category)
        ], 200);
    }
    public function destroy($id)
    {
        $category = $this->categoryServices->getCategory($id);
        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found'
            ], 404);
        }
        $delete = $this->categoryServices->delete($category);
        if (!$delete) {
            return response()->json([
                'status' => false,
                'message' => 'Category not deleted'
            ], 500);
        }
        return response()->json([
            'status' => true,
            'message' => 'Category deleted successfully'
        ], 200);
    }
}
