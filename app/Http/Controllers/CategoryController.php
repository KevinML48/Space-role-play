<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Server;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function store(Request $request, Server $server)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        $server->categories()->create([
            'name' => $request->name,
        ]);
    
        return redirect()->route('servers.show', $server)
                         ->with('success', 'Catégorie créée avec succès.');
    }
}
