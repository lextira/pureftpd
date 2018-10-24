<?php

namespace App\Http\Controllers;

use App\Features\CheckHealthFeature;

/**
 * @OA\Response(
 *     response="health_check_ok",
 *     description="Service is running smoothly",
 *     @OA\JsonContent(
 *         @OA\Property(
 *             property="status",
 *             type="integer",
 *             example=200
 *         ),
 *         @OA\Property(
 *             property="data",
 *             type="object",
 *             @OA\Property(
 *                 property="db_status",
 *                 type="string",
 *                 example="OK"
 *             ),
 *             @OA\Property(
 *                 property="ftp_status",
 *                 type="string",
 *                 example="OK"
 *             ),
 *             @OA\Property(
 *                 property="ssl_status",
 *                 type="string",
 *                 example="OK"
 *             )
 *         )
 *     )
 * )
 *
 * @OA\Response(
 *     response="health_check_error",
 *     description="Something went wrong",
 *     @OA\JsonContent(
 *         @OA\Property(
 *             property="status",
 *             type="integer",
 *             example=500
 *         ),
 *         @OA\Property(
 *             property="data",
 *             type="object",
 *             @OA\Property(
 *                 property="db_status",
 *                 type="string",
 *                 example="OK"
 *             ),
 *             @OA\Property(
 *                 property="ftp_status",
 *                 type="string",
 *                 example="Unable to connect"
 *             ),
 *             @OA\Property(
 *                 property="ssl_status",
 *                 type="string",
 *                 example="SSL routines:CONNECT_CR_CERT:certificate verify failed"
 *             )
 *         )
 *     )
 * )
 */
class HealthController extends Controller
{
    /**
     * @OA\Get(
     *   path="/api/v1/health/check",
     *   tags={"health"},
     *   summary="Checks FTP, DB and SSL services",
     *   description="",
     *   operationId="checkHealth",
     *   @OA\Response(response=200, ref="#/components/responses/health_check_ok"),
     *   @OA\Response(response=500, ref="#/components/responses/health_check_error")
     * )
     */
    public function check()
    {
        return $this->serve(CheckHealthFeature::class);
    }
}
