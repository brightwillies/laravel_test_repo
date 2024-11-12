<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class FrontendController extends Controller
{
    //

    public function index()
    {
        $products = $this->fetchProductsJsonData();
        return view('index', compact('products'));

    }

    public function saveProduct(Request $request)
    {

        $productData = [
            'product_name' => $request->input('product_name'),
            'product_quantity' => (int) $request->input('product_quantity'),
            'product_price' => (double) $request->input('product_price'),
            'datetime' => Carbon::now()->format('Y-m-d H:i:s'),
            'total_value' => (int) $request->input('product_quantity') * (float) $request->input('product_price'),
        ];

        $products = $this->fetchProductsJsonData();
        $products[] = $productData;

        Storage::put('products.json', json_encode($products));

        return response()->json(['success' => true, 'products' => $products]);
    }

    public function fetchProductsJsonData()
    {
        return json_decode(Storage::get('products.json'), true)?? [];
    }
}



