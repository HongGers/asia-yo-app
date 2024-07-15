<?php

namespace App\Service;

use App\Http\Requests\OrderRequest;

class OrderService
{
    /**
     * Transform the order  request to TWD.
     */
    static public function transformOrder(OrderRequest $order): OrderRequest
    {
        //define the currency that need to be transformed and its transform rate.
        $transformRateMap = [
            'USD' => 31
        ];

        //if currency is in the map, transform the price to TWD.
        $currency = $order['currency'];
        if (isset($transformRateMap[$currency])) {
            $order['price'] *= $transformRateMap[$currency];
            $order['currency'] = 'TWD';
        }

        return $order;
    }
}
