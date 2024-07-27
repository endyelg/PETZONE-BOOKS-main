<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    /**
     * Show users list
     *
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        if ($request->ajax()) {
            $users = User::paginate(10); // 10 items per page for AJAX requests
            return response()->json($users);
        }

        $users = User::paginate(10);


        return view('admin.frontend.users.list', compact('users'));
    }

    /**
     * Show form for creating a new user
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.frontend.users.add');
    }

    /**
     * Store a new created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validateAddForm($request);

        if ($validator->fails()) {
        return back()
            ->withErrors($validator)
            ->withInput();
    }
            // Create user
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = $request->input('password');
            $user->role = $request->input('role');
            $user->phone_number = $request->input('phone_number');
            $user->address = $request->input('address'); 
            if ($request->hasFile('image_path')) {
                // Store the new image and update the user's image_path
            $imagePath = $request->file('image_path')->store('profile_images', 'public');
            $user->image_path = $imagePath;
            } else {
               
            $user->image_path = null; // Or leave it as null
            }
            $user->save();

        return redirect()->route('admin.users.all')->with('simpleSuccessAlert', 'User added successfully');
        } 
    /**
     * Show form for editing the specified user.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //$user = User::findOrFail($id);
        return view('admin.frontend.users.edit', compact('user'));
    }

    /** 
     * Update specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, Request $request){
        $validator = $this->validateUpdateForm($request);
        // dd($user);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

    // Update user details
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = $request->input('password');
        $user->role = $request->input('role');
        $user->phone_number = $request->input('phone_number');
        $user->address = $request->input('address');

    if ($request->hasFile('image_path')) {
        
        $imagePath = $request->file('image_path')->store('profile_images', 'public');
        $user->image_path = $imagePath;
    }
    $user->save();

///////////////
        // Handle admin role update
        if ($user->role === 'admin') {
            // Fetch the user's email and password
            $email = $user->email;
            $password = $user->password;

            // Insert or update in the admin table
            DB::table('admin')->updateOrInsert(
                ['email' => $email], // Find existing admin by email
                ['password' => $password] // Update password
            );
        } else {
            // If the user is no longer an admin, remove from admin table
            DB::table('admin')->where('email', $user->email)->delete();
        }

        ///////////////
    return redirect()->route('admin.users.all')->with('simpleSuccessAlert', 'User updated successfully');
}


    /**
     * Remove specified user from storage.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        File::delete(public_path("\images\users\\$user->image_path"));

        $user->delete();

        return back()->with('simpleSuccessAlert' , 'User removed successfully');
    }

    /**
     * Validate form data for adding a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validateAddForm(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'required|string|min:6',
            'role' => 'required|in:user,admin',
            'phone_number' => 'required|string|max:20', // Changed field name to match HTML form
            'address' => 'required|string|max:255',
        ]);  
    }

    protected function validateUpdateForm(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'required|string|min:6',
            'role' => 'required|in:user,admin',
            'phone_number' => 'required|string|max:20', // Changed field name to match HTML form
            'address' => 'required|string|max:255',
        ]);
    }

    public function deactivateUser(User $user)
    {
        $user->update(['is_active' => false]);

        return redirect()->back()->with('success', 'User deactivated successfully');
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
 
         return redirect()->route('users.create')->with('success', 'Data has been added successfully.');
     }
 
     public function getchunkdata($chunkdata)
 {
     foreach ($chunkdata as $column) {
         // $supplier_id = $column[0];
         $Name = $column[0];
         $Email = $column[1];
         $Password = bcrypt($column[2]);
         $Role = $column[3];
         $Number = $column[4];
         $Address = $column[5];
         $Image = $column[6];
 
         // Create new expense
         $users = new User();
         // $users->id = $supplier_id;
         $users->name = $Name;
         $users->email = $Email;
         $users->password = $Password;
         $users->role = $Role;
         $users->phone_number = $Number;
         $users->address = $Address;
 
         // Handle image upload
         if ($Image) {
             $source_path = 'C:/xampp/htdocs/petzone-master/public/images/' . $Image;
             if (File::exists($source_path)) {
                 $destination_path = public_path('storage/images/' . $Image);
                 File::copy($source_path, $destination_path);
                 $users->image_path = $Image;
             }
         }
 
         // dd($Supplier);
         $users->save();
     }
 }
 
 

}