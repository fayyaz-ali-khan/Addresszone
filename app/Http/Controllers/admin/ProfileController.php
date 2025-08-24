<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Traits\FileHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    use FileHandler;

    public function edit()
    {
        $user = auth()->guard('admin')->user();

        return view('admin.profile.index', compact('user'));
    }

    public function update(Request $request, Admin $admin)
    {
        $admin = auth()->guard('admin')->user();
        $validatedData = $request->validate([
            'email' => ['required', 'email', 'max:255', Rule::unique('admins')->ignore($admin->id)],
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:admins,username,'.$admin->id,
            'password' => 'nullable|min:8|confirmed',
            'current_password' => 'required|current_password',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        if (! empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        if ($request->hasFile('image')) {
            $validatedData['image'] = $this->updateFile($request->file('image'), $admin->image, 'admin/profile');
        }
        $admin->update($validatedData);
        toastr()->success('Profile updated successfully!');

        return back();
    }
}
