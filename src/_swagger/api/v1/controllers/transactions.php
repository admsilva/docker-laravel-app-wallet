<?php

/**
 * @OA\Tag(
 *       name="Transactions",
 *       description="Transactions api`s"
 * )
 *
 * @OA\Schema(
 *        schema="TransactionInput",
 *        title="Transaction input date",
 *        description="Schema for transaction input",
 *        @OA\Property(
 *            property="wallet_payer_id",
 *            type="integer",
 *            example=1,
 *            description="Payer user id"
 *        ),
 *        @OA\Property(
 *            property="description",
 *            type="string",
 *            example="Deposit bill",
 *            description="Description of transaction"
 *        ),
 *        @OA\Property(
 *            property="amount",
 *            type="integer",
 *            example=100,
 *            description="Amount of transaction"
 *         ),
 *        @OA\Property(
 *            property="type",
 *            type="string",
 *            example="deposit",
 *            description="Balance of wallet"
 *        ),
 *        @OA\Property(
 *            property="wallet_payee_id",
 *            type="integer",
 *            example=1,
 *            description="Payee user id"
 *        )
 *    )
 *
 *  @OA\Schema(
 *      schema="TransactionOutput",
 *      title="Transaction output date",
 *      description="Schema for output transaction",
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          example=1,
 *          description="Identifier"
 *      ),
 *      @OA\Property(
 *          property="wallet_payer_id",
 *          type="integer",
 *          example=1,
 *          description="Payer user id"
 *      ),
 *      @OA\Property(
 *          property="description",
 *          type="string",
 *          example="Deposit bill",
 *          description="Description of transaction"
 *      ),
 *      @OA\Property(
 *          property="amount",
 *          type="integer",
 *          example=100,
 *          description="Amount of transaction"
 *      ),
 *      @OA\Property(
 *          property="type",
 *          type="string",
 *          example="deposit",
 *          description="Balance of wallet"
 *      ),
 *      @OA\Property(
 *          property="wallet_payee_id",
 *          type="integer",
 *          example=1,
 *          description="Payee user id"
 *      ),
 *      @OA\Property(
 *          property="status",
 *          type="string",
 *          example="success",
 *          description="Status transaction"
 *      ),
 *      @OA\Property(
 *          property="notify",
 *          type="string",
 *          example="success",
 *          description="Notify transaction"
 *      )
 *  )
 *
 * @OA\Schema(
 *       schema="WalletTransactionsOutput",
 *       title="Wallet transactions output date",
 *       description="Schema for output wallet transactions",
 *       @OA\Property(
 *           property="deposits",
 *           type="array",
 *           @OA\Items(ref="#/components/schemas/TransactionOutput"),
 *           description="Wallet of user deposits"
 *       ),
 *       @OA\Property(
 *           property="withdraws",
 *           type="array",
 *           @OA\Items(ref="#/components/schemas/TransactionOutput"),
 *           description="Wallet of user withdraws"
 *       ),
 *       @OA\Property(
 *           property="transfers",
 *           type="array",
 *           @OA\Items(ref="#/components/schemas/TransactionOutput"),
 *           description="Wallet of user transfers"
 *       )
 *   )
 *
 * @OA\Get(
 *     path="/api/v1/transactions/{id}",
 *     tags={"Transactions"},
 *     summary="List transaction by id",
 *     @OA\Parameter(
 *       name="id",
 *       in="path",
 *       description="ID transaction",
 *       required=true,
 *       @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *       response=200,
 *       description="Transaction by id",
 *       @OA\JsonContent(ref="#/components/schemas/TransactionOutput")
 *     ),
 *     @OA\Response(
 *       response="500",
 *       description="error"
 *     ),
 *     security={{ "bearerAuth": {} }}
 *   )
 *
 * @OA\Get(
 *     path="/api/v1/transactions/byWallet/{id}",
 *     tags={"Transactions"},
 *     summary="List transaction by wallet id",
 *     @OA\Parameter(
 *       name="id",
 *       in="path",
 *       description="ID wallet",
 *       required=true,
 *       @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *       response=200,
 *       description="Transaction by id",
 *       @OA\JsonContent(ref="#/components/schemas/WalletTransactionsOutput")
 *     ),
 *     @OA\Response(
 *       response="500",
 *       description="error"
 *     ),
 *     security={{ "bearerAuth": {} }}
 *   )
 *
 * @OA\Post(
 *      path="/api/v1/transactions",
 *      tags={"Transactions"},
 *      summary="Create transaction",
 *      @OA\RequestBody(
 *          required=true,
 *          description="Transaction input",
 *          @OA\JsonContent(ref="#/components/schemas/TransactionInput")
 *      ),
 *      @OA\Response(
 *           response=200,
 *           description="Transaction output",
 *           @OA\JsonContent(ref="#/components/schemas/TransactionOutput")
 *      ),
 *      @OA\Response(
 *        response="500",
 *        description="error"
 *      ),
 *      security={{ "bearerAuth": {} }}
 *    )
 */
