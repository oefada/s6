<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderLineItem;
use Illuminate\Http\Request;
use Spatie\ArrayToXml\ArrayToXml;

class VendorController extends Controller
{
    //

    public function orders()
    {
        $orders = Order::whereHas('line_items', function ($q) {
            $q->where('vendor_id', auth()->user()->vendor->id)->where('status', 'processing');
        })->get();

        foreach ($orders as $order) {
            $order->line_items = $order->line_items()->where('vendor_id', auth()->user()->vendor->id)->get();
        }

        if (auth()->user()->vendor->id == 2) {
            $xml_array = [];

            foreach ($orders as $order) {
                $line_items = [];
                foreach ($order->line_items as $line_item) {
                    $line_items[] = [
                        'item' => [
                            'order_line_item_id' => $line_item->id,
                            'product_id' => $line_item->product_id,
                            'quantity' => $line_item->quantity,
                            'image_url' => $line_item->image_url,
                        ]
                    ];
                }
                $xml_array['orders']['order'][] =
                    [
                        'order_number' => $order->id,
                        'customer_data' => [
                            'first_name' => $order->shipping_address->first_name,
                            'last_name' => $order->shipping_address->last_name,
                            'address1' => $order->shipping_address->line_1,
                            'address2' => $order->shipping_address->line_2,
                            'city' => $order->shipping_address->city,
                            'state' => $order->shipping_address->state,
                            'zip' => $order->shipping_address->zip,
                            'country' => $order->shipping_address->country,
                        ],
                        'items' => $line_items
                    ];
            }
            return ArrayToXml::convert($xml_array);
        } elseif (auth()->user()->vendor->id == 1) {
            $json_output = [];
            foreach ($orders as $order) {
                $line_items = [];
                foreach ($order->line_items as $line_item) {
                    $line_items[] = [
                        'external_order_line_item_id' => $line_item->id,
                        'product_id' => $line_item->product_id,
                        'external_order_line_item_id' => $line_item->id,
                        'quantity' => $line_item->quantity,
                        'image_url' => $line_item->image_url,
                    ];
                }
                $json_output['data']['orders'][] = [
                    'external_order_id' => $order->id,
                    'buyer_first_name' => $order->shipping_address->first_name,
                    'buyer_last_name' => $order->shipping_address->last_name,
                    'buyer_shipping_address_1' => $order->shipping_address->line_1,
                    'buyer_shipping_address_2' => $order->shipping_address->line_2,
                    'buyer_shipping_city' => $order->shipping_address->city,
                    'buyer_shipping_state' => $order->shipping_address->state,
                    'buyer_shipping_postal' => $order->shipping_address->zip,
                    'buyer_shipping_country' => $order->shipping_address->country,
                    'print_line_items' => $line_items
                ];
            }
            return $json_output;
        }
    }
    public function orderUpdate()
    {
        request()->validate([
            'order_line_item_id' => 'required|string',
            'status' => 'required|in:shipped,cancelled',
        ]);

        $item_id = OrderLineItem::findOrFail(request()->order_line_item_id);
        $item_id->status = request()->status;
        $item_id->save();
        return ['status updated to ' . request()->status];
    }
}
