<?php

namespace App\Http\Controllers\Core;

use App\Contracts\Services\Finance\TransactionServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Core\IndexTransactionRequest;
use App\Http\Requests\Finance\CreateTransactionRequest;
use App\Http\Requests\Finance\UpdateTransactionRequest;
use App\Http\Resources\Finance\TransactionResource;
use App\Models\Transaction;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TransactionController extends Controller
{
    use AuthorizesRequests;

    public function __construct(protected TransactionServiceInterface $transactionService)
    {
    }

    public function index(IndexTransactionRequest $request)
    {

        $transactions = $this->transactionService->list([
            "filters" => $request->filters(),
            "sort" => $request->sort(),
            "direction" => $request->direction(),
            "perPage" => $request->perPage(),
            "relations" => $request->relations()
            ]
        );

        return TransactionResource::collection($transactions);
    }

    public function show(int $id)
    {
        $this->authorize('view', Transaction::class);
        $result = $this->transactionService->findOrFail($id);
        return new TransactionResource($result);
    }

    public function create(CreateTransactionRequest $request)
    {
        $this->authorize('create', Transaction::class);
        $result = $this->transactionService->create($request->validated());
        return new TransactionResource($result);
    }

    public function update(int $id,UpdateTransactionRequest $request)
    {
        $this->authorize('update', Transaction::class);
        $result = $this->transactionService->update($id, $request->validated());
        return new TransactionResource($result);
    }

    public function delete(int $id){
        $this->authorize('delete', Transaction::class);
        $deleted = $this->transactionService->delete($id);
        if($deleted){
            return response()->json(["message"=>"Category deleted successfully"]);
        }
        return response()->json(["message"=>"Category deleted failed"]);

    }
}
