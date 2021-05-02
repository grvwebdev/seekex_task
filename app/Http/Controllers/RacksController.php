<?php

namespace App\Http\Controllers;
use Session;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Validator;
use App\Models\Racks;

class RacksController extends Controller
{

    public function index()
    {
        $data['racks'] = Racks::select('id', 'name', 'distance_rank')->get();
        return view('racks', $data);
    }

    public function update(Request $request){ 
        $validatedData = $request->validate([
            "rack.*"  => "required|numeric|distinct|min:1|max:5",
        ]);
        $input = $request->all();
        $racksCap = Racks::select('id', 'capacity_rank')->get();
        foreach($racksCap as $rack){
            $s = ($rack->capacity_rank *0.3) + ($input['rack'][$rack->id] *0.7);
            Racks::where('id', $rack->id)
            ->update(['distance_rank' => $input['rack'][$rack->id], 'storage_coefficient_s' => $s]);
        }
        return redirect()->back()->with('success', 'successfully updated');
    }
}
