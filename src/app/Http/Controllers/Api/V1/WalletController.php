<?php


namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\WalletRequest;
use App\Services\WalletService;
use App\Http\Resources\Api\V1\WalletResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;
use OpenApi\Attributes as OA;

/**
 * Class WalletController
 * @package App\Http\Controllers
 */
class WalletController extends Controller
{
    /**
     * WalletController constructor.
     * @param WalletService $walletService
     */
    public function __construct(protected WalletService $walletService)
    {
    }

    /**
     * @return ResourceCollection|JsonResponse
     */
    #[OA\Get(
        path: '/api/v1/wallets',
        summary: 'List wallets',
        security: [
            [
                'bearerAuth' => []
            ]
        ],
        tags: ['Wallets'],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: 'List wallets'),
            new OA\Response(response: Response::HTTP_UNAUTHORIZED, description: 'Unauthorized'),
            new OA\Response(response: Response::HTTP_NOT_FOUND, description: 'Not found'),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: 'Server error')
        ]
    )]
    public function index(): ResourceCollection|JsonResponse
    {
        try {
            $wallets = $this->walletService->getAllWallets();

            return WalletResource::collection($wallets);
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
     * @return WalletResource|JsonResponse
     */
    #[OA\Get(
        path: '/api/v1/wallets/{id}',
        summary: 'List wallet by id',
        security: [
            [
                'bearerAuth' => []
            ]
        ],
        tags: ['Wallets'],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: 'List wallet by id'),
            new OA\Response(response: Response::HTTP_UNAUTHORIZED, description: 'Unauthorized'),
            new OA\Response(response: Response::HTTP_NOT_FOUND, description: 'Not found'),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: 'Server error')
        ]
    )]
    public function show(
        #[OA\PathParameter(required: true)]
        int $id
    ): WalletResource|JsonResponse {
        try {
            $wallet = $this->walletService->getWalletById($id);

            return new WalletResource($wallet);
        }
        catch (Throwable $exception) {
            return response()->json([
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * @param WalletRequest $request
     * @return WalletResource|JsonResponse
     */
    #[OA\Post(
        path: '/api/v1/wallets',
        summary: 'Create wallet',
        security: [
            [
                'bearerAuth' => []
            ]
        ],
        requestBody: new OA\RequestBody(
            description: 'Inputs for create wallet',
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'user_id', type: 'integer', example: 1),
                    new OA\Property(property: 'balance', type: 'integer', example: 100),
                    new OA\Property(property: 'status', type: 'string', example: 'Status of wallet'),
                ],
                type: 'object'
            )
        ),
        tags: ['Wallets'],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Wallet saved success',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'user_id', type: 'integer', example: 1),
                        new OA\Property(property: 'balance', type: 'integer', example: 100),
                        new OA\Property(property: 'status', type: 'string', example: 'Status of wallet'),
                    ],
                    type: 'object'
                ),
            ),
            new OA\Response(response: Response::HTTP_UNAUTHORIZED, description: 'Unauthorized'),
            new OA\Response(response: Response::HTTP_NOT_FOUND, description: 'Not found'),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: 'Server error')
        ]
    )]
    public function store(WalletRequest $request): WalletResource|JsonResponse
    {
        try {
            $wallet = $this->walletService->makeWallet($request->all());

            return (new WalletResource($wallet))->response()->setStatusCode(201);
        }
        catch (Throwable $exception) {
            return response()->json([
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * @param WalletRequest $request
     * @param int $id
     * @return WalletResource|JsonResponse
     */
    #[OA\Post(
        path: '/api/v1/wallets/{id}',
        summary: 'Update wallet',
        security: [
            [
                'bearerAuth' => []
            ]
        ],
        requestBody: new OA\RequestBody(
            description: 'Inputs for update wallet',
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'user_id', type: 'integer', example: 1),
                    new OA\Property(property: 'balance', type: 'integer', example: 100),
                    new OA\Property(property: 'status', type: 'string', example: 'Status of wallet'),
                ],
                type: 'object'
            )
        ),
        tags: ['Wallets'],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Wallet update success',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'user_id', type: 'integer', example: 1),
                        new OA\Property(property: 'balance', type: 'integer', example: 100),
                        new OA\Property(property: 'status', type: 'string', example: 'Status of wallet'),
                    ],
                    type: 'object'
                ),
            ),
            new OA\Response(response: Response::HTTP_UNAUTHORIZED, description: 'Unauthorized'),
            new OA\Response(response: Response::HTTP_NOT_FOUND, description: 'Not found'),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: 'Server error')
        ]
    )]
    public function update(
        WalletRequest $request,
        #[OA\PathParameter(required: true)]
        int $id
    ): WalletResource|JsonResponse {
        try {
            $this->walletService->changeWallet($id, $request->all());

            $wallet = $this->walletService->getWalletById($id);

            return new WalletResource($wallet);
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
     * @return WalletResource|JsonResponse
     */
    #[OA\Delete(
        path: '/api/v1/wallets/{id}',
        summary: 'Delete wallet by id',
        security: [
            [
                'bearerAuth' => []
            ]
        ],
        tags: ['Wallets'],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: 'Delete wallet by id'),
            new OA\Response(response: Response::HTTP_UNAUTHORIZED, description: 'Unauthorized'),
            new OA\Response(response: Response::HTTP_NOT_FOUND, description: 'Not found'),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: 'Server error')
        ]
    )]
    public function destroy(
        #[OA\PathParameter(required: true)]
        int $id
    ): WalletResource|JsonResponse {
        try {
            $this->walletService->deleteWallet($id);

            return response()->json()->setStatusCode(204);
        }
        catch (Throwable $exception) {
            return response()->json([
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ], 500);
        }
    }
}
