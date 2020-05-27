<?php
Route::group([
	'prefix' => LaravelLocalization::setLocale(),
         'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function(){ //...

         	Route::prefix("dashboards")->name("dashboard.")->middleware("auth")->group(function(){


         		Route::get("/","dashboardController@index");

                // user Routes
         		Route::resource("/user","userController")->except("show");
               // categories Routes
         		Route::resource("/categories","categoryController")->except("show");
               // products Routes
         		Route::resource("/products","productController")->except("show");
               // client Routes
         		Route::resource("/clients","clientController")->except("show");
         		Route::resource("/clients.order","client\orderController")->except("show");

               Route::resource("orders","orderController")->except("show");
               Route::get("orders/{order}/products","orderController@products")->name("orders.products");
         	});
         });
