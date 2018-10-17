<?php

namespace App\Http\Controllers;

use App\Features\CreateAccountFeature;
use App\Features\DeleteAccountFeature;
use App\Features\ListAccountsFeature;
use App\Features\ShowAccountFeature;
use App\Features\UpdateAccountFeature;

class AccountController extends Controller
{
    /**
     * @OA\Get(
     *   path="/api/v1/accounts",
     *   tags={"accounts"},
     *   summary="Get list of accounts",
     *   description="",
     *   operationId="listAccounts",
     *   security={{"api_key": {}}},
     *   @OA\Parameter(ref="#/components/parameters/page_number"),
     *   @OA\Response(
     *       response=200,
     *       ref="#/components/responses/paginated_account_list"
     *   ),
     *   @OA\Response(response=401, ref="#/components/responses/unauthenticated")
     * )
     */
    public function index()
    {
        return $this->serve(ListAccountsFeature::class);
    }

    /**
     * @OA\Post(
     *   path="/api/v1/accounts",
     *   tags={"accounts"},
     *   summary="Create account",
     *   description="",
     *   operationId="createAccount",
     *   security={{"api_key": {}}},
     *   @OA\RequestBody(ref="#/components/requestBodies/account_request"),
     *   @OA\Response(
     *       response=200,
     *       ref="#/components/responses/account_data"
     *   ),
     *   @OA\Response(response=401, ref="#/components/responses/unauthenticated")
     * )
     */
    public function store()
    {
        return $this->serve(CreateAccountFeature::class);
    }

    /**
     * @OA\Get(
     *   path="/api/v1/accounts/{account_id}",
     *   tags={"accounts"},
     *   summary="Get account",
     *   description="",
     *   operationId="getAccount",
     *   security={{"api_key": {}}},
     *   @OA\Parameter(ref="#/components/parameters/account_id"),
     *   @OA\Response(
     *       response=200,
     *       ref="#/components/responses/account_data"
     *   ),
     *   @OA\Response(response=404, ref="#/components/responses/not_found"),
     *   @OA\Response(response=401, ref="#/components/responses/unauthenticated")
     * )
     */
    public function show()
    {
        return $this->serve(ShowAccountFeature::class);
    }

    /**
     * @OA\Put(
     *   path="/api/v1/accounts/{account_id}",
     *   tags={"accounts"},
     *   summary="Update account",
     *   description="",
     *   operationId="updateAccount",
     *   security={{"api_key": {}}},
     *   @OA\Parameter(ref="#/components/parameters/account_id"),
     *   @OA\RequestBody(ref="#/components/requestBodies/account_request"),
     *   @OA\Response(
     *       response=200,
     *       ref="#/components/responses/account_data"
     *   ),
     *   @OA\Response(response=404, ref="#/components/responses/not_found"),
     *   @OA\Response(response=401, ref="#/components/responses/unauthenticated")
     * )
     */
    public function update()
    {
        return $this->serve(UpdateAccountFeature::class);
    }

    /**
     * @OA\Delete(
     *   path="/api/v1/accounts/{account_id}",
     *   tags={"accounts"},
     *   summary="Update account",
     *   description="",
     *   operationId="deleteAccount",
     *   security={{"api_key": {}}},
     *   @OA\Parameter(ref="#/components/parameters/account_id"),
     *   @OA\Response(
     *       response=200,
     *       description="Account successfully removed",
     *       @OA\JsonContent(
     *           @OA\Property(
     *               property="status",
     *               description="Response status code",
     *               type="integer",
     *               example=200
     *           ),
     *           @OA\Property(
     *               property="data",
     *               description="Response data",
     *               type="boolean",
     *               example=true
     *           )
     *       )
     *   ),
     *   @OA\Response(response=404, ref="#/components/responses/not_found"),
     *   @OA\Response(response=401, ref="#/components/responses/unauthenticated")
     * )
     */
    public function destroy()
    {
        return $this->serve(DeleteAccountFeature::class);
    }
}
