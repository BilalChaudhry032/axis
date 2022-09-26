<?php

namespace App\Http\Controllers;

use App\Models\Part;
use Illuminate\Http\Request;

class PartsController extends Controller
{
    public function index() {
        $parts = Part::where('name', 'LIKE', "%".request('search')."%")
            ->orWhere('unit_price', 'LIKE', "%".request('search')."%")
            ->orWhere('description', 'LIKE', "%".request('search')."%")
            ->orderByDesc('part_id')
            ->paginate(10);

        return view('parts.index', [
            'parts' => $parts,
            'search' => request('search')
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'unit_price' => 'required|numeric'
        ]);
        Part::create([
            'name' => $request->name,
            'unit_price' => $request->unit_price,
            'description' => $request->description
        ]);
        
        return redirect()->back()->with('message', 'Part created successfully!');
    }

    public function update(Request $request, $part_id) {
        Part::where('part_id', '=', $part_id)->update([
            'name' => $request->name,
            'unit_price' => $request->unit_price,
            'description' => $request->description
        ]);

        return redirect()->back()->with('message', 'Part updated successfully!');
    }

    public function destroy($part_id) {
        Part::where('part_id', '=', $part_id)->delete();

        return redirect()->back()->with('message', 'Part deleted successfully!');
    }
}
