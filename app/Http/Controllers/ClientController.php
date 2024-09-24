<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    //
    public function index(){

        $clients = Client::all();

        return view('admin/client.index', compact('clients'));
    }

    public function show(Client $client){
        return view('admin/client.show',['client'=> $client]);
    }
}
