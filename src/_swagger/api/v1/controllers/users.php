<?php

/**
 *
 * @OA\Tag(
 *      name="User",
 *      description="User"
 *  )
 *
 *  @OA\Schema(
 *      schema="UserResource",
 *      @OA\Property(property="message", type="string", example="success", description="Get user message"),
 *      @OA\Property(
 *          property="model",
 *          type="object",
 *          @OA\Property(property="first_name", type="string", example="Mary", description="Name of user"),
 *          @OA\Property(property="last_name", type="string", example="Silva", description="Last name of user"),
 *          @OA\Property(property="photo", type="string", example="/storage/profiles/mary.jpg", description="Path of photo"),
 *          @OA\Property(property="rep_photo", type="integer", example="602", description="Repository code of phpto"),
 *          @OA\Property(property="mobile_phone", type="string", example="+55 11 99364 5540", description="Mobile phone of user"),
 *          @OA\Property(property="language_id", type="string", example="1", description="Language code of user"),
 *          @OA\Property(property="job", type="string", example="Developer", description="Job of user"),
 *          @OA\Property(property="department", type="string", example="IT", description="Department of user"),
 *          @OA\Property(property="email", type="string", example="mary@gmail.com", description="Email of user"),
 *          @OA\Property(property="id", type="integer", example="1", description="Code of user")
 *      )
 *  )
 *
 * @OA\Schema(
 *       schema="UserRequest",
 *       @OA\Property(property="first_name", type="string", example="Mary", description="Name of user"),
 *       @OA\Property(property="last_name", type="string", example="Silva", description="Last name of user"),
 *       @OA\Property(property="mobile_phone", type="string", example="+55 11 99364 5540", description="Mobile phone of user"),
 *       @OA\Property(property="language_id", type="string", example="1", description="Language code of user"),
 *       @OA\Property(property="email", type="string", example="mary@gmail.com", description="Email of user"),
 *       @OA\Property(property="job", type="string", example="Developer", description="Job of user"),
 *       @OA\Property(property="department", type="string", example="IT", description="Department of user"),
 *   )
 *
 * @OA\Schema(
 *      schema="UserPasswordChangeRequest",
 *      @OA\Property(property="current_password", type="integer", example=123456, description="Current passowrd of auth user"),
 *      @OA\Property(property="password", type="string", example="12345678", description="New password of auth user"),
 *      @OA\Property(property="system", type="string", example="snapper", description="System of user")
 *  )
 *
 * @OA\Get(
 *     path="/api/snapper/v1/users/{id}",
 *     tags={"SnapperUser"},
 *     summary="Get user details by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID of the user",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful request",
 *         @OA\JsonContent(ref="#/components/schemas/UserResource")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found"
 *     ),
 *     security={{"bearerAuth": {}}}
 * )
 *
 * @OA\Post(
 *      path="/api/snapper/v1/users/",
 *      tags={"SnapperUser"},
 *      summary="Storage new user",
 *      @OA\RequestBody(
 *          required=true,
 *          description="Request of user",
 *          @OA\JsonContent(ref="#/components/schemas/UserRequest")
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Successful request",
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="User not found"
 *      ),
 *      security={{"bearerAuth": {}}}
 *  )
 *
 * @OA\Put(
 *      path="/api/snapper/v1/users/{id}",
 *      tags={"SnapperUser"},
 *      summary="Update user by ID",
 *      @OA\Parameter(
 *          name="id",
 *          in="path",
 *          description="ID of the user",
 *          required=true,
 *          @OA\Schema(type="integer")
 *      ),
 *      @OA\RequestBody(
 *           required=true,
 *           description="Request of user",
 *           @OA\JsonContent(ref="#/components/schemas/UserRequest")
 *      ),
 *      @OA\Response(
 *           response=200,
 *           description="Successful request",
 *       ),
 *      @OA\Response(
 *          response=404,
 *          description="User not found"
 *      ),
 *      security={{"bearerAuth": {}}}
 *  )
 *
 * @OA\Delete(
 *       path="/api/snapper/v1/users/{id}",
 *       tags={"SnapperUser"},
 *       summary="Delete user by ID",
 *       @OA\Parameter(
 *           name="id",
 *           in="path",
 *           description="ID of the user",
 *           required=true,
 *           @OA\Schema(type="integer")
 *       ),
 *       @OA\Response(
 *            response=200,
 *            description="Successful request",
 *        ),
 *       @OA\Response(
 *           response=404,
 *           description="User not found"
 *       ),
 *       security={{"bearerAuth": {}}}
 *   )
 *
 * @OA\Post(
 *       path="/api/snapper/v1/users/update/password",
 *       tags={"SnapperUser"},
 *       summary="Change auth user password",
 *       @OA\RequestBody(
 *          required=true,
 *          description="Change password of auth user",
 *          @OA\JsonContent(ref="#/components/schemas/UserPasswordChangeRequest")
 *       ),
 *       @OA\Response(
 *           response=200,
 *           description="Successful request",
 *       ),
 *       @OA\Response(
 *           response=404,
 *           description="User not found"
 *       ),
 *       security={{"bearerAuth": {}}}
 *   )
 */
