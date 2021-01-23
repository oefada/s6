<?php

namespace App\Http\Controllers;

use App\Models\Creative;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CreativeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return auth()->user()->creatives;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'image_url' => 'required|string',
        ]);

        return auth()->user()->creatives()->save(new Creative(['image_url' => $request->image_url]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return auth()->user()->creatives()->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function listForSale($id)
    {
        request()->validate([
            'sku' => 'required|unique:products',
            'price' => 'required|numeric',
            'product_type' => 'required|string|exists:product_types,name'
        ]);



        return auth()->user()->creatives()->findOrFail($id)->products()->save(new Product([
            'user_id' => auth()->user()->id,
            'product_type_id' => ProductType::where('name', request()->product_type)->first()->id,
            'price' => request()->price,
            'sku' => request()->sku,
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $creative = auth()->user()->creatives()->findOrFail($id);
        $creative->update($request->all());
        return $creative;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $creative = auth()->user()->creatives()->findOrFail($id);
        $creative->delete();
        return ['success'];
    }
}
