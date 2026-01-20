<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;


abstract class Controller
{

    /**
     * @OA\Get(
     *     path="/api/health",
     *     tags={"Health"},
     *     summary="Health Check",
     *     description="Check if API is running",
     *     @OA\Response(response="200", description="API is running")
     * )
     */
    public function health()
    {
        return response()->json(['status' => 'ok']);
    }
}
