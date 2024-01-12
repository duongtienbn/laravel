<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use Illuminate\Support\Facades\DB;

class CountryController extends Controller
{
    //
    public function getCountry() {
        $countries = Country::all();
        session()->put('countries',$countries);
        return response()->json($countries);
    }
    public function newCountry(Request $request) {
        $data = $request->input('newCountry');
        $country = new Country();
        $country->name = $data;
        $country->save();
        return response()->json([
            'status' => 200,
            'message' => 'Successfully',
            'country' => $data,
        ]);
    }
    public function delCountry(Request $request) {
        $data = $request->input('delCountry');
        $countries = DB::table('countries')->where('name', '=', $data);
        // $countries = Country::where('name', '=', $data);
        $countries->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Successfully',
            'country' => $countries,
        ]);
    }
}
