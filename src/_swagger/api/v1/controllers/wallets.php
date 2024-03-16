<?php

/**
 * @OA\Tag(
 *       name="Wallets",
 *       description="Wallets api`s"
 * )
 *
 * @OA\Schema(
 *        schema="WalletInput",
 *        title="Wallet input date",
 *        description="Schema for wallet input",
 *        @OA\Property(
 *            property="user_id",
 *            type="integer",
 *            example=1,
 *            description="User id"
 *        ),
 *        @OA\Property(
 *            property="balance",
 *            type="integer",
 *            example=100,
 *            description="Balance of wallet"
 *        ),
 *        @OA\Property(
 *            property="status",
 *            type="string",
 *            example="open",
 *            description="Status of wallet"
 *        )
 *    )
 *
 *  @OA\Schema(
 *      schema="WalletOutput",
 *      title="Wallet input date",
 *      description="Schema for input wallet",
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          example=1,
 *          description="Identifier"
 *      ),
 *      @OA\Property(
 *          property="user_id",
 *          type="integer",
 *          example=1,
 *          description="User id"
 *      ),
 *      @OA\Property(
 *          property="balance",
 *          type="integer",
 *          example=100,
 *          description="Balance of wallet"
 *      ),
 *      @OA\Property(
 *          property="status",
 *          type="string",
 *          example="open",
 *          description="Status of wallet"
 *      )
 *  )
 *
 * @OA\Get(
 *     path="/api/v1/wallets",
 *     tags={"Wallets"},
 *     summary="List wallets",
 *     @OA\Response(
 *       response=200,
 *       description="List wallets"
 *     ),
 *     @OA\Response(
 *       response="500",
 *       description="error"
 *     ),
 *     security={{ "bearerAuth": {} }}
 *   )
 *
 * @OA\Get(
 *     path="/api/v1/wallets/{id}",
 *     tags={"Wallets"},
 *     summary="List wallet by id",
 *     @OA\Parameter(
 *       name="id",
 *       in="path",
 *       description="ID wallet",
 *       required=true,
 *       @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *       response=200,
 *       description="List wallet by id"
 *     ),
 *     @OA\Response(
 *       response="500",
 *       description="error"
 *     ),
 *     security={{ "bearerAuth": {} }}
 *   )
 *
 * @OA\Post(
 *      path="/api/v1/wallets",
 *      tags={"Wallets"},
 *      summary="Create wallet",
 *      @OA\RequestBody(
 *          required=true,
 *          description="Wallet input",
 *          @OA\JsonContent(ref="#/components/schemas/WalletInput")
 *      ),
 *      @OA\Response(
 *           response=200,
 *           description="User wallet",
 *           @OA\JsonContent(ref="#/components/schemas/WalletOutput")
 *      ),
 *      @OA\Response(
 *        response="500",
 *        description="error"
 *      ),
 *      security={{ "bearerAuth": {} }}
 *    )
 *
 * @OA\Put(
 *       path="/api/v1/wallets",
 *       tags={"Wallets"},
 *       summary="Update wallet",
 *       @OA\RequestBody(
 *           required=true,
 *           description="Wallet input",
 *           @OA\JsonContent(ref="#/components/schemas/WalletInput")
 *       ),
 *       @OA\Response(
 *            response=200,
 *            description="Wallet create",
 *            @OA\JsonContent(ref="#/components/schemas/WalletOutput")
 *       ),
 *       @OA\Response(
 *         response="500",
 *         description="error"
 *       ),
 *       security={{ "bearerAuth": {} }}
 *     )
 *
 * @OA\Delete(
 *      path="/api/v1/wallets/{id}",
 *      tags={"Wallets"},
 *      summary="Delete wallet by id",
 *      @OA\Parameter(
 *        name="id",
 *        in="path",
 *        description="ID wallet",
 *        required=true,
 *        @OA\Schema(type="integer")
 *      ),
 *      @OA\Response(
 *        response=204,
 *        description="Not content"
 *      ),
 *      @OA\Response(
 *        response="500",
 *        description="error"
 *      ),
 *      security={{ "bearerAuth": {} }}
 *    )
 */
