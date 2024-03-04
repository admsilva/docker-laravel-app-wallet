<?php


namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\TransactionRequest;
use App\Http\Resources\Api\V1\TransactionResource;
use App\Services\TransactionService;
use Throwable;
use Illuminate\Http\JsonResponse;

/**
 * Class TransactionController
 * @package App\Http\Controllers
 */
class TransactionController extends Controller
{
    /**
     * TransactionController constructor.
     * @param TransactionService $transactionService
     */
    public function __construct(protected TransactionService $transactionService)
    {
    }

    /**
     * @param int $id
     * @return JsonResponse|TransactionResource
     */
    public function showTransactionsByWalletId(int $id): JsonResponse|TransactionResource
    {
        try {
            $transactions = $this->transactionService->getAllTransactionsByWalletId($id);

            return new TransactionResource($transactions);
        }
        catch (Throwable $exception) {
            return response()->json([
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * @param int $id
     * @return JsonResponse|TransactionResource
     */
    public function show(int $id): JsonResponse|TransactionResource
    {
        try {
            $transactions = $this->transactionService->getTransactionById($id);

            return new TransactionResource($transactions);
        }
        catch (Throwable $exception) {
            return response()->json([
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * @param TransactionRequest $request
     * @return TransactionResource|JsonResponse
     */
    public function store(TransactionRequest $request): TransactionResource|JsonResponse
    {
        try {
            $transaction = $this->transactionService->makeTransaction($request->all());

            return (new TransactionResource($transaction))->response()->setStatusCode(201);
        }
        catch (Throwable $exception) {
            return response()->json([
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ], 500);
        }
    }
}
