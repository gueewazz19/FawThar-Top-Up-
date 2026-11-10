<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GameController extends Controller
{
    public function index(Request $request)
    {
        $query = Game::with(['category'])->withCount(['products', 'orders']);

        if ($request->filled('q')) {
            $search = $request->get('q');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->get('category_id'));
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->get('status') === 'active');
        }

        $games = $query->orderBy('name', 'asc')->paginate(10)->withQueryString();
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('admin.games.index', compact('games', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:games,name',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'user_id_label' => 'nullable|string|max:50',
            'server_id_label' => 'nullable|string|max:50',
            'requires_user_id' => 'sometimes|boolean',
            'requires_server_id' => 'sometimes|boolean',
        ]);

        $slug = Str::slug($validated['name']);
        $logoUrl = null;

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $gameDir = public_path('uploads/games');
            if (!file_exists($gameDir)) {
                mkdir($gameDir, 0755, true);
            }
            $file = $request->file('photo');
            $filename = 'game_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($gameDir, $filename);
            $logoUrl = '/uploads/games/' . $filename;
        }
        
        $game = Game::create([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? 'Top Up instan 24 jam.',
            'logo' => $logoUrl,
            'banner' => null,
            'is_active' => true,
            'requires_user_id' => $request->has('requires_user_id'),
            'requires_server_id' => $request->has('requires_server_id'),
            'user_id_label' => $validated['user_id_label'] ?? 'User ID',
            'server_id_label' => $validated['server_id_label'] ?? ($request->has('requires_server_id') ? 'Zone ID' : null),
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'ADMIN_CREATE_GAME',
            'description' => "Admin menambahkan game baru: {$game->name}",
            'new_values' => $game->toArray(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.games.index')->with('success', "Game {$game->name} berhasil ditambahkan!");
    }

    public function update(Request $request, Game $game)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:games,name,' . $game->id,
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'user_id_label' => 'nullable|string|max:50',
            'server_id_label' => 'nullable|string|max:50',
            'requires_user_id' => 'sometimes|boolean',
            'requires_server_id' => 'sometimes|boolean',
            'is_active' => 'sometimes|boolean',
        ]);

        $oldValues = $game->toArray();

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            if ($game->logo && str_starts_with($game->logo, '/uploads/games/') && file_exists(public_path($game->logo))) {
                @unlink(public_path($game->logo));
            }
            $gameDir = public_path('uploads/games');
            if (!file_exists($gameDir)) {
                mkdir($gameDir, 0755, true);
            }
            $file = $request->file('photo');
            $filename = 'game_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($gameDir, $filename);
            $game->logo = '/uploads/games/' . $filename;
        }

        $game->category_id = $validated['category_id'];
        $game->name = $validated['name'];
        $game->slug = Str::slug($validated['name']);
        $game->description = $validated['description'] ?? $game->description;
        $game->requires_user_id = $request->has('requires_user_id');
        $game->requires_server_id = $request->has('requires_server_id');
        $game->user_id_label = $validated['user_id_label'] ?? ($game->requires_user_id ? 'User ID' : null);
        $game->server_id_label = $validated['server_id_label'] ?? ($game->requires_server_id ? 'Zone ID' : null);
        if ($request->has('is_active')) {
            $game->is_active = $request->boolean('is_active');
        }
        $game->save();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'ADMIN_UPDATE_GAME',
            'description' => "Admin memperbarui data game: {$game->name}",
            'old_values' => $oldValues,
            'new_values' => $game->toArray(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.games.index')->with('success', "Game {$game->name} berhasil diperbarui!");
    }

    public function toggleStatus(Request $request, Game $game)
    {
        $oldStatus = $game->is_active;
        $game->is_active = !$game->is_active;
        $game->save();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'ADMIN_TOGGLE_GAME_STATUS',
            'description' => "Status game {$game->name} diubah menjadi " . ($game->is_active ? 'AKTIF' : 'NONAKTIF'),
            'old_values' => ['is_active' => $oldStatus],
            'new_values' => ['is_active' => $game->is_active],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $statusText = $game->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "Game {$game->name} berhasil {$statusText}.");
    }
}
