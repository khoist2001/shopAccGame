<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game;
use Illuminate\Support\Str;

class AdminGameController extends Controller
{
    public function index()
    {
        $games = Game::withCount('accounts')->paginate(10);
        return view('admin.games.index', compact('games'));
    }

    public function create()
    {
        return view('admin.games.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|url',
            'description' => 'nullable|string',
        ]);

        Game::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $request->image,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.games.index')->with('success', 'Thêm danh mục game thành công!');
    }

    public function edit($id)
    {
        $game = Game::findOrFail($id);
        return view('admin.games.edit', compact('game'));
    }

    public function update(Request $request, $id)
    {
        $game = Game::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|url',
            'description' => 'nullable|string',
        ]);

        $game->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $request->image,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.games.index')->with('success', 'Cập nhật danh mục game thành công!');
    }

    public function destroy($id)
    {
        $game = Game::findOrFail($id);
        $game->delete();

        return redirect()->route('admin.games.index')->with('success', 'Xóa danh mục game thành công!');
    }
}
