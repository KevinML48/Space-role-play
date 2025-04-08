<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class CategoryController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin')->only(['store']);
    }

    public function store(Request $request, Server $server)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = $server->categories()->create([
            'name' => $request->name,
        ]);

        return redirect()->route('servers.show', $server)->with('success', 'Catégorie créée avec succès.');
    }
}
