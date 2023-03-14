<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAccessToken
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    $token = $request->header('X-API-KEY');
    if ($token !== config('app.API_TOKEN')) {
      return response()->json([
        'message' => 'Bad Request response status code indicates that the server cannot or will not process the request'
      ], 400);
    }
    return $next($request);
  }
}
