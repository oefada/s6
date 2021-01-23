<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderLineItem;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    //
    public function shop()
    {
        return Product::all();
    }

    public function placeOrder()
    {
        request()->validate([
            'products' => 'required|array',
            'quantities' => 'required|array',
        ]);

        $products = request()->products;
        $quantities = request()->quantities;

        $billing_address_id = auth()->user()->addresses()->first()->id;
        $shipping_address_id = auth()->user()->addresses()->first()->id;

        $sub_total = 0;
        foreach ($products as $key => $product) {
            $product = Product::find($product);
            if ($product) {
                $sub_total += $product->price * $quantities[$key];
            }
        }
        $tax = 0.05 * $sub_total;
        $total = $tax + $sub_total;
        $user_id = auth()->user()->id;

        $order = Order::create(compact('total', 'sub_total', 'tax', 'shipping_address_id', 'billing_address_id', 'user_id'));

        // $order = Order::find(1);


        foreach ($products as $key => $product) {
            $product = Product::find($product);
            if ($product) {
                $order->line_items()->save(new OrderLineItem([
                    'product_id' => $product->id,
                    'quantity' => $quantities[$key],
                    'vendor_id' => ProductType::find($product->product_type_id)->vendor_id,
                    'image_url' => $product->creative->image_url,
                ]));
            }
        }
        return $order;
    }
}
