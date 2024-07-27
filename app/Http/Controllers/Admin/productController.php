<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Services\Admin\Traits\HasProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class productController extends Controller{
    use HasProduct;

    /**
     * Show products list
     *
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        if ($request->ajax()) {
            $products = Product::paginate(10); // 10 items per page for AJAX requests
            return response()->json($products);
        }

        $products = Product::paginate(10);

        return view('admin.frontend.products.list' , compact('products'));
    }

    /**
     * Show the form for create a new product
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $categories = Category::all();
        
        return view('admin.frontend.products.add' , compact('categories'));
    }

    /**
     * Store a new product
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $validator = $this->validateAddForm($request);

        $this->doStore($validator);

        return redirect()->route('api.admin.products.all')->with('simpleSuccessAlert' , 'New product added successfully');
    }

    /**
     * Show the form for edit a product
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product){
        $categories = Category::all();

        return view('admin.frontend.products.edit' , compact('product' , 'categories'));
    }

    /**
     * Update a product
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Product $product,Request $request){
        $validator = $this->validateUpdateForm($request);

        $this->doUpdate($product , $validator);

        return redirect()->route('api.admin.products.all')->with('simpleSuccessAlert' , 'Product updated successfully');
    }

    /**
     * Remove a product
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product){
        File::delete(public_path("\images\products\\$product->demo_url"));
        
        $product->delete();

        return back()->with('simpleSuccessAlert' , 'Product removed successfully');
    }

    /**
     * Download demo
     *
     * @param Product $product
     * @return void
     */
    public function downloadDemo(Product $product){
        return response()->download(public_path('images\products\\' . $product->demo_url));
    }

    public function index()
    {
        if (request()->ajax()) {
            $products = Product::with('category'); // Eager loading the category
            return DataTables::of($products)
                ->addColumn('action', function($row){
                    $deleteForm = '<form action="'.route('api.admin.products.destroy', $row->id).'" method="POST" id="prepare-form" style="display:inline;">
                                    '.csrf_field().'
                                    '.method_field('DELETE').'
                                    <button type="submit" class="btn btn-danger"><span class="ti-trash"></span></button>
                                   </form>';
                    $editLink = '<a href="'.route('api.admin.products.edit', $row->id).'" class="btn btn-primary"><span class="ti-pencil"></span></a>';
                    return $deleteForm . ' | ' . $editLink;
                })
                ->addColumn('image', function($row){
                    $imagePath = $row->demo_url ? asset('images/products/' . $row->demo_url) : null;
                    return $imagePath ? '<img src="'.$imagePath.'" alt="Product Image" width="50">' : 'No Image';
                })
                ->rawColumns(['action', 'image']) // Make sure the HTML in 'action' and 'image' columns is not escaped
                ->make(true);
        }

        return view('admin.frontend.products.list'); // No need to fetch products for AJAX requests
    }


 // import csv
 public function importCSV(Request $request)
 {
     $request->validate([
         'import_csv' => 'required',
     ]);
     //read csv file and skip data
     $file = $request->file('import_csv');
     $handle = fopen($file->path(), 'r');

     //skip the header row
     fgetcsv($handle);

     $chunksize = 25;
     while(!feof($handle))
     {
         $chunkdata = [];

         for($i = 0; $i<$chunksize; $i++)
         {
             $data = fgetcsv($handle);
             if($data === false)
             {
                 break;
             }
             $chunkdata[] = $data;
         }

         $this->getchunkdata($chunkdata);
     }
     fclose($handle);

     return redirect()->route('products.create')->with('success', 'Data has been added successfully.');
 }

 public function getchunkdata($chunkdata)
{
 foreach ($chunkdata as $column) {
     // $expense_id = $column[0];
     $Category_ID = $column[0];
     $Title = $column[1];
     $Description = $column[2];
     $Price = $column[3];
     $Stock = $column[4];
     $Discount = $column[5];
     $Author = $column[6];
     $Image_URL = $column[7];

    //  $image_filename = $column[4];

     // Create new expense
     $products = new Product();
     // $expense->id = $expense_id;
     $products->category_id = $Category_ID;
     $products->title = $Title;
     $products->description = $Description;
    //  $products->demo_url = $payment;
     $products->price = $Price;
     $products->stock = $Stock;
     $products->percent_discount = $Discount;
     $products->author = $Author;

     // Handle image upload
     if ($Image_URL) {
         $source_path = 'C:/xampp/htdocs/petzone-master/public/images/' . $Image_URL;
         if (File::exists($source_path)) {
             $destination_path = public_path('storage/images/' . $Image_URL);
             File::copy($source_path, $destination_path);
             $products->demo_url = $Image_URL;
         }
     }

     // dd($expense);
     $products->save();
 }
}


}