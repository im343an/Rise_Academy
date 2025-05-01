<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function registerform(){
        return view('Auth/register');
    }
    public function register(Request $request){
       $data = $request->validate([
        'firstname' => 'required',
        'lastname' => 'required',
        'email' => 'required',
        'password' => 'required|min:8|confirmed'
       ]);

       $user = User::create($data);
       if($user){
        return redirect()->route('login')->with('success', 'User created successfully. Now you can login');
       }
       
    }
    public function login(){
        return view('Auth/login');
    }
    public function loginform(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard')->with('success', 'Login successful!');
        }
        
        return back()->with('error', 'Invalid email or password. Please try again.');
    }
        public function profile(){
        $user = Auth::user();
        return view('Auth/profile', compact('user'));
    }
    public function updatepicture(Request $request){
       $image = $request->file('image');

       $request->validate([
        'image' => 'required|image|mimes:png,jpg,jpeg'
       ]);

       $filename = $image->getClientOriginalName();

       $path = $image->storeAs('images', $filename, 'public');

        $user = Auth::user();
        $user->profile_picture = $path;
        $user->save();
        return redirect()->route('profile');
    }
    public function updateprofileinfo(Request $request)
    {
        // Validate input
        $data = $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'password' => 'nullable|min:8', // Ensuring password is at least 8 characters if provided
        ]);
    
        // Get authenticated user
        $user = Auth::user();
    
        // Check if email has changed
        $emailChanged = $user->email !== $data['email'];
    
        // Update user data
        $user->firstname = $data['firstname'];
        $user->lastname = $data['lastname'];
        $user->email = $data['email'];
    
        // Check if password is provided and update it
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
    
        // Save the user
        $user->save();
    
        // If email changed, log out and force re-login
        if ($emailChanged) {
            Auth::logout();
            return redirect()->route('login')->with('message', 'Email updated. Please log in again.');
        }
    
        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }
        
    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
    public function forgetpassowrd(){
        return view('Auth/forgetpassword');
    }
    public function resetpassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->old_password, $user->password)) {
            // Update password
            $user->password = Hash::make($request->new_password);
            $user->save();

            return redirect()->route('login')->with('success', 'Password updated successfully');
        }

        return redirect()->back()->with('error', 'Invalid email or password');
    }        
}
