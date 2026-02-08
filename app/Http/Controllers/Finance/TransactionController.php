<?php

namespace App\Http\Controllers\Finance;

use App\Contracts\Services\Finance\TransactionServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\StoreTransactionRequest;
use App\Http\Requests\Finance\UpdateTransactionRequest;
use App\Http\Resources\Finance\TransactionResource;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct(
        protected TransactionServiceInterface $transactionService
    ) {}

    public function index(Request $request)
    {
        $filters = [
            'filters' => $request->only(['type', 'category_id', 'budget_id']),
            'search'  => $request->input('search'),
            'sort'    => $request->input('sort'),
            'direction' => $request->input('direction'),
            'start_date' => $request->input('start_date'),
            'end_date'   => $request->input('end_date'),
        ];

        $result = $this->transactionService->list(
            $filters,
            $request->input('per_page', 15)
        );
        return TransactionResource::collection($result);
    }

    public function show(int $id)
    {
        $result = $this->transactionService->findOrFail($id);
        return new TransactionResource($result);
    }

    public function store(StoreTransactionRequest $request)
    {
        $result = $this->transactionService->create($request->validated());
        return new TransactionResource($result);
    }

    public function update(int $id, UpdateTransactionRequest $request)
    {
        $result = $this->transactionService->update($id, $request->validated());
        return new TransactionResource($result);
    }

    public function destroy(int $id)
    {
        $this->transactionService->delete($id);
        return response()->json(['message' => 'Transaction deleted successfully']);
    }
}
