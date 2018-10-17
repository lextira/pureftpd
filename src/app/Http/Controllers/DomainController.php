<?php

namespace App\Http\Controllers;

use App\Features\ListDomainsFeature;

class DomainController extends Controller
{
    /**
     * @OA\Get(
     *   path="/api/v1/domains",
     *   tags={"domains"},
     *   summary="Get list of domains",
     *   description="",
     *   operationId="lisDomains",
     *   security={{"api_key": {}}},
     *   @OA\Parameter(ref="#/components/parameters/page_number"),
     *   @OA\Response(
     *       response=200,
     *       ref="#/components/responses/domain_list"
     *   ),
     *   @OA\Response(response=401, ref="#/components/responses/unauthenticated")
     * )
     */
    public function index()
    {
        return $this->serve(ListDomainsFeature::class);
    }
}
