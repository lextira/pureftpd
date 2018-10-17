<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Lucid\Foundation\Http\Controller as LucidController;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0.0",
 *         title="Pure-FTPd API",
 *         description="Laravel based API for Pure-FTPd. For authorization use header:
              `Authorization: Bearer <Key_Token>`",
 *         @OA\Contact(
 *             email="dominik.kohler@lextira.ch"
 *         )
 *     ),
 *     @OA\ExternalDocumentation(
 *         description="Find out more about Pure-FTPd API",
 *         url="https://github.com/lextira/pureftpd-api"
 *     )
 * ),
 * @OA\Components(
 *     @OA\SecurityScheme(
 *         securityScheme="api_key",
 *         type="http",
 *         scheme="bearer",
 *         in="header",
 *         name="Authorization"
 *     ),
 *     @OA\Parameter(
 *         parameter="page_number",
 *         name="page",
 *         example=2,
 *         @OA\Schema(
 *             type="integer",
 *         ),
 *         in="query",
 *         required=true
 *     ),
 *     @OA\Parameter(
 *         parameter="account_id",
 *         name="account_id",
 *         example=2,
 *         @OA\Schema(
 *             type="integer",
 *         ),
 *         in="path",
 *         required=true
 *     ),
 *     @OA\Response(
 *         response="paginated_account_list",
 *         description="Response with paginated list of accounts",
 *         @OA\JsonContent(
 *             @OA\Property(ref="#/components/schemas/status_200", property="status"),
 *             @OA\Property(
 *                 property="data",
 *                 description="Response data",
 *                 type="object",
 *                 allOf={
 *                     @OA\Schema(ref="#/components/schemas/pagination_data"),
 *                     @OA\Schema(
 *                         @OA\Property(property="data",
 *                         @OA\Items(ref="#/components/schemas/Account"), type="array")
 *                     )
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response="paginated_domain_list",
 *         description="Response with paginated list of domains",
 *         @OA\JsonContent(
 *             @OA\Property(ref="#/components/schemas/status_200", property="status"),
 *             @OA\Property(
 *                 property="data",
 *                 description="Response data",
 *                 type="object",
 *                 allOf={
 *                     @OA\Schema(ref="#/components/schemas/pagination_data"),
 *                     @OA\Schema(
 *                         @OA\Property(property="data",
 *                         @OA\Items(ref="#/components/schemas/Domain"), type="array")
 *                     )
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response="account_data",
 *         description="Response with account info",
 *         @OA\JsonContent(ref="#/components/schemas/single_account")
 *     ),
 *     @OA\Response(
 *         response="unauthenticated",
 *         description="Unauthenticated response",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Unauthenticated"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response="not_found",
 *         description="Model was not found",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Model was not found"
 *             )
 *         )
 *     ),
 *     @OA\RequestBody(
 *         request="account_request",
 *         required=true,
 *         description="account_request",
 *         @OA\JsonContent(ref="#/components/schemas/Account")
 *     ),
 *     @OA\Schema(
 *         schema="single_account",
 *         @OA\Property(ref="#/components/schemas/status_200", property="status"),
 *         @OA\Property(
 *             property="data",
 *             description="Response data",
 *             type="object",
 *             ref="#/components/schemas/Account"
 *         )
 *     ),
 *     @OA\Property(
 *         schema="status_200",
 *         property="status",
 *         description="Response status code",
 *         type="integer",
 *         example=200,
 *     ),
 *     @OA\Schema(
 *         schema="pagination_data",
 *         @OA\Property(property="current_page", type="integer", example=1),
 *         @OA\Property(property="first_page_url", type="string", example="http://localhost/api/v1/accounts?page=1"),
 *         @OA\Property(property="from", type="integer", example=1),
 *         @OA\Property(property="last_page", type="integer", example=1),
 *         @OA\Property(property="last_page_url", type="string", example="http://localhost/api/v1/accounts?page=1"),
 *         @OA\Property(property="next_page_url", type="string|null", example="http://localhost/api/v1/accounts?page=1"),
 *         @OA\Property(property="path", type="string", example="http://localhost/api/v1/accounts"),
 *         @OA\Property(property="per_page", type="integer", example=15),
 *         @OA\Property(property="prev_page_url", type="string|null", example="ttp://localhost/api/v1/accounts?page=1"),
 *         @OA\Property(property="to", type="integer", example=10),
 *         @OA\Property(property="total", type="integer", example=25),
 *     )
 * )
 */
class Controller extends LucidController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
