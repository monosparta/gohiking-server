<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * @SWG\Swagger(
 *     @OA\Info(title="XX接口说明文档", version="0.1")
 * )
 */

class SwaggerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/",
     *     operationId="getTaskList",
     *     tags={"Tasks"},
     *     summary="Get list of tasks",
     *     description="Returns list of tasks",
     *     @OA\Parameter(
     *         name="Accept",
     *         description="Accept header to specify api version",
     *         required=false,
     *         in="header",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         description="The page num of the list",
     *         required=false,
     *         in="query",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         description="The item num per page",
     *         required=false,
     *         in="query",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="The result of tasks"
     *     ),
     *     security={
     *         {"passport": {}},
     *     }
     * )
     */
    public function show()
    {
        echo date('Y-m-d H:i:s', time());
    }
}
