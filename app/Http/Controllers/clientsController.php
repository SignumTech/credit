<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class clientsController extends Controller
{
    public function getClients(Request $request){
        
        return $request->user()->clients->makeVisible([
            'secret'
        ]);
    }

    public function test(Request $request){
        $this->validate($request, [
            "test" => "required"
        ]);
        return "you posted ".$request->test;
    }
}
