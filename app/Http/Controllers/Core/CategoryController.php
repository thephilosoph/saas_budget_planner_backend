<?php

namespace App\Http\Controllers\Core;

use App\Contracts\Services\Core\CategoryServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Core\CreateCategoryRequest;
use App\Http\Requests\Core\IndexCategoryRequest;
use App\Http\Requests\Core\UpdateCategoryRequest;
use App\Http\Resources\Core\CategoryResource;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(protected CategoryServiceInterface $categoryService)
    {
    }

    public function index(IndexCategoryRequest $request)
    {
//        $result = $this->categoryService->list($request->validated());
        $result = $this->categoryService->list([
            'filters'   => $request->filters(),
            'relations' => $request->relations(),
            'sort'      => $request->sort(),
            'direction' => $request->direction(),
            'perPage'   => $request->perPage(),
        ]);
        return CategoryResource::collection($result);
    }

    public function show(int $id)
    {
        $result = $this->categoryService->findOrFail($id);
        return new CategoryResource($result);
    }

    public function create(CreateCategoryRequest $request)
    {
        $result = $this->categoryService->create($request->validated());
        return new CategoryResource($result);
    }

    public function update(int $id,UpdateCategoryRequest $request)
    {
        $result = $this->categoryService->update($id, $request->validated());
        return new CategoryResource($result);
    }

    public function delete(int $id){
        $deleted = $this->categoryService->delete($id);
        if($deleted){
            return response()->json(["message"=>"Category deleted successfully"]);
        }
        return response()->json(["message"=>"Category deleted failed"]);

    }

}
