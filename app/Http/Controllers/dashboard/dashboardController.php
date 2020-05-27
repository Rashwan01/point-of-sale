<?php

namespace App\Http\Controllers\dashboard;

use App\Category;
use App\Client;
use App\Http\Controllers\Controller;
use App\User;
use App\product;
use Illuminate\Http\Request;

class dashboardController extends Controller
{
	public function index(){

		$categoriesCount = Category::count();
		$productsCount = product::count();
		$clientsCount = Client::count();
		$usersCount = User::whereRoleIs('admin')->count();
	
		return view("dashboard.index",compact('categoriesCount','productsCount','clientsCount','usersCount'));
	} 
}
