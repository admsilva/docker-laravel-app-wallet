<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Micro Wallet Documentation",
     *      description="Software for manage wallets and transictions by users",
     *      @OA\Contact(
     *          email="menezes.adolfo@gmail.com"
     *      ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     *
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="API Documentation for Micro Wallet"
     * )
     *
     * @OA\Tag(
     *     name="Micro Wallet",
     *     description="API Endpoints of Micro Wallet"
     * )
     */
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
