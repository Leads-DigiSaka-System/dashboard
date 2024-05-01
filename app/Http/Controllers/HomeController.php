<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Survey;
use App\Models\Farms;
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

        $users = User::where('role','!=', 0)->count();
        $latest_farmers = User::where('role','!=', 0)->orderBy('id','desc')->limit(10)->get();
        $latest_farms = Farms::orderBy('id','desc')->limit(10)->get();
        $farms = Farms::count();
        $survey = Survey::count();
        $allFarms = Farms::all();

        return view('home',compact("users","farms","survey","latest_farmers","latest_farms","allFarms"));
    }
    public function installApp($diawi){
	return view('install',['diawi',$diawi]);
    }
}
