<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\JsonResponse;

class AttributeController extends Controller
{
    public function index(): JsonResponse
    {
        $attributes = Attribute::orderBy('sort_order')->get();

        return response()->json([
            'data' => $attributes,
        ]);
    }

    public function filterable(): JsonResponse
    {
        $attributes = Attribute::where('is_filterable', true)
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'data' => $attributes,
        ]);
    }
}
