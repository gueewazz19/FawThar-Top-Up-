<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Game;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('game');

        if ($request->filled('game_id')) {
            $query->where('game_id', $request->get('game_id'));
        }

        if ($request->filled('q')) {
            $search = $request->get('q');
            $query->where('name', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $query->where('is_available', $request->get('status') === 'available');
        }

        $products = $query->orderBy('game_id')->orderBy('sort_order')->paginate(15)->withQueryString();
        $games = Game::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'games'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'game_id' => 'required|exists:games,id',
            'name' => 'required|string|max:100',
            'currency_amount' => 'required|string|max:50',
            'price' => 'required|numeric|min:100',
            'cost' => 'required|numeric|min:0',
            'sort_order' => 'nullable|integer',
            'is_popular' => 'sometimes|boolean',
        ]);

        $product = Product::create([
            'game_id' => $validated['game_id'],
            'name' => $validated['name'],
            'currency_amount' => $validated['currency_amount'],
            'price' => $validated['price'],
            'cost' => $validated['cost'],
            'sort_order' => $validated['sort_order'] ?? 99,
            'is_popular' => $request->has('is_popular'),
            'is_available' => true,
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'ADMIN_CREATE_PRODUCT',
            'description' => "Admin menambahkan paket baru: {$product->name} (Rp " . number_format($product->price, 0) . ")",
            'new_values' => $product->toArray(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.products.index', ['game_id' => $product->game_id])
            ->with('success', "Paket {$product->name} berhasil ditambahkan!");
    }

    public function toggleStatus(Request $request, Product $product)
    {
        $old = $product->is_available;
        $product->is_available = !$product->is_available;
        $product->save();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'ADMIN_TOGGLE_PRODUCT_STATUS',
            'description' => "Status paket {$product->name} diubah menjadi " . ($product->is_available ? 'TERSEDIA' : 'HABIS'),
            'old_values' => ['is_available' => $old],
            'new_values' => ['is_available' => $product->is_available],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->back()->with('success', "Status paket {$product->name} diperbarui.");
    }

    public function destroy(Request $request, Product $product)
    {
        $name = $product->name;
        $gameId = $product->game_id;

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'ADMIN_DELETE_PRODUCT',
            'description' => "Admin menghapus paket: {$name}",
            'old_values' => $product->toArray(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $product->delete();

        return redirect()->route('admin.products.index', ['game_id' => $gameId])
            ->with('success', "Paket {$name} berhasil dihapus.");
    }
}
