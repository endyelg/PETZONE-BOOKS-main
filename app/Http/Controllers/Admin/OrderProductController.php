<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class OrderProductController extends Controller
{
    public function index()
    {
        // Fetch order_product entries with pagination
        $orderProducts = DB::table('order_product')->paginate(10);

        return view('admin.frontend.orders.index', compact('orderProducts'));
    }
}