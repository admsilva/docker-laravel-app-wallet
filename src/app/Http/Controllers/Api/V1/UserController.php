<?php


namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\UserRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Throwable;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * @var UserService
     */
    protected UserService $userService;

    /**
     * UserController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Get(
     *      path="/users",
     *      operationId="getAllUsers",
     *      tags={"Users"},
     *      summary="Get list of users",
     *      description="Returns list of users",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              description="list of users",
     *              type="object",
     *              @OA\Property(property="data", type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="id", type="number"),
     *                      @OA\Property(property="name", type="string"),
     *                      @OA\Property(property="email", type="string"),
     *                      @OA\Property(property="cpf_cnpj", type="string"),
     *                      @OA\Property(property="type", type="string"),
     *                      @OA\Property(property="status", type="string"),
     *                      @OA\Property(property="wallet", type="object",
     *                          @OA\Property(property="wallet_id", type="number"),
     *                          @OA\Property(property="user_id", type="number"),
     *                          @OA\Property(property="balance", type="number"),
     *                          @OA\Property(property="status", type="string"),
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
     * @return ResourceCollection|JsonResponse
     */
    public function index(): ResourceCollection|JsonResponse
    {
        try {
            $users = $this->userService->getAllUsers();

            return UserResource::collection($users);
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
     *      path="/users/{id}",
     *      operationId="getUsersById",
     *      tags={"Users"},
     *      summary="List user by id",
     *      description="Return data of user",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="user id",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              description="data of user",
     *              type="object",
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="id", type="number"),
     *                  @OA\Property(property="name", type="string"),
     *                  @OA\Property(property="email", type="string"),
     *                  @OA\Property(property="cpf_cnpj", type="string"),
     *                  @OA\Property(property="type", type="string"),
     *                  @OA\Property(property="status", type="string"),
     *                  @OA\Property(property="wallet", type="object",
     *                      @OA\Property(property="wallet_id", type="number"),
     *                      @OA\Property(property="user_id", type="number"),
     *                      @OA\Property(property="balance", type="number"),
     *                      @OA\Property(property="status", type="string"),
     *                   ),
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
     * @return UserResource|JsonResponse
     */
    public function show(int $id): UserResource|JsonResponse
    {
        try {
            $user = $this->userService->getUserById($id);

            return new UserResource($user);
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
     *      path="/users",
     *      operationId="storeUser",
     *      tags={"Users"},
     *      summary="Create user",
     *      description="Return create new user",
     *      @OA\RequestBody(
     *          @OA\MediaType( mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="name", type="string"),
     *                  @OA\Property(property="email", type="string"),
     *                  @OA\Property(property="cpf_cnpj", type="string"),
     *                  @OA\Property(property="type", type="string"),
     *                  @OA\Property(property="password", type="string"),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              description="data of new user",
     *              type="object",
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="id", type="number"),
     *                  @OA\Property(property="name", type="string"),
     *                  @OA\Property(property="email", type="string"),
     *                  @OA\Property(property="cpf_cnpj", type="string"),
     *                  @OA\Property(property="type", type="string"),
     *                  @OA\Property(property="status", type="string"),
     *                  @OA\Property(property="wallet", type="object",
     *                      @OA\Property(property="wallet_id", type="number"),
     *                      @OA\Property(property="user_id", type="number"),
     *                      @OA\Property(property="balance", type="number"),
     *                      @OA\Property(property="status", type="string"),
     *                   ),
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
     * @param UserRequest $request
     * @return UserResource|JsonResponse
     */
    public function store(UserRequest $request): UserResource|JsonResponse
    {
        try {
            $user = $this->userService->makeUser($request->all());

            return (new UserResource($user))->response()->setStatusCode(201);
        }
        catch (Throwable $exception) {
            return response()->json([
                'code' => $exception->getCode(),
                'message' => $exception->getPrevious()->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Put(
     *      path="/users/{id}",
     *      operationId="updateUser",
     *      tags={"Users"},
     *      summary="Update user",
     *      description="Return update user",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="user id",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          @OA\MediaType( mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="name", type="string"),
     *                  @OA\Property(property="email", type="string"),
     *                  @OA\Property(property="cpf_cnpj", type="string"),
     *                  @OA\Property(property="type", type="string"),
     *                  @OA\Property(property="password", type="string"),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              description="data of updated user",
     *              type="object",
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="id", type="number"),
     *                  @OA\Property(property="name", type="string"),
     *                  @OA\Property(property="email", type="string"),
     *                  @OA\Property(property="cpf_cnpj", type="string"),
     *                  @OA\Property(property="type", type="string"),
     *                  @OA\Property(property="status", type="string"),
     *                  @OA\Property(property="wallet", type="object",
     *                      @OA\Property(property="wallet_id", type="number"),
     *                      @OA\Property(property="user_id", type="number"),
     *                      @OA\Property(property="balance", type="number"),
     *                      @OA\Property(property="status", type="string"),
     *                   ),
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
     * @param UserRequest $request
     * @param int $id
     * @return UserResource|JsonResponse
     */
    public function update(UserRequest $request, int $id): UserResource|JsonResponse
    {
        try {
            $this->userService->changeUser($id, $request->all());

            $wallet = $this->userService->getUserById($id);

            return new UserResource($wallet);
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
     *      path="/users/{id}",
     *      operationId="deleteUser",
     *      tags={"Users"},
     *      summary="Delete user",
     *      description="Return delete user",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="user id",
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
     * @return UserResource|JsonResponse
     */
    public function destroy(int $id): UserResource|JsonResponse
    {
        try {
            $this->userService->deleteUser($id);

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
