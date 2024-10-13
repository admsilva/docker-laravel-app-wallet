<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Attributes as OA;

#[
    OA\Info(version: '1.0.0', description: 'Wallet API', title: 'Wallet-api Documentation'),
    OA\Server(url: 'http://localhost', description: 'local server'),
    OA\SecurityScheme( securityScheme: 'bearerAuth', type: 'http', name: 'Authorization', in: 'header', scheme: 'bearer')
]
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
