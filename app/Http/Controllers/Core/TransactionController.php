<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    use AuthorizesRequests;

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
        $this->authorize('view', Category::class);
        $result = $this->categoryService->findOrFail($id);
        Gate::authorize('view', auth()->user(),$result);
        return new CategoryResource($result);
    }

    public function create(CreateCategoryRequest $request)
    {
        $this->authorize('create', Category::class);
        $result = $this->categoryService->create($request->validated());
        return new CategoryResource($result);
    }

    public function update(int $id,UpdateCategoryRequest $request)
    {
        $this->authorize('update', Category::class);
        $result = $this->categoryService->update($id, $request->validated());
        return new CategoryResource($result);
    }

    public function delete(int $id){
        $this->authorize('delete', Category::class);
        $deleted = $this->categoryService->delete($id);
        if($deleted){
            return response()->json(["message"=>"Category deleted successfully"]);
        }
        return response()->json(["message"=>"Category deleted failed"]);

    }
}
