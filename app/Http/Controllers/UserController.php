<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|regex:/^[a-zA-Z\s]+$/', 
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|regex:/^[0-9]{10}$/', 
            'profile_pic' => 'nullable|image|mimes:jpg,jpeg,png',
            'password' => 'required|min:8',
        ]);

        $filePath = null;
        if ($request->hasFile('profile_pic')) {
            $filePath = $request->file('profile_pic')->store('profiles', 'public');
        }

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'mobile' => $validated['mobile'],
            'profile_pic' => $filePath,
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('users.create', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|regex:/^[a-zA-Z\s]+$/', 
            'email' => 'required|email|unique:users,email,' . $user->id,
            'mobile' => 'required|regex:/^[0-9]{10}$/', 
            'profile_pic' => 'nullable|image|mimes:jpg,jpeg,png',
            'password' => 'nullable|min:8',
        ]);

        $filePath = $user->profile_pic;
        if ($request->hasFile('profile_pic')) {
            if ($filePath) {
                Storage::disk('public')->delete($filePath);
            }
            $filePath = $request->file('profile_pic')->store('profiles', 'public');
        }

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'mobile' => $validated['mobile'],
            'profile_pic' => $filePath,
            'password' => $validated['password'] ? Hash::make($validated['password']) : $user->password,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->profile_pic) {
            Storage::disk('public')->delete($user->profile_pic);
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function exportCSV()
    {
        $users = User::all();
        $csvFileName = 'users.csv';
        $handle = fopen(storage_path('app/' . $csvFileName), 'w');
        fputcsv($handle, ['ID', 'Name', 'Email', 'Mobile', 'Profile Picture']);

        foreach ($users as $user) {
            fputcsv($handle, [$user->id, $user->name, $user->email, $user->mobile, $user->profile_pic]);
        }

        fclose($handle);

        return response()->download(storage_path('app/' . $csvFileName));
    }
}
