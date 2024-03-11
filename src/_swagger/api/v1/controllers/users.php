<?php

/**
 * @OA\Schema(
 *        schema="UserInput",
 *        title="User input date",
 *        description="Schema for user input",
 *        @OA\Property(
 *            property="name",
 *            type="integer",
 *            example="Jose",
 *            description="Wallet of id"
 *        ),
 *        @OA\Property(
 *            property="email",
 *            type="integer",
 *            example="jose@gmail.com",
 *            description="Email for user"
 *        ),
 *        @OA\Property(
 *            property="cpf_cnpj",
 *            type="string",
 *            example=100,
 *            description="CPF/CNPJ for user"
 *        ),
 *        @OA\Property(
 *            property="type",
 *            type="string",
 *            example="shopkeeper",
 *            description="Type user"
 *        ),
 *        @OA\Property(
 *            property="password",
 *            type="string",
 *            example="123456",
 *            description="Password"
 *         )
 *    )
 *
 * @OA\Schema(
 *       schema="WalletUserOutput",
 *       title="Wallet of user",
 *       description="Schema for wallet of user",
 *       @OA\Property(
 *           property="wallet_id",
 *           type="integer",
 *           example=1,
 *           description="Wallet of id"
 *       ),
 *       @OA\Property(
 *           property="user_id",
 *           type="integer",
 *           example=1,
 *           description="User id of wallet"
 *       ),
 *       @OA\Property(
 *           property="balance",
 *           type="string",
 *           example=100,
 *           description="Balance of wallet"
 *       ),
 *       @OA\Property(
 *           property="status",
 *           type="string",
 *           example="open",
 *           description="Status of wallet"
 *       )
 *   )
 *
 *  @OA\Schema(
 *      schema="UserOutput",
 *      title="User input date",
 *      description="Schema for input user",
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          example=1,
 *          description="Identifier"
 *      ),
 *      @OA\Property(
 *          property="name",
 *          type="integer",
 *          example="Jose",
 *          description="Name of user"
 *      ),
 *      @OA\Property(
 *          property="email",
 *          type="string",
 *          example="jose@gmail.com",
 *          description="Email of user"
 *      ),
 *      @OA\Property(
 *          property="cpf_cnpj",
 *          type="string",
 *          example="1234567890",
 *          description="CPF/CNPJ of user"
 *      ),
 *      @OA\Property(
 *          property="type",
 *          type="string",
 *          example="person",
 *          description="Type of user"
 *      ),
 *      @OA\Property(
 *          property="status",
 *          type="string",
 *          example="active",
 *          description="Status of user"
 *      ),
 *      @OA\Property(
 *          property="wallet",
 *          type="array",
 *          @OA\Items(ref="#/components/schemas/WalletUserOutput"),
 *          description="Wallet of user"
 *      )
 *  )
 *
 * @OA\Get(
 *     path="/api/v1/users",
 *     tags={"users"},
 *     summary="List users",
 *     @OA\Response(
 *       response=200,
 *       description="List users"
 *     ),
 *     @OA\Response(
 *       response="500",
 *       description="error"
 *     ),
 *     security={{ "bearerAuth": {} }}
 *   )
 *
 * @OA\Get(
 *     path="/api/v1/users/{id}",
 *     tags={"users"},
 *     summary="List user by id",
 *     @OA\Parameter(
 *       name="id",
 *       in="path",
 *       description="ID user",
 *       required=true,
 *       @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *       response=200,
 *       description="List user by id"
 *     ),
 *     @OA\Response(
 *       response="500",
 *       description="error"
 *     ),
 *     security={{ "bearerAuth": {} }}
 *   )
 *
 * @OA\Post(
 *      path="/api/v1/users",
 *      tags={"users"},
 *      summary="List users",
 *      @OA\RequestBody(
 *          required=true,
 *          description="User inputs",
 *          @OA\JsonContent(ref="#/components/schemas/UserInput")
 *      ),
 *      @OA\Response(
 * *         response=200,
 * *         description="User create",
 * *         @OA\JsonContent(ref="#/components/schemas/UserOutput")
 * *    ),
 *      @OA\Response(
 *        response="500",
 *        description="error"
 *      ),
 *      security={{ "bearerAuth": {} }}
 *    )
 */
