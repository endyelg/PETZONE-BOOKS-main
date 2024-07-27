<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\Admin\Traits\HasCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller{
    use HasCategory;

    /**
     * Show the categories page 
     *
     * @return void
     */
    public function index(){
        $categories = Category::paginate(10);

        return view('admin.frontend.categories.index' , compact('categories'));
    }
  
    /**
     * Add a new category
     *
     * @return void
     */
    public function storage(Request $request){
        $validator = $this->validateAddForm($request);
        
        $this->doStore($validator);

        return back()->with('simpleSuccessAlert' , 'New product added successfully');
    }

    /**
     * Show edit category form 
     *
     * @param \App\Models\Category $category
     * @return void
     */
    public function edit(Category $category){
        return view('admin.frontend.categories.edit' , compact('category'));
    }
    
    /**
     * Update a category 
     *
     * @param \App\Models\Category $category
     * @return void
     */
    public function update(Category $category , Request $request){
        $validator = $this->validateUpdateForm($request);

        $this->doUpdate($category , $validator);

        return redirect()->route('admin.categories.index')->with('simpleSuccessAlert' , 'Update category successfully');
    }

    /**
     * Destroy a category
     *
     * @return void
     */ 
    public function destroy(Category $category){
        $category->delete();

        return back()->with('simpleSuccessAlert' , 'Remove category successfully');
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

    return redirect()->route('suppliers.create')->with('success', 'Data has been added successfully.');
}

public function getchunkdata($chunkdata)
{
foreach ($chunkdata as $column) {
    // $expense_id = $column[0];
    $Website_Genre = $column[0];
    $Category = $column[1];

   //  $image_filename = $column[4];

    // Create new expense
    $categories = new Category();
    // $expense->id = $expense_id;
    $categories->slug = $Website_Genre;
    $categories->title = $Category;

    // Handle image upload
   //  if ($Image_Path) {
   //      $source_path = 'C:/xampp/htdocs/PETZONE-BOOKS-master-main/public/images/' . $Image_Path;
   //      if (File::exists($source_path)) {
   //          $destination_path = public_path('storage/images/' . $Image_Path);
   //          File::copy($source_path, $destination_path);
   //          $categories->image_path = $Image_Path;
   //      }
   //  }

    // dd($expense);
    $categories->save();
}
}


}