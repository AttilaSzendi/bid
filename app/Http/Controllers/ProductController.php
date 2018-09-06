<?php

namespace App\Http\Controllers;

use App\Product;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        return view('welcome', compact('product'));
    }
}
