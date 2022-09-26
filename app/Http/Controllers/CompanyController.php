<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index() {
        $companies = Company::where('name', 'LIKE', "%".request('search')."%")
            ->orderByDesc('company_id')
            ->paginate(10);

        return view('company.index', [
            'companies' => $companies,
            'search' => request('search')
        ]);
    }

    public function store(Request $request) {
        Company::create([
            'name' => $request->name
        ]);
        
        return redirect()->back()->with('message', 'Company created successfully!');
    }

    public function update(Request $request, $company_id) {
        Company::where('company_id', '=', $company_id)->update([
            'name' => $request->name
        ]);

        return redirect()->back()->with('message', 'Company updated successfully!');
    }

    public function destroy($company_id) {
        Company::where('company_id', '=', $company_id)->delete();

        return redirect()->back()->with('message', 'Company deleted successfully!');
    }
}
