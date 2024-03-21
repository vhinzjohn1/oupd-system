<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $items = [
            ['title' => 'Material', 'id' => '1', 'particular' => 'Compaction'],
            ['title' => 'Labor', 'id' => '2', 'particular' => 'Earthworks'],
            ['title' => 'Equipment', 'id' => '3', 'particular' => 'GroundWorks'],
        ];
        return view('home', ['items' => $items]);
    }
}
