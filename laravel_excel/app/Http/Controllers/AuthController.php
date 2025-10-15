<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Login user and remember if checkbox checked
            Auth::login($user, $request->has('remember'));
            return redirect()->intended('/inventory');
        }

        return back()->withErrors(['email' => 'email or password is incorrect'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function showCreateForm()
    {
        return view('auth.create-user');
    }

    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname'  => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:3',
            'image'     => 'nullable|image|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('users', 'public');
        }

        $user = User::create([
            'first_name' => $request->firstname,
            'last_name'  => $request->lastname,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'image_url'     => $path,
        ]);

        return redirect()->back()->with('success', 'User created successfully!');
    }

    public function update(Request $request){
        $user = Auth::user();

        if(!$user){
            return redirect('/login');
        }
        //validation
        $validation = $request->validate([
            'first_name' => "required|string|max:255",
            "last_name" => "required|string|max:255",
            "email" => "required|email|unique:users,email," . $user->id,
            "image_url" => "nullable|image|max:2048",
        ]);

        // Handle profile image upload
        if ($request->hasFile('image_url')) {
            // delete old image if exists
            if ($user->image_url && Storage::disk('public')->exists($user->image_url)) {
                Storage::disk('public')->delete($user->image_url);
            }

            // store new image in "public/users" folder
            $imagePath = $request->file('image_url')->store('users', 'public');
            $validation['image_url'] = $imagePath;
        } else {
            // keep old image if not uploaded
            $validation['image_url'] = $user->image_url;
        }

        $user->update($validation);
        // Return JSON always (so your AJAX loader works)
        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully!',
        ]);
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login');
        }

        // Validate input
        $request->validate([
            'current_password' => 'required|string',
            'new_password'     => 'required|string|min:3', // optional: add confirmed field
        ]);

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Current password is incorrect!', "success" => false]);
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(["success" => true]);
    }

    public function update_profile(Request $request){

        $user = Auth::user();
        if(!$user){
            return redirect("/login");
        }

        $validated = $request->validate([
            "image_url" => "nullable|image|max:2048"
        ]);

        if($request->hasFile("image_url")){
            if($user->image_url && Storage::disk("public")->exists($user->image_url)){
                Storage::disk("public")->delete($user->image_url);
            }

            $path = $request->file("image_url")->store("users", "public");
            $validated["image_url"] = $path;
        }else{
            $validated["image_url"] = $user->image_url;
        }

        $user->update($validated);

        return back()->with("success", "Profile updated successfully!");
    }
}
