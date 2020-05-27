<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;

class orderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = Order::whereHas("Client",function($q) use ($request){
            $q->where("name","like","%".$request->search."%");
        })->latest()->get();
        return view("dashboard.orders.index",['orders'=>$orders]);
    }
    public function products(Order $order){
        $products = $order->products;

        return view("dashboard.orders._products",['products'=>$products,'order'=>$order]);        
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Order $order)
    {
        foreach ($order->products as $product) {
            $product->update(["stock"=>$product->stock+$product->pivot->quantity]);
        }
        $order->delete();
        $request->session()->flash("success",__("site.add_successfully"));
        return redirect()->route('dashboard.orders.index');
    }
}
