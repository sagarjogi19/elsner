<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;
use Validator;
use Auth;

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
        return view('home');
    }

    public function getDashboardData()
    {
        if(Auth::user()->is_admin==1) {
            $cat= Category::count();
            $prod= Product::count();
        } else {
            $cat= Category::whereUserId(Auth::id())->count();
            $prod= Product::whereUserId(Auth::id())->count();
        }
        $data = [
            'total_cat' => $cat,
            'total_prod' => $prod,
        ];
        return response()->success('success',$data);
    }
}
