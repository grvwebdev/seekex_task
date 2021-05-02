<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skus;
use App\Models\Racks;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['skus'] = Skus::select('name', 'volumetric_size')->orderBy('name', 'ASC')->get();
        $data['racks'] = Racks::select('name', 'capacity', 'capacity_rank', 'distance_rank', 'storage_coefficient_s', 'loaded')->orderBy('name', 'ASC')->get();
        return view('home', $data);
    }
}
