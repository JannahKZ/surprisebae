<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        $admin = Auth::user();
        return view('account.index', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = Auth::user();
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
        ]);

        $admin->update($request->only('name', 'email'));

        return redirect()->route('account.index')->with('success', 'Account updated successfully.');
    }
}
