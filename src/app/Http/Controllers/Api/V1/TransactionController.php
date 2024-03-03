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
     * @var TransactionService
     */
    protected TransactionService $transactionService;

    /**
     * TransactionController constructor.
     * @param TransactionService $transactionService
     */
    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * @OA\Get(
     *      path="/transactions/byWallet/{id}",
     *      operationId="showTransactionsByWalletId",
     *      tags={"Transactions"},
     *      summary="Get list of transactions by wallet id",
     *      description="Returns transactions by wallet id",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="wallet id",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              description="transactions by wallet id",
     *              type="object",
     *              @OA\Property(property="data", type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="deposits", type="array",
     *                          @OA\Items(
     *                              @OA\Property(property="id", type="number"),
     *                              @OA\Property(property="wallet_payer_id", type="number"),
     *                              @OA\Property(property="amount", type="number"),
     *                              @OA\Property(property="description", type="string"),
     *                              @OA\Property(property="type", type="string"),
     *                              @OA\Property(property="status", type="string"),
     *                              @OA\Property(property="notify", type="string"),
     *                          ),
     *                      ),
     *                      @OA\Property(property="withdraws", type="array",
     *                          @OA\Items(
     *                              @OA\Property(property="id", type="number"),
     *                              @OA\Property(property="wallet_payer_id", type="number"),
     *                              @OA\Property(property="amount", type="number"),
     *                              @OA\Property(property="description", type="string"),
     *                              @OA\Property(property="type", type="string"),
     *                              @OA\Property(property="status", type="string"),
     *                              @OA\Property(property="notify", type="string"),
     *                          ),
     *                      ),
     *                      @OA\Property(property="transfers", type="array",
     *                          @OA\Items(
     *                              @OA\Property(property="id", type="number"),
     *                              @OA\Property(property="wallet_payer_id", type="number"),
     *                              @OA\Property(property="wallet_payee_id", type="number"),
     *                              @OA\Property(property="amount", type="number"),
     *                              @OA\Property(property="description", type="string"),
     *                              @OA\Property(property="type", type="string"),
     *                              @OA\Property(property="status", type="string"),
     *                              @OA\Property(property="notify", type="string"),
     *                          ),
     *                      ),
     *                  ),
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Error",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      )
     *     )
     *
     *
     * @param int $id
     * @return TransactionResource|JsonResponse
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
     * @OA\Get(
     *      path="/transactions/{id}",
     *      operationId="getTransactionById",
     *      tags={"Transactions"},
     *      summary="List transaction by id",
     *      description="Return data of transaction by id",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="transaction id",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              description="data of transaction by id",
     *              type="object",
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="id", type="number"),
     *                  @OA\Property(property="wallet_payer_id", type="number"),
     *                  @OA\Property(property="wallet_payee_id", type="number"),
     *                  @OA\Property(property="amount", type="number"),
     *                  @OA\Property(property="description", type="string"),
     *                  @OA\Property(property="type", type="string"),
     *                  @OA\Property(property="status", type="string"),
     *                  @OA\Property(property="notify", type="string"),
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Erro",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      )
     *     )
     *
     *
     * @param int $id
     * @return TransactionResource|JsonResponse
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
     * @OA\Post(
     *      path="/transactions",
     *      operationId="storeTransactions",
     *      tags={"Transactions"},
     *      summary="Create transactions",
     *      description="Return create new transaction",
     *      @OA\RequestBody(
     *          @OA\MediaType( mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="wallet_payer_id", type="number"),
     *                  @OA\Property(property="wallet_payee_id", type="number"),
     *                  @OA\Property(property="amount", type="number"),
     *                  @OA\Property(property="description", type="string"),
     *                  @OA\Property(property="type", type="string"),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              description="data of new transaction",
     *              type="object",
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="id", type="number"),
     *                  @OA\Property(property="wallet_payer_id", type="number"),
     *                  @OA\Property(property="wallet_payee_id", type="number"),
     *                  @OA\Property(property="amount", type="number"),
     *                  @OA\Property(property="description", type="string"),
     *                  @OA\Property(property="type", type="string"),
     *                  @OA\Property(property="status", type="string"),
     *                  @OA\Property(property="notify", type="string"),
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=409,
     *          description="Conflict",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Erro",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      )
     *     )
     *
     *
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
