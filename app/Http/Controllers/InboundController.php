<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skus;
use App\Models\Racks;
class InboundController extends Controller
{
    public function index()
    {
        $data['skus'] = Skus::select('name', 'volumetric_size')->get();
        $data['rack'] = Racks::select('name', 'capacity', 'storage_coefficient_s')->where('loaded', 0)->orderBy('storage_coefficient_s', 'ASC')->first();
        return view('inbound', $data);
    }

    public function skuInboundDone(Request $request){
        $input = $request->all();
        $validatedData = $request->validate([
            "quantity"  => "required|numeric|min:1",
            "rack"  => "required",
            "spacetaken"  => "required|numeric|gt:0",
        ]);
        if(Racks::where('name', $input['rack'])->update(['loaded' => 1])){
            return redirect()->back()->with('success', 'successfully updated')->with('remove', $input['rack']);
        }
    }
}
