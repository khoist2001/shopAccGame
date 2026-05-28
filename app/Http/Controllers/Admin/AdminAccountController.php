<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Game;

class AdminAccountController extends Controller
{
    public function index()
    {
        $accounts = Account::with('game')->paginate(10);
        return view('admin.accounts.index', compact('accounts'));
    }

    public function create()
    {
        $games = Game::all();
        return view('admin.accounts.create', compact('games'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'rank' => 'nullable|string',
            'images_raw' => 'required|string', // Comma separated or line-by-line URLs
            'description' => 'nullable|string',
            'login_details' => 'required|string',
            'is_featured' => 'nullable|boolean',
        ]);

        // Process images string into JSON array of strings
        $images = array_filter(array_map('trim', explode("\n", str_replace("\r", "", $request->images_raw))));

        Account::create([
            'game_id' => $request->game_id,
            'title' => $request->title,
            'price' => $request->price,
            'rank' => $request->rank,
            'status' => 'available',
            'images' => array_values($images),
            'description' => $request->description,
            'login_details' => $request->login_details,
            'is_featured' => $request->has('is_featured'),
        ]);

        return redirect()->route('admin.accounts.index')->with('success', 'Đăng bán account game thành công!');
    }

    public function edit($id)
    {
        $account = Account::findOrFail($id);
        $games = Game::all();
        
        // Formulate raw images string
        $imagesRaw = is_array($account->images) ? implode("\n", $account->images) : '';

        return view('admin.accounts.edit', compact('account', 'games', 'imagesRaw'));
    }

    public function update(Request $request, $id)
    {
        $account = Account::findOrFail($id);

        $request->validate([
            'game_id' => 'required|exists:games,id',
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'rank' => 'nullable|string',
            'images_raw' => 'required|string',
            'description' => 'nullable|string',
            'login_details' => 'required|string',
            'status' => 'required|string|in:available,sold',
            'is_featured' => 'nullable|boolean',
        ]);

        $images = array_filter(array_map('trim', explode("\n", str_replace("\r", "", $request->images_raw))));

        $account->update([
            'game_id' => $request->game_id,
            'title' => $request->title,
            'price' => $request->price,
            'rank' => $request->rank,
            'status' => $request->status,
            'images' => array_values($images),
            'description' => $request->description,
            'login_details' => $request->login_details,
            'is_featured' => $request->has('is_featured'),
        ]);

        return redirect()->route('admin.accounts.index')->with('success', 'Cập nhật account game thành công!');
    }

    public function destroy($id)
    {
        $account = Account::findOrFail($id);
        $account->delete();

        return redirect()->route('admin.accounts.index')->with('success', 'Xóa account game thành công!');
    }
}
