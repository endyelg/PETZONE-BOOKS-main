<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class ChartController extends Controller
{

    // piechart
    public function pieChart()
    {
        $result = DB::table('CATEGORIES as c')
                    ->leftJoin('PRODUCTS as p', 'c.id', '=', 'p.category_id')
                    ->select(DB::raw('c.title AS category_title, COUNT(p.id) AS products_count'))
                    ->groupBy('c.id', 'c.title')
                    ->get();

        $labels = $result->pluck('category_title')->toArray(); // Extracting labels
        $data = $result->pluck('products_count')->toArray(); // Extracting data

        return response()->json(array('data' => $data, 'labels' => $labels));
    }

    // linechart
    public function lineChart()
    {
        $line = DB::table('ORDERS as o')
                    ->join('ORDER_PRODUCT as op', 'o.id', '=', 'op.order_id')
                    ->select(DB::raw("DATE_FORMAT(o.date_placed, '%M') AS month, SUM(o.price) AS total_sales"))
                    ->groupBy(DB::raw("DATE_FORMAT(o.date_placed, '%M')"))
                    ->orderBy(DB::raw("MONTH(o.date_placed)"))
                    ->get();
    
        // Extracting labels and data correctly
        $labels = $line->pluck('month')->toArray(); // Get month names as labels
        $data = $line->pluck('total_sales')->toArray(); // Get total sales as data
    
        return response()->json(['data' => $data, 'labels' => $labels]);
    }
    
    //barchart   
    public function barChart()
{
    $bar = DB::table('CATEGORIES as c')
                ->join('PRODUCTS as p', 'c.id', '=', 'p.category_id')
                ->join('ORDER_PRODUCT as op', 'p.id', '=', 'op.product_id')
                ->join('ORDERS as o', 'op.order_id', '=', 'o.id')
                ->groupBy('c.title')
                ->orderBy('total_sales')
                ->pluck(DB::raw('SUM(o.price) as total_sales'), 'c.title')
                ->all();

                $labels = (array_keys($bar));

                $data = array_values($bar);
                return response()->json(array('data' => $data, 'labels' => $labels));
}
}