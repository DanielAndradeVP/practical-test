<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class Controller
{
    public const TYPE_SUCESS = 'sucess';

    public function ok($items = [], int $status = Response::HTTP_OK): JsonResponse
    {
        $data = [
            'type' => self::TYPE_SUCESS,
            'status' => $status,
            'data' => $items,
            'show' => false,
        ];

        return response()->json($data, $status);
    }
}
