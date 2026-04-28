<?php

namespace App\Http\Services;

use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryServices
{
    public function getCategories($per_page)
    {
        return Category::paginate($per_page ?? 3);
    }
    public function getCategory($id)
    {
        return Category::find($id);
    }
    public function create($validatedData)
    {
        return  Category::create($validatedData);
    }
    public function update($category, $validatedData)
    {

        return $category->update($validatedData);
    }
    public function delete($category)
    {
        return $category->delete();
    }
}
