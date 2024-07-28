<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // Correct import
use Illuminate\Http\Request;
use App\Models\ProductStock;

class ProductStockController extends Controller
{
    public function index()
    {
        $productStocks = ProductStock::paginate(10);
        return view('admin.frontend.product_stock.index', compact('productStocks'));
    }
}
