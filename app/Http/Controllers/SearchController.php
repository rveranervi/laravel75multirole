<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if($request->route != ""){
        	if($request->search != ""){
        		return redirect('/'.$request->route.'/'. urlencode(str_replace("/", "", $request->search)) );
        	}
        	else{
        		return redirect('/'.$request->route);
        	}
        }
        else{
        	return "Ocurrio un error";
        }
    }
}
