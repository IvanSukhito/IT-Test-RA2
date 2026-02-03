<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AppendTokenToResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($response instanceof \Illuminate\Http\JsonResponse && $request->user()) {
            $data = $response->getData(true);

            // Selipkan token yang sedang aktif
            // Jika ingin meniru GM (selalu kirim token), pakai cara ini:
            $data['data']['_token'] = $request->bearerToken();

            $response = $response->setData($data);
        }
        return $response;
    }
}
