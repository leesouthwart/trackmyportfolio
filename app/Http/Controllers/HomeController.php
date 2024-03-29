<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Portfolio;
use App\User;
use App\Investment;
use App\Asset;

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
        $lee = User::where('id', 1)->first();
        $port = Portfolio::where('user_id', (Auth()->user()->id))->first();

        $investment = Investment::where('user_id', 1)->first();

        $assets = Asset::pluck('asset_name', 'id')->toArray();
        
        
        return view('home', compact('port', 'assets'));
    }
}
