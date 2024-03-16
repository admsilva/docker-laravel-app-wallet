<?php

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0.0",
 *         title=L5_SWAGGER_CONST_APP_NAME,
 *     ),
 *     @OA\Server(
 *         description="API",
 *         url=L5_SWAGGER_CONST_HOST,
 *     ),
 * )
 *
 * @OA\SecurityScheme(
 *     type="http",
 *     description="Logar com token",
 *     name="token",
 *     in="header",
 *     scheme="bearer",
 *     securityScheme="bearerAuth",
 * )
 */
