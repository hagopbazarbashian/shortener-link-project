<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ShortLinkRequest;
use App\Models\short_link;
use Illuminate\Support\Str;

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
        $shortLinks = short_link::latest()->get();
        return view('home')->with([
            'shortLinks'=>$shortLinks,
        ]);
    }


    public function store(ShortLinkRequest $request){

        short_link::create([
            'link' =>$request->link,
            'code' => Str::random(6)
        ]);
        return redirect()->back()->with('success', 'Shorten Link Generated Successfully!');
    }

    public function shortenLink($code)
    {
        $find = short_link::where('code', $code)->first();
   
        return redirect($find->link);
    }
}
