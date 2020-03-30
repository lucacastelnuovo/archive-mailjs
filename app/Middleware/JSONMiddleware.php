<?php

namespace App\Middleware;

use App\Helpers\StringHelper;
use MiladRahimi\PhpRouter\Middleware;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class JSONMiddleware implements Middleware
{
    /**
     * If POST,PUT,PATCH requests contains JSON interpret it
     * Also validate that the provided JSON is valid.
     *
     * @param Request $request
     * @param $next
     *
     * @return mixed
     */
    public function handle(ServerRequestInterface $request, $next)
    {
        if (in_array($request->getMethod(), ['POST', 'PUT'])) {
            if (!StringHelper::contains($request->getHeader('content-type')[0], '/json')) {
                return new JsonResponse([
                    'success' => false,
                    'errors' => [
                        'status' => 400,
                        'title' => 'invalid_content_type',
                        'detail' => "Content-Type should be 'application/json'"
                    ]
                ], 400);
            }

            $data = json_decode($request->getBody()->getContents());

            if ((JSON_ERROR_NONE !== json_last_error())) {
                return new JsonResponse([
                    'success' => false,
                    'errors' => [
                        'status' => 400,
                        'title' => 'invalid_json',
                        'detail' => 'Problems parsing provided JSON'
                    ]
                ], 400);
            }

            $request->data = $data;
            $request->isJSON = true;
        }

        return $next($request);
    }
}