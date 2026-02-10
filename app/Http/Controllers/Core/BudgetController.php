<?php

namespace App\Http\Controllers\Core;

use App\Contracts\Services\Core\BudgetServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Core\CreateBudgetRequest;
use App\Http\Requests\Core\UpdateBudgetRequest;
use App\Http\Resources\Core\BudgetResource;
use App\Models\Budget;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    use AuthorizesRequests;

    public function __construct(protected  BudgetServiceInterface $budgetService)
    {
    }

//    public function index(IndexCategoryRequest $request)
//    {
////        $result = $this->categoryService->list($request->validated());
//        $result = $this->categoryService->list([
//            'filters'   => $request->filters(),
//            'relations' => $request->relations(),
//            'sort'      => $request->sort(),
//            'direction' => $request->direction(),
//            'perPage'   => $request->perPage(),
//        ]);
//        return CategoryResource::collection($result);
//    }

    public function show(int $id)
    {
        $this->authorize('view', Budget::class);
        $result = $this->budgetService->findOrFail($id);
        return new BudgetResource($result);
    }

    public function create(CreateBudgetRequest $request)
    {
        $this->authorize('create', Budget::class);
        $result = $this->budgetService->create($request->validated());
        return new BudgetResource($result);
    }

    public function update(int $id,UpdateBudgetRequest $request)
    {
        $this->authorize('update', Budget::class);
        $result = $this->budgetService->update($id, $request->validated());
        return new BudgetResource($result);
    }

    public function delete(int $id){
        $this->authorize('delete', Budget::class);
        $deleted = $this->budgetService->delete($id);
        if($deleted){
            return response()->json(["message"=>"Category deleted successfully"]);
        }
        return response()->json(["message"=>"Category deleted failed"]);

    }
}
