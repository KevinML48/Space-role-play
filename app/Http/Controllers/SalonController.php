<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salon;
use App\Models\Category;

class SalonController extends Controller
{
    public function index()
    {
        $salons = Salon::all();
        $categories = Category::with('salons')->get();  // Récupère toutes les catégories avec leurs salons
        return view('salons.index', compact('salons', 'categories'));
    }
    
    public function show($id)
    {
        $salons = Salon::all();
        $categories = Category::with('salons')->get();  // Récupère les catégories avec leurs salons
        $currentSalon = Salon::with('messages.user')->findOrFail($id);
        
        return view('salons.index', compact('salons', 'categories', 'currentSalon'));
    }  

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
    ]);

    Salon::create([
        'name' => $request->name,
        'category_id' => $request->category_id,
    ]);

    return redirect()->route('salons.index')->with('success', 'Salon créé avec succès !');
}
}
