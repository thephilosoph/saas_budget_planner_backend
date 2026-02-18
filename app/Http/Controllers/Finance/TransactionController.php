<?php

namespace App\Http\Controllers\Finance;

use App\Contracts\Services\Finance\TransactionServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\CreateTransactionRequest;
use App\Http\Requests\Finance\IndexTransactionRequest;
use App\Http\Requests\Finance\StoreTransactionRequest;
use App\Http\Requests\Finance\UpdateTransactionRequest;
use App\Http\Resources\Finance\TransactionResource;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct(
        protected TransactionServiceInterface $transactionService
    ) {}

    public function index(IndexTransactionRequest $request)
    {
        $filters = [
            'filters' => $request->filters(),
            'search'  => $request->input('search'),
            'sort'    => $request->sort(),
            'direction' => $request->direction(),
            'start_date' => $request->input('start_date'),
            'end_date'   => $request->input('end_date'),
        ];

        $result = $this->transactionService->list(
            $filters,
            $request->perPage()
        );
        return TransactionResource::collection($result);
    }

    public function show(int $id)
    {
        $result = $this->transactionService->findOrFail($id);
        return new TransactionResource($result);
    }

    public function store(CreateTransactionRequest $request)
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
