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
     * UserController constructor.
     * @param UserService $userService
     */
    public function __construct(protected UserService $userService)
    {
    }

    /**
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
