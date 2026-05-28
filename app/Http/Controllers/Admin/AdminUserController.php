<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string|in:user,admin',
            'balance' => 'required|numeric|min:0',
        ]);

        $oldBalance = $user->balance;
        $newBalance = $request->balance;

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'balance' => $newBalance,
        ]);

        // If balance was modified by admin, log a manual audit transaction
        if ($oldBalance != $newBalance) {
            $diff = $newBalance - $oldBalance;
            Transaction::create([
                'user_id' => $user->id,
                'amount' => abs($diff),
                'type' => $diff > 0 ? 'deposit' : 'purchase',
                'description' => 'Số dư được điều chỉnh bởi Quản trị viên (Admin Audit)',
                'status' => 'completed'
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật tài khoản người dùng thành công!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'Bạn không thể tự xóa chính mình!');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Xóa tài khoản người dùng thành công!');
    }
}
