<?php


namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\UserRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Throwable;
use OpenApi\Attributes as OA;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * UserController constructor.
     * @param UserService $userService
     */
    public function __construct(protected UserService $userService)
    {
    }

    /**
     * @return ResourceCollection|JsonResponse
     */
    #[OA\Get(
        path: '/api/v1/users',
        summary: 'List users',
        security: [
            [
                'bearerAuth' => []
            ]
        ],
        tags: ['Users'],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: 'List users'),
            new OA\Response(response: Response::HTTP_UNAUTHORIZED, description: 'Unauthorized'),
            new OA\Response(response: Response::HTTP_NOT_FOUND, description: 'Not found'),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: 'Server error')
        ]
    )]
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
     * @param int $id
     * @return UserResource|JsonResponse
     */
    #[OA\Get(
        path: '/api/v1/users/{id}',
        summary: 'List user by id',
        security: [
            [
                'bearerAuth' => []
            ]
        ],
        tags: ['Users'],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: 'List user by id'),
            new OA\Response(response: Response::HTTP_UNAUTHORIZED, description: 'Unauthorized'),
            new OA\Response(response: Response::HTTP_NOT_FOUND, description: 'Not found'),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: 'Server error')
        ]
    )]
    public function show(
        #[OA\PathParameter(required: true)]
        int $id
    ): UserResource|JsonResponse {
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
     * @param UserRequest $request
     * @return UserResource|JsonResponse
     */
    #[OA\Post(
        path: '/api/v1/users',
        summary: 'Create user',
        security: [
            [
                'bearerAuth' => []
            ]
        ],
        requestBody: new OA\RequestBody(
            description: 'Inputs for create user',
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Jose'),
                    new OA\Property(property: 'email', type: 'string', example: 'jose@gmail.com'),
                    new OA\Property(property: 'cpf_cnpj', type: 'string', example: '12312312312'),
                    new OA\Property(property: 'type', type: 'string', example: 'shopkeeper'),
                    new OA\Property(property: 'status', type: 'string', example: 'active'),
                    new OA\Property(property: 'password', type: 'string', example: '123456'),
                ],
                type: 'object'
            )
        ),
        tags: ['Users'],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'User saved success',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'name', type: 'string', example: 'Jose'),
                        new OA\Property(property: 'email', type: 'string', example: 'jose@gmail.com'),
                        new OA\Property(property: 'cpf_cnpj', type: 'string', example: '12312312312'),
                        new OA\Property(property: 'type', type: 'string', example: 'shopkeeper'),
                        new OA\Property(property: 'status', type: 'string', example: 'active'),
                        new OA\Property(
                            property: 'wallet',
                            description: 'Wallet of user',
                            type: 'array',
                            items: new OA\Items(
                                properties: [
                                    new OA\Property(property: 'wallet_id', type: 'integer', example: 1),
                                    new OA\Property(property: 'user_id', type: 'integer', example: 1),
                                    new OA\Property(property: 'balance', type: 'integer', example: 100),
                                    new OA\Property(property: 'status', type: 'string', example: 'open'),
                                ]
                            )
                        ),
                    ],
                    type: 'object'
                ),
            ),
            new OA\Response(response: Response::HTTP_UNAUTHORIZED, description: 'Unauthorized'),
            new OA\Response(response: Response::HTTP_NOT_FOUND, description: 'not found'),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: 'Server Error')
        ]
    )]
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
     * @param UserRequest $request
     * @param int $id
     * @return UserResource|JsonResponse
     */
    #[OA\Put(
        path: '/api/v1/users/{id}',
        summary: 'Update users',
        security: [
            [
                'bearerAuth' => []
            ]
        ],
        requestBody: new OA\RequestBody(
            description: 'Inputs for update user',
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Jose'),
                    new OA\Property(property: 'email', type: 'string', example: 'jose@gmail.com'),
                    new OA\Property(property: 'cpf_cnpj', type: 'string', example: '12312312312'),
                    new OA\Property(property: 'type', type: 'string', example: 'shopkeeper'),
                    new OA\Property(property: 'status', type: 'string', example: 'active'),
                    new OA\Property(property: 'password', type: 'string', example: '123456'),
                ],
                type: 'object'
            )
        ),
        tags: ['Users'],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'User updated success',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'name', type: 'string', example: 'Jose'),
                        new OA\Property(property: 'email', type: 'string', example: 'jose@gmail.com'),
                        new OA\Property(property: 'cpf_cnpj', type: 'string', example: '12312312312'),
                        new OA\Property(property: 'type', type: 'string', example: 'shopkeeper'),
                        new OA\Property(property: 'status', type: 'string', example: 'active'),
                        new OA\Property(
                            property: 'wallet',
                            description: 'Wallet of user',
                            type: 'array',
                            items: new OA\Items(
                                properties: [
                                    new OA\Property(property: 'wallet_id', type: 'integer', example: 1),
                                    new OA\Property(property: 'user_id', type: 'integer', example: 1),
                                    new OA\Property(property: 'balance', type: 'integer', example: 100),
                                    new OA\Property(property: 'status', type: 'string', example: 'open'),
                                ]
                            )
                        ),
                    ],
                    type: 'object'
                ),
            ),
            new OA\Response(response: Response::HTTP_UNAUTHORIZED, description: 'Unauthorized'),
            new OA\Response(response: Response::HTTP_NOT_FOUND, description: 'not found'),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: 'Server Error')
        ]
    )]
    public function update(
        UserRequest $request,
        #[OA\PathParameter(required: true)]
        int $id
    ): UserResource|JsonResponse {
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
     * @param int $id
     * @return UserResource|JsonResponse
     */
    #[OA\Delete(
        path: '/api/v1/users/{id}',
        summary: 'Delete user by id',
        security: [
            [
                'bearerAuth' => []
            ]
        ],
        tags: ['Users'],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: 'Delete user by id'),
            new OA\Response(response: Response::HTTP_UNAUTHORIZED, description: 'Unauthorized'),
            new OA\Response(response: Response::HTTP_NOT_FOUND, description: 'Not found'),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: 'Server error')
        ]
    )]
    public function destroy(
        #[OA\PathParameter(required: true)]
        int $id
    ): UserResource|JsonResponse {
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
