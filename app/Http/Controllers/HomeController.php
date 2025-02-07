<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class HomeController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'message' => __('home.index.success')
        ]);
    }
}
