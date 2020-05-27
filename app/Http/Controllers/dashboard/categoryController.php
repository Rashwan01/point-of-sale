<?php

namespace App\Http\Controllers\dashboard;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class categoryController extends Controller
{
	public function index(Request $request){

        $categories = Category::when($request->search,function($q) use ($request){

            return $q->whereTranslationLike('name','%'.$request->search.'%');
        })->latest()->get();

		return view("dashboard.categories.index",['categories'=>$categories]);

	}
	public function create(){

		return view("dashboard.categories.create");
	}


	public function store(Request $request){
		$data= $request->validate($this->validateCategory());
		Category::create($request->except("_token"));
		return redirect()->route("dashboard.categories.index");
	}


	public function edit(Category $category){

		return view("dashboard.categories.edit",['category'=>$category]);
	}



	public function update(Request $request,Category $category){


		$rules = [];
		foreach(config('translatable.locales') as $local)

		{
			//ar.name
			$rules += [$local.'.name' =>["required"]];
		}
		$request->validate($rules);
		$category->update($request->except("_token"));
		$request->session()->flash("success",__("site.update_successfully"));
		return redirect()->route('dashboard.categories.index');
		
	}



	public function destroy(Request $request,Category $category){

		$category->delete();
		$request->session()->flash("success",__("site.add_successfully"));
		return redirect()->route('dashboard.categories.index');
	}


	public function validateCategory (){
		$rules = [];
		foreach(config('translatable.locales') as $local)

		{
			$rules+= [$local.'.name'=>["required",Rule::unique("category_translations","name")]];
		}
		return $rules;

	}


}
