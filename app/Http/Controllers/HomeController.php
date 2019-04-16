<?php

namespace App\Http\Controllers;

use App\Complain;
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
        $complain= Complain::where('verification', 0)->get();


        return view('admin.pending.home',[
            'complains'=>$complain
        ]);
    }
}
