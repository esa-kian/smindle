<?php

namespace App\Http\Controllers;

use App\DB\ItemRepo;
use App\DB\OrderRepo;
use App\Jobs\SubscriptionJob;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function store(Request $request, OrderRepo $orderRepo, ItemRepo $itemRepo)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'basket' => 'required|array'
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $order = $orderRepo->save($request);

        if ($request['basket']) {
            foreach ($request['basket'] as $item) {

                $itemRepo->save($order, $item);

                if ($item['type'] == 'subscription') {

                    dispatch(new SubscriptionJob($item));
                }
            }
        }


        return $order;
    }

    public function fetch()
    {
        return Order::with('basket')->get();
    }
}
