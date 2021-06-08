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
     * @var WalletService
     */
    protected WalletService $walletService;

    /**
     * WalletController constructor.
     * @param WalletService $walletService
     */
    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    /**
     * @OA\Get(
     *      path="/wallets",
     *      operationId="getAllWallets",
     *      tags={"Wallets"},
     *      summary="Get list of wallets",
     *      description="Returns list of wallets",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              description="list of wallets",
     *              type="object",
     *              @OA\Property(property="data", type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="id", type="number"),
     *                      @OA\Property(property="user_id", type="number"),
     *                      @OA\Property(property="balance", type="number"),
     *                      @OA\Property(property="status", type="string"),
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
     * @OA\Get(
     *      path="/wallets/{id}",
     *      operationId="getWalletsById",
     *      tags={"Wallets"},
     *      summary="List wallet by id",
     *      description="Returns data of wallet",
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
     *              description="data of wallet",
     *              type="object",
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="id", type="number"),
     *                  @OA\Property(property="user_id", type="number"),
     *                  @OA\Property(property="balance", type="number"),
     *                  @OA\Property(property="status", type="string"),
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
     * @OA\Post(
     *      path="/wallets",
     *      operationId="storeWallet",
     *      tags={"Wallets"},
     *      summary="Create wallet",
     *      description="Return create new wallet",
     *      @OA\RequestBody(
     *          @OA\MediaType( mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="user_id", type="number"),
     *                  @OA\Property(property="balance", type="number"),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              description="data of new wallet",
     *              type="object",
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="id", type="number"),
     *                  @OA\Property(property="user_id", type="number"),
     *                  @OA\Property(property="balance", type="number"),
     *                  @OA\Property(property="status", type="string"),
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
     * @OA\Put(
     *      path="/wallets/{id}",
     *      operationId="updateWallet",
     *      tags={"Wallets"},
     *      summary="Update wallet",
     *      description="Return update wallet",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="wallet id",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          @OA\MediaType( mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="user_id", type="number"),
     *                  @OA\Property(property="balance", type="number"),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              description="data of updated wallet",
     *              type="object",
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="id", type="number"),
     *                  @OA\Property(property="user_id", type="number"),
     *                  @OA\Property(property="balance", type="number"),
     *                  @OA\Property(property="status", type="string"),
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
     * @OA\Delete(
     *      path="/wallets/{id}",
     *      operationId="deleteWallet",
     *      tags={"Wallets"},
     *      summary="Delete wallet",
     *      description="Return delete wallet",
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
     *          response=204,
     *          description="Successful operation",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found",
     *          @OA\MediaType(
     *              mediaType="application/json",
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
