<?php


namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\WalletRequest;
use App\Services\WalletService;
use App\Http\Resources\Api\V1\WalletResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\JsonResponse;
use Throwable;

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
    public function show(int $id): WalletResource|JsonResponse
    {
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
    public function update(WalletRequest $request, int $id): WalletResource|JsonResponse
    {
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
    public function destroy(int $id): WalletResource|JsonResponse
    {
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
