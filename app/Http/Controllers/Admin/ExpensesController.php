<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expenses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ExpensesController extends Controller
{
    /**
     * Show expenses list
     *
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        if ($request->ajax()) {
            $expenses = Expenses::paginate(10); // 10 items per page for AJAX requests
            return response()->json($expenses);
        }

        $expenses = Expenses::paginate(10);

        return view('admin.frontend.expenses.list', compact('expenses'));
    }

    /**
     * Show form for creating a new expense
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.frontend.expenses.add');
    }

    /**
     * Store a newly created expense in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $validator = $this->validateAddForm($request);

        if ($validator->fails()) {
        return back()
            ->withErrors($validator)
            ->withInput();
    }      
            $expense = new Expenses();
            $expense->expense_name = $request->input('expense_name');
            $expense->expense_date = $request->input('expense_date');
            $expense->expense_amount = $request->input('expense_amount');
            $expense->expense_payment = $request->input('expense_payment');
            // Handle expense image upload
            if ($request->hasFile('expense_img')) {
            $Expense_images = $request->file('expense_img')->store('expense_images', 'public');
            $expense->expense_img = $Expense_images;
            } else {
               
            $expense->Expense_images = null;
            }
            $expense->save();

        return redirect()->route('admin.expenses.all')->with('simpleSuccessAlert', 'Expense added successfully');
    }

    /**
     * Show form for editing the specified expense.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expenses $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expenses $expense)
    {
        return view('admin.frontend.expenses.edit', compact('expense'));
    }

    /**
     * Update the specified expense in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expenses $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expenses $expense)
    {
        $validator = $this->validateUpdateForm($request);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $expense->expense_name = $request->input('expense_name');
        $expense->expense_date = $request->input('expense_date');
        $expense->expense_amount = $request->input('expense_amount');
        $expense->expense_payment = $request->input('expense_payment');
        // Handle expense image upload
        if ($request->hasFile('expense_img')) {
            $Expense_img = $request->file('expense_img')->store('expense_images', 'public');
            $expense->expense_img = $Expense_img;
        }
        $expense->save();

        return redirect()->route('admin.expenses.all')->with('simpleSuccessAlert', 'Expense added successfully');
    }
    /**
     * Remove the specified expense from storage.
     *
     * @param  \App\Models\Expenses $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expenses $expense)
    {
        File::delete(public_path("\expense_images\\$expense->expense_img"));
  
            $expense->delete();

            return back()->with('simpleSuccessAlert' , 'Expenses removed successfully');

    }
    /**
     * Validate form data for adding a new supplier.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validateAddForm(Request $request)
    {
        return Validator::make($request->all(), [
            'expense_name' => 'required|string|max:255',
            'expense_date' => 'required|date',
            'expense_amount' => 'required|numeric',
            'expense_payment' => 'required|string|min:1',
            'expense_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);
    }

    protected function validateUpdateForm(Request $request)
    {
        return Validator::make($request->all(), [
            'expense_name' => 'required|string|max:255',
            'expense_date' => 'required|date',
            'expense_amount' => 'required|numeric',
            'expense_payment' => 'required|string|min:1',
            'expense_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);
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

        return redirect()->route('expenses.create')->with('success', 'Data has been added successfully.');
    }

    public function getchunkdata($chunkdata)
{
    foreach ($chunkdata as $column) {
        // $expense_id = $column[0];
        $name = $column[0];
        $date = $column[1];
        $amount = $column[2];
        $payment = $column[3];
        $image_filename = $column[4];

        // Create new expense
        $expense = new Expenses();
        // $expense->id = $expense_id;
        $expense->expense_name = $name;
        $expense->expense_date = $date;
        $expense->expense_amount = $amount;
        $expense->expense_payment = $payment;

        // Handle image upload
        if ($image_filename) {
            $source_path = 'C:/xampp/htdocs/petzone-master/public/images/' . $image_filename;
            if (File::exists($source_path)) {
                $destination_path = public_path('storage/images/' . $image_filename);
                File::copy($source_path, $destination_path);
                $expense->expense_img = $image_filename;
            }
        }

        // dd($expense);
        $expense->save();
    }
}

}