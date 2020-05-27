<?php

namespace App\Http\Controllers\dashboard\client;

use App\Category;
use App\Client;
use App\product;
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
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Client $client)
    {

        return view("dashboard.clients.orders.create",['client'=>$client,'categories'=> Category::with("products")->get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Client $client)
    {

        $request->validate([
            "products"=>"required|array",
            "quantities"=>"required|array"
        ]);
        $this->attachOrder($request,$client);

        $request->session()->flash("success",__("site.add_successfully"));
        return redirect()->route('dashboard.orders.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client,Order $order)
    {
     $categories = Category::with("products")->get();
     return view("dashboard.clients.orders.edit",compact(['client','order','categories']));
 }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Client $client, Order $order)
    {
        $this->deattachOrder($order)->attachOrder($request,$client);
        $request->session()->flash("success",__("site.add_successfully"));
        return redirect()->route('dashboard.orders.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
    public function attachOrder($request,$client)
    {
        
     $order = $client->orders()->create([]);
     $totalPrice = 0;
     foreach ($request->products as $index => $product) {
        $product = product::findOrFail($product);
        $totalPrice += $product->sale_price * $request->quantities[$index];
        $order->products()->attach($product,['quantity'=>$request->quantities[$index]]);

        $product->update(['stock'=>$product->stock-$request->quantities[$index]]);
    }
    $order->update(['total_price'=>$totalPrice]);

}
public function deattachOrder($order)
{
   foreach ($order->products as $product) {
    $product->update(["stock"=>$product->stock+$product->pivot->quantity]);
}
$order->delete();
return $this;

}
}
