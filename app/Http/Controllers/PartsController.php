<?php

namespace App\Http\Controllers;

use App\Models\Part;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PartsController extends Controller
{
    public function index() {
        return view('parts.index');
    }
    public function getParts(Request $request) {
        if($request->ajax()) {
            $parts = Part::select('part.*');
            return DataTables::of($parts)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                $actionBtn = '<div class="dropdown-button">
                        <a href="#" class="d-flex align-items-center justify-content-end" data-toggle="dropdown">
                            <div class="menu-icon mr-0">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="#" class="part_edit_modal_btn" id="edit_'.$row->part_id.'">Edit</a>
                            <a href="#" class="part_delete_modal_btn" id="delete_'.$row->part_id.'">Delete</a>
                        </div>
                    </div>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
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

    public function getPart() {
        $part_id = $_GET['part_id'];
        $part = Part::where('part_id', '=', $part_id)->select('part.*')->first();
        return response()->json(['response'=> $part], 200);
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
