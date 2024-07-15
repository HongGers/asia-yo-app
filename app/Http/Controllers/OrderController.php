<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use Illuminate\Http\JsonResponse;
use App\Service\OrderService;

class OrderController extends Controller
{
    public function create(OrderRequest $request): JsonResponse
    {
        //validate the input request
        $request->validated();

        //pass the input request to the transform service
        $transformedOrder = OrderService::transformOrder($request);

        return response()->json([
            'message' => 'Order created successfully',
            'data' => $transformedOrder->all()
        ]);
    }
}
