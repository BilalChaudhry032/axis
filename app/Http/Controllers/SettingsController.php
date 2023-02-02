<?php

namespace App\Http\Controllers;

use App\Models\ExchangeRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class SettingsController extends Controller
{
    public function index() {
        $exchange_rate = ExchangeRate::select('to_pkr')
            ->where('currency', '=', 'usd')
            ->get();
        // dd($exchange_rate);
        $to_pkr = '';
        if(count($exchange_rate)) {
            $to_pkr = $exchange_rate[0]->to_pkr;
        }
        return view('settings.index', [
            'to_pkr' => $to_pkr
        ]);
    }

    public function updateUsdRate(Request $request) {
        // dd($request->usd_exc_rate);
        ExchangeRate::where('currency', '=', 'usd')->update(['to_pkr' => $request->usd_exc_rate]);
        return Redirect::to(URL::previous())->with('message', 'Exchange rate updated successfully!');
    }

    public function getUsdRate() {
        $exchange_rate = ExchangeRate::select('to_pkr')
            ->where('currency', '=', 'usd')
            ->get();
        // dd($exchange_rate);
        $to_pkr = '';
        if(count($exchange_rate)) {
            $to_pkr = $exchange_rate[0]->to_pkr;
        }
        return response()->json(['to_pkr'=> $to_pkr], 200);
    }
}
