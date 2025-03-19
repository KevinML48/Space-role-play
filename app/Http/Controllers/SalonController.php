<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salon;
use App\Models\Category;

class SalonController extends Controller
{
    public function index()
    {
        // Paginer les salons, 10 salons par page
        $salons = Salon::paginate(10); 
        return view('salons.index', compact('salons'));
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

        return redirect()->route('salons.index')->with('success', 'Salon created successfully.');
    }
}
