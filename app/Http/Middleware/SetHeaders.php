<?php

namespace App\Http\Middleware;

use App\Utils\ApiResponse;
use Closure;
use Illuminate\Http\Request;

class SetHeaders
{
    public function handle(Request $request, Closure $next)
    {
        // Only enforce the header check for non-GET requests
        // if ($request->method() !== 'GET') {
        //     if (!$request->hasHeader('accept') || $request->header('accept') !== "application/json") {
        //         $error = 'The Header is required to have {Accept: application/json}';
        //         return ApiResponse::ofClientError(__($error), [__($error)]);
        //     }
        // }

        return $next($request);
    }
}
