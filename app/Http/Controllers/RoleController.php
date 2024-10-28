<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
// use \Illuminate\Support\Facades\Facades\Auth;
use Illuminate\Validation\Rules;

class RoleController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.manage-users', compact('users'));
    }
    public function UserAll(){

        $users = User::latest()->get();
        return view('backend.user.user_all',compact('users'));

    } // End Mehtod 

    public function UserAdd(){
        return view('backend.user.user_add');
       }  

    public function UserEdit($id){

        $user = User::findOrFail($id);
        return view('backend.user.user_edit',compact('user'));
 
     } // End Method

     public function UserUpdate(Request $request)
{
    // Validate the request data
    $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username,' . $request->id,
        'email' => 'required|string|email|max:255|unique:users,email,' . $request->id,
        'role' => 'required|string|max:255',
    ]);

    $user_id = $request->id;

    User::findOrFail($user_id)->update([
        'name' => $request->name,
        'username' => $request->username,
        'email' => $request->email,
        'role' => $request->role,
        'updated_by' => Auth::user()->id,
        'updated_at' => Carbon::now(),
    ]);

    $notification = [
        'message' => 'User Updated Successfully',
        'alert-type' => 'success'
    ];

    return redirect()->route('user.all')->with($notification);
}
 // End Method

    public function UserDelete($id)
    {

        User::findOrFail($id)->delete();

        $notification = array(
            'message' => 'User Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // End Method 

    public function UserStore(Request $request){

        // // Define the validation rules
        // $rules = [
        //     'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
        //     'username' => ['required', 'string', 'max:255', 'unique:users'],
        //     'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        //     'password' => ['required', 'min:8', 'confirmed', Rules\Password::defaults()],
        // ];

        // // Define the custom error messages
        // $messages = [
        //     'name.required' => 'The name field is mandatory.',
        //     'name.string' => 'The name must be a string.',
        //     'name.max' => 'The name may not be greater than 255 characters.',
        //     'name.regex' => 'The name may only contain letters and spaces.',
        //     'username.required' => 'The username field is mandatory.',
        //     'username.string' => 'The username must be a string.',
        //     'username.max' => 'The username may not be greater than 255 characters.',
        //     'username.unique' => 'The username has already been taken.',
        //     'email.required' => 'The email field is mandatory.',
        //     'email.string' => 'The email must be a string.',
        //     'email.email' => 'Please enter a valid email address.',
        //     'email.max' => 'The email may not be greater than 255 characters.',
        //     'email.unique' => 'The email has already been taken.',
        //     'password.required' => 'The password field is mandatory.',
        //     'password.min' => 'The password must be at least 8 characters long.',
        //     'password.confirmed' => 'The password confirmation does not match.',
        // ];

        // // Validate the request with custom messages
        // $request->validate($rules, $messages);

        User::insert([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            // 'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),

        ]);

         $notification = array(
            'message' => 'User Inserted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('user.all')->with($notification);

    } // End Method
}

