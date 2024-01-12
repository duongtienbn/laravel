<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Place;
use Illuminate\Support\Facades\DB;

class PlaceController extends Controller
{
    //
    public function getPlace() {
        $places = Place::all();
        return response()->json($places);
    }
    public function newPlace(Request $request) {
        $data = $request->input('newPlace');
        $place = new Place();
        $place->name = $data;
        $place->save();
        return response()->json([
            'status' => 200,
            'message' => 'Successfully',
            'place' => $data,
        ]);
    }
    public function delPlace(Request $request) {
        $datas = $request->input('delPlace');
        if (isset($datas) && !empty($datas)) {
            foreach ($datas as $data) {
                $place = DB::table('working_places')->where('name', '=', $data);
                $place->delete();
            }
        }
        return response()->json([
            'status' => 200,
            'message' => 'Successfully',
            'place' => $place,
        ]);
    }
}
