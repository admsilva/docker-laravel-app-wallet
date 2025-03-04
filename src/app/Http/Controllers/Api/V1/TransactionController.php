<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\TransactionRequest;
use App\Http\Resources\Api\V1\TransactionResource;
use App\Services\TransactionService;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

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
    #[OA\Get(
        path: '/api/v1/transactions/byWallet/{id}',
        summary: 'List transaction by wallet id',
        security: [
            [
                'bearerAuth' => []
            ]
        ],
        tags: ['Transactions'],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: 'Transactions by wallet id retrieved success'),
            new OA\Response(response: Response::HTTP_UNAUTHORIZED, description: 'Unauthorized'),
            new OA\Response(response: Response::HTTP_NOT_FOUND, description: 'not found'),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: 'Server Error')
        ]
    )]
    public function showTransactionsByWalletId(
        #[OA\PathParameter(required: true)]
        int $id
    ): JsonResponse|TransactionResource {
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
    #[OA\Get(
        path: '/api/v1/transactions/{id}',
        summary: 'List transaction by id',
        security: [
            [
                'bearerAuth' => []
            ]
        ],
        tags: ['Transactions'],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: 'Transactions retrieved success'),
            new OA\Response(response: Response::HTTP_UNAUTHORIZED, description: 'Unauthorized'),
            new OA\Response(response: Response::HTTP_NOT_FOUND, description: 'Not found'),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: 'Server error')
        ]
    )]
    public function show(
        #[OA\PathParameter(required: true)]
        int $id
    ): JsonResponse|TransactionResource {
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
    #[OA\Post(
        path: '/api/v1/transactions',
        summary: 'Save transaction',
        security: [
            [
                'bearerAuth' => []
            ]
        ],
        requestBody: new OA\RequestBody(
            description: 'Inputs for create transaction',
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'wallet_payer_id', type: 'integer', example: 1),
                    new OA\Property(property: 'description', type: 'string', example: 'Deposit bill'),
                    new OA\Property(property: 'amount', type: 'integer', example: 100),
                    new OA\Property(property: 'type', type: 'string', example: 'deposit'),
                    new OA\Property(property: 'wallet_payee_id', type: 'integer', example: 'Payee user id'),
                ],
                type: 'object'
            )
        ),
        tags: ['Transactions'],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: 'Transactions saved success'),
            new OA\Response(response: Response::HTTP_UNAUTHORIZED, description: 'Unauthorized'),
            new OA\Response(response: Response::HTTP_NOT_FOUND, description: 'Not found'),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: 'Server error')
        ]
    )]
    public function store(TransactionRequest $request): TransactionResource|JsonResponse
    {
        try {
            $transaction = $this->transactionService->makeTransaction($request->all());

            return new TransactionResource($transaction)->response()->setStatusCode(201);
        }
        catch (Throwable $exception) {
            return response()->json([
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ], 500);
        }
    }
}
