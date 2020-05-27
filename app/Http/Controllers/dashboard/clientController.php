<?php

namespace App\Http\Controllers\dashboard;

use App\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class clientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clients  = Client::when($request->search,function($q) use($request){
            $q->where("name","like","%".$request->search."%")->
            orWhere("phone","like","%".$request->search."%")->
            orWhere("address","like","%".$request->search."%");
        })->get();
        return view("dashboard.clients.index",['clients'=>$clients]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("dashboard.clients.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data =$request->validate([
            "name"=>"required",
            "address"=>"required",
            "phone"=>"required",

        ])   ;
        Client::create($data);
        $request->session()->flash("success",__("site.add_successfully"));
        return redirect()->route('dashboard.clients.index');

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        return view("dashboard.clients.edit",['client'=>$client]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
      $data =$request->validate([
        "name"=>"required",
        "address"=>"required",
        "phone"=>"required",

    ])   ;
      $client->update($data);
      $request->session()->flash("success",__("site.add_successfully"));
      return redirect()->route('dashboard.clients.index');
  }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Client $client)
    {
        $client->delete();
        $request->session()->flash("success",__("site.add_successfully"));
        return redirect()->route('dashboard.clients.index');
    }
}
