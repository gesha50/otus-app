<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return CategoryCollection
     */
    public function index(): CategoryCollection
    {
        return Cache::remember('categories', 60*60*24, function () {
            return new CategoryCollection(Category::all());
        });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryStoreRequest $request
     * @return CategoryResource
     */
    public function store(CategoryStoreRequest $request): CategoryResource
    {
        $category = Category::create($request->all());
        if ($request->hasFile('image')){
            $category->image  = $request->file('image')->store('categories');
            $category->save();
        }
        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return CategoryResource
     */
    public function show(Category $category): CategoryResource
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryUpdateRequest $request
     * @param $id
     * @return CategoryResource
     */
    public function update(CategoryUpdateRequest $request, $id): CategoryResource
    {
        $category = Category::find($id);
        $category->update([
            'title' => $request->title
        ]);
        if ($request->hasFile('image')){
            Storage::disk('public')->delete($category->image);
            $category->image = $request->file('image')->store('categories', 'public');
            $category->save();
        }
        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return array
     */
    public function destroy(Category $category): array
    {
        Storage::disk('public')->delete($category->image);
        $category->delete();
        return [
            'success'=> true,
            'message' => 'delete success'
        ];
    }
}
